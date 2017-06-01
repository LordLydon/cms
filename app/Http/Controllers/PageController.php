<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $page = Page::find(1);
        $topSubpages = $page->topSubpages;

        $pages = Page::all()->pluck('name', 'id');

        return view('admin.pages.form', compact('topSubpages', 'pages'));
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
            'name'       => 'required|unique:pages,name',
            'position'   => 'required|in:top,left,right,none',
            'is_private' => 'sometimes',
            'page_id'    => 'required|exists:pages,id',
            'content'    => 'required|string',
        ]);

        $page = Page::create([
            'name'       => $request->name,
            'position'   => $request->position,
            'is_private' => $request->has('is_private'),
            'page_id'    => $request->page_id,
            'content'    => $request['content'],
            'user_id'    => Auth::user()->id,
        ]);

        return redirect()->route('pages.show', ['page' => $page->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id = 1)
    {
        $page = Page::find($id);

        if (is_null($page) || (Auth::guest() && $page->is_private)) {
            // If the page doesn't exist in the db, or the page is private & the user isn't logged in, then send 404 response
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
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = Page::find(1);
        $topSubpages = $page->topSubpages;

        $page = Page::find($id);

        if (is_null($page)) {
            abort(404);
        }

        $pages = Page::all()->pluck('name', 'id');

        return view('admin.pages.form', compact('topSubpages', 'pages', 'page'));
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
        $page = Page::find($id);

        if (is_null($page)) {
            abort(404);
        }

        $validation = [
            'position'   => 'required|in:top,left,right,none',
            'is_private' => 'sometimes',
            'page_id'    => 'required|exists:pages,id',
            'content'    => 'required|string',
        ];

        if ($page->name != $request->name) {
            $validation['name'] = 'required|unique:pages,name';
        }

        $this->validate($request, $validation);

        $page->name = $request->name;
        $page->content = $request['content'];
        $page->user_id = Auth::user()->id;

        if ($page->id == 1) {
            $page->position = 'none';
            $page->is_private = false;
            $page->page_id = null;
        } else {
            $page->position = $request->position;
            $page->is_private = $request->has('is_private');
            $page->page_id = $request->page_id;
        }

        $page->save();

        return redirect()->route('pages.show', ['page' => $page->id]);
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
        $page = Page::find($id);

        if (is_null($page)) {
            abort(404);
        }

        if ($page->id == 1) {
            return redirect()->back()->with(['status' => 'No se puede eliminar la página principal!', 'status-result' => 'danger']);
        }

        $page->delete();

        return redirect()->back()->with(['status' => 'Pagina eliminada correctamente!', 'status-result' => 'success']);
    }
}
