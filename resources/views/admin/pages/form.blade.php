@extends('layouts.admin')

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('/css/select2.min.css') }}">
@endpush


@section('admin-content')
    <h3>{{ isset($page) ? 'Editar' : 'Crear' }} Página</h3>
    <hr class="mt-0">

    <form class="form-horizontal" role="form" method="post"
          action="{{ isset($page) ? route('admin.pages.update', ['page' => $page->id]) : route('admin.pages.store') }}">
        {{ csrf_field() }}
        {{ isset($page) ? method_field('put') : '' }}

        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name" class="col-md-4 control-label">Nombre</label>

            <div class="col-md-6">
                <input id="name" type="text" class="form-control" name="name"
                       value="{{ old('name') ?: (isset($page) ? $page->name : '') }}" required autofocus>

                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('position') ? ' has-error' : '' }}">
            <label for="position" class="col-md-4 control-label">Ubicación</label>

            <div class="col-md-6">
                <select class="form-control" id="position" name="position" required>
                    @if(!isset($page) || $page->id != 1)
                        <option value="top" {{ isset($page) ? ($page->position == 'top' ? 'selected' : '') : '' }}>
                            Arriba
                        </option>
                        <option value="left" {{ isset($page) ? ($page->position == 'left' ? 'selected' : '') : '' }}>
                            Izquierda
                        </option>
                        <option value="right" {{ isset($page) ? ($page->position == 'right' ? 'selected' : '') : '' }}>
                            Derecha
                        </option>
                    @endif
                    <option value="none" {{ isset($page) ? ($page->position == 'none' ? 'selected' : '') : '' }}>
                        No mostrar
                    </option>
                </select>

                @if ($errors->has('position'))
                    <span class="help-block">
                        <strong>{{ $errors->first('position') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('page_id') ? ' has-error' : '' }}">
            <label for="page_id" class="col-md-4 control-label">Superpágina</label>

            <div class="col-md-6">
                {{ Form::select('page_id', $pages, 1, ['placeholder' => 'Elige la superpágina', 'required' => 'required', 'style' => 'width:100%', 'id' => 'page_id']) }}
                @if ($errors->has('page_id'))
                    <span class="help-block">
                        <strong>{{ $errors->first('page_id') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-offset-4">
                <div class="checkbox">
                    <label>
                        <input name="is_private"
                               type="checkbox" {{ isset($page) ? ($page->is_private ? 'checked' : '') : '' }} {{ isset($page) ? ($page->id == 1 ? 'disabled' : '') : '' }}>
                        Privado?
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
            <label for="content" class="control-label">Contenido</label>
            @if ($errors->has('content'))
                <span class="help-block">
                    <strong>{{ $errors->first('content') }}</strong>
                </span>
            @endif
            <hr class="mt-0">
            <textarea name="content" id="content" required>
                {!! isset($page) ? $page->content : '' !!}
            </textarea>
        </div>

        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                    {{ isset($page) ? 'Editar' : 'Crear' }} Página
                </button>
            </div>
        </div>
    </form>

@endsection

@push('scripts')
<script src="{{ asset('/js/select2.min.js') }}"></script>
<script src="{{ asset('/js/i18n/es.js') }}"></script>
<script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var selPage = $("#page_id");
        $.fn.select2.defaults.set("language", "es");
        selPage.select2();

        if (window.matchMedia("(max-width: 480px)").matches) {
            /* the viewport is at most 480 pixels wide */
            /* disable autofocus on select2 open*/
            selPage.on('select2:open', function (e) {
                $('.select2-search input').prop('focus', false);
            });
        }

        tinymce.init({
            selector: '#content',  // change this value according to your HTML
            theme: 'modern',
            width: '100%',
            height: 300,
            language: 'es',
            plugins: [
                'advlist autolink link image lists charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
                'save table contextmenu directionality emoticons template paste textcolor'
            ],
            content_css: '{{ asset('css/paper.bootstrap.min.css') }}',
            toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons'
        });

    });
</script>
@endpush
