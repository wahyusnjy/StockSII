<?php

namespace App\Http\Controllers;

use App\Models\Rak;
use Illuminate\Http\Request;

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
        return view('rak.create');
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
            'name' => $request->name,
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
        $rak = Rak::find($id);
        return view('rak.edit')
        ->with('rak',$rak);
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
            'name' => $request->name
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
