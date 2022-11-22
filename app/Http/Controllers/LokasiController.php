<?php

namespace App\Http\Controllers;

use App\Exports\ExportLokasi;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LokasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('lokasi.index');
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
        $this->validate($request, [
			'name' => 'required|string'
		]);

		Lokasi::create([
            'name' => $request->name,
        ]);

		return response()->json([
			'success' => true,
			'message' => 'Lokasi Created',
		]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lokasi  $lokasi
     * @return \Illuminate\Http\Response
     */
    public function show(Lokasi $lokasi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lokasi  $lokasi
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lokasi = Lokasi::find($id);
		return $lokasi;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lokasi  $lokasi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $this->validate($request, [
			'name' => 'required|string',
		]);

		Lokasi::where('id',$id)->update([
            'name' => $request->name,
        ]);

		return response()->json([
			'success' => true,
			'message' => 'Lokasi Updated',
		]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lokasi  $lokasi
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Lokasi::destroy($id);

		return response()->json([
			'success' => true,
			'message' => 'Lokasi Delete',
		]);
    }

    public function apiLokasi() {
		$lokasi = Lokasi::all();

		return DataTables::of($lokasi)
			->addColumn('action', function ($lokasi) {
				return '<a href="#" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-eye-open"></i> Show</a> ' .
				'<a onclick="editForm(' . $lokasi->id . ')" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a> ' .
				'<a onclick="deleteData(' . $lokasi->id . ')" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
			})
			->rawColumns(['action'])->make(true);
	}

    public function exportExcel()
    {
        return (new ExportLokasi)->download('lokasi.xlsx');
    }
}
