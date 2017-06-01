@extends('layouts.admin')

@section('admin-content')
    <h3>{{ isset($option) ? 'Editar' : 'Crear' }} Opciones</h3>
    <hr class="mt-0">

    <form class="form-horizontal" role="form" method="post" action="{{ isset($option) ? route('admin.surveys.options.update', ['survey' => $survey->id, 'option' => $option->id]) : route('admin.survey.options.store', ['survey' => $survey->id]) }}">
        {{ csrf_field() }}
        {{ isset($option) ? method_field('put') : '' }}

        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name" class="col-md-4 control-label">Valor</label>

            <div class="col-md-6">
                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') ?: (isset($option) ? $option->name : '') }}" required autofocus>

                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="email" class="col-md-4 control-label">E-Mail</label>

            <div class="col-md-6">
                <input id="email" type="text" class="form-control" name="email" value="{{ old('email') ?: (isset($option) ? $option->email : '') }}" required>

                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                    {{ isset($option) ? 'Editar' : 'Crear' }} Usuario
                </button>
            </div>
        </div>
    </form>

@endsection
