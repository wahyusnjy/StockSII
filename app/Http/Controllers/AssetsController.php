<?php

namespace App\Http\Controllers;

use App\Models\Assets;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AssetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assets = Assets::paginate(10);
        return view('assetsOrInventory.index', compact('assets'));
    }

    public function Cari(Request $request)
   {
    $cari = $request->cari;
    $assets = Assets::where('name','like',"%".$cari."%")
    ->paginate(10);

    return view('assetsOrInventory.index',compact('assets'));
   }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('assetsOrInventory.create');
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

		Assets::create([
            'name' => $request->name,
        ]);

		return redirect()->route('assetinventory.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Assets  $assets
     * @return \Illuminate\Http\Response
     */
    public function show(Assets $assets)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Assets  $assets
     * @return \Illuminate\Http\Response
     */
    public function edit(Assets $assets,$id)
    {
        $assets = Assets::find($id);
		return view('assetsOrInventory.edit', compact('assets'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Assets  $assets
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
			'name' => 'required|string',
		]);

		Assets::where('id',$id)->update([
            'name' => $request->name,
        ]);

		return redirect()->route('assetinventory.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Assets  $assets
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Assets::destroy($id);

		return redirect()->route('assetinventory.index');
    }

    public function apiAssetInventory() {
		$aset = Assets::all();

		return DataTables::of($aset)
			->addColumn('action', function ($aset) {
				return '<a href="#" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-eye-open"></i> Show</a> ' .
				'<a onclick="editForm(' . $aset->id . ')" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a> ' .
				'<a onclick="deleteData(' . $aset->id . ')" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
			})
			->rawColumns(['action'])->make(true);
	}
}
