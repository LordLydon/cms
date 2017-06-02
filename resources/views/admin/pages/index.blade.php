@extends('layouts.admin')

@section('admin-content')
    <a href="{{ route('admin.pages.create') }}" class="btn btn-success pull-right mt-20"><i class="fa fa-plus"></i></a>
    <h3>Páginas</h3>
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
            <th>Privado?</th>
            <th>Ubicación</th>
            <th>Creador</th>
            <th>Fecha de Creación</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse($pages as $page)
            <tr>
                <td>{{ $page->name }}
                    @if(!is_null($page->superpage))
                        <small>({{ $page->superpage->name }})</small>
                    @endif
                </td>
                <td>{{ $page->is_private ? 'Si' : 'No' }}</td>
                <td>{{ $page->position }}</td>
                <td>{{ $page->user->name }}</td>
                <td>{{ $page->created_at->format('d/m/Y g:ia') }}</td>
                <td class="text-center"><a href="{{ route('pages.show', ['page' => $page->id]) }}" class="btn btn-primary"><i class="fa fa-eye"></i></a></td>
                <td class="text-center">
                    <a href="{{ route('admin.pages.edit', ['page' => $page->id]) }}" class="btn btn-warning"><i
                                class="fa fa-pencil"></i></a>
                </td>
                <td class="text-center">
                    @if($page->id != 1)
                        <form action="{{ route('admin.pages.destroy', ['page' => $page->id]) }}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('delete') }}
                            <button type="submit" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>
                        </form>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">No hay páginas</td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endsection
