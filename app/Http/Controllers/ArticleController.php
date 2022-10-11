<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::with('category', 'user')
                    ->get();

        return view('dashboard.article.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view('dashboard.article.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Article $article)
    {

        // ddd($request);

        $request -> validate([
               'title' => 'required',
               'content' => 'required',
               'category_id' => 'required',
               'image' => 'nullable|image'
           ]);

        //    ddd($request);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            
            $image->move('images/article/', $image->getClientOriginalName());

            $article->create([
                'title' => $request->title,
                'category_id' => $request->category_id,
                'content' =>  strip_tags($request->content),
                'user_id' =>Auth::user()->id,
                'image' => $image->getClientOriginalName(),
            ]);
        }
        else {
            $article->create([
                'title' => $request->title,
                'category_id' => $request->category_id,
                'content' =>  strip_tags($request->content),
                'user_id' =>Auth::user()->id,
                'image' => null
            ]);
        }

        return redirect()->route('article.index')
                            ->with('success', 'Article has been created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        return view('dashboard.article.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        $categories = Category::all();

        return view('dashboard.article.edit', compact('article', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        $request -> validate([
            'title' => 'required',
            'content' => 'required',
            'category_id' => 'required',
            'image' => 'nullable|image|mimes:jpg,png|max:1024'
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = '/images/article/';
            if ($request->oldImage) {
                File::delete(public_path('images/article/' . $article->image));
            }

            $filename = Str::slug($request->title) . '-' . time() . '.' . $image->extension();
            $image->move(public_path($path), $filename);
        }

        $article->update([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'content' =>  strip_tags($request->content),
            'user_id' =>Auth::user()->id,
            'image' => $request->hasFile('image') ? $filename : null
        ]);
        return redirect()->route('article.index')
                        ->with('success', 'Article has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        File::delete(public_path('images/article/' . $article->image));

        $article->delete();

        return redirect()->route('article.index')
                            ->with('success', 'Article has been deleted');
    }
}
