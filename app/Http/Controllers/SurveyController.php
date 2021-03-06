<?php

namespace App\Http\Controllers;

use App\Page;
use App\Survey;
use App\SurveyOption;
use App\SurveyResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = Page::find(1);
        $topSubpages = $page->topSubpages;

        $surveys = Survey::with('results')->get();

        return view('admin.surveys.index', compact('topSubpages', 'surveys'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page = Page::find(1);
        $topSubpages = $page->topSubpages;

        $pages = Page::all()->pluck('name', 'id');

        return view('admin.surveys.form', compact('topSubpages', 'pages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title'    => 'required|unique:surveys,title',
            'question' => 'required',
            'page_id'  => 'required|exists:pages,id',
        ]);

        $survey = Survey::create([
            'title'    => $request->title,
            'question' => $request->question,
            'page_id'  => $request->page_id,
        ]);

        return redirect()->route('admin.surveys.show', ['survey' => $survey->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $survey = Survey::find($id);

        if (is_null($survey)) {
            abort(404);
        }

        $page = Page::find(1);
        $topSubpages = $page->topSubpages;

        $options = $survey->options()->withCount('results')->get();

        return view('admin.surveys.show', compact('topSubpages', 'survey', 'options'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $survey = Survey::find($id);

        if (is_null($survey)) {
            abort(404);
        }

        $page = Page::find(1);
        $topSubpages = $page->topSubpages;

        $pages = Page::all()->pluck('name', 'id');

        return view('admin.surveys.form', compact('topSubpages', 'pages', 'survey'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $survey = Survey::find($id);

        if (is_null($survey)) {
            abort(404);
        }

        $rules = [
            'question' => 'required',
            'page_id'  => 'required|exists:pages,id',
        ];

        if ($survey->title != $request->title) {
            $rules['title'] = 'required|unique:surveys,title';
        }

        $this->validate($request, $rules);

        $survey->title = $request->title;
        $survey->question = $request->question;
        $survey->page_id = $request->page_id;
        $survey->save();

        return redirect()->route('admin.surveys.show', ['survey' => $survey->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $survey = Survey::find($id);

        if (is_null($survey)) {
            abort(404);
        }

        if ($survey->results()->count() > 0) {
            return redirect()->back()->with(['status' => 'No puedes eliminar una encuesta con resultados', 'status-result' => 'danger']);
        }

        $survey->delete();

        return redirect()->back()->with(['status' => 'La encuesta fue eliminada correctamente', 'status-result' => 'success']);
    }

    public function submit(Request $request, $id)
    {
        $survey = Survey::find($id);

        if (is_null($survey)) {
            abort(404);
        }

        $this->validate($request, [
            'optionsRadio' => 'required|exists:survey_options,id',
        ]);

        SurveyResult::create([
            'survey_id' => $survey->id,
            'option_id' => $request->optionsRadio,
        ]);

        $page = Page::find(1);
        $topSubpages = $page->topSubpages;
        $options = $survey->options()->withCount('results');
        $back = URL::previous();

        return view('surveys.result', compact('survey', 'options', 'back', 'topSubpages'));
    }

    /**
     * SurveyOptions
     */

    public function createOption($survey)
    {
        $survey = Survey::find($survey);

        if (is_null($survey)) {
            abort(404);
        }

        $page = Page::find(1);
        $topSubpages = $page->topSubpages;

        return view('admin.surveys.options-form', compact('topSubpages', 'pages', 'survey'));
    }

    public function storeOption(Request $request, $survey)
    {
        $survey = Survey::find($survey);

        if (is_null($survey)) {
            abort(404);
        }

        $validator = Validator::make($request->all(), [
            'value' => 'required',
        ]);

        $validator->after(function ($validator) use ($survey, $request) {
            #TODO Trim survey options to avoid repeating options
            if ($survey->options()->where('value', 'LIKE', '%' . $request->value . '%')->exists()) {
                $validator->errors()->add('value', 'Ya existe el valor para esta encuesta');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $option = SurveyOption::create([
            'value'     => $request->value,
            'survey_id' => $survey->id,
        ]);

        return redirect()->back()->with(['status' => 'Opción creada correctamente!', 'status-result' => 'success']);
    }


    public function destroyOption(Request $request, $survey, $id)
    {
        $survey = Survey::find($survey);

        if (is_null($survey)) {
            abort(404);
        }

        $option = SurveyOption::find($id);

        if (is_null($option)) {
            abort(404);
        }

        if ($option->results()->count() > 0) {
            return redirect()->back()->with(['status' => 'No puedes eliminar una opción que ya ha sido escogida!', 'status-result' => 'danger']);
        }

        $option->delete();

        return redirect()->back()->with(['status' => 'Opción eliminada correctamente!', 'status-result' => 'success']);
    }
}
