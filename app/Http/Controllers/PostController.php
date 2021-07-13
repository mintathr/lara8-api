<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $post = Post::orderBy('created_at', 'DESC')->get();
        /** data yg akan diberikan ke user (api) */
        $response = [
            'message'   => 'List post order by time',
            'data'      => $post
        ];

        /**bisa dengan cara ini, maka laravel akan menggenerate secara json 
         * return $response;
         * atau bisa jd dgn cara sprti dibawah (method response, dan kode status)
         */
        return response()->json($response, Response::HTTP_OK);
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
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required'],
            'body'  => ['required'],
        ]);

        // jika gagal
        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        /* jika berhasil
        queryexception menginformasikan pesan error dibagian mana */
        try {
            $post = Post::create([
                'title' => $request->title,
                'slug'  => \Str::slug($request->title),
                'body'  => $request->body,
            ]);

            $response = [
                'message'   => 'Post created',
                'data'      => $post
            ];
            return response()->json($response, Response::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed " . $e->errorInfo
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);
        $response = [
            'message' => 'Detail of post resource updated',
            'data'    => $post
        ];
        return response()->json($response, Response::HTTP_OK);
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
        $post = Post::findOrFail($id);

        $validator = Validator::make($request->only('body'), [
            'body' => ['required'],
        ]);

        // jika gagal
        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        /* jika berhasil
        queryexception menginformasikan pesan error dibagian mana */
        try {
            $post->update($request->only('body'));
            $response = [
                'message' => 'Post updated',
                'data'    => $post
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message'   => "Failed " . $e->errorInfo
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        /* jika berhasil
        query exception menginformasikan pesan error dibagianmana */
        try {
            $post->delete();
            $response = [
                'message' => 'Post deleted',
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed " . $e->errorInfo
            ]);
        }
    }
}
