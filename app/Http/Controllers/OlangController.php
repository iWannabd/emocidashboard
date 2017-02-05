<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions;
use App\Oranghilang;

class OlangController extends Controller
{

    public function __construct()
    {
        // Apply the jwt.auth middleware to all methods in this controller
        // except for the authenticate method. We don't want to prevent
        // the user from retrieving their token if they don't already have it
        $this->middleware('jwt.auth', ['except' => ['index','show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            "data"=>Oranghilang::all()
        ],200);
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
        //
        if ($request->hasFile('file')){
            $data = $request->only(['nama','address','usia','sex','img','kontak']);
            $file = $request->file('file');
            $data['validate'] = false;
            $data['img'] = $file->store('images');
            Oranghilang::create($data);
            return response()->json([
                "response" => "Data tersimpan"
            ],201);
        }
    }

    public function validasi($id){
        $terpilih = Oranghilang::find($id);
        if ( $terpilih->validate == 1){
            $data['validate'] = 0;
        } else {
            $data['validate'] = 1;
        }
        $terpilih->update($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $terpilih = Oranghilang::find($id);
        if ($terpilih){
            return $terpilih;
        } else {
            return response("data tidak ada",404);
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
    public function update(Request $request, $id)
    {
        //
        $terpilih = Oranghilang::find($id);
        if ($terpilih){
            $terpilih->update($request->only(['nama','address','usia','sex','img','kontak','validate']));
            return response("data terubah",200);
        } else {
            return response("data tidak ada",404);
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
        //
        $terpilih = Oranghilang::find($id);
        if ($terpilih){
            Storage::disk('local')->delete($terpilih->img);
            $terpilih->delete();
            return response("data terhapus",200);
        } else {
            return response("data tidak ada",404);
        }
    }
}
