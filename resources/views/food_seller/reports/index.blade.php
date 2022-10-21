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

                        <div class="row justify-content-center">
                            <div class="col-6">
                                <canvas id="year_monthlySalesChart"></canvas>
                            </div>
                        </div>

                        <div class="row justify-content-center mb-4">
                            <div class="col-6">
                                <canvas id="year_productSalesChart"></canvas>
                            </div>
                        </div>

                    </div>

                    <div id="monthly" hidden>

                        <div class="row justify-content-center">
                            <div class="col-6">
                                <canvas id="month_dailySalesChart"></canvas>
                            </div>
                        </div>

                        <div class="row justify-content-center mb-4">
                            <div class="col-6">
                                <canvas id="month_productSalesChart"></canvas>
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
        year_productSalesChart = null,
        month_dailySalesChart = null,
        month_productSalesChart = null;

    let result = null;

    function getData() {
        console.log('getting data...');
        let value = document.getElementById('report_date').value;
        console.log(value);

        axios.get('{{ route("food_seller.reports.get_data") }}' + '?report_date=' + value)
            .then(response => {
                console.log(response);

                result = response.data;

                resetCharts();

                if (response.data.type === 'year') {
                    showYearChart();

                    year_productSalesChart = new Chart(document.getElementById('year_productSalesChart'), response.data.productSales.chart);
                    year_monthlySalesChart = new Chart(document.getElementById('year_monthlySalesChart'), response.data.monthlySales.chart);
                } else {
                    showMonthChart();

                    month_productSalesChart = new Chart(document.getElementById('month_productSalesChart'), response.data.productSales.chart);
                    month_dailySalesChart = new Chart(document.getElementById('month_dailySalesChart'), response.data.dailySales.chart);
                }

            })
            .catch(error => {
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
            }, {
                image: document.getElementById('year_productSalesChart').toDataURL('image/png'),
                width: defaultSize[0] / 1.5,
                alignment: 'center',
                margin: 5,
                pageBreak: 'before',
            }];

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
                                    body: result.productSales.table,
                                },
                            }, {
                                width: '*',
                                text: ''
                            },
                        ],
                    },
                ],
            };

        } else {

            images = [{
                image: document.getElementById('month_dailySalesChart').toDataURL('image/png'),
                width: defaultSize[0] / 1.5,
                alignment: 'center',
                margin: 5,
            }, {
                image: document.getElementById('month_productSalesChart').toDataURL('image/png'),
                width: defaultSize[0] / 1.5,
                alignment: 'center',
                margin: 5,
                pageBreak: 'before',
            }];

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
                                    body: result.dailySales.table,
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
                                    body: result.productSales.table,
                                },
                            }, {
                                width: '*',
                                text: ''
                            },
                        ],
                    },
                ],
            };

        }

        pdfMake.createPdf(dd).download(result.appName + ' - ' + result.title);

    }

    function resetCharts() {
        if (year_monthlySalesChart !== null) {
            year_monthlySalesChart.destroy();
        }

        if (year_productSalesChart !== null) {
            year_productSalesChart.destroy();
        }

        if (month_dailySalesChart !== null) {
            month_dailySalesChart.destroy();
        }

        if (month_productSalesChart !== null) {
            month_productSalesChart.destroy();
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