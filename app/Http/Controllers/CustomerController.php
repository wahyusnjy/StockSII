<?php

namespace App\Http\Controllers;

use App\Exports\ExportCustomers;
use App\Imports\CustomersImport;
use App\Models\Customer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin,staff');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::paginate(10);

        return view('customers.index',compact('customers'));
    }

    public function Cari(Request $request)
   {
    $cari = $request->cari;
    $customers = Customer::where('nama','like',"%".$cari."%")
    ->orWhere('alamat','like',"%".$cari."%")
    ->orWhere('email','like',"%".$cari."%")
    ->orWhere('telepon','like',"%".$cari."%")
    ->paginate(10);

    return view('customers.index',compact('customers'));
   }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customers.create');
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
            'nama'      => 'required',
            'alamat'    => 'required',
            'email'     => 'required|unique:customers',
            'telepon'   => 'required',
        ]);

        Customer::create($request->all());

        return redirect()->route('customers.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Customer::find($id);
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama'      => 'required|string|min:2',
            'alamat'    => 'required|string|min:2',
            'email'     => 'required|string|email|max:255',
            'telepon'   => 'required|string|min:2',
        ]);

        $customer = Customer::findOrFail($id);

        $customer->update($request->all());

        return redirect()->route('customers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Customer::destroy($id);

        return redirect()->route('customers.index');
    }

    public function apiCustomers()
    {
        $customer = Customer::all();

        return DataTables::of($customer)
            ->addColumn('action', function($customer){
                return '<a href="#" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-eye-open"></i> Show</a> ' .
                    '<a onclick="editForm('. $customer->id .')" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a> ' .
                    '<a onclick="deleteData('. $customer->id .')" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
            })
            ->rawColumns(['action'])->make(true);
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
            Excel::import(new CustomersImport, $file); //IMPORT FILE
            return redirect()->back()->with(['success' => 'Upload file data customers !']);
        }

        return redirect()->back()->with(['error' => 'Please choose file before!']);
    }


    public function exportCustomersAll()
    {
        $customers = Customer::all();
        $pdf = Pdf::loadView('customers.CustomersAllPDF',compact('customers'));
        return $pdf->download('customers.pdf');
    }

    public function exportExcel()
    {
        return (new ExportCustomers)->download('customers.xlsx');
    }
}
