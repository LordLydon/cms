<?php

namespace App\Http\Controllers;

use App\Survey;
use App\Page;
use App\SurveyResult;
use Illuminate\Http\Request;

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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function submit(Request $request, $id)
    {
        $survey = Survey::find($id);

        if (is_null($survey)) {
            abort(404);
        }

        $this->validate($request, [
            'optionsRadio' => 'required|exists:survey_options,id'
        ]);

        SurveyResult::create([
            'survey_id' => $survey->id,
            'option_id' => $request->optionsRadio
        ]);

        return back();
    }
}
