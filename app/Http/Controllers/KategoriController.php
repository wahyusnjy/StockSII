<?php

namespace App\Http\Controllers;

use App\Models\Assets;
use App\Models\KategoriChild;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assets = Assets::paginate(10);
        return view('kategori.index', compact('assets'));
    }

    public function Cari(Request $request)
   {
    $cari = $request->cari;
    $assets = Assets::where('name','like',"%".$cari."%")
    ->paginate(10);

    return view('kategori.index',compact('assets'));
   }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parent_id = Assets::all();
        return view('kategori.create')
        ->with('parent_id',$parent_id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $data = $request->all();
        $this->validate($request, [
			'name' => 'required|string'
		]);

        if($request->parent_id == null)
        {
            $parent = Assets::create([
                'parent_id' => 0,
                'name' => $request->name,
            ]);
        }else {
            $parent = Assets::create([
                'parent_id' => $request->parent_id,
                'name' => $request->name,
            ]);
        }


		return redirect()->route('kategori.index');
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
		return view('kategori.edit', compact('assets'));
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

		return redirect()->back();
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
