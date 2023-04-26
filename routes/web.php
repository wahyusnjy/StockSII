<?php

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductKeluarController;
use App\Http\Controllers\ProductMasukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RakController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WilayahController;
use App\Models\Product;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Milon\Barcode\DNS1D;
use Yajra\DataTables\Facades\DataTables;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/dashboard', function () {
    // return Inertia::render('Dashboard');
    return view('layouts.master');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('homes');


Route::group(['middleware' => 'auth'], function () {
	Route::resource('wilayah', WilayahController::class);
    Route::get('/cari/wilayah',[WilayahController::class, 'Cari'])->name('cari.wilayah');
	Route::get('/apiwilayah', [WilayahController::class, 'apiwilayah'])->name('api.wilayah');
	Route::get('/exportwilayahAll', [WilayahController::class, 'exportwilayahAll'])->name('exportPDF.wilayahAll');
	Route::get('/exportwilayahAllExcel', [WilayahController::class, 'exportExcel'])->name('exportExcel.wilayahAll');

	Route::resource('customers', CustomerController::class);
    Route::get('/cari/customers',[CustomerController::class, 'Cari'])->name('cari.customers');
	Route::get('/apiCustomers', [CustomerController::class, 'apiCustomers'])->name('api.customers');
	Route::post('/importCustomers', [CustomerController::class, 'ImportExcel'])->name('import.customers');
	Route::get('/exportCustomersAll', [CustomerController::class, 'exportCustomersAll'])->name('exportPDF.customersAll');
	Route::get('/exportCustomersAllExcel', [CustomerController::class, 'exportExcel'])->name('exportExcel.customersAll');

	Route::resource('sales', SaleController::class);
    Route::get('/cari/sales',[SaleController::class, 'Cari'])->name('cari.sales');
	Route::get('/apiSales', [SaleController::class, 'apiSales'])->name('api.sales');
	Route::post('/importSales', [SaleController::class, 'ImportExcel'])->name('import.sales');
	Route::get('/exportSalesAll', [SaleController::class, 'exportSalesAll'])->name('exportPDF.salesAll');
	Route::get('/exportSalesAllExcel', [SaleController::class, 'exportExcel'])->name('exportExcel.salesAll');

	Route::resource('suppliers', SupplierController::class);
    Route::get('/cari/suppliers',[SupplierController::class, 'Cari'])->name('cari.suppliers');
	Route::get('/apiSuppliers', [SupplierController::class, 'apiSuppliers'])->name('api.suppliers');
	Route::post('/importSuppliers', [SupplierController::class, 'ImportExcel'])->name('import.suppliers');
	Route::get('/exportSupplierssAll', [SupplierController::class, 'exportSuppliersAll'])->name('exportPDF.suppliersAll');
	Route::get('/exportSuppliersAllExcel', [SupplierController::class, 'exportExcel'])->name('exportExcel.suppliersAll');

	Route::resource('products', ProductController::class);
    Route::get('/barcodePage',[ProductController::class, 'BarcodePage'])->name('BarcodePage.products');
    Route::get('/barcodeSelected',[ProductController::class, 'BarcodeSelected'])->name('barcodeSelected.products');
    Route::get('/cari/product',[ProductController::class, 'CariProduct'])->name('cariproduct.products');
    Route::post('/importProducts', [ProductController::class, 'ImportExcel'])->name('import.products');
    Route::get('/getProducts',[ProductController::class, 'getProducts'])->name('getProducts.products');
    Route::get('products/detail/{id}',[ProductController::class,'detail'])->name('detail.products');
	Route::get('/apiProducts', [ProductController::class, 'apiProducts'])->name('api.products');
    Route::get('/ProductsAllExcel', [ProductController::class, 'exportExcel'])->name('exportExcel.products');


	Route::resource('productsOut', ProductKeluarController::class);
    Route::get('/cari/productsOut',[ProductKeluarController::class, 'Cari'])->name('cari.productsOut');
	Route::get('/apiProductsOut', [ProductKeluarController::class, 'apiProductsOut'])->name('api.productsOut');
	Route::get('/exportProductKeluarAll', [ProductKeluarController::class, 'exportProductKeluarAll'])->name('exportPDF.productKeluarAll');
	Route::get('/exportProductKeluarAllExcel', [ProductKeluarController::class, 'exportExcel'])->name('exportExcel.productKeluarAll');
	Route::get('/exportProductKeluar/{id}', [ProductKeluarController::class, 'exportProductKeluar'])->name('exportPDF.productKeluar');
    Route::post('/importProductsKeluar', [ProductKeluarController::class, 'ImportExcel'])->name('import.productsKeluar');

	Route::resource('productsIn', ProductMasukController::class);
    Route::get('/cari/productsIn',[ProductMasukController::class, 'Cari'])->name('cari.productsIn');
	Route::get('/apiProductsIn', [ProductMasukController::class, 'apiProductsIn'])->name('api.productsIn');
	Route::get('/exportProductMasukAll', [ProductMasukController::class, 'exportProductMasukAll'])->name('exportPDF.productMasukAll');
	Route::get('/exportProductMasukAllExcel', [ProductMasukController::class, 'exportExcel'])->name('exportExcel.productMasukAll');
	Route::get('/exportProductMasuk/{id}', [ProductMasukController::class, 'exportProductMasuk'])->name('exportPDF.productMasuk');
    Route::post('/importProductsMasuk', [ProductMasukController::class, 'ImportExcel'])->name('import.productsMasuk');

	Route::resource('user', UserController::class);
    Route::get('/user/detail/{id}',[UserController::class,'detail'])->name('detail.users');
    Route::get('/cari/user',[UserController::class, 'Cari'])->name('cari.users');
	Route::get('/apiUser', [UserController::class, 'apiUsers'])->name('api.users');

    Route::resource('lokasi', LokasiController::class);
    Route::get('/cari/lokasi',[LokasiController::class, 'Cari'])->name('cari.lokasi');
	Route::get('/apiLokasi', [LokasiController::class, 'apiLokasi'])->name('api.lokasi');
	Route::get('/exportLokasiMasukAllExcel', [LokasiController::class, 'exportExcel'])->name('exportExcel.lokasiAll');
    Route::post('/importLokasiMasuk', [LokasiController::class, 'ImportExcel'])->name('import.lokasi');

    Route::resource('kategori', KategoriController::class);
    Route::get('/cari/assets',[KategoriController::class, 'Cari'])->name('cari.kategori');
	Route::get('/apikategori', [KategoriController::class, 'apikategori'])->name('api.kategori');

    //Profile
    Route::get('profile/{id}',[ProfileController::class,'show'])->name('show.profile');
    Route::get('profile/edit/{id}',[ProfileController::class, 'edit'])->name('edit.profile');
    Route::patch('profile/update/{id}',[ProfileController::class,'update'])->name('update.profile');

    Route::resource('divisi', DivisiController::class);
    Route::get('/cari/divisi',[DivisiController::class, 'CariDivisi'])->name('caridivisi.divisi');
    Route::get('divisi/edit/{id}',[DivisiController::class, 'edit'])->name('edit.profile');
    Route::get('divisi/detail/{id}',[DivisiController::class,'detail'])->name('detail.divisi');
	Route::get('/apiDivisi', [DivisiController::class, 'apiDivisi'])->name('api.divisi');

    Route::resource('rak', RakController::class);
    Route::get('/cari/rak',[RakController::class, 'CariRak'])->name('cari.rak');
	Route::get('/apirak', [RakController::class, 'apirak'])->name('api.rak');
	Route::get('/exportrakMasukAllExcel', [RakController::class, 'exportExcel'])->name('exportExcel.rakAll');
    Route::post('/importrakMasuk', [RakController::class, 'ImportExcel'])->name('import.rak');

    Route::resource('ruangan', RuanganController::class);
    Route::get('/cari/ruangan',[RuanganController::class, 'CariRuangan'])->name('cari.ruangan');
	Route::get('/apiruangan', [RuanganController::class, 'apiruangan'])->name('api.ruangan');
	Route::get('/exportruanganMasukAllExcel', [RuanganController::class, 'exportExcel'])->name('exportExcel.ruanganAll');
    Route::post('/importruanganMasuk', [RuanganController::class, 'ImportExcel'])->name('import.ruangan');

	Route::get('api/print/barcode', function(Request $request){

		$product = Product::all();
		return DataTables::of($product)

            ->addColumn('product_code', function ($product){
            	return DNS1D::getBarcodeHTML($product->product_code, 'C128');
            })->escapeColumns([])
			->addColumn('pcode', function ($product){
                return $product->product_code;
            })
            ->rawColumns(['action'])->make(true);

	})->name('api.print.barcode');
	Route::get('print/barcode', function(Request $request){
		// set_time_limit(3000);
		ini_set("memory_limit", "999M");
		ini_set("max_execution_time", "999");
		$product = Product::get();
		$pdf = Pdf::loadView('products.barcode', ['product' => $product])->setOptions(['defaultFont' => 'sans-serif']);
		//dd($pdf);

        //
		return view('products.barcode')->with('product', $product);
	});

    Route::get('print/barcode/{id}', function(Request $request, $id){
		// set_time_limit(3000);
		ini_set("memory_limit", "999M");
		ini_set("max_execution_time", "999");
		$product1 = Product::where('id',$id)->get();
		$pdf = Pdf::loadView('products.barcode_id', ['product1' => $product1])->setOptions(['defaultFont' => 'sans-serif']);
		//dd($pdf);
		if($request->download){
			//return view('products.barcode')->with('product', $product);
			return $pdf->download('product_'.date('Y-m-dHis').'.pdf');
		}

        //
		return view('products.barcode_id')->with('product1', $product1);
	});


});

Route::get('barcode/allfireman', function(Request $request){
	// set_time_limit(3000);
	ini_set("memory_limit", "999M");
	ini_set("max_execution_time", "999");
	// $product = Product::get();
	$file = file_get_contents(public_path('file.txt'));
	$product = explode('\n', $file);



	// $product = file_get_contents();
	$pdf = Pdf::loadView('products.bardcode_fireman', ['product' => $product])->setOptions(['defaultFont' => 'sans-serif']);
	//dd($pdf);
	if($request->download){
		//return view('products.barcode')->with('product', $product);
		return $pdf->download('product_'.date('Y-m-dHis').'.pdf');
	}

	//
	//return view('products.bardcode_fireman')->with('product', $product);
});



require __DIR__.'/auth.php';
