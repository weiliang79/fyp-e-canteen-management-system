@extends('layouts.app')

@section('content')

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-20">
            <div class="card">
                <div class="card-header">
                    {{ __('Reports') }}
                </div>

                <div class="card-body">

                    <div class="row mb-3">
                        <label for="" class="col-md-3 col-form-label text-md-end">{{ __('Report') }}</label>

                        <div class="col-md-8">
                            <div class="input-group">
                                <select class="form-control" name="report_date" id="report_date">
                                    <optgroup label="Year">
                                        @foreach($list->yearly as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </optgroup>
                                    <optgroup label="Month">
                                        @foreach($list->monthly as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </optgroup>
                                </select>

                                <button type="button" class="btn btn-primary" onclick="getData();">{{ __('Generate') }}</button>
                            </div>
                        </div>
                    </div>

                    <div id="yearly" hidden>
                        <div class="row justify-content-center mb-4">
                            <div class="col-6">
                                <canvas id="year_monthlySalesChart"></canvas>
                            </div>
                        </div>

                        <div class="row justify-content-center mb-4">
                            <div class="col-6">
                                <canvas id="year_storesSalesChart"></canvas>
                            </div>
                        </div>

                        <div class="row justify-content-center mb-4">
                            <div class="col-6">
                                <canvas id="year_productCategoriesSalesChart"></canvas>
                            </div>
                        </div>

                        <div class="row justify-content-center mb-4">
                            <div class="col-6">
                                <canvas id="year_topProductsSalesChart"></canvas>
                            </div>
                        </div>

                    </div>

                    <div id="monthly" hidden>

                        <div class="row justify-content-center mb-4">
                            <div class="col-6">
                                <canvas id="month_storesSalesChart"></canvas>
                            </div>
                        </div>

                        <div class="row justify-content-center mb-4">
                            <div class="col-6">
                                <canvas id="month_productCategoriesSalesChart"></canvas>
                            </div>
                        </div>

                        <div class="row justify-content-center mb-4">
                            <div class="col-6">
                                <canvas id="month_topProductsSalesChart"></canvas>
                            </div>
                        </div>

                    </div>

                    <div id="generatePdfButton" hidden>
                        <div class="row">
                            <div class="col-md-8 offset-md-3">
                                <button type="button" class="btn btn-primary" onclick="generatePdf()">{{ __('Generate PDF') }}</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let yearly = document.getElementById('yearly'),
        monthly = document.getElementById('monthly'),
        pdfButton = document.getElementById('generatePdfButton');

    let year_monthlySalesChart = null,
        year_storeSalesChart = null,
        year_productCategoriesSalesChart = null,
        year_topProductsSalesChart = null,
        month_productCategoriesSalesChart = null,
        month_storesSalesChart = null,
        month_topProductsSalesChart = null;

    let result = null;

    function getData() {
        let value = document.getElementById('report_date').value;

        axios.get('{{ route("admin.reports.get_data") }}' + '?report_date=' + value)
            .then(response => {
                result = response.data;
                resetCharts();

                if (response.data.type === 'year') {
                    showYearChart();
                    year_monthlySalesChart = new Chart(document.getElementById('year_monthlySalesChart'), response.data.monthlySales.chart);
                    year_storeSalesChart = new Chart(document.getElementById('year_storesSalesChart'), response.data.storesSales.chart);
                    year_productCategoriesSalesChart = new Chart(document.getElementById('year_productCategoriesSalesChart'), response.data.productCategoriesSales.chart);

                    if (response.data.topProductsSales !== null) {
                        year_topProductsSalesChart = new Chart(document.getElementById('year_topProductsSalesChart'), response.data.topProductsSales.chart);
                    }

                } else {
                    showMonthChart();
                    month_productCategoriesSalesChart = new Chart(document.getElementById('month_productCategoriesSalesChart'), response.data.productCategoriesSales.chart);
                    month_storesSalesChart = new Chart(document.getElementById('month_storesSalesChart'), response.data.storesSales.chart);

                    if (response.data.topProductsSales !== null) {
                        month_topProductsSalesChart = new Chart(document.getElementById('month_topProductsSalesChart'), response.data.topProductsSales.chart);
                    }
                }

            })
            .catch(error => {
                SwalWithBootstrap.fire({
                    title: 'Error',
                    html: 'The server have some errors when generating the reports.',
                    icon: 'error',
                });
                console.log(error);
            });
    }

    function generatePdf() {

        let defaultSize = pdfSize.A4;
        let dd, images;

        if (result.type === 'year') {
            images = [{
                    image: document.getElementById('year_monthlySalesChart').toDataURL('image/png'),
                    width: defaultSize[0] / 1.5,
                    alignment: 'center',
                    margin: 5,
                },
                {
                    image: document.getElementById('year_storesSalesChart').toDataURL('image/png'),
                    width: defaultSize[0] / 1.5,
                    alignment: 'center',
                    margin: 5,
                    pageBreak: 'before',
                },
                {
                    image: document.getElementById('year_productCategoriesSalesChart').toDataURL('image/png'),
                    width: defaultSize[0] / 1.5,
                    alignment: 'center',
                    margin: 5,
                    pageBreak: 'before',
                },
            ];

            dd = {
                pageSize: {
                    width: defaultSize[0],
                    height: defaultSize[1],
                },
                header: function() {
                    return [{
                        text: result.appName,
                        alignment: 'center',
                        fontSize: 9
                    }, ];
                },
                footer: function(currentPage, pageCount) {
                    return [{
                        text: currentPage.toString() + ' of ' + pageCount,
                        alignment: 'center',
                        fontSize: 9
                    }, ];
                },
                content: [{
                        text: result.appName + ' - ' + result.title,
                        alignment: 'center',
                    },
                    images[0],
                    {
                        columns: [{
                                width: '*',
                                text: ''
                            },
                            {
                                width: 'auto',
                                table: {
                                    headerRows: 1,
                                    body: result.monthlySales.table,
                                },
                            }, {
                                width: '*',
                                text: ''
                            },
                        ],
                    },
                    images[1],
                    {
                        columns: [{
                                width: '*',
                                text: ''
                            },
                            {
                                width: 'auto',
                                table: {
                                    headerRows: 1,
                                    body: result.storesSales.table,
                                },
                            }, {
                                width: '*',
                                text: ''
                            },
                        ],
                    },
                    images[2],
                    {
                        columns: [{
                                width: '*',
                                text: ''
                            },
                            {
                                width: 'auto',
                                table: {
                                    headerRows: 1,
                                    body: result.productCategoriesSales.table,
                                },
                            }, {
                                width: '*',
                                text: ''
                            },
                        ],
                    },
                ],
            };

            if (result.topProductsSales !== null) {
                dd.content.push({
                    image: document.getElementById('year_topProductsSalesChart').toDataURL('image/png'),
                    width: defaultSize[0] / 1.5,
                    alignment: 'center',
                    margin: 5,
                    pageBreak: 'before',
                }, {
                    columns: [{
                            width: '*',
                            text: ''
                        },
                        {
                            width: 'auto',
                            table: {
                                headerRows: 1,
                                body: result.topProductsSales.table,
                            },
                        }, {
                            width: '*',
                            text: ''
                        },
                    ],
                }, );
            }

        } else {
            images = [{
                    image: document.getElementById('month_storesSalesChart').toDataURL('image/png'),
                    width: defaultSize[0] / 1.5,
                    alignment: 'center',
                    margin: 5,
                },
                {
                    image: document.getElementById('month_productCategoriesSalesChart').toDataURL('image/png'),
                    width: defaultSize[0] / 1.5,
                    alignment: 'center',
                    margin: 5,
                    pageBreak: 'before',
                },
            ];

            dd = {
                pageSize: {
                    width: defaultSize[0],
                    height: defaultSize[1],
                },
                header: function() {
                    return [{
                        text: result.appName,
                        alignment: 'center',
                        fontSize: 9
                    }, ];
                },
                footer: function(currentPage, pageCount) {
                    return [{
                        text: currentPage.toString() + ' of ' + pageCount,
                        alignment: 'center',
                        fontSize: 9
                    }, ];
                },
                content: [{
                        text: result.appName + ' - ' + result.title,
                        alignment: 'center',
                    },
                    images[0],
                    {
                        columns: [{
                                width: '*',
                                text: ''
                            },
                            {
                                width: 'auto',
                                table: {
                                    headerRows: 1,
                                    body: result.storesSales.table,
                                },
                            }, {
                                width: '*',
                                text: ''
                            },
                        ],
                    },
                    images[1],
                    {
                        columns: [{
                                width: '*',
                                text: ''
                            },
                            {
                                width: 'auto',
                                table: {
                                    headerRows: 1,
                                    body: result.productCategoriesSales.table,
                                },
                            }, {
                                width: '*',
                                text: ''
                            },
                        ],
                    },
                ],
            };

            if (result.topProductsSales !== null) {
                dd.content.push({
                    image: document.getElementById('month_topProductsSalesChart').toDataURL('image/png'),
                    width: defaultSize[0] / 1.5,
                    alignment: 'center',
                    margin: 5,
                    pageBreak: 'before',
                }, {
                    columns: [{
                            width: '*',
                            text: ''
                        },
                        {
                            width: 'auto',
                            table: {
                                headerRows: 1,
                                body: result.topProductsSales.table,
                            },
                        }, {
                            width: '*',
                            text: ''
                        },
                    ],
                }, );
            }
        }

        pdfMake.createPdf(dd).download(result.appName + ' - ' + result.title);

    }

    function resetCharts() {
        if (year_monthlySalesChart !== null) {
            year_monthlySalesChart.destroy();
        }

        if (year_storeSalesChart !== null) {
            year_storeSalesChart.destroy();
        }

        if (year_productCategoriesSalesChart !== null) {
            year_productCategoriesSalesChart.destroy();
        }

        if (year_topProductsSalesChart !== null) {
            year_topProductsSalesChart.destroy();
        }

        if (month_productCategoriesSalesChart !== null) {
            month_productCategoriesSalesChart.destroy();
        }

        if (month_storesSalesChart !== null) {
            month_storesSalesChart.destroy();
        }

        if (month_topProductsSalesChart !== null) {
            month_topProductsSalesChart.destroy();
        }
    }

    function showYearChart() {
        yearly.hidden = false;
        monthly.hidden = true;
        pdfButton.hidden = false;
    }

    function showMonthChart() {
        yearly.hidden = true;
        monthly.hidden = false;
        pdfButton.hidden = false;
    }
</script>

@endsection