<x-app-layout>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-app.navbar />
        <div class="container-fluid py-4 px-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-md-flex align-items-center mb-3 mx-2">
                        <div class="mb-md-0 mb-3">
                            <h3 class="font-weight-bold mb-0">Hello, {{ Auth::user()->name }}</h3>
                            <p class="mb-0">Have a nice day</p>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="my-0">
            <div class="row" style="display: none;">
                <div class="position-relative overflow-hidden">
                    <div class="swiper mySwiper mt-4 mb-2">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div>
                                    <div class="card card-background shadow-none border-radius-xl card-background-after-none align-items-start mb-0">
                                        <div class="full-background bg-cover bg-dark"></div>
                                        <div class="card-body text-start px-3 py-0 w-100" style="height: 340px;">
                                            <div class="row mt-2">
                                                <div class="col-sm-3 mt-auto">
                                                    <h4 class="text-white font-weight-bolder">#1</h4>
                                                    <p class="text-white opacity-6 text-xs font-weight-bolder mb-0">Category</p>
                                                    <h5 class="text-white font-weight-bolder">Employee</h5>
                                                </div>
                                                <div class="col-sm-3 ms-auto mt-auto">
                                                    <p class="text-white opacity-6 text-xs font-weight-bolder mb-0">Number of employees</p>
                                                    <h5 class="text-white font-weight-bolder">{{ $employee }} Person</h5>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-12">
                                                    <canvas id="employeePieChart" style="height: 220px;"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div>
                                    <div class="card card-background shadow-none border-radius-xl card-background-after-none align-items-start mb-0">
                                        <div class="full-background bg-cover bg-info"></div>
                                        <div class="card-body text-start px-3 py-0 w-100" style="height: 340px;">
                                            <div class="row mt-2">
                                                <div class="col-sm-3 mt-auto">
                                                    <h4 class="text-dark font-weight-bolder">#2</h4>
                                                    <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Category</p>
                                                    <h5 class="text-dark font-weight-bolder">Flight</h5>
                                                </div>
                                                <div class="col-sm-3 ms-auto mt-auto">
                                                    <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Number of flights in the last year</p>
                                                    <h5 class="text-dark font-weight-bolder">{{ $totalFlights }} Flights</h5>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-12">
                                                    <!-- <canvas id="flightChart" style="height: 220px;"></canvas> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="swiper-slide">
                                <div class="card card-background shadow-none border-radius-xl card-background-after-none align-items-start mb-0">
                                    <div class="full-background bg-cover" style="background-image: url('../assets/img/img-1.jpg')"></div>
                                    <div class="card-body text-start px-3 py-0 w-100">
                                        <div class="row mt-12">
                                            <div class="col-sm-3 mt-auto">
                                                <h4 class="text-dark font-weight-bolder">#2</h4>
                                                <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Name</p>
                                                <h5 class="text-dark font-weight-bolder">Cyber</h5>
                                            </div>
                                            <div class="col-sm-3 ms-auto mt-auto">
                                                <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Category
                                                </p>
                                                <h5 class="text-dark font-weight-bolder">Security</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="card card-background shadow-none border-radius-xl card-background-after-none align-items-start mb-0">
                                    <div class="full-background bg-cover" style="background-image: url('../assets/img/img-3.jpg')"></div>
                                    <div class="card-body text-start px-3 py-0 w-100">
                                        <div class="row mt-12">
                                            <div class="col-sm-3 mt-auto">
                                                <h4 class="text-dark font-weight-bolder">#3</h4>
                                                <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Name</p>
                                                <h5 class="text-dark font-weight-bolder">Alpha</h5>
                                            </div>
                                            <div class="col-sm-3 ms-auto mt-auto">
                                                <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Category
                                                </p>
                                                <h5 class="text-dark font-weight-bolder">Blockchain</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="card card-background shadow-none border-radius-xl card-background-after-none align-items-start mb-0">
                                    <div class="full-background bg-cover" style="background-image: url('../assets/img/img-4.jpg')"></div>
                                    <div class="card-body text-start px-3 py-0 w-100">
                                        <div class="row mt-12">
                                            <div class="col-sm-3 mt-auto">
                                                <h4 class="text-dark font-weight-bolder">#4</h4>
                                                <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Name</p>
                                                <h5 class="text-dark font-weight-bolder">Beta</h5>
                                            </div>
                                            <div class="col-sm-3 ms-auto mt-auto">
                                                <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Category
                                                </p>
                                                <h5 class="text-dark font-weight-bolder">Web3</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="card card-background shadow-none border-radius-xl card-background-after-none align-items-start mb-0">
                                    <div class="full-background bg-cover" style="background-image: url('../assets/img/img-5.jpg')"></div>
                                    <div class="card-body text-start px-3 py-0 w-100">
                                        <div class="row mt-12">
                                            <div class="col-sm-3 mt-auto">
                                                <h4 class="text-dark font-weight-bolder">#5</h4>
                                                <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Name</p>
                                                <h5 class="text-dark font-weight-bolder">Gama</h5>
                                            </div>
                                            <div class="col-sm-3 ms-auto mt-auto">
                                                <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Category
                                                </p>
                                                <h5 class="text-dark font-weight-bolder">Design</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="card card-background shadow-none border-radius-xl card-background-after-none align-items-start mb-0">
                                    <div class="full-background bg-cover" style="background-image: url('../assets/img/img-1.jpg')"></div>
                                    <div class="card-body text-start px-3 py-0 w-100">
                                        <div class="row mt-12">
                                            <div class="col-sm-3 mt-auto">
                                                <h4 class="text-dark font-weight-bolder">#6</h4>
                                                <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Name</p>
                                                <h5 class="text-dark font-weight-bolder">Rompro</h5>
                                            </div>
                                            <div class="col-sm-3 ms-auto mt-auto">
                                                <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Category
                                                </p>
                                                <h5 class="text-dark font-weight-bolder">Security</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>

            <div class="row my-4">
                <div class="col-lg-4 col-md-6 mb-md-0 mb-4">
                    <div class="card shadow-xs border h-100">
                        <div class="card-header pb-0">
                            <h6 class="font-weight-semibold text-lg mb-0">Flights Total</h6>
                            <p class="text-sm">Here you have details.</p>
                        </div>
                        <div class="card-body py-3">
                            <div class="col-12">
                                <canvas id="flightChart" style="height: 220px;"></canvas>
                            </div>
                            <hr>
                            <div class="ms-auto mt-auto text-end">
                                <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Number of flights in the last year</p>
                                <h5 class="text-dark font-weight-bolder">{{ $totalFlights }} Flights</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-md-0 mb-4">
                    <div class="card shadow-xs border h-100">
                        <div class="card-header pb-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="font-weight-semibold mb-0">Flights Total by Type</h6>
                                <button id="showAll" class="btn btn-dark btn-sm" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">Show All</button>
                            </div>
                            <p class="text-sm">Here you have details.</p>
                        </div>
                        <div class="card-body py-3">
                            <div class="col-12">
                                <canvas id="flightTypeChart" style="height: 220px;"></canvas>
                            </div>
                            <hr>
                            <!-- Legend Container -->
                            <div id="chartLegend" class="mt-3" style="font-size: 0.75rem; line-height: 1.2; justify-content: center;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-md-0 mb-4">
                    <div class="card shadow-xs border h-100">
                        <div class="card-header pb-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="font-weight-semibold mb-0">Flights Total by Type</h6>
                                <select class="form-select form-select-sm btn btn-dark" style="width: 50px; --bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;" id="quarterSelect">
                                    <option value="1">Q1</option>
                                    <option value="2">Q2</option>
                                    <option value="3">Q3</option>
                                    <option value="4">Q4</option>
                                </select>
                            </div>
                            <p class="text-sm">Here you have details.</p>
                        </div>
                        <div class="card-body py-3">
                            <div class="col-12">
                                <canvas id="quarterlyPieChart" style="height: 220px;"></canvas>
                            </div>
                            <hr>
                            <div class="ms-auto mt-auto text-end">
                                <p id="labelActualPrice" class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Total Actual Price Flight per ....</p>
                                <h5 id="totalActualPrice" class="text-dark font-weight-bolder">Rp.0</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row my-4">
                <div class="col-lg-12">
                    <div class="card shadow-xs border">
                        <div class="card-header border-bottom pb-0">
                            <div class="d-sm-flex align-items-center mb-3">
                                <div>
                                    <h6 class="font-weight-semibold text-lg mb-0">Employees</h6>
                                    <p class="text-sm mb-sm-0 mb-2">These are details about the employees</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 py-0">
                            <div class="table-responsive p-0" style="max-height: 335px; overflow-y: auto;">
                                <table class="letter table align-items-center justify-content-center mb-0" id="letter">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">No</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">NIK</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Name</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Organization</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Job Position</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Job Level</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Branch Name</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">POH</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($allEmployees as $employee)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $employee->nik }}</td>
                                            <td>{{ $employee->nama }}</td>
                                            <td>{{ $employee->organization }}</td>
                                            <td>{{ $employee->job_position }}</td>
                                            <td>{{ $employee->job_level }}</td>
                                            <td>{{ $employee->branch_name }}</td>
                                            <td>{{ $employee->poh }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <x-app.footer />
        </div>
    </main>

    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="../assets/js/plugins/chartjs.min.js"></script>
    <script src="../assets/js/plugins/swiper-bundle.min.js" type="text/javascript"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Data dari backend
            const quarterlyPricesByType = @json($quarterlyPricesByType);
            const actualPriceData = @json($quarterlyPrices);

            // Warna untuk setiap jenis
            const colors = [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)'
            ];

            // Mendapatkan kuartal dan tahun saat ini
            const currentMonth = new Date().getMonth() + 1;
            const currentQuarter = Math.ceil(currentMonth / 3);
            const thisYear = new Date().getFullYear();

            // Fungsi untuk memetakan data ke dalam format dataset Chart.js
            function mapDataToChartDataset(data) {
                const types = [...new Set(data.map(item => item.jenis))];
                const totalPrices = types.map(type => {
                    return data
                        .filter(item => item.jenis === type)
                        .reduce((sum, item) => sum + item.total_actual_price, 0);
                });

                return {
                    labels: types,
                    datasets: [{
                        data: totalPrices,
                        backgroundColor: colors.slice(0, types.length),
                    }]
                };
            }

            // Inisialisasi chart dengan data awal
            const ctx = document.getElementById('quarterlyPieChart').getContext('2d');
            const flightChart = new Chart(ctx, {
                type: 'pie',
                data: mapDataToChartDataset(quarterlyPricesByType),
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    return `${label}: Rp.${Number(value).toLocaleString()}`;
                                }
                            }
                        }
                    }
                }
            });

            // Set nilai default pada select input
            const quarterSelect = document.getElementById('quarterSelect');
            quarterSelect.value = currentQuarter;

            // Event listener untuk select input
            quarterSelect.addEventListener('change', function() {
                const selectedQuarter = this.value;
                updateChartByQuarter(selectedQuarter);
            });

            // Fungsi untuk memperbarui chart berdasarkan kuartal yang dipilih
            function updateChartByQuarter(quarter) {
                let filteredData;

                if (quarter === 'all') {
                    filteredData = quarterlyPricesByType;
                } else {
                    filteredData = quarterlyPricesByType.filter(item => item.quarter === parseInt(quarter));
                }

                // Perbarui data pada chart
                const newChartData = mapDataToChartDataset(filteredData);
                flightChart.data.labels = newChartData.labels;
                flightChart.data.datasets[0].data = newChartData.datasets[0].data;
                flightChart.data.datasets[0].backgroundColor = newChartData.datasets[0].backgroundColor;
                flightChart.update();

                // Temukan total_actual_price untuk kuartal yang dipilih
                let totalActualPrice = 0;
                if (quarter === 'all') {
                    totalActualPrice = actualPriceData.reduce((sum, item) => sum + parseFloat(item.total_actual_price), 0);
                } else {
                    const quarterData = actualPriceData.find(item => item.quarter === parseInt(quarter));
                    totalActualPrice = quarterData ? parseFloat(quarterData.total_actual_price) : 0;
                }

                // Perbarui total actual price
                document.getElementById('totalActualPrice').textContent = `Rp.${totalActualPrice.toLocaleString()}`;

                // Perbarui label actual price
                document.getElementById('labelActualPrice').textContent = `Total Actual Price Flight per Q${quarter} ${thisYear}`;
            }

            // Panggil fungsi untuk menampilkan data default kuartal saat ini
            updateChartByQuarter(currentQuarter);
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const flightsPerMonthByType = @json($flightsPerMonthByType);
            const months = Array.from(new Set(flightsPerMonthByType.map(item => item.month)));
            const flightTypes = Array.from(new Set(flightsPerMonthByType.map(item => item.jenis)));

            const colors = [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)'
            ];

            const datasets = flightTypes.map((type, index) => {
                return {
                    label: type,
                    data: months.map(month => {
                        const dataItem = flightsPerMonthByType.find(item => item.month === month && item.jenis === type);
                        return dataItem ? dataItem.total_flights : 0;
                    }),
                    backgroundColor: colors[index % colors.length],
                    borderColor: colors[index % colors.length],
                    borderWidth: 2
                };
            });

            const ctx = document.getElementById('flightTypeChart').getContext('2d');
            const flightChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: months,
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false // Hide default legend
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + context.raw;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                color: 'black',
                                padding: 10
                            },
                            grid: {
                                drawBorder: false,
                                display: false,
                                drawOnChartArea: false,
                                drawTicks: false
                            }
                        },
                        y: {
                            ticks: {
                                color: 'black',
                                padding: 20
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)',
                                borderColor: 'black',
                                borderDash: [5, 5],
                                drawOnChartArea: true,
                                drawBorder: false,
                                drawTicks: false
                            }
                        }
                    }
                }
            });

            // Generate custom legend
            const legendContainer = document.getElementById('chartLegend');
            legendContainer.style.display = 'flex'; // Set display to flex
            legendContainer.style.flexDirection = 'row'; // Arrange items in a row

            flightTypes.forEach((type, index) => {
                const color = colors[index % colors.length];
                const legendItem = document.createElement('div');
                legendItem.style.display = 'flex'; // Ensure the legend item is also flex
                legendItem.style.alignItems = 'center'; // Center items vertically
                legendItem.style.marginRight = '9px'; // Add space between items
                legendItem.style.cursor = 'pointer'; // Indicate that the item is clickable
                legendItem.setAttribute('data-type', type); // Store the type in a data attribute

                legendItem.innerHTML = `
            <span style="display: inline-block; width: 12px; height: 12px; background-color: ${color}; margin-right: 3px;"></span>
            ${type}
        `;
                legendContainer.appendChild(legendItem);

                legendItem.addEventListener('click', function() {
                    const type = this.getAttribute('data-type');
                    updateChart(type);
                });
            });

            // Add event listener for "Show All" button
            document.getElementById('showAll').addEventListener('click', function() {
                showAllDatasets();
            });

            function updateChart(selectedType) {
                flightChart.data.datasets.forEach((dataset) => {
                    dataset.hidden = !dataset.label.includes(selectedType);
                });
                flightChart.update();
            }

            function showAllDatasets() {
                flightChart.data.datasets.forEach((dataset) => {
                    dataset.hidden = false;
                });
                flightChart.update();
            }
        })
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var ctx = document.getElementById('employeePieChart').getContext('2d');
            var employeeCountsByBranch = @json($employeeCountsByBranch);

            var labels = employeeCountsByBranch.map(function(branch) {
                return branch.branch_name;
            });

            var data = employeeCountsByBranch.map(function(branch) {
                return branch.total;
            });

            var pieChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Employees by Branch',
                        data: data,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.4)',
                            'rgba(54, 162, 235, 0.4)',
                            'rgba(255, 206, 86, 0.4)',
                            'rgba(75, 192, 192, 0.4)',
                            'rgba(153, 102, 255, 0.4)',
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            labels: {
                                color: 'white', // Set the legend text color to white
                            },
                            position: 'bottom',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    var label = context.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    label += context.raw;
                                    return label;
                                }
                            }
                        }
                    }
                }
            });

            var ctx = document.getElementById('flightChart').getContext('2d');
            var flightsPerMonth = @json($flightsPerMonth);

            var labels = flightsPerMonth.map(item => item.month);
            var data = flightsPerMonth.map(item => item.total_flights);

            var flightChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Number of Flights',
                        data: data,
                        backgroundColor: 'rgba(0, 0, 0, 1)', // Light grey background color
                        borderColor: 'rgba(0, 0, 0, 1)', // Black border color
                        borderWidth: 2 // Thicker line for better visibility
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false, // Hide the legend
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + context.raw;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                color: 'black', // Black color for x-axis labels
                                padding: 10
                            },
                            grid: {
                                drawBorder: false,
                                display: false,
                                drawOnChartArea: false,
                                drawTicks: false
                            }
                        },
                        y: {
                            ticks: {
                                color: 'black', // Black color for y-axis labels
                                padding: 20
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)', // Light grey grid lines
                                borderColor: 'black', // Black border color for the grid
                                borderDash: [5, 5], // Dashed horizontal grid lines
                                drawOnChartArea: true, // Ensure horizontal lines are drawn on the chart area
                                drawBorder: false,
                                drawTicks: false
                            }
                        }
                    }
                }
            });
        });
    </script>

    <!-- <script>
        if (document.getElementsByClassName('mySwiper')) {
            var swiper = new Swiper(".mySwiper", {
                effect: "cards",
                autoplay: {
                    delay: 3000,
                    // disableOnInteraction: false,
                },
                grabCursor: true,
                initialSlide: 0,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });
        };


        var ctx = document.getElementById("chart-bars").getContext("2d");

        new Chart(ctx, {
            type: "bar",
            data: {
                labels: ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10"],
                datasets: [{
                        label: "Sales",
                        tension: 0.4,
                        borderWidth: 0,
                        borderSkipped: false,
                        backgroundColor: "#2ca8ff",
                        data: [450, 200, 100, 220, 500, 100, 400, 230, 500, 200],
                        maxBarThickness: 6
                    },
                    {
                        label: "Sales",
                        tension: 0.4,
                        borderWidth: 0,
                        borderSkipped: false,
                        backgroundColor: "#7c3aed",
                        data: [200, 300, 200, 420, 400, 200, 300, 430, 400, 300],
                        maxBarThickness: 6
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                    tooltip: {
                        backgroundColor: '#fff',
                        titleColor: '#1e293b',
                        bodyColor: '#1e293b',
                        borderColor: '#e9ecef',
                        borderWidth: 1,
                        usePointStyle: true
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        stacked: true,
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [4, 4],
                        },
                        ticks: {
                            beginAtZero: true,
                            padding: 10,
                            font: {
                                size: 12,
                                family: "Noto Sans",
                                style: 'normal',
                                lineHeight: 2
                            },
                            color: "#64748B"
                        },
                    },
                    x: {
                        stacked: true,
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false
                        },
                        ticks: {
                            font: {
                                size: 12,
                                family: "Noto Sans",
                                style: 'normal',
                                lineHeight: 2
                            },
                            color: "#64748B"
                        },
                    },
                },
            },
        });


        var ctx2 = document.getElementById("chart-line").getContext("2d");

        var gradientStroke1 = ctx2.createLinearGradient(0, 230, 0, 50);

        gradientStroke1.addColorStop(1, 'rgba(45,168,255,0.2)');
        gradientStroke1.addColorStop(0.2, 'rgba(45,168,255,0.0)');
        gradientStroke1.addColorStop(0, 'rgba(45,168,255,0)'); //blue colors

        var gradientStroke2 = ctx2.createLinearGradient(0, 230, 0, 50);

        gradientStroke2.addColorStop(1, 'rgba(119,77,211,0.4)');
        gradientStroke2.addColorStop(0.7, 'rgba(119,77,211,0.1)');
        gradientStroke2.addColorStop(0, 'rgba(119,77,211,0)'); //purple colors

        new Chart(ctx2, {
            plugins: [{
                beforeInit(chart) {
                    const originalFit = chart.legend.fit;
                    chart.legend.fit = function fit() {
                        originalFit.bind(chart.legend)();
                        this.height += 40;
                    }
                },
            }],
            type: "line",
            data: {
                labels: ["Aug 18", "Aug 19", "Aug 20", "Aug 21", "Aug 22", "Aug 23", "Aug 24", "Aug 25", "Aug 26",
                    "Aug 27", "Aug 28", "Aug 29", "Aug 30", "Aug 31", "Sept 01", "Sept 02", "Sept 03", "Aug 22",
                    "Sept 04", "Sept 05", "Sept 06", "Sept 07", "Sept 08", "Sept 09"
                ],
                datasets: [{
                        label: "Volume",
                        tension: 0,
                        borderWidth: 2,
                        pointRadius: 3,
                        borderColor: "#2ca8ff",
                        pointBorderColor: '#2ca8ff',
                        pointBackgroundColor: '#2ca8ff',
                        backgroundColor: gradientStroke1,
                        fill: true,
                        data: [2828, 1291, 3360, 3223, 1630, 980, 2059, 3092, 1831, 1842, 1902, 1478, 1123,
                            2444, 2636, 2593, 2885, 1764, 898, 1356, 2573, 3382, 2858, 4228
                        ],
                        maxBarThickness: 6

                    },
                    {
                        label: "Trade",
                        tension: 0,
                        borderWidth: 2,
                        pointRadius: 3,
                        borderColor: "#832bf9",
                        pointBorderColor: '#832bf9',
                        pointBackgroundColor: '#832bf9',
                        backgroundColor: gradientStroke2,
                        fill: true,
                        data: [2797, 2182, 1069, 2098, 3309, 3881, 2059, 3239, 6215, 2185, 2115, 5430, 4648,
                            2444, 2161, 3018, 1153, 1068, 2192, 1152, 2129, 1396, 2067, 1215, 712, 2462,
                            1669, 2360, 2787, 861
                        ],
                        maxBarThickness: 6
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        align: 'end',
                        labels: {
                            boxWidth: 6,
                            boxHeight: 6,
                            padding: 20,
                            pointStyle: 'circle',
                            borderRadius: 50,
                            usePointStyle: true,
                            font: {
                                weight: 400,
                            },
                        },
                    },
                    tooltip: {
                        backgroundColor: '#fff',
                        titleColor: '#1e293b',
                        bodyColor: '#1e293b',
                        borderColor: '#e9ecef',
                        borderWidth: 1,
                        pointRadius: 2,
                        usePointStyle: true,
                        boxWidth: 8,
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [4, 4]
                        },
                        ticks: {
                            callback: function(value, index, ticks) {
                                return parseInt(value).toLocaleString() + ' EUR';
                            },
                            display: true,
                            padding: 10,
                            color: '#b2b9bf',
                            font: {
                                size: 12,
                                family: "Noto Sans",
                                style: 'normal',
                                lineHeight: 2
                            },
                            color: "#64748B"
                        }
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                            borderDash: [4, 4]
                        },
                        ticks: {
                            display: true,
                            color: '#b2b9bf',
                            padding: 20,
                            font: {
                                size: 12,
                                family: "Noto Sans",
                                style: 'normal',
                                lineHeight: 2
                            },
                            color: "#64748B"
                        }
                    },
                },
            },
        });
    </script> -->

</x-app-layout>