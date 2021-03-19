<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use phpDocumentor\Reflection\Types\Integer;

class PostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function get($id){
        return Post::findOrFail($id);
    }

    public function getList()
    {
        $posts = Post::get();//withCount('comments')->get(); //count done with acessor directly in the model
        return $posts->makeHidden(['comments']);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'content' => 'required|string'
        ]);
        $post = new Post();
        $post->fill($request->all());
        $post->save();
        return $post;
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'filled|string',
            'content' => 'filled|string'
        ]);
        $post = Post::findOrFail($id);
        Gate::authorize('update',$post);
        $post->update($request->all());
        return $post;
    }

    public function delete($id)
    {
        $post = Post::findOrFail($id);
        Gate::authorize('delete',$post);
        $post->delete();
        return [];
    }

    
}
