<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Assets;
use App\Models\KategoriChild;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ApiKategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assets = Assets::all();
        return response()->json([
            "Success" => true,
            "message" => "Category List",
            "data" => $assets
        ]);
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
        if(Auth::user()->role == 'admin'){
        $parent_id = Assets::all();
        return view('kategori.create')
        ->with('parent_id',$parent_id);
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
        if(Auth::user()->role == 'admin'){
        $allkategori = Assets::all();
        $parent_id = Assets::find($id);
		return view('kategori.edit', compact('parent_id','allkategori'));
        }
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

        if($request->parent_id == null)
        {
            $parent = Assets::where('id',$id)->update([
                'parent_id' => 0,
                'name' => $request->name,
            ]);
        }else {
            $parent = Assets::where('id',$id)->update([
                'parent_id' => $request->parent_id,
                'name' => $request->name,
            ]);
        }


		return redirect()->route('kategori.index');
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
