@extends('layouts.admin')

@section('admin-content')
    <h3>{{ isset($user) ? 'Editar' : 'Crear' }} Usuario</h3>
    <hr class="mt-0">

    <form class="form-horizontal" role="form" method="post" action="{{ isset($user) ? route('admin.users.update', ['user' => $user->id]) : route('admin.users.store') }}">
        {{ csrf_field() }}
        {{ isset($user) ? method_field('put') : '' }}

        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name" class="col-md-4 control-label">Nombre</label>

            <div class="col-md-6">
                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') ?: (isset($user) ? $user->name : '') }}" required autofocus>

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
                <input id="email" type="text" class="form-control" name="email" value="{{ old('email') ?: (isset($user) ? $user->email : '') }}" required>

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
                    {{ isset($user) ? 'Editar' : 'Crear' }} Usuario
                </button>
            </div>
        </div>
    </form>

@endsection
