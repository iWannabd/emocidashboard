<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Dpo;

class DPOController extends Controller
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
            "data"=>Dpo::all()
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
            $data = $request->only(['nama','kasus','usia','sex','call']);
            $data['validate'] = false;
            $data['img'] = $file->store('images');
            Dpo::create($data);

            return response("berhasil disimpan",201);
        } else {
            return response("nothing",200);
        }
    }

    public function validasi($id){
        $terpilih = Dpo::find($id);
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
        $terpilih = Dpo::find($id);
        if ($terpilih) {
            $terpilih->update($request->only(['nama','kasus','usia','sex','call','img','validate']));
            return response('data terubah',200);

        } else {
            return response('data tidak ada',404);

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
        $terpilih = Dpo::find($id);
        if ($terpilih) {
            Storage::disk('local')->delete($terpilih->img);
            $terpilih->delete();
            return response('data terhapus',200);
        } else {
            return response('data tidak ada',404);
        }
    }
}
