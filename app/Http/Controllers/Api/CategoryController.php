<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::latest()
        ->get();
        if ($categories) {
            return response()->json([
                "message" => "Success Load Category",
                "data" => $categories
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
    public function store(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $category = Category::create([
            'name' => $request->name,
            'user_id' => $request->user()->id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Category has been created',
            'data'    => $category
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);
        if ($category) {
            return response()->json([
                "message" => "Success",
                "data" => $category
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
    public function update(Request $request, Category $category)
    {
        if ($category) {
            $validate = Validator::make($request->all(), [
                'name' => 'required',

            ]);

            if ($validate->fails()) {
                return response()->json([
                    "message" => "Bad Request",
                    "data" => $validate->errors()
                ], 400);
            }

            $category->name = $request->name;
            $category->update();

            return response()->json([
                "message" => "Category has been updated",
                "data" => $category], 201);
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
    public function destroy(Category $category)
    {
        if ($category) {
            $category->delete();

            return response()->json([
                'message' => 'Category has been deleted',
                'data'    => $category
                ], 200);
        } else {
            return response()->json([
                "message" => "Not Found"
            ], 404);
        }
    }
}
