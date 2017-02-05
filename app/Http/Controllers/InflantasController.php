<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Lantas;

class InflantasController extends Controller
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
        //
        return response()->json([
            "data"=>Lantas::all()
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
            $file = $request->file('file');
            Lantas::create([
                'konten'=>$request->input('judul'),
                'img'=>$file->store('images')
            ]);
            return response()->json([
                "Message"=>"Informasi ditambahkan"
            ],201);
        }

//        Lantas::create($request->only(['konten','img']));
//        return response("Berhasil ditambahkan",201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
//        $terpilih = Lantas::find($id);
//        if ($terpilih){
//            $terpilih->update($request->only(['konten','img']));
//            return response("Berhasil diubah",200);
//        } else {
//            return response("data tidak ada",404);
//        }
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
        $terpilih = Lantas::find($id);
        if ($terpilih){
            Storage::disk('local')->delete($terpilih->img);
            $terpilih->delete();
            return response("Berhasil dihapus",200);
        } else {
            return response("data tidak ada",404);
        }
    }
}
