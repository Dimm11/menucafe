@extends('layouts.staff') {{-- Use staff layout --}}

@section('content') {{-- Start content section --}}

<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    <hr class="dashboard-divider"> {{-- Tailwind margin classes --}}

    <h2 class="sales-overview-title">Sales Overview</h2> {{-- Tailwind text and margin classes --}}

    {{-- Date Filter Form --}}
    <form id="sales-filter-form" class="sales-filter-form"> {{-- Tailwind margin, flex, items, and space classes --}}
        <div>
            <label for="start_date" class="form-label">Start Date:</label>
            <input type="date" id="start_date" name="start_date" class="form-input"> {{-- Tailwind form input classes --}}
        </div>

        <div>
            <label for="end_date" class="form-label">End Date:</label>
            <input type="date" id="end_date" name="end_date" class="form-input"> {{-- Tailwind form input classes --}}
        </div>

        <button type="submit" class="btn btn-primary">
            Filter
        </button> {{-- Tailwind button classes --}}
        <button type="button" id="export-excel" class="btn btn-secondary">
            Export to Excel
        </button> {{-- Tailwind button classes --}}
    </form>

    {{-- Sales Chart --}}
    <div class="sales-chart-container"> {{-- Tailwind margin class --}}
        <canvas id="salesChart"></canvas>
    </div>

    {{-- Sales Table --}}
    <h3 class="sales-data-title">Sales Data</h3> {{-- Tailwind text and margin classes --}}
    <table id="salesTable" class="sales-table"> {{-- Tailwind table classes --}}
        <thead class="sales-table-header"> {{-- Tailwind table header classes --}}
            <tr>
                <th scope="col" class="sales-table-header-cell">Order ID</th> {{-- Tailwind table header cell classes --}}
                <th scope="col" class="sales-table-header-cell">Date</th> {{-- Tailwind table header cell classes --}}
                <th scope="col" class="sales-table-header-cell">Total Amount</th> {{-- Tailwind table header cell classes --}}
                <th scope="col" class="sales-table-header-cell">Payment Method</th> {{-- Tailwind table header cell classes --}}
            </tr>
        </thead>
        <tbody class="sales-table-body"> {{-- Tailwind table body classes --}}
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
                                <td class="px-6 py-4 whitespace-nowrap">${sale.id}</td> {{-- Tailwind table cell classes --}}
                                <td class="px-6 py-4 whitespace-nowrap">${saleDate}</td> {{-- Tailwind table cell classes --}}
                                <td class="px-6 py-4 whitespace-nowrap">Rp ${parseFloat(sale.total_amount).toLocaleString('id-ID')}</td> {{-- Tailwind table cell classes --}}
                                <td class="px-6 py-4 whitespace-nowrap">${sale.metode_pembayaran}</td> {{-- Tailwind table cell classes --}}
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
                    type: 'line', // or 'line', 'pie', etc.
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
