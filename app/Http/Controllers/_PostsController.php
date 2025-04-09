<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Post;
use App\Http\Requests\PostRequest;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $posts= Post::all();
        return view('posts.index', ['posts'=>$posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PostRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PostRequest $request)
    {
        $post = new Post;
		$post->id = $request->input('id');
		$post->socio_nro = $request->input('socio_nro');
		$post->id_servicio = $request->input('id_servicio');
		$post->vto_1 = $request->input('vto_1');
		$post->importe_1 = $request->input('importe_1');
		$post->vto_2 = $request->input('vto_2');
		$post->importe_2 = $request->input('importe_2');
		$post->vto_3 = $request->input('vto_3');
		$post->importe_3 = $request->input('importe_3');
        $post->save();

        return to_route('posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.show',['post'=>$post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.edit',['post'=>$post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PostRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
		$post->id = $request->input('id');
		$post->socio_nro = $request->input('socio_nro');
		$post->id_servicio = $request->input('id_servicio');
		$post->vto_1 = $request->input('vto_1');
		$post->importe_1 = $request->input('importe_1');
		$post->vto_2 = $request->input('vto_2');
		$post->importe_2 = $request->input('importe_2');
		$post->vto_3 = $request->input('vto_3');
		$post->importe_3 = $request->input('importe_3');
        $post->save();

        return to_route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return to_route('posts.index');
    }
}
