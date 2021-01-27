<?php

namespace App\Http\Controllers;

use App\Http\Requests\Posts\StorePost;
use App\Models\Posts;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use App\Transformers\Posts\PostResource;
use App\Transformers\Posts\PostResourceCollection;
use Exception;

class PostsController extends Controller
{

    private $post; 
    public function __construct(Posts $posts)
    {
    $this->post = $posts;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $a = $this->post->index();
        } catch (\Throwable|Exception $e) {
            return $e;
            return ResponseService::exception('posts.index', null, $e);
        }
        return new PostResourceCollection($a);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePost $request)
    {
        try {
            $post = $this->post->create([
                'title' => $request->get('title'),
                'url' => $request->get('url'),
                'author' => $request->get('author'),
                'paragraph' => $request->get('paragraph'),
                'image' => $request->get('image'),
            ]);
        } catch (\Throwable|\Exception $e) {
            return $e;
            return ResponseService::exception('posts.store', null, $e);
        }
        return new PostResource($post,array('type' => 'store','route' => 'posts.store'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $data = $this->post->show($id);
        }
        catch(\Throwable|\Exception $e){
            return $e;
            return ResponseService::exception('posts.show', $id, $e);
        }

        return new PostResource($data, array('type'=>'show', 'route'=>'posts.show'));
    }
}
