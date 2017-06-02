@extends('layouts.admin')

@section('admin-content')
    <h3>Encuesta: {{ $survey->title }}</h3>
    <h6><b>Pregunta:</b> {{ $survey->question }}</h6>
    <hr class="mt-0">
    @if (session('status'))
        <div class="alert alert-{{ session('status-result') }}">
            {{ session('status') }}
        </div>
    @endif

    <h4>Resultados</h4>

    <canvas id="myChart" max-width="350" max-height="350"></canvas>

    <br>

    <table class="table table-bordered">
        <thead>
        <tr>
            <td>Valor</td>
            <td># Respuestas</td>
            <td></td>
        </tr>
        </thead>
        <tbody>
        @forelse($options as $option)
            <tr>
                <td>{{ $option->value }}</td>
                <td>{{ $option->results()->count() }}</td>
                <td class="text-center">
                    <form action="{{ route('admin.surveys.options.destroy', ['survey' => $survey->id, 'option' => $option->id]) }}" method="post" role="form">
                        {{ csrf_field() }}
                        {{ method_field('delete') }}
                        <button class="btn btn-danger"><i class="fa fa-trash-o"></i></button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4">No existen opciones para esta encuesta.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <form class="form-horizontal" role="form" method="post" action="{{ route('admin.surveys.options.store', ['survey' => $survey->id]) }}">
        {{ csrf_field() }}
        <div class="form-group{{ $errors->has('value') ? ' has-error' : '' }}">
            <label for="value" class="col-xs-3 control-label">Valor</label>

            <div class="col-md-4 col-xs-9">
                <input id="value" type="text" class="form-control" name="value" value="{{ old('value')  }}" required>

                @if ($errors->has('value'))
                    <span class="help-block">
                        <strong>{{ $errors->first('value') }}</strong>
                    </span>
                @endif
            </div>

            <div class="col-md-5 col-xs-12">
                <button class="btn btn-primary">Agregar</button>
            </div>
        </div>
    </form>
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
