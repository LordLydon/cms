@extends('layouts.admin')

@section('admin-content')
    <a href="{{ route('admin.surveys.create') }}" class="btn btn-success pull-right mt-20"><i class="fa fa-plus"></i></a>
    <h3>Encuestas</h3>
    <hr class="mt-0">
    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>Titulo</th>
            <th>Pregunta</th>
            <th># de Respuestas</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse($surveys as $survey)
            <tr>
                <td>{{ $survey->title }}</td>
                <td>{{ $survey->question }}</td>
                <td>{{ $survey->results()->count() }}</td>
                <td class="text-center"><a href="{{ route('admin.surveys.show', ['survey' => $survey->id]) }}" class="btn btn-primary"><i class="fa fa-eye"></i></a></td>
                <td class="text-center">
                    <a href="{{ route('admin.surveys.edit', ['survey' => $survey->id]) }}" class="btn btn-warning"><i class="fa fa-pencil"></i></a>
                </td>
                <td class="text-center">
                    <form action="{{ route('admin.surveys.destroy', ['survey' => $survey->id]) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('delete') }}
                        <button type="submit" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">No hay encuestas</td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endsection
