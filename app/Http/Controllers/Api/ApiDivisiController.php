<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Divisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiDivisiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $divisi = Divisi::all();
        return response()->json([
            "Success" => true,
            "message" => "Divisi List",
            "data" => $divisi
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->role == 'admin'){
            return view('divisi.create');
        }
    }

    public function detail($id)
    {
        $divisi = Divisi::find($id);
        return response()->json([
            "Success" => true,
            "message" => "Divisi Detail",
            "data" => $divisi
        ]);
    }

    public function CariDivisi(Request $request)
    {
    $cari = $request->cari;
    $divisi = Divisi::where('name','like',"%".$cari."%")
    ->paginate(10);

    return view('divisi.index',compact('divisi'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
			'name' => 'required|string'
		]);
        // dd($request->all());

        $divisi = Divisi::create([
            'name' => $request->name,
        ]);

        return response()->json([
            "Success" => true,
            "message" => "Create Divisi Success",
            "data" => $divisi
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Divisi  $divisi
     * @return \Illuminate\Http\Response
     */
    public function show(Divisi $divisi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Divisi  $divisi
     * @return \Illuminate\Http\Response
     */
    public function edit(Divisi $divisi,$id)
    {
        if(Auth::user()->role == 'admin'){
        $divisi = Divisi::find($id);

        return response()->json([
            "Success" => true,
            "message" => "Product Edit Detail",
            "data" => $divisi
        ]);
        }
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
			'name' => 'required|string'
		]);
         Divisi::where('id',$id)->update([
            'name' => $request->name
        ]);
        $divisi = Divisi::find($id);
        return response()->json([
            "Success" => true,
            "message" => "Update Divisi Success",
            "data" => $divisi
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Divisi  $divisi
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $divisi = Divisi::destroy($id);

         return response()->json([
            "Success" => true,
            "message" => "Delete Divisi Success",
            "data" => $divisi
        ]);
    }
}
