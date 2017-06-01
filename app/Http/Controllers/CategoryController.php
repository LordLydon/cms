<?php

namespace App\Http\Controllers;

use App\Category;
use App\Page;
use Illuminate\Http\Request;

class CategoryController extends Controller
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

        $categories = Category::with('documents')->get();

        return view('admin.categories.index', compact('topSubpages', 'categories'));
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

        return view('admin.categories.form', compact('topSubpages', 'pages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:categories,name',
            'description' => 'required',
            'page_id' => 'required|exists:pages,id'
        ]);

        $cat = Category::create([
            'name' => $request->name,
            'description' => $request->description,
            'page_id' => $request->page_id
        ]);

        return redirect()->route('admin.categories.show', ['category' => $cat->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::with('documents')->find($id);

        if ($category == null) {
            abort(404);
        }

        $page = Page::find(1);
        $topSubpages = $page->topSubpages;

        $documents = $category->documents;

        return view('admin.categories.show', compact('topSubpages', 'category', 'documents'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);

        if ($category == null) {
            abort(404);
        }

        $page = Page::find(1);
        $topSubpages = $page->topSubpages;

        $pages = Page::all()->pluck('name', 'id');

        return view('admin.categories.form', compact('topSubpages', 'pages', 'category'));
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
        $category = Category::find($id);

        if (is_null($category)) {
            abort(404);
        }

        $rules = [
            'description' => 'required',
            'page_id' => 'required|exists:pages,id'
        ];

        if ($category->name != $request->name) {
            $rules['name'] = 'required|unique:categories,name';
        }

        $this->validate($request, $rules);

        $category->name = $request->name;
        $category->description = $request->description;
        $category->page_id = $request->page_id;
        $category->save();

        return redirect()->route('admin.categories.show', ['category' => $cat->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);

        if ($category == null) {
            abort(404);
        }

        if ($category->documents()->count() > 0) {
            return redirect()->back()->with(['status' => 'No se pueden eliminar categorías con documentos cargados', 'status-result' => 'danger']);
        }

        $category->delete();

        return redirect()->back()->with(['status' => 'Categoría eliminada exitosamente.', 'status-result' => 'success']);
    }
}
