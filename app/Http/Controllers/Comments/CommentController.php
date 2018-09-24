<?php

namespace App\Http\Controllers\Comments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;

class CommentController extends Controller
{
    public function update(Comment $comment, Request $request)
    {
    	$this->authorize('update', $comment);
    	
    	$request->validate([
    		'body' => 'required?max:5000'
    	]);

    	$comment->update([
    		'body' => $request->body
    	]);

    	return new CommentResource($comment);
    }
}
