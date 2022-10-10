@extends('layouts.app')

@section('content')

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-20">
            <div class="card">
                <div class="card-header">
                    Reports
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

                                <button type="button" class="btn btn-primary" onclick="getData();">Generate</button>
                            </div>
                        </div>
                    </div>

                    <div class="row row-cols-2">
                        <div id="year_monthlySalesCol" class="col" hidden>
                            <canvas id="year_monthlySalesChart"></canvas>
                        </div>
                        <div id="year_storeSalesCol" class="col" hidden>
                            <canvas id="year_storesSalesChart"></canvas>
                        </div>
                        <div id="year_productCategoriesSalesCol" class="col" hidden>
                            <canvas id="year_productCategoriesSalesChart"></canvas>
                        </div>
                        <div id="month_productCategoriesSalesCol" class="col" hidden>
                            <canvas id="month_productCategoriesSalesChart"></canvas>
                        </div>
                        <div id="month_storesSalesCol" class="col" hidden>
                            <canvas id="month_storesSalesChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let year_monthlySalesCol = document.getElementById('year_monthlySalesCol'),
        year_storeSalesCol = document.getElementById('year_storeSalesCol'),
        year_productCategoriesSalesCol = document.getElementById('year_productCategoriesSalesCol'),
        month_productCategoriesSalesCol = document.getElementById('month_productCategoriesSalesCol'),
        month_storesSalesCol = document.getElementById('month_storesSalesCol');

    let year_monthlySalesChart = null,
        year_storeSalesChart = null,
        year_productCategoriesSalesChart = null,
        month_productCategoriesSalesChart = null,
        month_storesSalesChart = null;

    function getData() {
        console.log('getting data...');
        let value = document.getElementById('report_date').value;
        console.log(value);

        axios.get('{{ route("admin.reports.get_data") }}' + '?report_date=' + value)
            .then(response => {
                console.log(response);

                resetCharts();

                if (response.data.type === 'year') {
                    showYearChart();
                    year_monthlySalesChart = new Chart(document.getElementById('year_monthlySalesChart'), response.data.monthlySales);
                    year_storeSalesChart = new Chart(document.getElementById('year_storesSalesChart'), response.data.storesSales);
                    year_productCategoriesSalesChart = new Chart(document.getElementById('year_productCategoriesSalesChart'), response.data.productCategoriesSales);
                } else {
                    showMonthChart();
                    month_productCategoriesSalesChart = new Chart(document.getElementById('month_productCategoriesSalesChart'), response.data.productCategoriesSales);
                    month_storesSalesChart = new Chart(document.getElementById('month_storesSalesChart'), response.data.storesSales);
                }

            })
            .catch(error => {
                console.log(error);
            });
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

        if (month_productCategoriesSalesChart !== null) {
            month_productCategoriesSalesChart.destroy();
        }

        if (month_storesSalesChart !== null) {
            month_storesSalesChart.destroy();
        }
    }

    function showYearChart() {
        year_monthlySalesCol.hidden = false;
        year_storeSalesCol.hidden = false;
        year_productCategoriesSalesCol.hidden = false;
        month_productCategoriesSalesCol.hidden = true;
        month_storesSalesCol.hidden = true;
    }

    function showMonthChart() {
        year_monthlySalesCol.hidden = true;
        year_storeSalesCol.hidden = true;
        year_productCategoriesSalesCol.hidden = true;
        month_productCategoriesSalesCol.hidden = false;
        month_storesSalesCol.hidden = false;
    }
</script>

@endsection