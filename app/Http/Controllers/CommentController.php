<?php

namespace App\Http\Controllers;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use phpDocumentor\Reflection\Types\Integer;

class CommentController extends Controller
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

    public function create(Request $request,$postId)
    {

        $post = Post::findOrFail($postId);//procedo solo se esiste il post
        $this->validate($request, [
            'content' => 'required|string'
        ]);
        $comment = new Comment();
        $comment->fill($request->all());
        $comment->fill(['post_id'=>$postId]);
        $comment->save();
        return $comment;
    }

    public function update(Request $request, $postId, $id)
    {
        $post = Post::findOrFail($postId);//procedo solo se esiste il post
        $this->validate($request, [
            'content' => 'filled|string'
        ]);
        $comment = Comment::findOrFail($id);
        Gate::authorize('update',$comment);
        $comment->update($request->all());
        $comment->update(['post_id'=>$postId]);
        return $comment;
    }

    public function delete($postId,$id)
    {
        $post = Post::findOrFail($postId); //procedo solo se esiste il post
        $comment = Comment::findOrFail($id); //TODO fare query e gestire null
        if( $post->id  != $comment->post_id){
            return response('Error: non puoi cancellare commento di un altro post', 409);
        }
        Gate::authorize('delete',$comment);
        $comment->delete();
        return [];
    }

    
}
