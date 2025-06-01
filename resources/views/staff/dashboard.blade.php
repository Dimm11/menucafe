@extends('layouts.staff')

@section('content')

<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    <hr class="dashboard-divider">

    <h2 class="sales-overview-title">Sales Overview</h2>

    <form id="sales-filter-form" class="sales-filter-form">
        <div  class="margin-right-5">
            <label for="start_date" class="form-label">Start Date:</label>
            <input type="date" id="start_date" name="start_date" class="form-input">
        </div>

        <div class="margin-right-5">
            <label for="end_date" class="form-label">End Date:</label>
            <input type="date" id="end_date" name="end_date" class="form-input">
        </div>

        <button type="submit" class="btn btn-primary">
            Filter
        </button>
        <button type="button" id="export-excel" class="btn btn-secondary">
            Export to Excel
        </button>
    </form>

    <div class="sales-charts-container">
        <div class="sales-chart-container">
            <canvas id="salesChart" class="line-chart-canvas"></canvas>
        </div>
        <div class="sales-chart-container">
            <canvas id="paymentMethodChart" class="pie-chart-canvas"></canvas>
        </div>
    </div>

    <h3 class="sales-data-title">Sales Data</h3>
    <table id="salesTable" class="sales-table">
        <thead class="sales-table-header">
            <tr>
                <th scope="col" class="sales-table-header-cell">Order ID</th>
                <th scope="col" class="sales-table-header-cell">Date</th>
                <th scope="col" class="sales-table-header-cell">Total Amount</th>
                <th scope="col" class="sales-table-header-cell">Payment Method</th>
            </tr>
        </thead>
        <tbody class="sales-table-body">
        </tbody>
    </table>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const salesFilterForm = document.getElementById('sales-filter-form');
            const salesTableBody = document.querySelector('#salesTable tbody');
            const exportExcelButton = document.getElementById('export-excel');
            const salesChartCanvas = document.getElementById('salesChart').getContext('2d');
            const paymentMethodChartCanvas = document.getElementById('paymentMethodChart').getContext('2d');
            let salesChart;
            let paymentMethodChart;

            function fetchSalesData(startDate = '', endDate = '') {
                const url = `{{ route('staff.sales.data') }}?start_date=${startDate}&end_date=${endDate}`;

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        salesTableBody.innerHTML = '';

                        data.forEach(sale => {
                            const row = salesTableBody.insertRow();
                            const saleDate = new Date(sale.created_at).toLocaleDateString('id-ID');
                            row.innerHTML = `
                                <td class="px-6 py-4 whitespace-nowrap">${sale.id}</td>
                                <td class="px-6 py-4 whitespace-nowrap">${saleDate}</td>
                                <td class="px-6 py-4 whitespace-nowrap">Rp ${parseFloat(sale.total_amount).toLocaleString('id-ID')}</td>
                                <td class="px-6 py-4 whitespace-nowrap">${sale.metode_pembayaran}</td>
                            `;
                        });

                        const paymentMethodData = data.reduce((acc, sale) => {
                            acc[sale.metode_pembayaran] = (acc[sale.metode_pembayaran] || 0) + parseFloat(sale.total_amount);
                            return acc;
                        }, {});

                        updateSalesChart(data);
                        updatePaymentMethodChart(paymentMethodData);
                    })
                    .catch(error => {
                        console.error('Error fetching sales data:', error);
                        alert('Failed to fetch sales data.');
                    });
            }

            function updateSalesChart(data) {
                if (salesChart) {
                    salesChart.destroy();
                }

                const dates = data.map(sale => new Date(sale.created_at).toLocaleDateString('id-ID'));
                const totals = data.map(sale => parseFloat(sale.total_amount));

                salesChart = new Chart(salesChartCanvas, {
                    type: 'line',
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

            function updatePaymentMethodChart(data) {
                if (paymentMethodChart) {
                    paymentMethodChart.destroy();
                }

                let labels = Object.keys(data);
                const totals = Object.values(data);

                labels = labels.map(label => label === 'null' ? 'Tidak diketahui' : label);

                paymentMethodChart = new Chart(paymentMethodChartCanvas, {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Sales by Payment Method',
                            data: totals,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.5)',
                                'rgba(54, 162, 235, 0.5)',
                                'rgba(255, 206, 86, 0.5)',
                                'rgba(75, 192, 192, 0.5)',
                                'rgba(153, 102, 255, 0.5)',
                                'rgba(255, 159, 64, 0.5)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: 'Sales by Payment Method'
                            }
                        }
                    }
                });
            }

            salesFilterForm.addEventListener('submit', function (event) {
                event.preventDefault();
                const startDate = document.getElementById('start_date').value;
                const endDate = document.getElementById('end_date').value;
                fetchSalesData(startDate, endDate);
            });

            exportExcelButton.addEventListener('click', function () {
                const startDate = document.getElementById('start_date').value;
                const endDate = document.getElementById('end_date').value;
                const exportUrl = `{{ route('staff.sales.export') }}?start_date=${startDate}&end_date=${endDate}`;
                window.location.href = exportUrl;
            });

            fetchSalesData();
        });
    </script>

@endsection
