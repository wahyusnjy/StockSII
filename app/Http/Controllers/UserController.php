<?php

namespace App\Http\Controllers;

use App\Exports\ExportSuppliers;
use App\Imports\SuppliersImport;
use App\Models\Supplier;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller {
	public function __construct() {
		$this->middleware('role:admin,staff');
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$users = User::paginate(10);

		return view('user.index', compact('users'));
	}

    public function Cari(Request $request)
   {
    $cari = $request->cari;
    $users = User::where('name','like',"%".$cari."%")
    ->orWhere('email','like',"%".$cari."%")
    ->orWhere('role','like',"%".$cari."%")
    ->orWhere('id','like',"%".$cari."%")
    ->paginate(10);

    return view('user.index',compact('users'));
   }

   public function detail($id)
    {
        $users = User::find($id);
        return view('user.detail')
        ->with('users',$users);
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(Request $request)
    {
        return view('user.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$this->validate($request, [
			'name' => 'required|string|max:255',
			'email' => 'required|string|email|max:255|unique:users',
		]);

		User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password'=> bcrypt($request->password),
            'role'=> $request->role,
        ]);

		return redirect()->route('user.index');

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
		$users = User::find($id);
		return view('user.edit',compact('users'));
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
			'name' => 'required|string|min:2',
			'email' => 'required|string|email|max:255|unique:suppliers',
		]);

		User::where('id',$id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'password'=> bcrypt($request->password),
            'role'=> $request->role,
        ]);

		return redirect()->route('user.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		User::destroy($id);

        return redirect()->back()->with(['success' => 'Delete data Users Success !']);
	}

	public function apiUsers() {
		$users = User::all();

		return DataTables::of($users)
			->addColumn('action', function ($users) {
				return '<a href="#" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-eye-open"></i> Show</a> ' .
				'<a onclick="editForm(' . $users->id . ')" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a> ' .
				'<a onclick="deleteData(' . $users->id . ')" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
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
