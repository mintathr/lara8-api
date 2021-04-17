<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\TryCatch;
use Symfony\Component\HttpFoundation\Response;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transaction = Transaction::orderBy('time', 'DESC')->get();
        /** data yg akan diberikan ke user (api) */
        $response = [
            'message'   => 'List transaction order by time',
            'data'      => $transaction
        ];

        /**bisa dengan cara ini, maka laravel akan menggenerate secara json 
         * return $response;
         * atau bisa jd dgn cara sprti dibawah (method response, dan kode status)
         */
        return response()->json($response, Response::HTTP_OK);
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
            'title'     => ['required'],
            'amount'    => ['required', 'numeric'],
            'type'      => ['required', 'in:expense,revenue'],
        ]);

        /* jika gagal */
        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        /** jika berhasil
         * queryexception menginformasikan pesan error dibagian mana
         */
        try {
            $transaction = Transaction::create($request->all());
            $response   = [
                'message' => 'Transaction created',
                'data'    => $transaction
            ];

            return response()->json($response, Response::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json([
                'message'   => "Failed " . $e->errorInfo
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
        $transaction = Transaction::findOrFail($id);
        $response   = [
            'message' => 'Detail of transaction resource updated',
            'data'    => $transaction
        ];

        return response()->json($response, Response::HTTP_OK);
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
        $transaction = Transaction::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title'     => ['required'],
            'amount'    => ['required', 'numeric'],
            'type'      => ['required', 'in:expense,revenue'],
        ]);

        /* jika gagal */
        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        /** jika berhasil
         * queryexception menginformasikan pesan error dibagian mana
         */
        try {
            $transaction->update($request->all());
            $response   = [
                'message' => 'Transaction updated',
                'data'    => $transaction
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
        $transaction = Transaction::findOrFail($id);

        /** jika berhasil
         * queryexception menginformasikan pesan error dibagian mana
         */
        try {
            $transaction->delete();
            $response   = [
                'message' => 'Transaction deleted',
            ];

            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message'   => "Failed " . $e->errorInfo
            ]);
        }
    }
}
