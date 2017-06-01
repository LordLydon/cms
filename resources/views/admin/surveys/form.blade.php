@extends('layouts.admin')

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('/css/select2.min.css') }}">
@endpush


@section('admin-content')
    <h3>{{ isset($survey) ? 'Editar' : 'Crear' }} Encuesta</h3>
    <hr class="mt-0">

    <form class="form-horizontal" role="form" method="post"
          action="{{ isset($survey) ? route('admin.surveys.update', ['survey' => $survey->id]) : route('admin.surveys.store') }}">
        {{ csrf_field() }}
        {{ isset($survey) ? method_field('put') : '' }}

        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
            <label for="title" class="col-md-4 control-label">Título</label>

            <div class="col-md-6">
                <input id="title" type="text" class="form-control" name="title"
                       value="{{ old('title') ?: (isset($survey) ? $survey->title : '') }}" required autofocus>

                @if ($errors->has('title'))
                    <span class="help-block">
                        <strong>{{ $errors->first('title') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('question') ? ' has-error' : '' }}">
            <label for="question" class="col-md-4 control-label">Descripción</label>

            <div class="col-md-6">
                <input id="question" type="text" class="form-control" name="question"
                       value="{{ old('question') ?: (isset($survey) ? $survey->question : '') }}" required>

                @if ($errors->has('question'))
                    <span class="help-block">
                        <strong>{{ $errors->first('question') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('page_id') ? ' has-error' : '' }}">
            <label for="survey_id" class="col-md-4 control-label">Habilitada en</label>

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
            <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                    {{ isset($survey) ? 'Editar' : 'Crear' }} Encuesta
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
