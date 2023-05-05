<?php

namespace App\Http\Controllers;

use App\Exports\ExportProdukKeluar;
use App\Imports\ProductsImportOut;
use App\Models\ActivityLog;
use App\Models\Assets;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Divisi;
use App\Models\Product;
use App\Models\Product_Keluar;
use App\Models\Rak;
use App\Models\Ruangan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ProductKeluarController extends Controller
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
        $products = Product::orderBy('id','ASC')
        ->get(['nama','id', 'qrcode']);

        $customers = Customer::orderBy('nama','ASC')
        ->get(['nama','id']);

        $invoice_data = Product_Keluar::where('user_id',Auth::user()->id)->paginate(10);
        return view('product_keluar.index', compact('products','customers', 'invoice_data'));
    }

    public function Cari(Request $request)
   {
    $cari = $request->cari;

    $products = Product::orderBy('id','ASC')
    ->get(['nama','id', 'qrcode']);

    $customers = Customer::orderBy('nama','ASC')
    ->get(['nama','id']);

    $invoice_data = Product_Keluar::where('qty','like',"%".$cari."%")
    ->orWhere('tanggal','like',"%".$cari."%")
    ->orWhere('keterangan','like',"%".$cari."%")
    ->orWhere('id','like',"%".$cari."%")
    ->orWhereHas('product',function($q) use ($cari){
        return $q->where('nama','like',"%".$cari."%");
    })
    ->orWhereHas('customer',function($q) use ($cari){
        return $q->where('nama','like',"%".$cari."%");
    })
    ->paginate(10);

    return view('product_keluar.index',compact('products','customers', 'invoice_data'));
   }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::orderBy('id','ASC')->where('divisi_id',Auth::user()->divisi_id)
        ->get(['nama','id', 'qrcode','qty']);

        $divisi = Divisi::orderBy('name','ASC')
        ->get(['name','id']);

        $customers = Customer::orderBy('nama','ASC')
        ->get(['nama','id']);

        $region = Category::orderBy('name','ASC')
        ->get(['name','id']);

        $room = Ruangan::orderBy('name','ASC')
        ->get(['name','id']);

        $rack = Rak::orderBy('name','ASC')
        ->get(['name','id']);

        return view('product_keluar.create',compact('products','customers','divisi','region','room','rack'));
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
           'qty'            => 'required',
           'tanggal'        => 'required',
           'keterangan'     => 'required',
        ]);

        Product_Keluar::create($request->all());

        $product = Product::findOrFail($request->product_id);
        $product->qty -= $request->qty;
        $product->save();

        $new = Product::where('divisi_id',$request->divisi_id)->where('nama',$product->nama)->get();

        foreach($new as $n){
            $np = $n;
        }


        if(empty($np)){
             //product_code,qrcode,user_id,divisi_id
             $get_category = Category::orderBy('name','ASC')
             ->where('id', $request->region_id)->first();
             $kategori = Assets::orderBy('name','ASC')
             ->where('id', $product->assets_id)->first();
             $divisi = Divisi::orderBy('name','ASC')
             ->where('id', $request->divisi_id)->first();
            //  dd($kategori);
             if(empty($request->room_id)){

             }else{
                 $room = Ruangan::orderBy('name','ASC')
                 ->where('id',$request->room_id)->first();
             }

             if(empty($request->rack_id)){

             } else{
                 $rack = Rak::orderBy('name','ASC')
                 ->where('id',$request->rack_id)->first();
             }


             if(empty($room)){
                 $product_code = strtoupper("Product :".$product->nama)."\n".strtoupper("Location : -")."\n".strtoupper("Category : ".$kategori->name);
             }else{
             $product_code = strtoupper("Product :".$product->nama)."\n".strtoupper("Location : ".$room->name)."\n".strtoupper("Category : ".$kategori->name);
             }

             if(empty($product->id)){
                 $id = 1;
                 $test = str_pad($id,3,'0', STR_PAD_LEFT);
                 if(empty($room)){

                     if(empty($rack)){
                         $qrcode = strtoupper($get_category->name).strtoupper(substr($divisi->name, 0,2)).strtoupper($test);
                     }else {
                         $qrcode = strtoupper($get_category->name).strtoupper(substr($rack->name,0,2)).strtoupper($test);
                     }
                 }else{

                     if(empty($rack)){
                         $qrcode = strtoupper($get_category->name).strtoupper(substr($room->name, 0, 2)).strtoupper($test);
                     }else {
                         $qrcode = strtoupper($get_category->name).strtoupper(substr($room->name, 0, 2)).strtoupper(substr($rack->name,0,2)).strtoupper($test);
                     }
                 }

             }else{
                 $id = $product->id;
                 $id++;
                 $test = str_pad($id,3,'0', STR_PAD_LEFT);

                 if(empty($room)){

                     if(empty($rack)){
                         $qrcode = strtoupper($get_category->name).strtoupper(substr($divisi->name, 0,2)).strtoupper($test);
                     }else {
                         $qrcode = strtoupper($get_category->name).strtoupper(substr($rack->name,0,2)).strtoupper($test);
                     }
                 }else{

                     if(empty($rack)){
                         $qrcode = strtoupper($get_category->name).strtoupper(substr($room->name, 0, 2)).strtoupper($test);
                     }else {
                         $qrcode = strtoupper($get_category->name).strtoupper(substr($room->name, 0, 2)).strtoupper(substr($rack->name,0,2)).strtoupper($test);
                     }
                 }

             }

             product::create([
                 'category_id'    => $request->region_id ?? null,
                 'room_id'        => $request->room_id ?? null,
                 'rack_id'        => $request->rack_id ?? null,
                 'assets_id'      => $product->assets_id,
                 'nama'           => $product->nama,
                 'harga'          => $product->harga,
                 'qty'            => $request->qty,
                 'product_code'   => $product_code,
                 'qrcode'         => $qrcode,
                 'divisi_id'      => $request->divisi_id,
             ]);
        }else{
        if($np->nama == $product->nama){
            $pn = product::where('divisi_id',$request->divisi_id)->where('nama', $product->nama)->first();

            $pn->qty +=  $request->qty;
            $pn->save();
        }else {
            //product_code,qrcode,user_id,divisi_id
            $get_category = Category::orderBy('name','ASC')
            ->where('id', $request->region_id)->first();
            $kategori = Assets::orderBy('name','ASC')
            ->where('id', $product->assets_id)->first();
            $divisi = Divisi::orderBy('name','ASC')
            ->where('id', $request->divisi_id)->first();
            // dd($kategori);
            if(empty($request->room_id)){

            }else{
                $room = Ruangan::orderBy('name','ASC')
                ->where('id',$request->room_id)->first();
            }

            if(empty($request->rack_id)){

            } else{
                $rack = Rak::orderBy('name','ASC')
                ->where('id',$request->rack_id)->first();
            }


            if(empty($room)){
                $product_code = strtoupper("Product :".$product->nama)."\n".strtoupper("Location : -")."\n".strtoupper("Category : ".$kategori->name);
            }else{
            $product_code = strtoupper("Product :".$product->nama)."\n".strtoupper("Location : ".$room->name)."\n".strtoupper("Category : ".$kategori->name);
            }

            if(empty($product->id)){
                $id = 1;
                $test = str_pad($id,3,'0', STR_PAD_LEFT);
                if(empty($room)){

                    if(empty($rack)){
                        $qrcode = strtoupper($get_category->name).strtoupper(substr($divisi->name, 0,2)).strtoupper($test);
                    }else {
                        $qrcode = strtoupper($get_category->name).strtoupper(substr($rack->name,0,2)).strtoupper($test);
                    }
                }else{

                    if(empty($rack)){
                        $qrcode = strtoupper($get_category->name).strtoupper(substr($room->name, 0, 2)).strtoupper($test);
                    }else {
                        $qrcode = strtoupper($get_category->name).strtoupper(substr($room->name, 0, 2)).strtoupper(substr($rack->name,0,2)).strtoupper($test);
                    }
                }

            }else{
                $id = $product->id;
                $id++;
                $test = str_pad($id,3,'0', STR_PAD_LEFT);

                if(empty($room)){

                    if(empty($rack)){
                        $qrcode = strtoupper($get_category->name).strtoupper(substr($divisi->name, 0,2)).strtoupper($test);
                    }else {
                        $qrcode = strtoupper($get_category->name).strtoupper(substr($rack->name,0,2)).strtoupper($test);
                    }
                }else{

                    if(empty($rack)){
                        $qrcode = strtoupper($get_category->name).strtoupper(substr($room->name, 0, 2)).strtoupper($test);
                    }else {
                        $qrcode = strtoupper($get_category->name).strtoupper(substr($room->name, 0, 2)).strtoupper(substr($rack->name,0,2)).strtoupper($test);
                    }
                }

            }

            product::create([
                'category_id'    => $request->region_id ?? null,
                'room_id'        => $request->room_id ?? null,
                'rack_id'        => $request->rack_id ?? null,
                'assets_id'      => $product->assets_id,
                'nama'           => $product->nama,
                'harga'          => $product->harga,
                'qty'            => $request->qty,
                'product_code'   => $product_code,
                'qrcode'         => $qrcode,
                'divisi_id'      => $request->divisi_id,
            ]);
        }
    }
        ActivityLog::create(['user_id'=> Auth::user()->id, 'activity_status'=> 7, 'product_id'=> $product->id]);
        return redirect()->route('productsOut.index');

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
    $products = Product::orderBy('id','ASC')->where('divisi_id',Auth::user()->divisi_id)
    ->get(['nama','id', 'qrcode']);
    $customers = Customer::orderBy('nama','ASC')
    ->get(['nama','id']);
    $divisi = Divisi::orderBy('name','ASC')
    ->get(['name','id']);

    $region = Category::orderBy('name','ASC')
        ->get(['name','id']);

    $room = Ruangan::orderBy('name','ASC')
    ->get(['name','id']);

    $rack = Rak::orderBy('name','ASC')
    ->get(['name','id']);

        $product_keluar = Product_Keluar::find($id);
        return view('product_keluar.edit', compact('product_keluar', 'products', 'customers','divisi','region','room','rack'));
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
            'qty'            => 'required',
            'tanggal'        => 'required',
            'keterangan'     => 'required'
        ]);

        $product_keluar = Product_Keluar::findOrFail($id);

        $product = Product::findOrFail($request->product_id);
        $pop = Product::where('divisi_id',$product_keluar->divisi_id)->where('nama',$product->nama)->first();
        dd($product_keluar != $request->all());
        $pop->delete();
        if($request->qty != $product_keluar->qty){
            $get_category = Category::orderBy('name','ASC')
            ->where('id', $request->region_id)->first();
            $kategori = Assets::orderBy('name','ASC')
            ->where('id', $product->assets_id)->first();
            $divisi = Divisi::orderBy('name','ASC')
            ->where('id', $request->divisi_id)->first();
            // dd($get_category);
            if(empty($request->room_id)){

                }else{
                    $room = Ruangan::orderBy('name','ASC')
                    ->where('id',$request->room_id)->first();
            }

            if(empty($request->rack_id)){

                } else{
                    $rack = Rak::orderBy('name','ASC')
                    ->where('id',$request->rack_id)->first();
            }


            if(empty($room)){
                    $product_code = strtoupper("Product :".$product->nama)."\n".strtoupper("Location : -")."\n".strtoupper("Category : ".$kategori->name);
                }else{
                $product_code = strtoupper("Product :".$product->nama)."\n".strtoupper("Location : ".$room->name)."\n".strtoupper("Category : ".$kategori->name);
            }

            if(empty($product->id)){
                $id = 1;
                $test = str_pad($id,3,'0', STR_PAD_LEFT);
                if(empty($room)){

                    if(empty($rack)){
                        $qrcode = strtoupper($get_category->name).strtoupper(substr($divisi->name, 0,2)).strtoupper($test);
                    }else {
                        $qrcode = strtoupper($get_category->name).strtoupper(substr($rack->name,0,2)).strtoupper($test);
                    }
                }else{

                    if(empty($rack)){
                        $qrcode = strtoupper($get_category->name).strtoupper(substr($room->name, 0, 2)).strtoupper($test);
                    }else {
                        $qrcode = strtoupper($get_category->name).strtoupper(substr($room->name, 0, 2)).strtoupper(substr($rack->name,0,2)).strtoupper($test);
                    }
                }

            }else{
                $id = $product->id;
                $id++;
                $test = str_pad($id,3,'0', STR_PAD_LEFT);

                if(empty($room)){

                    if(empty($rack)){
                        $qrcode = strtoupper($get_category->name).strtoupper(substr($divisi->name, 0,2)).strtoupper($test);
                    }else {
                        $qrcode = strtoupper($get_category->name).strtoupper(substr($rack->name,0,2)).strtoupper($test);
                    }
                }else{

                    if(empty($rack)){
                        $qrcode = strtoupper($get_category->name).strtoupper(substr($room->name, 0, 2)).strtoupper($test);
                    }else {
                        $qrcode = strtoupper($get_category->name).strtoupper(substr($room->name, 0, 2)).strtoupper(substr($rack->name,0,2)).strtoupper($test);
                    }
                }

            }


            $product->qty += $product_keluar->qty;
            $product->qty -= $request->qty;
            $product->category_id       = $request->region_id ?? null;
            $product->room_id           = $request->room_id ?? null;
            $product->rack_id           = $request->rack_id ?? null;
            $product->assets_id         = $request->region_id;
            $product->nama              = $request->nama;
            $product->harga             = $request->harga;
            $product->qty               = $request->qty;
            $product->product_code      = $product_code;
            $product->qrcode            = $qrcode;
            $product->divisi_id         = $request->divisi_id;
        }else {
            $get_category = Category::orderBy('name','ASC')
            ->where('id', $request->region_id)->first();
            $kategori = Assets::orderBy('name','ASC')
            ->where('id', $product->assets_id)->first();
            $divisi = Divisi::orderBy('name','ASC')
            ->where('id', $request->divisi_id)->first();
            // dd($get_category);
            if(empty($request->room_id)){

            }else{
                $room = Ruangan::orderBy('name','ASC')
                ->where('id',$request->room_id)->first();
            }

            if(empty($request->rack_id)){

            } else{
                $rack = Rak::orderBy('name','ASC')
                ->where('id',$request->rack_id)->first();
            }


            if(empty($room)){
                $product_code = strtoupper("Product :".$product->nama)."\n".strtoupper("Location : -")."\n".strtoupper("Category : ".$kategori->name);
            }else{
            $product_code = strtoupper("Product :".$product->nama)."\n".strtoupper("Location : ".$room->name)."\n".strtoupper("Category : ".$kategori->name);
            }

            if(empty($product->id)){
                $id = 1;
                $test = str_pad($id,3,'0', STR_PAD_LEFT);
                if(empty($room)){

                    if(empty($rack)){
                        $qrcode = strtoupper($get_category->name).strtoupper(substr($divisi->name, 0,2)).strtoupper($test);
                    }else {
                        $qrcode = strtoupper($get_category->name).strtoupper(substr($rack->name,0,2)).strtoupper($test);
                    }
                }else{

                    if(empty($rack)){
                        $qrcode = strtoupper($get_category->name).strtoupper(substr($room->name, 0, 2)).strtoupper($test);
                    }else {
                        $qrcode = strtoupper($get_category->name).strtoupper(substr($room->name, 0, 2)).strtoupper(substr($rack->name,0,2)).strtoupper($test);
                    }
                }

            }else{
                $id = $product->id;
                $id++;
                $test = str_pad($id,3,'0', STR_PAD_LEFT);

                if(empty($room)){

                    if(empty($rack)){
                        $qrcode = strtoupper($get_category->name).strtoupper(substr($divisi->name, 0,2)).strtoupper($test);
                    }else {
                        $qrcode = strtoupper($get_category->name).strtoupper(substr($rack->name,0,2)).strtoupper($test);
                    }
                }else{

                    if(empty($rack)){
                        $qrcode = strtoupper($get_category->name).strtoupper(substr($room->name, 0, 2)).strtoupper($test);
                    }else {
                        $qrcode = strtoupper($get_category->name).strtoupper(substr($room->name, 0, 2)).strtoupper(substr($rack->name,0,2)).strtoupper($test);
                    }
                }

            }
            $product->category_id       = $request->region_id ?? null;
            $product->room_id           = $request->room_id ?? null;
            $product->rack_id           = $request->rack_id ?? null;
            $product->assets_id         = $request->region_id;
            $product->nama              = $product->nama;
            $product->harga             = $product->harga;
            $product->qty               = $request->qty;
            $product->product_code      = $product_code;
            $product->qrcode            = $qrcode;
            $product->divisi_id         = $request->divisi_id;
        }

        $product->save();
        $product_keluar->update($request->all());
        if($request->qty != $product->qty){
            ActivityLog::create(['user_id'=> Auth::user()->id, 'activity_status'=> 11, 'product_id'=> $product->id]);
        }else{
            ActivityLog::create(['user_id'=> Auth::user()->id, 'activity_status'=> 9, 'product_id'=> $product->id]);
        }


        return redirect()->route('productsOut.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product_Keluar::destroy($id);
        ActivityLog::create(['user_id'=> Auth::user()->id, 'activity_status'=> 4, 'product_id'=> $id]);
        return redirect()->back();
    }



    public function apiProductsOut(){
        $product = Product_Keluar::all();

        return DataTables::of($product)
            ->addColumn('products_name', function ($product){
                return $product->product->qrcode;
            })
            ->addColumn('customer_name', function ($product){
                return $product->customer->nama;
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
                    '<a onclick="deleteData('. $product->id .')" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
            })
            ->rawColumns(['products_name','customer_name','action'])->make(true);

    }

    public function exportProductKeluarAll()
    {
        $product_keluar = Product_Keluar::all();
        $pdf = Pdf::loadView('product_keluar.productKeluarAllPDF',compact('product_keluar'));
        return $pdf->download('product_keluar.pdf');
    }

    public function exportProductKeluar($id)
    {
        $product_keluar = Product_Keluar::findOrFail($id);
        $pdf = Pdf::loadView('product_keluar.productKeluarPDF', compact('product_keluar'));
        return $pdf->stream($product_keluar->id.'_product_keluar.pdf');
    }

    public function exportExcel()
    {
        return (new ExportProdukKeluar)->download('product_keluar.xlsx');
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
            Excel::import(new ProductsImportOut, $file); //IMPORT FILE
            return redirect()->back()->with(['success' => 'Upload file data Products Keluar !']);
        }

        return redirect()->back()->with(['error' => 'Please choose file before!']);
    }
}
