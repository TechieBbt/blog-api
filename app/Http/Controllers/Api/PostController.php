<?php

namespace App\Http\Controllers\Api;


use App\Models\post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;



class PostController extends Controller
{
    public function index (){
        return "Welcome to Blog API!";
    }

    public function createPost (Request $request){

        $validator = Validator::make($request->all(), [
            'title'=> 'required|string|Max:50',
            'body'=> 'required|string|Max:10000',

        ]);

        if ($validator->fails())
        {
            return response() ->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        } else {
                $post = post::create([
                    'title' => $request->title,
                    'body' => $request->body,
            ]);
        
            if ($post) {
                return response()->json([
                    'status' => 201,
                    'message' => 'Post created successfully'
                ], 201);
            }else {
                return response()->json([
                    'status' => 500,
                    'message' => 'Something went wrong'
                ], 500);
            }
              
        }
    }

    public function allPost () {
        $Posts = Post::all();

        if ($Posts->count () > 0) {
            return response()->json([
                'status' => 200,
                'message' => $Posts
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Posts not found'
            ], 404);
        }
    }

    public function updatePost (Request $request, int $id) {
        $validator = Validator::make($request->all(), [
            'title'=> 'required|string|Max:50',
            'body'=> 'required|string|Max:10000',
        ]);

        if ($validator->fails())
        {
            return response() ->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        } else {

            $post = post::find($id);
        
            if ($post) {                
                $post-> update([
                    'title' => $request->title,
                    'body' => $request->body,
            ]);
                return response()->json([
                    'status' => 201,
                    'message' => 'Post updated successfully'
                ], 200);
            }else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Post not found'
                ], 500);
            }
              
        }
    }
    public function deletePost (int $id) {
       
            $post = post::find($id);
        
            if ($post) {                
                $post-> delete();
                return response()->json([
                    'status' => 200,
                    'message' => 'Post deleted successfully'
                ], 200);
            }else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Post not found'
                ], 404);
            }
              
        }
}
