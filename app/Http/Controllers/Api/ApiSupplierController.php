<?php

namespace App\Http\Controllers\Api;

use App\Exports\ExportSuppliers;
use App\Http\Controllers\Controller;
use App\Imports\SuppliersImport;
use App\Models\Supplier;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ApiSupplierController extends Controller {
	public function __construct() {
		$this->middleware('role:admin,staff');
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$suppliers = Supplier::all();
        return response()->json([
            "Success" => true,
            "message" => "Supplier List",
            "data" => $suppliers
        ]);
	}

    public function Cari(Request $request)
   {
    $cari = $request->cari;
    $suppliers = Supplier::where('nama','like',"%".$cari."%")
    ->orWhere('alamat','like',"%".$cari."%")
    ->orWhere('email','like',"%".$cari."%")
    ->orWhere('telepon','like',"%".$cari."%")
    ->orWhere('id','like',"%".$cari."%")
    ->paginate(10);

    return view('suppliers.index',compact('suppliers'));
   }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		return view('suppliers.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$this->validate($request, [
			'nama' => 'required',
			'alamat' => 'required',
			'email' => 'required',
			'telepon' => 'required',
		]);

		Supplier::create($request->all());

		return redirect()->route('suppliers.index');

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		$supplier = Supplier::find($id);
		return view('suppliers.edit', compact('supplier'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		$this->validate($request, [
			'nama' => 'required|string|min:2',
			'alamat' => 'required|string|min:2',
			'email' => 'required|string|email',
			'telepon' => 'required|string|min:2',
		]);

		$supplier = Supplier::findOrFail($id);

		$supplier->update($request->all());

		return redirect()->route('suppliers.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		Supplier::destroy($id);

		return redirect()->back();
	}

	public function apiSuppliers() {
		$suppliers = Supplier::all();

		return DataTables::of($suppliers)
			->addColumn('action', function ($suppliers) {
				return '<a href="#" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-eye-open"></i> Show</a> ' .
				'<a onclick="editForm(' . $suppliers->id . ')" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a> ' .
				'<a onclick="deleteData(' . $suppliers->id . ')" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
			})
			->rawColumns(['action'])->make(true);
	}

	public function ImportExcel(Request $request) {
		//Validasi
		$this->validate($request, [
			'file' => 'required|mimes:xls,xlsx',
		]);

		if ($request->hasFile('file')) {
			//UPLOAD FILE
			$file = $request->file('file'); //GET FILE
			Excel::import(new SuppliersImport, $file); //IMPORT FILE
			return redirect()->back()->with(['success' => 'Upload file data suppliers !']);
		}

		return redirect()->back()->with(['error' => 'Please choose file before!']);
	}

	public function exportSuppliersAll() {
		$suppliers = Supplier::all();
		$pdf = Pdf::loadView('suppliers.SuppliersAllPDF', compact('suppliers'));
		return $pdf->download('suppliers.pdf');
	}

	public function exportExcel() {
		return (new ExportSuppliers)->download('suppliers.xlsx');
	}
}
