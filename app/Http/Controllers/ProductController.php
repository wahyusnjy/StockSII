<?php

namespace App\Http\Controllers;

use App\Exports\ExportProduk;
use App\Imports\ProductsImport;
use App\Models\ActivityLog;
use App\Models\Assets;
use App\Models\Category;
use App\Models\Lokasi;
use App\Models\Product;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Laravel\Breeze\BreezeServiceProvider;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Milon\Barcode\DNS1D;
use Milon\Barcode\Facades\DNS2DFacade;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Dompdf;
use PhpParser\Node\Expr\Empty_;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Validators\ValidationException;
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
    public function index(Request $request)
    {
        $category = Category::orderBy('name','ASC')
            ->get(['name','id']);



        $type         = $request->type;
        $search       = $request->search;
        $producs      = Product::paginate(20);
        $product      = Product::all();
        foreach($product as $p){
        if(empty($activ)){

        }else{
        $activ        = ActivityLog::where('product_id', $p->id)->orderBy('id_activity', 'desc')->first();
    }
        }

        $lokasi  = Lokasi::all();
        $asset   = Assets::all();
        return view('products.index', compact('category','lokasi','asset','producs'));
    }
   public function CariProduct(Request $request)
   {

    $cari = $request->cari;

    $category = Category::orderBy('name','ASC')
            ->get(['name','id']);
    $lokasi  = Lokasi::all();
    $asset   = Assets::all();
    $producs = Product::where('nama','like',"%".$cari."%")
    ->orWhere('qrcode','like',"%".$cari."%")
    ->orWhere('user','like',"%".$cari."%")
    ->orWhere('id','like',"%".$cari."%")
    ->orWhereHas('assets',function($q) use ($cari){
        return $q->where('name','like',"%".$cari."%");
    })
    ->orWhereHas('lokasi',function($q) use ($cari){
        return $q->where('name','like',"%".$cari."%");
    })
    ->orWhereHas('category',function($q) use ($cari){
        return $q->where('name','like',"%".$cari."%");
    })
    ->paginate(20);

    return view('products.index',compact('producs','category','lokasi','asset'));
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
        $category = Category::all();
        //dd($category);
        $producs = Product::all();
        //dd($producs);
        $lokasi  = Lokasi::all();
        $asset   = Assets::all();
        return view('products.create')
        ->with('category',$category)
        ->with('lokasi',$lokasi)
        ->with('asset',$asset)
        ->with('producs', $producs);
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
            'qty'           => 'required|numeric',
            'category_id'   => 'required',
            'lokasi_id'     => 'required',
            'assets_id'     => 'required',
            'user'          => 'required',
            'image'         => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);


        $input = $request->all();

        $product = Product::orderBy('id', 'DESC')->first();
        $get_category = Category::orderBy('name','ASC')
        ->where('id', $input["category_id"])->first();
        $lokasi = Lokasi::orderBy('name','ASC')
        ->where('id',$input["lokasi_id"])->first();
        $input['image'] = null;
        $input['product_code'] = strtoupper("Product :".$request->nama)."\n".strtoupper("Lokasi : ".$lokasi->name)."\n".strtoupper("Category : ".$get_category->name);

        if(empty($product->id)){
            $id = 0;
            $test = str_pad($id++,5,'0', STR_PAD_LEFT);
            $input['qrcode'] = strtoupper(substr($get_category->name, 0, 1)).strtoupper(substr($get_category->name, 6, 1)).strtoupper($test);
        }else{
            $id = $product->id;
            $id++;
            $test = str_pad($id,5,'0', STR_PAD_LEFT);
            $input['qrcode'] = strtoupper(substr($get_category->name, 0, 1)).strtoupper(substr($get_category->name, 6, 1)).strtoupper($test);
        }


        if ($request->hasFile('image')){

            $image = $request->file('image');
            $input['image'] = '/upload/products/' . Str::slug($input['nama'], '-').strtotime('now').'.'.$request->image->getClientOriginalExtension();
            $image2 = Str::slug($input['nama'], '-').strtotime('now').'.'.$request->image->getClientOriginalExtension();
            $destinationPath = public_path('/upload/products/');
            $img = Image::make($image->getRealPath());
            $img->resize(1000,1000,function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath .'/'.$image2);
            $image->move($destinationPath, $image2);
            // $input['image'] = '/upload/products/'.Str::slug($input['nama'], '-').strtotime('now').'.'.$request->image->getClientOriginalExtension();
            // $request->image->move(public_path('/upload/products/'), $input['image']);
            // $file = $input['image'] = '/upload/products/'.Str::slug($input['nama'], '-').strtotime('now').'.'.$request->image->getClientOriginalExtension();

            // dd($compresedImage);
            //  $compresedImage->move(public_path('/upload/products/'), $input['image']);
        }
        $input['harga'] = str_replace(".", "", $input['harga']);

        $product_eks = Product::create($input);
        ActivityLog::create(['user_id'=> Auth::user()->id, 'activity_status'=> 1, 'product_id'=> $product_eks->id]);
        return redirect()->route('products.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::all();
        //dd($category);
        $producs = Product::find($id);
        //dd($producs);
        $lokasi  = Lokasi::all();
        $asset   = Assets::all();
        return view('products.edit')
        ->with('category',$category)
        ->with('lokasi',$lokasi)
        ->with('asset',$asset)
        ->with('producs', $producs);
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


        $this->validate($request , [
            'nama'          => 'required|string',
            'harga'         => 'required',
            'qty'           => 'required',
            'category_id'   => 'required',
            'lokasi_id'     => 'required',
            'assets_id'     => 'required',
            'user'          => 'required',
            'image'         => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);


        $input = $request->except('_token');

        $produk = Product::findOrFail($id);
        $input['harga'] = str_replace(".", "", $input['harga']);

        $get_category = Category::orderBy('name','ASC')
        ->where('id', $input["category_id"])->first();
        $lokasi = Lokasi::orderBy('name','ASC')
        ->where('id',$input["lokasi_id"])->first();

        if(empty($produk->id)){
            $id = 0;
            $test = str_pad($id++,5,'0', STR_PAD_LEFT);
            $input['qrcode'] = strtoupper(substr($get_category->name, 0, 1)).strtoupper(substr($get_category->name, 6, 1)).strtoupper($test);
        }else{
            $id = $produk->id;
            $test = str_pad($id,5,'0', STR_PAD_LEFT);
            $input['qrcode'] = strtoupper(substr($get_category->name, 0, 1)).strtoupper(substr($get_category->name, 6, 1)).strtoupper($test);
        }

        $input['product_code'] = strtoupper("Product :".$request->nama)."\n".strtoupper("Lokasi : ".$lokasi->name)."\n".strtoupper("Category : ".$get_category->name)."\n".strtoupper("User : ".$produk->user);

        $input['image'] = $produk->image;
        if ($request->hasFile('image')){
            if (!$produk->image == NULL){
                if(file_exists(public_path($produk->image))){
                    unlink(public_path($produk->image));
                }
                // unlink(public_path($produk->image));
            }
            $image = $request->file('image');
            $input['image'] = '/upload/products/' . Str::slug($input['nama'], '-').strtotime('now').'.'.$request->image->getClientOriginalExtension();
            $image2 = Str::slug($input['nama'], '-').strtotime('now').'.'.$request->image->getClientOriginalExtension();
            $destinationPath = public_path('/upload/products');
            $img = Image::make($image->getRealPath());
            $img->resize(1000,1000,function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath .'/'.$image2);
            $image->move($destinationPath, $image2);
            // $input['image'] = '/upload/products/'.Str::slug($input['nama'], '-').strtotime('now').'.'.$request->image->getClientOriginalExtension();
            // $request->image->move(public_path('/upload/products/'), $input['image']);
        }
        if($request->qty != $produk->qty){
            ActivityLog::create(['user_id'=> Auth::user()->id, 'activity_status'=> 6, 'product_id'=> $id]);
        }else{
            ActivityLog::create(['user_id'=> Auth::user()->id, 'activity_status'=> 2, 'product_id'=> $id]);
        }

        $produk->update($input);

        $url = $request->input('url');

       return redirect($url);

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
        return redirect()->back();
    }

    public function apiProducts(){
        //$product = Product::join('activity_log', 'activity_log.product_id', '=', 'products.id', 'left outer')->orderBy('products.id', 'desc')->get();
        $product = Product::all();
        //dd($product);
        // dd(DNS1D::getBarcodeHTML("1982924", 'PHARMA'));
        return DataTables::of($product)
            ->addColumn('checkbox', function($product){
            return '<input type="checkbox" class="child-cb" value="'.$product->id.'">';
            })
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
            'file' => 'required|mimes:xls,xlsx|max:1001'
        ]);

        try {
            if ($request->hasFile('file')) {
                //UPLOAD FILE
                $file = $request->file('file'); //GET FILE
                //dd($file);
                $import = new ProductsImport;
                Excel::import($import, $file); //IMPORT FILE
                // dd($import->getRowCount());
                return redirect()->back()->with(['success' => 'Upload file data Products !']);
                // if ($import->getRowCount() > 1001) {
                //     return redirect()->back()->with(['Failed' => 'Upload file data Products !']);
                // }
                // else{

                // }
            }

        } catch (ValidationException $e) {
            $errorMessage = $e->getMessage();
            return redirect()->back()->withErrors($errorMessage);
        }

        return redirect()->back()->with(['error' => 'Please choose file before!']);
    }

    public function BarcodeSelected(Request $request)
    {
        // $ids = explode(',', $request->ids);
        // return (new ExportProduk($ids))->download('produck.pdf', \Maatwebsite\Excel\Excel::TCPDF);
        // return Excel::download(new ExportProduk($ids), 'karyawan.xlsx');

        set_time_limit(3000);
		ini_set("memory_limit", "999M");
		ini_set("max_execution_time", "999");
        $ids = explode(',', $request->ids);
		$product1 = Product::findOrFail($ids);
		$pdf = Pdf::loadView('products.barcode_pdf', ['product1' => $product1])->setOptions(['defaultFont' => 'sans-serif'])->setpaper('A4', 'potrait');
		return $pdf->stream('Product.pdf');
		if($request->download){
			//return view('products.barcode')->with('product', $product);
			return $pdf->download('product_'.date('Y-m-dHis').'.pdf');
		}


		// return view('products.barcode_pdf')->with('product1', $product1);
    }

    public function BarcodePage(Request $request)
    {
        // $ids = explode(',', $request->ids);
        // return (new ExportProduk($ids))->download('produck.pdf', \Maatwebsite\Excel\Excel::TCPDF);
        // return Excel::download(new ExportProduk($ids), 'karyawan.xlsx');

        set_time_limit(3000);
		ini_set("memory_limit", "999M");
		ini_set("max_execution_time", "999");

		// $i = Product::paginate(20);
        // $pagin = $i->currentPage();
        $product1 =  Product::paginate(20);;
        // dd($i);

		$pdf = Pdf::loadView('products.barcode', ['product1' => $product1])->setOptions(['defaultFont' => 'sans-serif'])->setpaper('A4', 'potrait');
		return $pdf->stream('Product.pdf');
		if($request->download){
			//return view('products.barcode')->with('product', $product);
			return $pdf->download('product_'.date('Y-m-dHis').'.pdf');
		}


		// return view('products.barcode_pdf')->with('product1', $product1);
    }
}
