<?php

namespace App\Http\Controllers;

use App\Category;
use App\Page;
use Illuminate\Http\Request;

class PageController extends Controller
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

        $pages = Page::all();

        return view('admin.pages.index', compact('topSubpages', 'pages'));
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
    public function show($id = 1)
    {
        $page = Page::find($id);

        if(is_null($page)) {
            abort(404);
        }

        $active = $page->id;

        $topSubpages = $page->topSubpages;
        $leftSubpages = $page->leftSubpages;
        $rightSubpages = $page->rightSubpages;
        $survey = $page->survey;
        $categories = $page->categories;

        if (!is_null($page->superpage)) {
            // If the subpage doesn't have subpages for a position, a survey or categories, show the superpage's

            if ($topSubpages->count() <= 0) {
                $topSubpages = $page->superpage->topSubpages;
            }

            if ($leftSubpages->count() <= 0) {
                $leftSubpages = $page->superpage->leftSubpages;
            }

            if ($rightSubpages->count() <= 0) {
                $rightSubpages = $page->superpage->rightSubpages;
            }

            if (is_null($survey)) {
                $survey = $page->superpage->survey;
            }

            if ($categories->count() <= 0) {
                $categories = $page->superpage->categories;
            }
        }

        return view('home', compact('topSubpages', 'leftSubpages', 'rightSubpages', 'survey', 'categories', 'page', 'active'));
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
}
