@extends('layouts.admin')

@section('admin-content')
    <h3>{{ isset($document) ? 'Editar' : 'Crear' }} Documento</h3>
    <hr class="mt-0">

    <form class="form-horizontal" role="form" method="post"
          action="{{ isset($document) ? route('admin.categories.documents.update', ['category' => $category->id, 'document' => $document->id]) : route('admin.categories.documents.store', ['category' => $category->id]) }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        {{ isset($document) ? method_field('put') : '' }}

        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name" class="col-md-3 control-label">Nombre</label>

            <div class="col-md-6">
                <input id="name" type="text" class="form-control" name="name"
                       value="{{ old('name') ?: (isset($document) ? $document->name : '') }}" required autofocus>

                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
            <label for="description" class="col-md-3 control-label">Descripción</label>

            <div class="col-md-6">
                <input id="description" type="text" class="form-control" name="description"
                       value="{{ old('description') ?: (isset($document) ? $document->description : '') }}" required>

                @if ($errors->has('description'))
                    <span class="help-block">
                        <strong>{{ $errors->first('description') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('keywords') ? ' has-error' : '' }}">
            <label for="keywords" class="col-md-3 control-label">Palabras Clave</label>

            <div class="col-md-6">
                <input id="keywords" type="text" class="form-control" name="keywords"
                       value="{{ old('keywords') ?: (isset($document) ? $document->keywords : '') }}">
                <span class="help-block">Ingresa las palabras clave separadas por coma.</span>
                @if ($errors->has('keywords'))
                    <span class="help-block">
                        <strong>{{ $errors->first('keywords') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('document') ? ' has-error' : '' }}">
            <label for="document" class="col-md-3 control-label">Documento</label>

            <div class="col-md-6">
                <input type="file" id="document" name="document">

                @if ($errors->has('document'))
                    <span class="help-block">
                        <strong>{{ $errors->first('document') }}</strong>
                    </span>
                @endif
            </div>
        </div>


        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                    {{ isset($document) ? 'Editar' : 'Crear' }} Usuario
                </button>
            </div>
        </div>
    </form>

@endsection
