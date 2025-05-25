@extends('layouts.staff') {{-- Use staff layout --}}

@section('content') {{-- Start content section --}}

    <form method="POST" action="{{ route('staff.logout') }}"> {{-- Logout form --}}
        @csrf {{-- CSRF token --}}
        <button type="submit" style="padding: 10px 15px; background-color: #dc3545; color: white; border: none; border-radius: 4px; cursor: pointer;">Logout</button> {{-- Logout button --}}
    </form>

    <hr style="margin-top: 30px; margin-bottom: 30px;">

    <h2>Sales Overview</h2>

    {{-- Date Filter Form --}}
    <form id="sales-filter-form" style="margin-bottom: 20px;">
        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date">

        <label for="end_date" style="margin-left: 10px;">End Date:</label>
        <input type="date" id="end_date" name="end_date">

        <button type="submit" style="margin-left: 10px; padding: 5px 10px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer;">Filter</button>
        <button type="button" id="export-excel" style="margin-left: 10px; padding: 5px 10px; background-color: #ffc107; color: black; border: none; border-radius: 4px; cursor: pointer;">Export to Excel</button>
    </form>

    {{-- Sales Chart --}}
    <div style="margin-bottom: 30px;">
        <canvas id="salesChart"></canvas>
    </div>

    {{-- Sales Table --}}
    <h3>Sales Data</h3>
    <table id="salesTable" border="1" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Date</th>
                <th>Total Amount</th>
                <th>Payment Method</th>
            </tr>
        </thead>
        <tbody>
            {{-- Sales data will be loaded here via JavaScript --}}
        </tbody>
    </table>

    {{-- Include Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- Custom JavaScript for Chart and Table --}}
    <script>
        // Placeholder for JavaScript logic
        document.addEventListener('DOMContentLoaded', function () {
            const salesFilterForm = document.getElementById('sales-filter-form');
            const salesTableBody = document.querySelector('#salesTable tbody');
            const exportExcelButton = document.getElementById('export-excel');
            const salesChartCanvas = document.getElementById('salesChart').getContext('2d');
            let salesChart; // To hold the Chart.js instance

            // Function to fetch and display sales data
            function fetchSalesData(startDate = '', endDate = '') {
                const url = `{{ route('staff.sales.data') }}?start_date=${startDate}&end_date=${endDate}`;

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        // Clear existing table rows
                        salesTableBody.innerHTML = '';

                        // Populate table with fetched data
                        data.forEach(sale => {
                            const row = salesTableBody.insertRow();
                            const saleDate = new Date(sale.created_at).toLocaleDateString('id-ID');
                            row.innerHTML = `
                                <td>${sale.id}</td>
                                <td>${saleDate}</td>
                                <td>Rp ${parseFloat(sale.total_amount).toLocaleString('id-ID')}</td>
                                <td>${sale.metode_pembayaran}</td>
                            `;
                        });

                        // Update the chart
                        updateSalesChart(data);
                    })
                    .catch(error => {
                        console.error('Error fetching sales data:', error);
                        alert('Failed to fetch sales data.');
                    });
            }

            // Function to update the sales chart
            function updateSalesChart(data) {
                if (salesChart) {
                    salesChart.destroy(); // Destroy existing chart instance
                }

                const dates = data.map(sale => new Date(sale.created_at).toLocaleDateString('id-ID'));
                const totals = data.map(sale => parseFloat(sale.total_amount));

                salesChart = new Chart(salesChartCanvas, {
                    type: 'bar', // or 'line', 'pie', etc.
                    data: {
                        labels: dates,
                        datasets: [{
                            label: 'Daily Sales',
                            data: totals,
                            backgroundColor: 'rgba(0, 123, 255, 0.5)',
                            borderColor: 'rgba(0, 123, 255, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Total Sales (Rp)'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Date'
                                }
                            }
                        }
                    }
                });
            }

            // Event listener for filter form submission
            salesFilterForm.addEventListener('submit', function (event) {
                event.preventDefault();
                const startDate = document.getElementById('start_date').value;
                const endDate = document.getElementById('end_date').value;
                fetchSalesData(startDate, endDate);
            });

            // Event listener for export button
            exportExcelButton.addEventListener('click', function () {
                const startDate = document.getElementById('start_date').value;
                const endDate = document.getElementById('end_date').value;
                const exportUrl = `{{ route('staff.sales.export') }}?start_date=${startDate}&end_date=${endDate}`;
                window.location.href = exportUrl; // Trigger file download
            });

            // Initial data load
            fetchSalesData();
        });
    </script>

@endsection {{-- End content section --}}
