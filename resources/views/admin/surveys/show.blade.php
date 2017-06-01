@extends('layouts.admin')

@section('admin-content')
    <a href="{{ route('admin.surveys.options.create', ['survey' => $survey->id]) }}" class="btn btn-success pull-right mt-20"><i class="fa fa-plus"></i></a>
    <h3>Encuesta: {{ $survey->title }}</h3>
    <hr class="mt-0">

    <table class="table table-bordered">
        <thead>
        <tr>
            <td>Valor</td>
            <td># Respuestas</td>
            <td></td>
            <td></td>
        </tr>
        </thead>
        <tbody>
        @forelse($options as $option)
            <tr>
                <td>{{ $option->value }}</td>
                <td>{{ $option->results()->count() }}</td>
                <td>
                    <a href="{{ route('admin.surveys.options.edit', ['survey' => $survey->id, 'option' => $option->id]) }}"
                       class="btn btn-warning"><i class="fa fa-pencil"></i></a>
                </td>
                <td>
                    <form action="{{ route('admin.surveys.options.destroy', ['survey' => $survey->id, 'option' => $option->id]) }}" method="post" role="form">
                        {{ csrf_token() }}
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
        <div class="form-group{{ $errors->has('value') ? ' has-error' : '' }}">
            <label for="value" class="col-md-2 control-label">Valor</label>

            <div class="col-md-4">
                <input id="value" type="text" class="form-control" name="value" value="{{ old('value')  }}" required>

                @if ($errors->has('value'))
                    <span class="help-block">
                        <strong>{{ $errors->first('value') }}</strong>
                    </span>
                @endif
            </div>

            <div class="col-md-6">
                <button class="btn btn-primary">Agregar</button>
            </div>
        </div>
    </form>
@endsection
