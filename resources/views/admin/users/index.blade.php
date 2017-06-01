@extends('layouts.admin')

@section('admin-content')
    <a href="{{ route('admin.users.create') }}" class="btn btn-success pull-right mt-20"><i class="fa fa-plus"></i></a>
    <h3>Usuarios</h3>
    <hr class="mt-0">
    @if (session('status'))
        <div class="alert alert-{{ session('status-result') }}">
            {{ session('status') }}
        </div>
    @endif
    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>Nombre</th>
            <th>E-Mail</th>
            <th>Fecha de Creación</th>
            <th>Último Acceso</th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at->format('d/m/Y g:ia') }}</td>
                <td>{{ is_null($user->last_login) ? '-' : $user->last_login->format('d/m/Y g:ia') }}</td>
                <td class="text-center">
                    <a href="{{ route('admin.users.edit', ['user' => $user->id]) }}" class="btn btn-warning"><i class="fa fa-pencil"></i></a>
                </td>
                <td class="text-center">
                    @if($user->id != Auth::user()->id)
                        <form action="{{ route('admin.users.destroy', ['user' => $user->id]) }}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('delete') }}
                            <button type="submit" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>
                        </form>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">No hay usuarios</td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endsection
