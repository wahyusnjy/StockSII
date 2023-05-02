<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Imports\RoomImport;
use App\Models\Category;
use App\Models\Ruangan;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ApiRuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $ruangan =  Ruangan::all();

       return response()->json([
        "Success" => true,
        "message" => "Room List",
        "data" => $ruangan
    ]);
    }

    public function CariRuangan(Request $request)
    {
    $cari = $request->cari;
    $ruangan = Ruangan::where('name','like',"%".$cari."%")
    ->paginate(10);

    return view('ruangan.index',compact('ruangan'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->role == 'admin'){

        $wilayah = Category::all();
        return view('ruangan.create')
        ->with('wilayah',$wilayah);
        }
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

        Ruangan::create([
            'region_id' => $request->region_id,
            'name' => $request->name,
            'desc'  => $request->desc,
        ]);

        return redirect()->route('ruangan.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ruangan  $ruangan
     * @return \Illuminate\Http\Response
     */
    public function show(Ruangan $ruangan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ruangan  $ruangan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->role == 'admin'){
        $ruangan =  Ruangan::find($id);
        $wilayah = Category::all();
        return view('ruangan.edit')
        ->with('ruangan',$ruangan)
        ->with('wilayah',$wilayah);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ruangan  $ruangan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $this->validate($request, [
			'name' => 'required|string'
		]);

        Ruangan::where('id',$id)->update([
            'region_id' => $request->region_id,
            'name' => $request->name,
            'desc'  => $request->desc,
        ]);

        return redirect()->route('ruangan.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ruangan  $ruangan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Ruangan::destroy($id);

        return redirect()->back();
    }

    public function ImportExcel(Request $request)
    {
        //Validasi
        $this->validate($request, [
            'file' => 'required|mimes:xls,xlsx'
        ]);

        if ($request->hasFile('file')) {
            //UPLOAD FILE
            $file = $request->file('file'); //GET FILE
            //dd($file);
            Excel::import(new RoomImport, $file); //IMPORT FILE
            return redirect()->back()->with(['success' => 'Upload file data !']);
        }

        return redirect()->back()->with(['error' => 'Please choose file before!']);
    }
}
