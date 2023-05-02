<?php

namespace App\Http\Controllers\Api;


use App\Exports\ExportProdukMasuk;
use App\Http\Controllers\Controller;
use App\Imports\ProductsImportIn;
use App\Models\ActivityLog;
use App\Models\Product;
use App\Models\Product_Masuk;
use App\Models\Supplier;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ApiProductMasukController extends Controller
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

        $products = Product::orderBy('id','ASC')->where('divisi_id',Auth::user()->divisi_id)
        ->get(['nama','id','qrcode']);

        $suppliers = Supplier::orderBy('nama','ASC')
        ->get(['nama','id']);


        $invoice_data = Product_Masuk::all();
        return response()->json([
            "Success" => true,
            "message" => "Product In List",
            "data" => $invoice_data
        ]);
    }

    public function Cari(Request $request)
   {
    $cari = $request->cari;
    $cari = $request->cari;

    $products = Product::orderBy('id','ASC')
    ->get(['nama','id', 'qrcode']);

    $suppliers = Supplier::orderBy('nama','ASC')
    ->get(['nama','id']);

    $invoice_data = Product_Masuk::where('qty','like',"%".$cari."%")
    ->orWhere('tanggal','like',"%".$cari."%")
    ->orWhere('keterangan','like',"%".$cari."%")
    ->orWhere('id','like',"%".$cari."%")
    ->orWhereHas('product',function($q) use ($cari){
        return $q->where('nama','like',"%".$cari."%");
    })
    ->orWhereHas('supplier',function($q) use ($cari){
        return $q->where('nama','like',"%".$cari."%");
    })
    ->paginate(10);

    return view('product_masuk.index',compact('products','suppliers','invoice_data'));
   }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::orderBy('id','ASC')->where('divisi_id',Auth::user()->divisi_id)
        ->get(['nama','id','qrcode']);

        $suppliers = Supplier::orderBy('nama','ASC')
        ->get(['nama','id']);

        return view('product_masuk.create',compact('products', 'suppliers'));
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
            'product_id'     => 'required',
            'supplier_id'    => 'required',
            'qty'            => 'required',
            'tanggal'        => 'required',
            'keterangan'     => 'required'
        ]);


        Product_Masuk::create($request->all());

        $product = Product::findOrFail($request->product_id);
        $product->qty += $request->qty;
        $product->save();
        ActivityLog::create(['user_id'=> Auth::user()->id, 'activity_status'=> 8, 'product_id'=> $product->id]);
        return redirect()->route('productsIn.index');

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
        $products = Product::orderBy('id','ASC')
        ->get(['nama','id','qrcode']);

        $suppliers = Supplier::orderBy('nama','ASC')
        ->get(['nama','id']);
        $product_masuk = Product_Masuk::find($id);
        return view('product_masuk.edit',compact('product_masuk','products','suppliers'));
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
            'product_id'     => 'required',
            'supplier_id'    => 'required',
            'qty'            => 'required',
            'tanggal'        => 'required',
            'keterangan'     => 'required',
        ]);

        $product_masuk = Product_Masuk::findOrFail($id);
        $product_masuk->update($request->all());

        $product = Product::findOrFail($request->product_id);
        $product->qty += $request->qty;
        $product->update();
        if($request->qty != $product->qty){
            ActivityLog::create(['user_id'=> Auth::user()->id, 'activity_status'=> 12, 'product_id'=> $product->id]);
        }else{
            ActivityLog::create(['user_id'=> Auth::user()->id, 'activity_status'=> 10, 'product_id'=> $product->id]);
        }

        return redirect()->route('productsIn.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product_Masuk::destroy($id);
        ActivityLog::create(['user_id'=> Auth::user()->id, 'activity_status'=> 5, 'product_id'=> $id]);
        return redirect()->back();
    }



    public function apiProductsIn(){
        $product = Product_Masuk::all();

        return DataTables::of($product)
            ->addColumn('products_name', function ($product){
                return $product->product->qrcode;
            })
            ->addColumn('supplier_name', function ($product){
                return $product->supplier->nama;
            })
            ->addColumn('keterangan', function ($product){
                return $product->keterangan;
            })
            ->addColumn('tanggal', function ($product){
                return $product->tanggal;
            })
            ->addColumn('action', function($product){
                return '<a href="#" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-eye-open"></i> Show</a> ' .
                    '<a onclick="editForm('. $product->id .')" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a> ' .
                    '<a onclick="deleteData('. $product->id .')" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete</a> ';


            })
            ->rawColumns(['products_name','supplier_name','action'])->make(true);

    }

    public function exportProductMasukAll()
    {
        $product_masuk = Product_Masuk::all();
        $pdf = Pdf::loadView('product_masuk.productMasukAllPDF',compact('product_masuk'));
        return $pdf->download('product_masuk.pdf');
    }

    public function exportProductMasuk($id)
    {
        $product_masuk = Product_Masuk::findOrFail($id);
        //dd($product_masuk);
        $pdf = Pdf::loadView('product_masuk.productMasukPDF', compact('product_masuk'));
        return $pdf->stream($product_masuk->id.'_product_masuk.pdf');
    }

    public function exportExcel()
    {
        return (new ExportProdukMasuk)->download('product_masuk.xlsx');
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
            Excel::import(new ProductsImportIn, $file); //IMPORT FILE
            return redirect()->back()->with(['success' => 'Upload file data Products Masuk !']);
        }

        return redirect()->back()->with(['error' => 'Please choose file before!']);
    }
}
