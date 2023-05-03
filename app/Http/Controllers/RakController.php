<?php

namespace App\Http\Controllers;

use App\Imports\RackImport;
use App\Models\Rak;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class RakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rak = Rak::paginate(10);
        return view('rak.index')
        ->with('rak',$rak);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->role == 'admin'){

        $room = Ruangan::all();
        return view('rak.create')
        ->with('room',$room);
        }
    }


    public function CariRak(Request $request)
    {
    $cari = $request->cari;
    $rak = Rak::where('name','like',"%".$cari."%")
    ->orWhere('desc','like',"%".$cari."%")
    ->orWhereHas('room', function($i) use($cari){
        $i->where('name','like',"%". $cari . "%")
            ->orWhereHas('region',function($rg) use($cari){
                $rg->where('name','like',"%" . $cari . "%");
            });
    })
    ->paginate(10);

    return view('rak.index',compact('rak'));
    }


    public function store(Request $request)
    {
        $this->validate($request, [
			'name' => 'required|string'
		]);

        Rak::create([
            'room_id' => $request->room_id,
            'name' => $request->name,
            'desc'  => $request->desc,
        ]);

        return redirect()->route('rak.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rak  $rak
     * @return \Illuminate\Http\Response
     */
    public function show(Rak $rak)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rak  $rak
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->role == 'admin'){
        $rak = Rak::find($id);
        $room = Ruangan::all();
        return view('rak.edit')
        ->with('rak',$rak)
        ->with('room',$room);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rak  $rak
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
			'name' => 'required|string'
		]);
        Rak::where('id',$id)->update([
            'room_id' => $request->room_id,
            'name' => $request->name,
            'desc'  => $request->desc,
        ]);
        return redirect()->route('rak.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rak  $rak
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Rak::destroy($id);

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
            Excel::import(new RackImport, $file); //IMPORT FILE
            return redirect()->back()->with(['success' => 'Upload file data !']);
        }

        return redirect()->back()->with(['error' => 'Please choose file before!']);
    }
}
