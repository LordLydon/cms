@extends('layouts.admin')

@section('admin-content')
    <a href="{{ route('admin.categories.create') }}" class="btn btn-success pull-right mt-20"><i class="fa fa-plus"></i></a>
    <h3>Categorías de Documentos</h3>
    <hr class="mt-0">
    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th># de Documentos</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse($categories as $category)
            <tr>
                <td>{{ $category->name }}</td>
                <td>{{ $category->description }}</td>
                <td>{{ $category->documents()->count() }}</td>
                <td class="text-center"><a href="{{ route('admin.categories.show', ['category' => $category->id]) }}" class="btn btn-primary"><i class="fa fa-eye"></i></a></td>
                <td class="text-center">
                    <a href="{{ route('admin.categories.edit', ['category' => $category->id]) }}" class="btn btn-warning"><i class="fa fa-pencil"></i></a>
                </td>
                <td class="text-center">
                    <form action="{{ route('admin.categories.destroy', ['category' => $category->id]) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('delete') }}
                        <button type="submit" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">No hay categorias</td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endsection
