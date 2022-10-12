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

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let yearly = document.getElementById('yearly'), monthly = document.getElementById('monthly');

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
        yearly.hidden = false;
        monthly.hidden = true;
    }

    function showMonthChart() {
        yearly.hidden = true;
        monthly.hidden = false;
    }
</script>

@endsection