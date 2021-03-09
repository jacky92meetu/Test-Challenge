<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Post::class, 'post');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->user_type=='user'){
            return Post::where('user_id','=',auth()->user()->id)->paginate();
        }else{
            return Post::paginate();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->all();
        $validator = Validator::make($validatedData, [
            'title' => 'required|max:55',
            'body' => 'required'
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 400);
        }

        $validatedData['user_id'] = auth()->user()->id;

        $post = Post::create($validatedData);

        return response(['post' => $post], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return $post;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $validatedData = $request->all();
        $validatedData = array_intersect_key($validatedData,array_flip(['title','body']));
        
        $validator = Validator::make($validatedData, [
            'title' => 'max:55'
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 400);
        }

        $post->update($validatedData);

        return response(['post' => $post]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return response()->json(null, 204);
    }
}
