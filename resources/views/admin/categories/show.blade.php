@extends('layouts.admin')

@section('admin-content')
    <a href="{{ route('admin.categories.documents.create', ['category' => $category->id]) }}"
       class="btn btn-success pull-right mt-20"><i class="fa fa-upload"></i></a>
    <h3>Categorías de Documentos: {{ $category->name }}</h3>
    <hr class="mt-0">

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Palabras Clave</th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse($documents as $document)
            <tr>
                <td>{{ $document->name }}</td>
                <td>{{ $document->description }}</td>
                <td>{{ $document->keywords }}</td>
                <td class="text-center">
                    <a href="{{ route('categories.documents.show', ['categories' => $category->id, 'document' => $document->id]) }}"
                       class="btn btn-primary"><i class="fa fa-eye"></i></a></td>
                <td class="te">
                    <form action="{{ route('admin.categories.documents.destroy', ['category' => $category->id, 'document' => $document->id]) }}"
                          method="post" role="form">
                        {{ csrf_field() }}
                        {{ method_field('delete') }}
                        <button type="submit" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">No existen documentos en esta categoría.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endsection
