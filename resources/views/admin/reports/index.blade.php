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

                        <div class="row">
                            <div class="col-6">
                                <canvas id="chart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let chart = null;

        function getData(){
            console.log('getting data...');
            let value = document.getElementById('report_date').value;
            console.log(value);

            axios.get('{{ route('admin.reports.get_data') }}' + '?report_date=' + value)
                .then(response => {
                    console.log(response);

                    if(chart !== null){
                        chart.destroy();
                    }

                    chart = new Chart(document.getElementById('chart'), response.data.monthlySales);
                })
                .catch(error => {
                    console.log(error);
                });
        }
    </script>

@endsection
