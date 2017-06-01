@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <!-- Sidebar -->

                <div class="panel panel-default">
                    <div class="panel-body">
                        <ul class="nav nav-pills nav-stacked col-md-2">
                            <li {{ Route::currentRouteName() == 'admin.users.index' ? 'class=active' : '' }}>
                                <a href="{{ route('admin.users.index') }}">Usuarios</a>
                            </li>
                            <li {{ Route::currentRouteName() == 'admin.pages.index' ? 'class=active' : '' }}>
                                <a href="{{ route('admin.pages.index') }}">Páginas</a>
                            </li>
                            <li {{ Route::currentRouteName() == 'admin.categories.index' ? 'class=active' : '' }}>
                                <a href="{{ route('admin.categories.index') }}">Categorias</a>
                            </li>
                            <li {{ Route::currentRouteName() == 'admin.surveys.index' ? 'class=active' : '' }}>
                                <a href="{{ route('admin.surveys.index') }}">Encuestas</a>
                            </li>
                        </ul>
                        <div class="col-md-10">
                            @yield('admin-content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
