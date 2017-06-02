@extends('layouts.app')

@section('content')
    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                {{ $survey->title }}
            </div>
            <div class="panel-body">
                {{ $survey->question }}

                <canvas id="myChart" max-width="350" max-height="350"></canvas>
            </div>
            <div class="panel-footer">
                <a href="{{ url($back) }}" class="btn btn-primary">Volver</a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="{{ asset('js/Chart.min.js') }}"></script>
<script>
    var ctx = $("#myChart");
    var data = {
        labels: {!! json_encode($options->pluck('value')->all()) !!},
        datasets: [{
            label: "# de votos",
            data: {{ json_encode($options->pluck('results_count')->all()) }}
        }]
    };
    var options = [];
    var myBarChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: options
    });
</script>
@endpush
