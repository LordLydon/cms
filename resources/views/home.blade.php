@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">

            {{-- Main Content --}}
            <div class="panel panel-default col-md-6 col-md-push-3">
                <div class="panel-body">
                    {!! $page->content !!}
                </div>
            </div>

            {{-- Left Menu --}}
            @if($leftSubpages->count() > 0 || !is_null($survey))
                <div class="panel panel-default col-md-2 col-md-pull-6">
                    @if($leftSubpages->count() > 0)
                        <ul class="list-group text-center">
                            @foreach($leftSubpages as $subpage)
                                <li class="list-group-item">
                                    <a href="{{ route('pages.show', ['page' => $subpage->id]) }}" {{ isset($active) ? ($active == $subpage->id ? 'class=active' : '') : '' }}>{{ $subpage->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    @if(!is_null($survey))
                        <div class="panel-footer survey-div">
                            <hr>
                            <h5 class="text-center">Encuesta: {{ $survey->title }}</h5>
                            <hr>
                            <form action="{{ route('surveys.submit', ['survey' => $survey->id]) }}" method="post"
                                  role="form">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label class="control-label">{{ $survey->question }}</label>
                                    <div class="option-group">
                                        @foreach($survey->options as $key => $option)
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="optionsRadio" value="{{ $option->id }}" {{ $key == 0 ? 'checked' : '' }} required> {{ $option->value }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="form-group text-center">
                                    <button type="submit" class="btn btn-primary">Enviar</button>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            @endif

            {{-- Right Menu --}}
            @if($rightSubpages->count() > 0 || $categories->count() > 0)
                <div class="panel panel-default col-md-2 col-md-push-2">
                    @if($rightSubpages->count() > 0)
                        <ul class="list-group text-center">
                            @foreach($rightSubpages as $subpage)
                                <li class="list-group-item">
                                    <a href="{{ route('pages.show', ['page' => $subpage->id]) }}" {{ isset($active) ? ($active == $subpage->id ? 'class=active' : '') : '' }}>{{ $subpage->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    @if($categories->count() > 0)
                        <div class="panel-body documents-div text-left">
                            <hr>
                            <h5 class="text-center">Documentos</h5>
                            <hr>
                            @foreach($categories as $category)
                                <div class="panel panel-default">
                                    <div class="panel-heading">{{ $category->name }}</div>
                                    <ul class="list-group">
                                        @forelse($category->documents as $document)
                                            <li class="list-group-item">
                                                <a href="{{ route('categories.documents.show', ['category' => $category->id,'document' => $document->id]) }}">{{ $document->name }}</a>
                                            </li>
                                        @empty
                                            <li class="list-group-item">No existen documentos con esta categoría.</li>
                                        @endforelse
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>


@endsection

@push('scripts')
    <script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
@endpush
