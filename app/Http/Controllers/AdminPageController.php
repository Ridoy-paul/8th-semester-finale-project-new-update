<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Auth;
use Image;
use File;
use Alert;

class AdminPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->type == 1) {
            $pages = Page::all();
            return view('admin.page.index', compact('pages'));
        }
        else {
            Alert::toast('Something went wrong !', 'error');
            return back();
        }
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
        $page_slug = $request->page_slug;
        $check_page = Page::where('page_slug', $page_slug)->first();

        if(!is_null($check_page)) {
            Alert::toast('This Page is Already Exist!', 'error');
            return back();
        }

        $page = new Page;

        $page->page_slug = $page_slug;
        $page->name = $request->name;
        $page->description = $request->description;
        $page->save();

        Alert::toast('New Page Added.', 'success');
        return back();

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
        if (Auth::user()->type == 1) {
            $page = Page::find($id);
            if (!is_null($page)) {
                return view('admin.page.edit', compact('page'));
            }
            else {
                Alert::toast('Something went wrong !', 'error');
                return back();
            }
        }
        else {
            session()->flash('error','Something went wrong !');
            return back();
        }
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
        
        $page = Page::find($id);

        if(is_null($page)) {
            Alert::toast('No Page Found!', 'error');
            return back();
        }

        $page->name = $request->name;
        $page->description = $request->description;
        $page->save();
        
        Alert::toast('Page Updated', 'success');
        return redirect()->route('page.index');
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
