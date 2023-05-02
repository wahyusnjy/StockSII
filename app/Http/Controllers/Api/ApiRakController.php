<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rak;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiRakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rak = Rak::all();

        return response()->json([
            "Success" => true,
            "message" => "Rak List",
            "data" => $rak
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

        $room = Ruangan::all();
        return view('rak.create')
        ->with('room',$room);
        }
    }


    public function CariRak(Request $request)
    {
    $cari = $request->cari;
    $rak = Rak::where('name','like',"%".$cari."%")
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
}
