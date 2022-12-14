<?php

namespace App\Http\Controllers;

use App\Imports\ProductsImport;
use App\Models\ActivityLog;
use App\Models\Assets;
use App\Models\Category;
use App\Models\Lokasi;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Milon\Barcode\DNS1D;
use Milon\Barcode\Facades\DNS2DFacade;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
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
        $category = Category::orderBy('name','ASC')
            ->get(['name','id']);

        $producs = Product::all();
        $lokasi  = Lokasi::all();
        $asset   = Assets::all();
        return view('products.index', compact('category','lokasi','asset'));
    }


    public function detail($id)
    {
        $category = Category::where('id',$id)->get(['name']);
        //dd($category);
        $producs = Product::find($id);
        //dd($producs);
        $lokasi  = Lokasi::all();
        $asset   = Assets::all();
        return view('products.detail')
        ->with('category',$category)
        ->with('lokasi',$lokasi)
        ->with('asset',$asset)
        ->with('producs', $producs);
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
        $this->validate($request , [
            'nama'          => 'required|string',
            'harga'         => 'required',
            'qty'           => 'required',
            'category_id'   => 'required',
            'lokasi_id'     => 'required',
            'assets_id'     => 'required',
            'user'          => 'required',
        ]);


        $input = $request->all();

        $product = Product::orderBy('id', 'DESC')->first();
        $get_category = Category::orderBy('name','ASC')
        ->where('id', $input["category_id"])->first();
        $lokasi = Lokasi::orderBy('name','ASC')
        ->where('id',$input["lokasi_id"])->first();
        $input['image'] = null;
        $input['product_code'] = strtoupper("Product :".$request->nama)."\n".strtoupper("Lokasi : ".$lokasi->name)."\n".strtoupper("Category : ".$get_category->name);

        $id = $product->id;
        $id++;
        $test = str_pad($id,5,'0', STR_PAD_LEFT);
        $input['qrcode'] = strtoupper(substr($get_category->name, 0, 1)).strtoupper(substr($get_category->name, 6, 1)).strtoupper($test);

        if ($request->hasFile('image')){
            $input['image'] = '/upload/products/'.Str::slug($input['nama'], '-').strtotime('now').'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('/upload/products/'), $input['image']);
        }
        $input['harga'] = str_replace(",", "", $input['harga']);

        $product_eks = Product::create($input);
        ActivityLog::create(['user_id'=> Auth::user()->id, 'activity_status'=> 1, 'product_id'=> $product_eks->id]);
        return response()->json([
            'success' => true,
            'message' => 'Products Created'
        ]);

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
        $category = Category::orderBy('name','ASC')
            ->get()
            ->pluck('name','id');
        $product = Product::find($id);
        return $product;
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
        $category = Category::orderBy('name','ASC')
            ->get()
            ->pluck('name','id');

        $this->validate($request , [
            'nama'          => 'required|string',
            'harga'         => 'required',
            'qty'           => 'required',
            'category_id'   => 'required',
            'lokasi_id'     => 'required',
            'assets_id'     => 'required',
            'user'          => 'required',
        ]);

        $input = $request->all();
        $produk = Product::findOrFail($id);

        $input['image'] = $produk->image;

        if ($request->hasFile('image')){
            if (!$produk->image == NULL){
                if(file_exists(public_path($produk->image))){
                    unlink(public_path($produk->image));
                }
                // unlink(public_path($produk->image));
            }
            $input['image'] = '/upload/products/'.Str::slug($input['nama'], '-').strtotime('now').'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('/upload/products/'), $input['image']);
        }
        if($request->qty != $produk->qty){
            ActivityLog::create(['user_id'=> Auth::user()->id, 'activity_status'=> 6, 'product_id'=> $id]);
        }else{
            ActivityLog::create(['user_id'=> Auth::user()->id, 'activity_status'=> 2, 'product_id'=> $id]);
        }
        $produk->update($input);

        return response()->json([
            'success' => true,
            'message' => 'Products Update'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if (!$product->image == NULL){

            if(file_exists(public_path($product->image))){
                unlink(public_path($product->image));
            }
        }

        Product::destroy($id);
        ActivityLog::create(['user_id'=> Auth::user()->id, 'activity_status'=> 3, 'product_id'=> $id]);
        return response()->json([
            'success' => true,
            'message' => 'Products Deleted'
        ]);
    }

    public function apiProducts(){
        //$product = Product::join('activity_log', 'activity_log.product_id', '=', 'products.id', 'left outer')->orderBy('products.id', 'desc')->get();
        $product = Product::all();
        //dd($product);
        // dd(DNS1D::getBarcodeHTML("1982924", 'PHARMA'));
        return DataTables::of($product)
            ->addColumn('category_name', function ($product){
                return $product->category->name;
            })
            ->addColumn('lokasi_name', function ($product){
                return $product->lokasi->name;
            })
            ->addColumn('assets_name', function ($product){
                return $product->assets->name;
            })
            ->addColumn('product_code', function ($product){
                $qr = DNS2DFacade::getBarcodeHTML($product->product_code, 'QRCODE', 3,3 )."<br>"."<p>($product->qrcode)</p>";
                return $qr;
            })->escapeColumns([])
            ->addColumn('show_photo', function($product){
                if (empty($product->image)){
                    return 'No Image';
                }
                return '<img class="rounded-square" width="50" height="50" src="'. url($product->image) .'" alt="">';
            })
            ->addColumn('user_show', function($product){
                return $product->user;
            })
            // ->addColumn('link', function($product){
            //     if(!empty($product->link)){
            //     return '<a target="_blank" href="'.$product->link.'">Online Shop Link</a>';
            // }
            // })
            ->addColumn('activity_status', function($product){
                $activ = ActivityLog::where('product_id', $product->id)->orderBy('id_activity', 'desc')->first();
                if(isset($activ)){
                    $user = User::find($activ->user_id);
                    if ($activ->activity_status == 1){
                        $message = "Last Input Product by $user->name";
                    }else if($activ->activity_status == 2){
                        $message = "Last Edit Product by $user->name";
                    }else if($activ->activity_status == 3){
                        $message = "Last Hapus Product by $user->name";
                    }else if($activ->activity_status == 4){
                        $message = "Last Hapus PK by $user->name";
                    }else if($activ->activity_status == 5){
                        $message = "Last Hapus PM by $user->name";
                    }else if($activ->activity_status == 6){
                        $message = "Last Edit QTY by $user->name";
                    }else if($activ->activity_status == 7){
                        $message = "Last Add Product Out by $user->name";
                    }else if($activ->activity_status == 8){
                        $message = "Last Add Product In by $user->name";
                    }else if($activ->activity_status == 9){
                        $message = "Last Edit Product Out by $user->name";
                    }else if($activ->activity_status == 10){
                        $message = "Last Edit Product In by $user->name";
                    }else if($activ->activity_status == 11){
                        $message = "Last Edit QTY Product Out by $user->name";
                    }else if($activ->activity_status == 12){
                        $message = "Last Edit QTY Product In by $user->name";
                    }
                }else{
                    $message = "Nothing";
                }
                return '<span class="badge badge-warning">'.$message.'</span>';
            })
            ->addColumn('action', function($product){
                return '<a href="/print/barcode/'.$product->id .' ?download=Y" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-eye-open"></i> Export</a> ' .
                    '<a href="detail/'.$product->id .'" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-eye-open"></i> Show</a> ' .
                    '<a onclick="editForm('. $product->id .')" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a> ' .
                    '<a onclick="deleteData('. $product->id .')" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
            })
            ->rawColumns(['category_name','show_photo','action'])->make(true);

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
            Excel::import(new ProductsImport, $file); //IMPORT FILE
            return redirect()->back()->with(['success' => 'Upload file data Products !']);
        }

        return redirect()->back()->with(['error' => 'Please choose file before!']);
    }
}
