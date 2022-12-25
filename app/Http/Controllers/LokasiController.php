<?php

namespace App\Http\Controllers;

use App\Exports\ExportLokasi;
use App\Imports\LokasiImport;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
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
        $lokasi = Lokasi::paginate(10);
        return view('lokasi.index', compact('lokasi'));
    }

    public function Cari(Request $request)
   {
    $cari = $request->cari;
    $lokasi = Lokasi::where('name','like',"%".$cari."%")
    ->paginate();

    return view('lokasi.index',compact('lokasi'));
   }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('lokasi.create');
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

		return redirect()->route('lokasi.index');

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
		return view('lokasi.edit', compact('lokasi'));
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

		return redirect()->route('lokasi.index');
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

		return redirect()->route('lokasi.index');
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
            Excel::import(new LokasiImport, $file); //IMPORT FILE
            return redirect()->back()->with(['success' => 'Upload file data Products Masuk !']);
        }

        return redirect()->back()->with(['error' => 'Please choose file before!']);
    }
}
