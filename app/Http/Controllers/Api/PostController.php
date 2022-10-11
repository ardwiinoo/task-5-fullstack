<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::paginate(7);

        if ($posts) {
            return response()->json([
                "message" => "Success",
                "data" => $posts
            ], 200);
        } else {
            return response()->json([
                "message" => "Not Found"
            ], 404);
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
    public function store(Request $request, Post $post)
    {
        $validate = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpg,png|max:1024',
            'category_id' => 'required',
        ]);

        if ($validate->fails()) {
            dd($validate->errors());
            return response()->json([
                "message" => "Bad Request",
                "data" => $validate->errors()
            ], 400);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = '/images/article/';

            $filename = Str::slug($request->title) . '-' . time() . '.' . $image->extension();
            $image->move(public_path($path), $filename);
        }

        $post = new Post();
        $post->title = $request->title;
        $post->image = $request->image;
        $post->category_id = $request->category_id;
        $post->content = $request->content;
        $post->user_id = $request->user()->id;
        $post->save();

        return response()->json([
            'success' => true,
            'message' => "Post has been created",
            'data'    => $post
        ], 201);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $posts = Post::find($id);
        if ($posts) {
            return response()->json([
                "message" => "Success",
                "data" => $posts
            ], 200);
        } else {
            return response()->json([
                "message" => "Not Found"
            ], 404);
        }
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
        if ($post = Post::find($id)) {
            $validate = Validator::make($request->all(), [
                'title' => 'required',
                'content' => 'required',
                'image' => 'nullable|image|mimes:jpg,png|max:1024',
                'category_id' => 'required',
            ]);

            $post = Post::findOrFail($id);

            if ($request->file('image')) {
                $image = $request->file('image');
                if ($request->image) {
                    File::delete(public_path('images/article/' . $post->image));
                }


                $filename = Str::slug($request->title) . '-' . time() . '.' . $image->extension();
                $request->image->move('images/article/', $filename);
                $post->image = $filename;
            }

            $post->user_id = auth()->user()->id;
            $post->category_id = $request->category_id;
            $post->title = $request->title;
            $post->content = $request->content;


            $post->update();

            return response()->json([
                "message" => "Post has been update",
                "data" => $post
            ], 201);
        } else {
            return response()->json(["message" => "Not Found"], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        File::delete(public_path('images/article/' . $post->image));

        if ($post) {
            $post->delete();
            return response()->json([
                "message" => "Post Has Been deleted",
            ], 200);
        } else {
            return response()->json([
                "message" => "Not Found"
            ], 404);
        }
    }
}
