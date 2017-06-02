<?php

namespace App\Http\Controllers;

use App\Category;
use App\Document;
use App\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($category)
    {
        $category = Category::find($category);

        if (is_null($category)) {
            abort(404);
        }

        $page = Page::find(1);
        $topSubpages = $page->topSubpages;

        return view('admin.categories.document-form', compact('topSubpages', 'category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $category)
    {
        $category = Category::find($category);

        if (is_null($category)) {
            abort(404);
        }

        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'keywords' => 'sometimes',
            'document' => 'required|file|mimes:pdf,xls,xlsx,doc,docx,ppt,pptx,jpg,jpeg,png|max:10000' //max in kbytes
        ]);

        $path = $request->file('document')->store('public/documents');

        $document = Document::create([
            'name' => $request->name,
            'description' => $request->description,
            'keywords' => $request->keywords,
            'category_id' => $category->id,
            'storage_path' => $path,
            'file_extension' => $request->file('document')->extension(),
        ]);

        return redirect()->route('admin.categories.show', ['category' => $category->id])->with(['status' => 'El documento se ha cargado correctamente!', 'status-result' => 'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($category, $id)
    {
        $category = Category::find($category);

        if (is_null($category)) {
            abort(404);
        }

        $document = Document::find($id);

        if (is_null($document)) {
            abort(404);
        }


        return response()->download(Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix() . $document->storage_path);
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
    public function destroy($category, $id)
    {
        $category = Category::find($category);

        if (is_null($category)) {
            abort(404);
        }

        $document = Document::find($id);

        if (is_null($document)) {
            abort(404);
        }

        $document->delete();

        return redirect()->back()->with(['status' => 'El documento fue eliminado correctamente!', 'status-result' => 'success']);
    }
}
