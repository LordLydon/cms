@extends('layouts.admin')

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('/css/select2.min.css') }}">
@endpush


@section('admin-content')
    <h3>{{ isset($category) ? 'Editar' : 'Crear' }} Categoría</h3>
    <hr class="mt-0">

    <form class="form-horizontal" role="form" method="post"
          action="{{ isset($category) ? route('admin.categories.update', ['category' => $category->id]) : route('admin.categories.store') }}">
        {{ csrf_field() }}
        {{ isset($category) ? method_field('put') : '' }}

        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name" class="col-md-3 control-label">Nombre</label>

            <div class="col-md-6">
                <input id="name" type="text" class="form-control" name="name"
                       value="{{ old('name') ?: (isset($category) ? $category->name : '') }}" required autofocus>

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
                       value="{{ old('description') ?: (isset($category) ? $category->description : '') }}" required>

                @if ($errors->has('description'))
                    <span class="help-block">
                        <strong>{{ $errors->first('description') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('page_id') ? ' has-error' : '' }}">
            <label for="category_id" class="col-md-3 control-label">Habilitada en</label>

            <div class="col-md-6">
                {{ Form::select('page_id', $pages, 1, ['placeholder' => 'Elige la página donde mostrarla', 'required' => 'required', 'style' => 'width:100%', 'id' => 'page_id']) }}
                @if ($errors->has('page_id'))
                    <span class="help-block">
                        <strong>{{ $errors->first('page_id') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6 col-md-offset-3">
                <button type="submit" class="btn btn-primary">
                    {{ isset($category) ? 'Editar' : 'Crear' }} Categoría
                </button>
            </div>
        </div>
    </form>

@endsection

@push('scripts')
<script src="{{ asset('/js/select2.min.js') }}"></script>
<script src="{{ asset('/js/i18n/es.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var selpage = $("#page_id");
        $.fn.select2.defaults.set("language", "es");
        selpage.select2();

        if (window.matchMedia("(max-width: 480px)").matches) {
            /* the viewport is at most 480 pixels wide */
            /* disable autofocus on select2 open*/
            selpage.on('select2:open', function (e) {
                $('.select2-search input').prop('focus', false);
            });
        }
    });
</script>
@endpush
