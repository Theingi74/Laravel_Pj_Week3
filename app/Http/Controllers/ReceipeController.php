<?php

namespace App\Http\Controllers;

use App\Receipe;
use App\Category;
use Illuminate\Http\Request;

class ReceipeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = Receipe::where('author_id',auth()->id())->get();
        /*dd(auth()->check());*/
        return view('home',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::all();
        return view('create',compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       /*dd(request()->all());*/
       Receipe::create($this->validation($request) + ['author_id' => auth()->id()]);
       return redirect('receipe');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Receipe  $receipe
     * @return \Illuminate\Http\Response
     */
    public function show(Receipe $receipe)
    {
        /*dd($receipe->categories->name);*/
      /*  if ($receipe->author_id != auth()->id()) {
            abort(404);
        }*/
        $this->authorize('view',$receipe);
        return view('show',compact('receipe'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Receipe  $receipe
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $category = Category::all();
        $receipe = Receipe::find($id);
        $this->authorize('view',$receipe);
        return view('edit',compact('receipe','category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Receipe  $receipe
     * @return \Illuminate\Http\Response
     */
    public function update(Receipe $receipe, Request $request)
    {
        $validatedData = $this->validation($request);

        $receipe->update($validatedData);
        return redirect('receipe');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Receipe  $receipe
     * @return \Illuminate\Http\Response
     */
    public function destroy(Receipe $receipe)
    {
        $receipe->delete();
        return redirect('receipe');
    }

    public function validation($request)
    {
         $validatedData = $request->validate([
        'name' => 'required',
        'ingredients' => 'required',
        'category' => 'required',
    ]);
         return $validatedData;
    }
}
