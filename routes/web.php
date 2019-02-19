<?php

// use Symfony\Component\Routing\Annotation\Route;

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

Route::get('/helper', function () {
    return cek_helper();
});

Route::get("/", function () {
    if (Auth::check()) {
        return redirect()->route("home");
    } else {
        return redirect()->route("login");
    }
});

Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', function () {
        return view('auth/sign-in');
    })->name('login');

    Route::post('auth', [
        'uses' => 'authController@authenticate',
        'as' => 'auth.authenticate'
    ]);
});

Route::group(['middleware' => 'auth'], function () {

    Route::get('/logout', [
        'uses' => 'authController@logout',
        'as' => 'auth.logout'
    ]);

	// main route

    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('home');

	// master karyawan

    Route::get('master/karyawan', [
        'uses' => 'master\karyawan\karyawan_controller@index',
    ])->name('karyawan.index');

    Route::get('master/karyawan/add', [
        'uses' => 'master\karyawan\karyawan_controller@add',
    ])->name('karyawan.add');

    Route::post('master/karyawan/insert', [
        'uses' => 'master\karyawan\karyawan_controller@insert',
    ])->name('karyawan.insert');

    Route::post('master/karyawan/edit-multiple', [
        'uses' => 'master\karyawan\karyawan_controller@edit_multiple',
    ])->name('karyawan.edit_multiple');

    Route::post('master/karyawan/update', [
        'uses' => 'master\karyawan\karyawan_controller@update',
    ])->name('karyawan.update');

    Route::get('master/karyawan/edit', [
        'uses' => 'master\karyawan\karyawan_controller@edit',
    ])->name('karyawan.edit');

    Route::post('master/karyawan/multiple-delete', [
        'uses' => 'master\karyawan\karyawan_controller@multiple_delete',
    ])->name('karyawan.multiple_delete');


    Route::get('master/karyawan/grab/{id}', [
        'uses' => 'master\karyawan\karyawan_controller@get',
    ])->name('karyawan.get');

    Route::get('master/karyawan/get/form-resource', [
        'uses' => 'master\karyawan\karyawan_controller@get_form_resources',
    ])->name('karyawan.get_form_resources');

	// master karyawan end

	// master posisi karyawan

    Route::get('/master/posisi', 'master\posisi\posisi_controller@index');
    Route::match(['post', 'get'], '/master/posisi/add', 'master\posisi\posisi_controller@add');
    Route::match(['post', 'get'], '/master/posisi/edit-multiple', 'master\posisi\posisi_controller@multiple_edit_posisi');
    Route::get('/master/posisi/get/{id}', 'master\posisi\posisi_controller@get_posisi');
    Route::post('/master/posisi/update', 'master\posisi\posisi_controller@update');
    Route::get('/master/posisi/edit', 'master\posisi\posisi_controller@edit');
    Route::match(['get', 'post'], '/master/posisi/multiple-delete', 'master\posisi\posisi_controller@multiple_delete');

	// end master posisi karyawan

	// master jabatan

    Route::get('/master/jabatan', 'master\jabatan\jabatan_controller@index');
    Route::match(['post', 'get'], '/master/jabatan/add', 'master\jabatan\jabatan_controller@add');
    Route::match(['post', 'get'], '/master/jabatan/edit-multiple', 'master\jabatan\jabatan_controller@multiple_edit_jabatan');
    Route::get('/master/jabatan/get/{id}', 'master\jabatan\jabatan_controller@get_jabatan');
    Route::post('/master/jabatan/update', 'master\jabatan\jabatan_controller@update');
    Route::get('/master/jabatan/edit', 'master\jabatan\jabatan_controller@edit');
    Route::match(['get', 'post'], '/master/jabatan/multiple-delete', 'master\jabatan\jabatan_controller@multiple_delete');

	// end master jabatan

	// ==============================Master Barang===============================

    Route::get('master/barang', [
        'uses' => 'master\barang\barang_controller@index',
    ])->name('barang.index');

    Route::get('master/barang/getdataactive', [
        'uses' => 'master\barang\barang_controller@getdataactive',
    ])->name('barang.getdataactive');

    Route::get('master/barang/getdataall', [
        'uses' => 'master\barang\barang_controller@getdataall',
    ])->name('barang.getdataall');

    Route::get('master/barang/getdatanonactive', [
        'uses' => 'master\barang\barang_controller@getdatanonactive',
    ])->name('barang.getdatanonactive');

    Route::get('master/barang/add', [
        'uses' => 'master\barang\barang_controller@add',
    ])->name('barang.add');

    Route::get('master/barang/get/form-resource', [
        'uses' => 'master\barang\barang_controller@get_form_resources',
    ])->name('barang.get_form_resources');

    Route::post('master/barang/insert', [
        'uses' => 'master\barang\barang_controller@insert',
    ])->name('barang.insert');

    Route::match(['get', 'post'], '/master/barang/edit/{id}', 'master\barang\barang_controller@edit')->name('barang.edit');

    Route::get('/master/barang/delete-image/{id}', 'master\barang\barang_controller@deleteimage')->name('barang.delete.img');

    Route::get('/master/barang/detail/{id}', 'master\barang\barang_controller@detail')->name('barang.detail');

    Route::get('/master/barang/active/{id}', 'master\barang\barang_controller@active');

    Route::get('/master/barang/nonactive/{id}', 'master\barang\barang_controller@nonactive');

    Route::post('/master/barang/setharga', 'master\barang\barang_controller@hargaperoutlet')->name('barang.setharga');

    Route::post('/master/barang/addoutletprice', 'master\barang\barang_controller@addoutletprice')->name('barang.addoutletprice');

    Route::get('/master/barang/getharga/{outlet}/{item}', 'master\barang\barang_controller@gethargaperoutlet');

    Route::get('/master/barang/getoutlet/{item}', 'master\barang\barang_controller@getoutlet');

    Route::get('/master/barang/carikelompok', 'master\barang\barang_controller@cariKelompok');

    Route::get('/master/barang/carigroup', 'master\barang\barang_controller@cariGroup');

    Route::get('/master/barang/carisubgroup', 'master\barang\barang_controller@cariSubGroup');

    Route::get('/master/barang/carimerk', 'master\barang\barang_controller@cariMerk');

    Route::get('/master/barang/carinama', 'master\barang\barang_controller@cariNama');

    Route::get('/master/barang/searchitem', 'master\barang\barang_controller@searchItem');

	// ============================End Master Barang==========================

	// =============================Master Gudang=============================
    Route::get('/master/gudang', 'master\gudang\gudang_controller@gudang')->name('gudang.index');

    Route::match(['get', 'post'], '/master/gudang/add', 'master\gudang\gudang_controller@add_gudang')->name('gudang.add');

    Route::match(['get', 'post'], '/master/gudang/multiple-delete', 'master\gudang\gudang_controller@multiple_delete');

    Route::post('/master/gudang/edit-multiple', 'master\gudang\gudang_controller@edit_multiple');

    Route::get('/master/gudang/edit', 'master\gudang\gudang_controller@edit');

    Route::post('/master/gudang/update', 'master\gudang\gudang_controller@update');

    Route::match(['get', 'post'], '/master/gudang/get/{id}', 'master\gudang\gudang_controller@get_gudang');
	// ===========================Master Gudang End===========================

	// master jenis barang
    Route::get('/master/jenis-barang', 'master\jenisbarang\jenisbarang_controller@index')->name('jenis-barang.index');
    Route::match(['get', 'post'], '/master/jenis-barang/add', 'master\jenisbarang\jenisbarang_controller@add')->name('jenis-barang.add');
    Route::get('/master/jenis-barang/get-resources', 'master\jenisbarang\jenisbarang_controller@get_resource');
    Route::match(['get', 'post'], '/master/jenis-barang/multiple-delete', 'master\jenisbarang\jenisbarang_controller@multiple_delete');
    Route::post('/master/jenis-barang/edit-multiple', 'master\jenisbarang\jenisbarang_controller@edit_multiple');
    Route::get('/master/jenis-barang/edit', 'master\jenisbarang\jenisbarang_controller@edit');
    Route::post('/master/jenis-barang/update', 'master\jenisbarang\jenisbarang_controller@update');
    Route::match(['get', 'post'], '/master/jenis-barang/get/{id}', 'master\jenisbarang\jenisbarang_controller@get_jenisbarang');
	// master jenis barang end

	// master class barang
    Route::get('/master/class-barang', 'master\classbarang\classbarang_controller@index')->name('class-barang.index');
	// master class barang end

	// master satuan barang
    Route::get('/master/satuan-barang', 'master\satuanbarang\satuanbarang_controller@index')->name('satuan-barang.index');
	// master satuan barang end

	// master Suppplier

    Route::get('/master/supplier', 'master\suplier\suplier_controller@suplier');

    Route::get('/master/supplier/getdataactive', [
        'uses' => 'master\suplier\suplier_controller@getdataactive',
    ])->name('supplier.getdataactive');

    Route::get('/master/supplier/getdataall', [
        'uses' => 'master\suplier\suplier_controller@getdataall',
    ])->name('supplier.getdataall');

    Route::get('/master/supplier/getdatanonactive', [
        'uses' => 'master\suplier\suplier_controller@getdatanonactive',
    ])->name('supplier.getdatanonactive');

    Route::match(['get', 'post'], '/master/supplier/add', 'master\suplier\suplier_controller@add_suplier');

    Route::match(['get', 'post'], '/master/supplier/edit/{id}', 'master\suplier\suplier_controller@edit');

    Route::match(['get', 'post'], '/master/supplier/detail/{id}', 'master\suplier\suplier_controller@detail');

    Route::get('/master/supplier/active/{id}', 'master\suplier\suplier_controller@active');

    Route::get('/master/supplier/nonactive/{id}', 'master\suplier\suplier_controller@nonactive');

	// master Suppplier end

	// Master Outlet

    Route::get('/master/outlet', 'master\outlet\outlet_controller@index');

    Route::get('/master/outlet/getdataactive', [
        'uses' => 'master\outlet\outlet_controller@getdataactive',
    ])->name('outlet.getdataactive');

    Route::get('/master/outlet/getdataall', [
        'uses' => 'master\outlet\outlet_controller@getdataall',
    ])->name('outlet.getdataall');

    Route::get('/master/outlet/getdatanonactive', [
        'uses' => 'master\outlet\outlet_controller@getdatanonactive',
    ])->name('outlet.getdatanonactive');

    Route::get('/master/outlet/detail/{id}', 'master\outlet\outlet_controller@detail');

    Route::match(['get', 'post'], '/master/outlet/add', 'master\outlet\outlet_controller@add');

    Route::get('/master/getcode', 'master\outlet\outlet_controller@getcode');

    Route::match(['get', 'post'], '/master/outlet/edit/{id}', 'master\outlet\outlet_controller@edit');

    Route::get('/master/outlet/active/{id}', 'master\outlet\outlet_controller@active');

    Route::get('/master/outlet/nonactive/{id}', 'master\outlet\outlet_controller@nonactive');

	// End Master Outlet

	// Master Member

    Route::get('/master/member', 'master\member\member_controller@index');

    Route::get('/master/member/getdataactive', [
        'uses' => 'master\member\member_controller@get_data_active',
    ])->name('member.getdataactive');
    Route::get('/master/member/getdataall', [
        'uses' => 'master\member\member_controller@get_data_all',
    ])->name('member.getdataall');
    Route::get('/master/member/getdatanonactive', [
        'uses' => 'master\member\member_controller@get_data_nonactive',
    ])->name('member.getdatanonactive');

    Route::get('/master/member/detail/{id}', 'master\member\member_controller@detail');

    Route::get('/master/member/add', 'master\member\member_controller@tambah');
    Route::match(['get', 'post'], '/master/member/simpan-tambah', 'master\member\member_controller@simpan_tambah');
    Route::get('/master/member/edit/{id}', 'master\member\member_controller@edit');
    Route::match(['get', 'post'], '/master/member/simpan-edit/{id}', 'master\member\member_controller@simpan_edit');


    Route::get('/master/member/active/{id}', 'master\member\member_controller@active');
    Route::get('/master/member/nonactive/{id}', 'master\member\member_controller@nonactive');
    Route::get('/master/member/delete/{id}', 'master\member\member_controller@delete');
    Route::get('/master/member/getkota', 'master\member\member_controller@getkota');
    Route::get('/master/member/getkecamatan', 'master\member\member_controller@getkecamatan');
    Route::get('/master/member/getdesa', 'master\member\member_controller@getdesa');

	// End Master Member

    //master pembayaran
    Route::get('master/pembayaran', 'master\pembayaran\MasterPembayaranController@index');
    Route::get('master/pembayaran/get-dataY', 'master\pembayaran\MasterPembayaranController@getDataY');
    Route::get('master/pembayaran/get-dataN', 'master\pembayaran\MasterPembayaranController@getDataN');
    Route::get('master/pembayaran/get-outlet-payment', 'master\pembayaran\MasterPembayaranController@getOutletPayment');
    Route::get('master/pembayaran/nonaktif', 'master\pembayaran\MasterPembayaranController@setNonaktif');
    Route::get('master/pembayaran/aktifkan', 'master\pembayaran\MasterPembayaranController@setAktif');
    Route::get('master/pembayaran/get-detail', 'master\pembayaran\MasterPembayaranController@getDetail');
    Route::get('master/pembayaran/update', 'master\pembayaran\MasterPembayaranController@update');
    Route::post('master/pembayaran/simpan-payment', 'master\pembayaran\MasterPembayaranController@saveOutletPayment');
    Route::post('master/pembayaran/delete-payment', 'master\pembayaran\MasterPembayaranController@deleteOutletPayment');
    Route::post('master/pembayaran/simpan', 'master\pembayaran\MasterPembayaranController@save');
    //end pembayaran

	// Pembelian

	// Request Order

    Route::get('/pembelian/request-pembelian/t', 'PembelianController@menunggu');
    Route::get('/pembelian/request-pembelian/proses', 'PembelianController@requestProses');
    Route::post('/pembelian/request-pembelian/proses', 'PembelianController@requestProses');
    Route::get('/pembelian/request-pembelian/tolak', 'PembelianController@requestTolak');
    Route::post('/pembelian/request-pembelian/tolak', 'PembelianController@requestTolak');

	// 1
    Route::get('/pembelian/request-pembelian', 'PembelianController@request_order');
    Route::get('/pembelian/request-pembelian/ddRequest', 'PembelianController@ddRequest');
    Route::get('/pembelian/request-pembelian/clearData', 'PembelianController@clearData');
    Route::get('/pembelian/request-pembelian/tambah', 'PembelianController@request_order_tambah');
    Route::get('/pembelian/request-pembelian/getKelompok_item', 'PembelianController@getKelompok_item');
    Route::get('/pembelian/request-pembelian/getBarang', 'PembelianController@getBarang');
    Route::get('/pembelian/request-pembelian/getMerk', 'PembelianController@getMerk');
    Route::get('/pembelian/request-pembelian/getOutlet', 'PembelianController@getOutlet');
    Route::post('/pembelian/request-pembelian/simpanRequest', 'PembelianController@verifikasi_simpanRequest');
    Route::get('/pembelian/request-pembelian/addData', 'PembelianController@addData');
    Route::POST('/pembelian/request-pembelian/ddRequest_dummy', 'PembelianController@ddRequest_dumy');
    Route::get('/pembelian/request-pembelian/editDumy', 'PembelianController@editDumyReq');
    Route::POST('/pembelian/request-pembelian/addDumyReq', 'PembelianController@addDumyReq');
    Route::POST('/pembelian/request-pembelian/getInput', 'PembelianController@getBarang_input');
    Route::get('/pembelian/request-pembelian/hapusDumy', 'PembelianController@hapusDumy');
    Route::get('/pembelian/request-pembelian/cariItem', 'PembelianController@cariItem');
    Route::get('/pembelian/request-pembelian/testDesc', 'PembelianController@testDesc');
    Route::get('/pembelian/request-pembelian/updateReq', 'PembelianController@updateReq');
    Route::get('/pembelian/request-pembelian/updateReqTolak', 'PembelianController@updateReqTolak');
    Route::get('/pembelian/request-pembelian/hapusReq', 'PembelianController@hapusReq');



	// Route::match(['get', 'post'], '/pembelian/request-pembelian/tampilData', 'PembelianController@tampilData');

    Route::match(['get', 'post'], '/pembelian/request-order/add', 'PembelianController@form_add_request');

    Route::post('/pembelian/request-order/edit-multiple', 'PembelianController@edit_multiple');

    Route::get('/pembelian/request-order/edit', 'PembelianController@edit_order');

    Route::match(['get', 'post'], '/pembelian/request-order/get/{id}', 'PembelianController@get_order');

    Route::post('/pembelian/request-order/update', 'PembelianController@update_order');

    Route::match(['get', 'post'], '/pembelian/request-order/multiple-delete', 'PembelianController@multiple_delete_order');

	// End Request Order

	// Rencana Pembelian


    Route::get('/pembelian/rencana-pembelian', 'PembelianController@rencana_pembelian');
    Route::get('/pembelian/rencana-pembelian/tambah', 'PembelianController@addRencana');
    Route::post('/pembelian/rencana-pembelian/request-order-status', 'PembelianController@request_order_status');
    Route::get('/pembelian/rencana-pembelian/rencana-pembelian/edit', 'PembelianController@rencana_pembelian_edit');
    Route::post('/pembelian/rencana-pembelian/rencana-pembelian/update', 'PembelianController@update_rencana_pembelian');
    Route::post('/pembelian/rencana-pembelian/rencana-pembelian/edit-multiple', 'PembelianController@multiple_edit_rencana_pembelian');
// tampil data
    Route::get('/pembelian/rencana-pembelian/rencanaMenunggu', 'PembelianController@rencanaMenunggu');
    Route::get('/pembelian/rencana-pembelian/rencanaDitolak', 'PembelianController@rencanaDitolak');
    Route::get('/pembelian/rencana-pembelian/rencanaDisetujui', 'PembelianController@rencanaDisetujui');
    Route::get('/pembelian/rencana-pembelian/rencanaSemua', 'PembelianController@rencanaSemua');
    Route::POST('/pembelian/rencana-pembelian/view_tambahRencana', 'PembelianController@view_tambahRencana');
    Route::POST('/pembelian/rencana-pembelian/view_tambahRencana_dumy', 'PembelianController@view_tambahRencana_dumy');
    Route::get('/pembelian/rencana-pembelian/itemSuplier', 'PembelianController@itemSuplier');
// action data rencana pembelian
    Route::get('/pembelian/rencana-pembelian/updateRequest', 'PembelianController@updateRequest');
    Route::get('/pembelian/rencana-pembelian/updateRencana', 'PembelianController@updateRencana');
    Route::get('/pembelian/rencana-pembelian/deleteRencana', 'PembelianController@deleteRencana');

    Route::post('/pembelian/rencana-pembelian/tambahRencana', 'PembelianController@tambahRencana');
    Route::get('/pembelian/rencana-pembelian/tambahRencana', 'PembelianController@tambahRencana');
    Route::get('/pembelian/rencana-pembelian/tolakRequest', 'PembelianController@tolakRequest');
    Route::get('/pembelian/rencana-pembelian/getRequest_id', 'PembelianController@getRequest_id');

    Route::get('/pembelian/rencana-pembelian/getRequest_dumy', 'PembelianController@getRequest_dumy');
    Route::POST('/pembelian/rencana-pembelian/editDumy', 'PembelianController@editDumy');
    Route::get('/pembelian/rencana-pembelian/getComp_plan', 'PembelianController@getComp_plan');

    Route::get('/pembelian/rencana-pembelian/tambahrencana_view', 'PembelianController@tambahrencana_view');

	// End Rencana Pembelian

	// Konfirmasi Pembelian page

    Route::get('/pembelian/konfirmasi-pembelian', 'PembelianController@konfirmasi_pembelian');
    Route::get('/pembelian/konfirmasi-pembelian/view_addKonfirmasi', 'PembelianController@view_addKonfirmasi');

	//tampil data
    Route::get('/pembelian/konfirmasi-pembelian/view_confirmApp', 'PembelianController@view_confirmApp');
    Route::get('/pembelian/konfirmasi-pembelian/view_confirmPurchase', 'PembelianController@view_confirmPurchase');
    Route::get('/pembelian/konfirmasi-pembelian/view_confirmAll', 'PembelianController@view_confirmAll');
    Route::post('/pembelian/konfirmasi-pembelian/view_confirmAdd', 'PembelianController@view_confirmAdd');
    Route::get('/pembelian/konfirmasi-pembelian/view_confirmAdd_trans', 'PembelianController@view_confirmAdd_trans');
    Route::post('/pembelian/konfirmasi-pembelian/tampilSupplier', 'PembelianController@tampilSupplier');


	//action confirm order
    Route::POST('/pembelian/konfirmasi-pembelian/confirmSetuju', 'PembelianController@confirmSetuju');
    Route::post('/pembelian/konfirmasi-pembelian/confirmTolak', 'PembelianController@confirmTolak');
    Route::get('/pembelian/konfirmasi-pembelian/getPlan_id', 'PembelianController@getPlan_id');
    Route::get('/pembelian/konfirmasi-pembelian/getSupplier', 'PembelianController@getSupplier');
    Route::get('/pembelian/konfirmasi-pembelian/getTelp', 'PembelianController@getTelp');
    Route::post('/pembelian/konfirmasi-pembelian/editDumy', 'PembelianController@editConfirm_dummy');

    Route::GET('/pembelian/konfirmasi-pembelian/simpanConfirm', 'PembelianController@simpanConfirm');
    Route::match(['get', 'post'],'/pembelian/konfirmasi-pembelian/edit', 'PembelianController@editConfirm');
    Route::post('/pembelian/konfirmasi-pembelian/getHistory', 'PembelianController@getHistory');
    Route::get('/pembelian/konfirmasi-pembelian/auto-nota', 'PembelianController@auto_nota');
    Route::get('/pembelian/konfirmasi-pembelian/auto-supp', 'PembelianController@auto_supp');

    Route::get('/pembelian/konfirmasi-pembelian/get-data-order/{id}', 'PembelianController@get_data_order');

    Route::get('/pembelian/konfirmasi-pembelian/download-pdf/{id}', 'PembelianController@downloadpdf');
    Route::get('/pembelian/konfirmasi-pembelian/generate-pdf/{id}', 'PembelianController@generatePDF');
    Route::get('/pembelian/konfirmasi-pembelian/print/{id}', 'PembelianController@print');

	// End Konfirmasi Pembelian

	// Purchase Order

    Route::get('/pembelian/purchase-order', 'pembelian\PurchaseOrderController@index');
    Route::match(['get', 'post'],'/pembelian/inventory/penerimaan/supplier/edit', 'pembelian\PurchaseOrderController@tambah');
    Route::post('/pembelian/purchase-order/getCO', 'pembelian\PurchaseOrderController@getCO');
    Route::post('/pembelian/purchase-order/detil', 'pembelian\PurchaseOrderController@detail');
    Route::get('/pembelian/purchase-order/get-proses', 'pembelian\PurchaseOrderController@get_proses');
    Route::post('/pembelian/purchase-order/get-history', 'pembelian\PurchaseOrderController@get_history');
    Route::get('/pembelian/purchase-order/auto-nota', 'pembelian\PurchaseOrderController@auto_nota');
    Route::get('/pembelian/purchase-order/hapus/{id}', 'pembelian\PurchaseOrderController@hapus');
    Route::match(['get', 'post'],'/pembelian/purchase-order/edit', 'pembelian\PurchaseOrderController@edit');
    Route::get('/pembelian/purchase-order/print/{id}', 'pembelian\PurchaseOrderController@print');


    // Route::get('/pembelian/purchase-order/view_purchaseAll', 'PurchaseOrderController@view_purchaseAll');
    // Route::get('/pembelian/purchase-order/purchasing', 'PurchaseOrderController@purchasing');
    // Route::get('/pembelian/purchase-order/purchaseComplete', 'PurchaseOrderController@purchaseComplete');
    // Route::get('/pembelian/purchase-order/getDetail_purchase', 'PurchaseOrderController@getDetail_purchase');
    // Route::get('/pembelian/purchase-order/get_idDetail', 'PurchaseOrderController@get_idDetail');
    // Route::get('/pembelian/purchase-order/PurchaseTambah', 'PurchaseOrderController@purchaseTambah');
    // Route::get('/pembelian/purchase-order/add_purchaseOrder', 'PurchaseOrderController@add_purchaseOrder');

	// aksi purchase
    // Route::get('/pembelian/purchase-order/getSupplier_po', 'PurchaseOrderController@getSupplier_po');
    // Route::get('/pembelian/purchase-order/getOutlet_po', 'PurchaseOrderController@getOutlet_po');
    // Route::get('/pembelian/purchase-order/list_draftPo', 'PurchaseOrderController@list_draftPo');
    // Route::get('/pembelian/purchase-order/simpanPo', 'PurchaseOrderController@simpanPo');
	// // end aksi purchase
    // Route::get('/pembelian/purchase-order/add', 'PurchaseOrderController@purchase_order_add');
    // Route::get('/pembelian/purchase-order/get-purchase/{id}', 'PurchaseOrderController@get_purchase');
    // Route::get('/pembelian/purchase-order/get-request-purchase/{id}', 'PurchaseOrderController@get_request_purchase');
    // Route::post('/pembelian/purchase-order/add-purchase', 'PurchaseOrderController@add_purchase');
    // Route::get('/pembelian/purchase-order/get/{id}', 'PurchaseOrderController@get_purchase_order');
    // Route::get('/pembelian/purchase-order/edit', 'PurchaseOrderController@edit_purchase_order');
    // Route::post('/pembelian/purchase-order/update', 'PurchaseOrderController@update_purchase_order');
    // Route::post('/pembelian/purchase-order/edit-multiple', 'PurchaseOrderController@multiple_edit_purchase_order');
    // Route::match(['get', 'post'], '/pembelian/purchase-order/multiple-delete', 'PurchaseOrderController@multiple_delete_purchase_order');
    // Route::get('/pembelian/purchase-order/cetak', 'PurchaseOrderController@cetak_purchase');
    // Route::get('/pembelian/purchase-order/get-purchase-data/{id}', 'PurchaseOrderController@get_purchase_data');
    // Route::get('/pembelian/purchase-order/purchase-pdf/{id}', 'PurchaseOrderController@viewpdf_purchase');
    // Route::get('/pembelian/purchase-order/generate-pdf/{id}', 'PurchaseOrderController@pdf_purchase');

	// End Purchase Order

	// Return Barang
    Route::get('/pembelian/purchase-return', 'pembelian\ReturnPembelianController@index');
    Route::get('/pembelian/purchase-return/getData', 'pembelian\ReturnPembelianController@getData');
    Route::match(['get', 'post'],'/pembelian/purchase-return/add', 'pembelian\ReturnPembelianController@tambah');
    Route::match(['get', 'post'],'/pembelian/purchase-return/edit', 'pembelian\ReturnPembelianController@edit');
    Route::get('/pembelian/purchase-return/detail/{id}', 'pembelian\ReturnPembelianController@detail');
    Route::get('/pembelian/purchase-return/hapus/{id}', 'pembelian\ReturnPembelianController@hapus');

    Route::get('/pembelian/get-current-return/{id}', 'ReturnPembelianController@get_current_return');
    Route::get('/pembelian/purchase-return/update', 'ReturnPembelianController@update_purchase_return');
    Route::get('/pembelian/purchase-return/edit-multiple', 'ReturnPembelianController@multiple_edit_purchase_return');
    Route::get('/pembelian/purchase-return/get-current-return/{id}', 'ReturnPembelianController@get_edit_return');
    Route::get('/pembelian/purchase-return/multiple-delete', 'ReturnPembelianController@multiple_delete_purchase_return');
	// Route::get('/newprint', 'PembelianController@new_print');

	// End Return Barang

    // Refund
    Route::get('pembelian/refund', 'RefundController@index');
    Route::get('pembelian/refund/get-item', 'RefundController@getItemRefund');
    Route::get('pembelian/refund/tambah', 'RefundController@add');
    Route::get('pembelian/refund/get-data', 'RefundController@getDataItem');
    Route::get('pembelian/refund/get-supplier', 'RefundController@getSupplier');
    //end Refund

	// Pembelian end

	// Inventory
	// Penerimaan barang dari supplier
    Route::get('/inventory/penerimaan/supplier', 'inventory\SupplierReceptionController@index');
    Route::get('/inventory/penerimaan/supplier/get-proses', 'inventory\SupplierReceptionController@get_proses');
    Route::post('/inventory/penerimaan/supplier/get-history', 'inventory\SupplierReceptionController@get_history');
    Route::match(['get', 'post'],'/inventory/penerimaan/supplier/edit', 'inventory\SupplierReceptionController@edit');
    Route::post('/inventory/penerimaan/supplier/detail', 'inventory\SupplierReceptionController@detail');
    Route::post('/inventory/penerimaan/supplier/detailTerima', 'inventory\SupplierReceptionController@detail_terima');
    Route::get('/inventory/penerimaan/supplier/get-item', 'inventory\SupplierReceptionController@get_item');
    Route::get('/inventory/penerimaan/supplier/item-receive/{id}/{item}', 'inventory\SupplierReceptionController@itemReceive');
    Route::get('/inventory/penerimaan/supplier/get-item-received/{id}', 'inventory\SupplierReceptionController@getItemReceived');
    Route::post('/inventory/penerimaan/supplier/item-receive/add', 'inventory\SupplierReceptionController@itemReceiveAdd');
    Route::get('/inventory/penerimaan/supplier/getMaks/{id}/{item}', 'inventory\SupplierReceptionController@getMaks');
    Route::post('/inventory/penerimaan/supplier/getItemDT', 'inventory\SupplierReceptionController@itemReceiveDT');

    Route::post('/inventory/penerimaan/supplier/detailReceived/{id}/{item}', 'inventory\SupplierReceptionController@detailReceived');
    Route::match(['get', 'post'],'/inventory/penerimaan/supplier/editReceived', 'inventory\SupplierReceptionController@editReceived');
    Route::post('/inventory/penerimaan/supplier/hapusReceived/{id}/{item}', 'inventory\SupplierReceptionController@hapusReceived');

	// End penerimaan barang dari supplier

	// Penerimaan barang distribusi
    Route::get('/inventory/penerimaan/distribusi', 'inventory\ReceptionController@index_distribusi');
    Route::get('/inventory/penerimaan/distribusi/proses', 'inventory\ReceptionController@dataDistribusiProses')->name('distribusi.proses');
    Route::get('/inventory/penerimaan/distribusi/terima', 'inventory\ReceptionController@dataDistribusiTerima')->name('distribusi.terima');
    Route::get('/inventory/penerimaan/distribusi/detail/{id}', 'inventory\ReceptionController@detail');
    Route::get('/inventory/penerimaan/distribusi/detail-terima/{id}', 'inventory\ReceptionController@detailTerima');
    Route::get('/inventory/penerimaan/distribusi/edit/{id}', 'inventory\ReceptionController@editDistribusi');
    Route::get('/inventory/penerimaan/distribusi/get-item-received/{id}', 'inventory\ReceptionController@getItemReceived');
    Route::get('/inventory/penerimaan/distribusi/get-item/{id}', 'inventory\ReceptionController@getItem');
    Route::get('/inventory/penerimaan/distribusi/item-receive/{id}/{item}', 'inventory\ReceptionController@itemReceive');
    Route::post('/inventory/penerimaan/distribusi/item-receive/add', 'inventory\ReceptionController@itemReceiveAdd');
    Route::get('/inventory/penerimaan/distribusi/item-receive/check/{item}/{code}/{comp}/{dest}', 'inventory\ReceptionController@checkCode');
	// End penerimaan barang distribusi

	//=== OPNAME BARANG

    Route::get('/inventory/opname-barang/pusat', 'inventory\opnameBarangController@pusat');
    Route::get('/inventory/opname-barang/outlet', 'inventory\opnameBarangController@outlet');

    Route::get('/inventory/opname-barang/auto-comp-noPusat', 'inventory\opnameBarangController@auto_comp_noPusat');

    Route::get('/inventory/opname-barang/appr', 'inventory\opnameBarangController@get_approved');
    Route::get('/inventory/opname-barang/pend', 'inventory\opnameBarangController@get_pending');
    Route::get('/inventory/opname-barang/apprO', 'inventory\opnameBarangController@get_approved_outlet');
    Route::get('/inventory/opname-barang/pendO', 'inventory\opnameBarangController@get_pending_outlet');

	///DataTable Inputan form Tambah Opname
    Route::post('/inventory/opname-barang/get-stock-code', 'inventory\opnameBarangController@get_stock_code');
    Route::match(['get', 'post'],'/inventory/opname-barang/detail', 'inventory\opnameBarangController@detail');

    Route::get('/inventory/opname-barang/pencarian', 'inventory\opnameBarangController@pencarian');

    Route::post('/inventory/opname-barang/cariItemStock', 'inventory\opnameBarangController@cari_item_stock');
    Route::post('/inventory/opname-barang/getCompName', 'inventory\opnameBarangController@get_cn');

    Route::post('/inventory/opname-barang/formTambah', 'inventory\opnameBarangController@form_tambah');
    Route::match(['get', 'post'], '/inventory/opname-barang/tambah', 'inventory\opnameBarangController@tambah');
    Route::match(['get', 'post'], '/inventory/opname-barang/tambahOutlet', 'inventory\opnameBarangController@tambahOutlet');

    Route::get('/inventory/opname-barang/get-edit', 'inventory\opnameBarangController@get_edit');
    Route::match(['get', 'post'], '/inventory/opname-barang/edit', 'inventory\opnameBarangController@edit');
    Route::match(['get', 'post'], '/inventory/opname-barang/editOutlet', 'inventory\opnameBarangController@editOutlet');

    Route::post('/inventory/opname-barang/approve', 'inventory\opnameBarangController@approve');
    Route::post('/inventory/opname-barang/approveOutlet', 'inventory\opnameBarangController@approveOutlet');

    Route::post('/inventory/opname-barang/hapus', 'inventory\opnameBarangController@hapus');
    Route::post('/inventory/opname-barang/hapusOutlet', 'inventory\opnameBarangController@hapusOutlet');


	//=== End OPNAME BARANG

	//=== MINIMUM STOCK

    Route::get('/inventory/min-stock', 'inventory\minimumStockController@index');

    Route::get('inventory/min-stock/get-warning', 'inventory\minimumStockController@get_warning');
    Route::get('inventory/min-stock/get-active', 'inventory\minimumStockController@get_active');
    Route::get('inventory/min-stock/get-nonactive', 'inventory\minimumStockController@get_nonactive');
    Route::get('inventory/min-stock/pencarian', 'inventory\minimumStockController@pencarian');

    Route::post('inventory/min-stock/detail', 'inventory\minimumStockController@detail');
    Route::post('inventory/min-stock/active', 'inventory\minimumStockController@set_active');
    Route::post('inventory/min-stock/nonactive', 'inventory\minimumStockController@set_nonactive');

    Route::match(['get', 'post'], '/inventory/min-stock/tambah', 'inventory\minimumStockController@tambah');
    Route::match(['get', 'post'], '/inventory/min-stock/edit', 'inventory\minimumStockController@edit');

    Route::post('inventory/min-stock/cek-warn', 'inventory\minimumStockController@cek_warn');

	//=== End MINIMUM STOCK

	// End Inventory

	///// PENJUALAN

	// ####################################
	// Setting Harga
	// ####################################
    Route::get('/penjualan/set-harga', 'penjualan\setHargaController@index');
    Route::get('/penjualan/set-harga/getdataharga', [
        'uses' => 'penjualan\setHargaController@get_data_group',
    ])->name('penjualan.getdatagroup');

    Route::get('/penjualan/set-harga/cariItem', 'penjualan\setHargaController@cari_itemth');

    Route::get('/penjualan/set-harga/get-data-gp-non/{id}', 'penjualan\setHargaController@get_data_group_nonDT');
    Route::get('/penjualan/set-harga/get-data-gp', 'penjualan\setHargaController@get_data_gp');
    Route::get('/penjualan/set-harga/get-data-harga/{id}', 'penjualan\setHargaController@get_data_harga');
    Route::match(['get', 'post'], '/penjualan/set-harga/addGroup', 'penjualan\setHargaController@tambah_group');
    Route::match(['get', 'post'], '/penjualan/set-harga/addHarga', 'penjualan\setHargaController@tambah_harga');
    Route::match(['get', 'post'], '/penjualan/set-harga/editGroup', 'penjualan\setHargaController@edit_group');
    Route::match(['get', 'post'], '/penjualan/set-harga/editHarga', 'penjualan\setHargaController@edit_harga');
    Route::match(['get', 'post'], '/penjualan/set-harga/hapusGroup/{id}', 'penjualan\setHargaController@hapus_group');
    Route::match(['get', 'post'], '/penjualan/set-harga/hapusHarga', 'penjualan\setHargaController@hapus_harga');
	// ####################################
	// End Setting Harga
	// ####################################

	// ####################################
	// Return Penjualan
	// ####################################
    Route::get('/penjualan/return-penjualan', 'penjualan\ReturnPenjualanController@index')->name('return-penjualan');
    Route::get('/penjualan/return-penjualan/get-proses', 'penjualan\ReturnPenjualanController@getProses')->name('get-return-proses');
    Route::get('/penjualan/return-penjualan/get-done', 'penjualan\ReturnPenjualanController@getDone')->name('get-return-done');
    Route::get('/penjualan/return-penjualan/get-cancel', 'penjualan\ReturnPenjualanController@getCancel')->name('get-return-cancel');
    Route::get('/penjualan/return-penjualan/get-detail-return/{id}', 'penjualan\ReturnPenjualanController@getDetailReturn');
    Route::get('/penjualan/return-penjualan/done-return/{id}', 'penjualan\ReturnPenjualanController@doneReturn');
    Route::get('/penjualan/return-penjualan/cancel-return/{id}', 'penjualan\ReturnPenjualanController@cancelReturn');
    Route::get('/penjualan/return-penjualan/tambah', 'penjualan\ReturnPenjualanController@add');
    Route::get('/penjualan/return-penjualan/cari-member', 'penjualan\ReturnPenjualanController@cariMember');
    Route::get('/penjualan/return-penjualan/cari-kode', 'penjualan\ReturnPenjualanController@cariKode');
    Route::get('/penjualan/return-penjualan/cari-nota', 'penjualan\ReturnPenjualanController@cariNota');
    Route::get('/penjualan/return-penjualan/cari/member', 'penjualan\ReturnPenjualanController@cariNotaMember');
    Route::get('/penjualan/return-penjualan/cari', 'penjualan\ReturnPenjualanController@cariNotaPenjualan');
    Route::get('/penjualan/return-penjualan/cari/detail/{id}', 'penjualan\ReturnPenjualanController@cariNotaDetail');
    Route::get('/penjualan/return-penjualan/return/{idsales}/{iditem}/{spcode}', 'penjualan\ReturnPenjualanController@returnPenjualan');
    Route::get('/penjualan/return-penjualan/checkStock/{item}', 'penjualan\ReturnPenjualanController@checkStock');
    Route::get('/penjualan/return-penjualan/cariitembaru', 'penjualan\ReturnPenjualanController@cariItemBaru');
    Route::get('/penjualan/return-penjualan/cariitemlain', 'penjualan\ReturnPenjualanController@cariItemlain');
    Route::post('/penjualan/return-penjualan/add', 'penjualan\ReturnPenjualanController@returnAdd');
    Route::get('/penjualan/return-penjualan/struk/{id}', 'penjualan\ReturnPenjualanController@struk');
	// ####################################
	// End Return Penjualan
	// ####################################



    // ####################################
    // Service Barang
    // ####################################
    Route::get('/penjualan/service-barang', 'penjualan\ServicesController@index')->name('service-barang');
    Route::get('/penjualan/service-barang/cari-data-service', 'penjualan\ServicesController@cariDataService');
    Route::get('/penjualan/service-barang/get-data-service', 'penjualan\ServicesController@getDataService')->name('get-data-service');
    Route::get('/penjualan/service-barang/get-pending', 'penjualan\ServicesController@getPending')->name('get-service-pending');
    Route::get('/penjualan/service-barang/get-tolak', 'penjualan\ServicesController@getTolak')->name('get-service-tolak');
    Route::get('/penjualan/service-barang/get-proses', 'penjualan\ServicesController@getProses')->name('get-service-proses');
    Route::get('/penjualan/service-barang/get-done', 'penjualan\ServicesController@getDone')->name('get-service-done');
    Route::get('/penjualan/service-barang/get-detail-service/{id}', 'penjualan\ServicesController@getDetailService');
    Route::match(['get', 'post'], '/penjualan/service-barang/add', 'penjualan\ServicesController@add')->name('service-add');
    Route::match(['get', 'post'], '/penjualan/service-barang/add-service', 'penjualan\ServicesController@addService')->name('addService');
    Route::get('/penjualan/service-barang/cari-member', 'penjualan\ServicesController@cariMember');
    Route::get('/penjualan/service-barang/cari-kode', 'penjualan\ServicesController@cariKode');
    Route::get('/penjualan/service-barang/cari-nota', 'penjualan\ServicesController@cariNota');
    Route::get('/penjualan/service-barang/cari/member', 'penjualan\ServicesController@cariNotaMember');
    Route::get('/penjualan/service-barang/cari', 'penjualan\ServicesController@cariNotaPenjualan');
    Route::get('/penjualan/service-barang/cari/detail/{id}', 'penjualan\ServicesController@cariNotaDetail');
    Route::get('/penjualan/service-barang/service/{idsales}/{iditem}/{spcode}', 'penjualan\ServicesController@serviceBarang');
    Route::get('/penjualan/service-barang/send-service/{id}', 'penjualan\ServicesController@sendService');
    Route::get('/penjualan/service-barang/struk/{id}', 'penjualan\ServicesController@struk');
    Route::get('/penjualan/service-barang/tolak-barang/{id}', 'penjualan\ServicesController@serviceTolak');
    Route::get('/penjualan/service-barang/terima-barang/{id}', 'penjualan\ServicesController@serviceTerima');
    Route::get('/penjualan/service-barang/proses-perbaikan/{id}', 'penjualan\ServicesController@serviceProses');
    Route::get('/penjualan/service-barang/selesai-perbaikan/{id}', 'penjualan\ServicesController@serviceSelesai');
    Route::get('/penjualan/service-barang/terima-barang-pusat/{id}', 'penjualan\ServicesController@serviceTerimaPusat');
    // ####################################
    // End Service Barang
    // ####################################



	/////// OUTLET

    Route::get('/penjualan/set-harga/outlet', 'penjualan\setHargaController@index_outlet');
    Route::match(['get', 'post'], '/penjualan/set-harga/outlet/add', 'penjualan\setHargaController@add_price_outlet');
    Route::match(['get', 'post'], '/penjualan/set-harga/outlet/edit', 'penjualan\setHargaController@edit_price_outlet');
    Route::get('/penjualan/set-harga/outlet/hapus', 'penjualan\setHargaController@hapus_price_outlet');
    Route::get('/penjualan/set-harga/outlet/auto-CodeNItem', 'penjualan\setHargaController@cari_code_n_item');
    Route::get('/penjualan/set-harga/outlet/cektable', 'penjualan\setHargaController@cek_table');

	/////// End OUTLET

	//== End Set Harga

	//== Pemesanan Barang

    Route::get('/penjualan/pemesanan-barang', 'penjualan\pemesananBarangController@index');
    Route::get('/penjualan/pemesanan-barang/getdataproses', [
        'uses' => 'penjualan\pemesananBarangController@get_data_proses',
    ])->name('penjualan.getdataproses');
    Route::get('/penjualan/pemesanan-barang/getdatadone', [
        'uses' => 'penjualan\pemesananBarangController@get_data_done',
    ])->name('penjualan.getdatadone');
    Route::get('/penjualan/pemesanan-barang/getdatacancel', [
        'uses' => 'penjualan\pemesananBarangController@get_data_cancel',
    ])->name('penjualan.getdatacancel');

    Route::post('/penjualan/pemesanan-barang/getHistory', 'penjualan\pemesananBarangController@get_history');
    Route::post('/penjualan/pemesanan-barang/aksiHistory', 'penjualan\pemesananBarangController@aksi_history');
    Route::get('/penjualan/pemesanan-barang/get-member', 'penjualan\pemesananBarangController@cari_member');
    Route::get('/penjualan/pemesanan-barang/get-item', 'penjualan\pemesananBarangController@cari_item');
    Route::get('/penjualan/pemesanan-barang/get-group', 'penjualan\pemesananBarangController@get_group');

    Route::get('/penjualan/pemesanan-barang/detail/{id}', 'penjualan\pemesananBarangController@detail');
    Route::get('/penjualan/pemesanan-barang/detail-dt/{id}', 'penjualan\pemesananBarangController@detail_dt');

    Route::get('/penjualan/pemesanan-barang/auto-member', 'penjualan\pemesananBarangController@auto_member');
    Route::get('/penjualan/pemesanan-barang/auto-nota', 'penjualan\pemesananBarangController@auto_nota');

    Route::post('/penjualan/pemesanan-barang/simpan-status', 'penjualan\pemesananBarangController@simpan_status');

    Route::match(['get', 'post'], '/penjualan/pemesanan-barang/ft-pemesanan', 'penjualan\pemesananBarangController@ft_pemesanan');
    Route::match(['get', 'post'], '/penjualan/pemesanan-barang/tambah-member', 'penjualan\pemesananBarangController@tambah_member');
    Route::match(['get', 'post'], '/penjualan/pemesanan-barang/tambah-pemesanan', 'penjualan\pemesananBarangController@tambah_pemesanan');
    Route::match(['get', 'post'], '/penjualan/pemesanan-barang/hapus/{id}', 'penjualan\pemesananBarangController@hapus');
    Route::get('/penjualan/pemesanan-barang/print', 'penjualan\pemesananBarangController@print');
	//== End Pemesanan Barang

	///// End PENJUALAN


	///// MANAJEMEN PENJUALAN

	//=== RENCANA PENJUALAN

    Route::get('/man-penjualan/rencana-penjualan', 'manajemen_penjualan\pembuatanRencanaPenjualanController@index');
    Route::get('/man-penjualan/rencana-penjualan/auto-comp', 'manajemen_penjualan\pembuatanRencanaPenjualanController@auto_comp');
    Route::get('/man-penjualan/rencana-penjualan/auto-item', 'manajemen_penjualan\pembuatanRencanaPenjualanController@auto_item');

    Route::get('/man-penjualan/rencana-penjualan/getPending', 'manajemen_penjualan\pembuatanRencanaPenjualanController@get_data_pending');
    Route::get('/man-penjualan/rencana-penjualan/getApproved', 'manajemen_penjualan\pembuatanRencanaPenjualanController@get_data_approved');
    Route::match(['get', 'post'], '/man-penjualan/rencana-penjualan/add', 'manajemen_penjualan\pembuatanRencanaPenjualanController@tambah');
    Route::match(['get', 'post'], '/man-penjualan/rencana-penjualan/edit/{id}', 'manajemen_penjualan\pembuatanRencanaPenjualanController@edit');
    Route::get('/man-penjualan/rencana-penjualan/edit-dt/{id}', 'manajemen_penjualan\pembuatanRencanaPenjualanController@edit_dt');

    Route::get('/man-penjualan/rencana-penjualan/detail/{id}', 'manajemen_penjualan\pembuatanRencanaPenjualanController@detail');
    Route::get('/man-penjualan/rencana-penjualan/detail-dt/{id}', 'manajemen_penjualan\pembuatanRencanaPenjualanController@detail_dt');
    Route::get('/man-penjualan/rencana-penjualan/pencarian', 'manajemen_penjualan\pembuatanRencanaPenjualanController@cari');

    Route::get('/man-penjualan/rencana-penjualan/approve/{id}', 'manajemen_penjualan\pembuatanRencanaPenjualanController@approve');
    Route::get('/man-penjualan/rencana-penjualan/hapus/{id}', 'manajemen_penjualan\pembuatanRencanaPenjualanController@hapus');

	//=== End RENCANA PENJUALAN

	//=== MONITORING PENJUALAN

    Route::get('/man-penjualan/monitoring-penjualan', 'manajemen_penjualan\monitoringPenjualanController@index');
    Route::post('/man-penjualan/monitoring-penjualan/realtime', 'manajemen_penjualan\monitoringPenjualanController@realtime');
    Route::post('/man-penjualan/monitoring-penjualan/realtime-dt/{id}', 'manajemen_penjualan\monitoringPenjualanController@realtime_dt');
    Route::post('/man-penjualan/monitoring-penjualan/realisasi', 'manajemen_penjualan\monitoringPenjualanController@realisasi');
    Route::post('/man-penjualan/monitoring-penjualan/cari-realisasi', 'manajemen_penjualan\monitoringPenjualanController@cari_realisasi');
    Route::post('/man-penjualan/monitoring-penjualan/outlet', 'manajemen_penjualan\monitoringPenjualanController@outlet');
    Route::post('/man-penjualan/monitoring-penjualan/outlet-month', 'manajemen_penjualan\monitoringPenjualanController@outlet_month');

	//=== End MONITORING PENJUALAN

	//=== ANALISIS PENJUALAN

    Route::get('/man-penjualan/analisis-penjualan', 'manajemen_penjualan\analisisPenjualanController@index');
    Route::post('/man-penjualan/analisis-penjualan/analyze', 'manajemen_penjualan\analisisPenjualanController@analyze');

	//=== End ANALISIS PENJUALAN

	///// End MANAJEMEN PENJUALAN

	// Setting Application

	// Akses Pengguna
    Route::get('/pengaturan/akses-pengguna', 'PengaturanController@akses_pengguna');
    Route::get('/pengaturan/akses-pengguna/edit/{id}', 'PengaturanController@edit_akses');
    Route::post('/pengaturan/akses-pengguna/simpan', 'PengaturanController@simpan');
    Route::match(['get', 'post'], '/pengaturan/akses-pengguna/dataUser', 'PengaturanController@dataUser');

	// End Akses Pengguna

	// Manajemen Pengguna
    Route::get('/pengaturan/kelola-pengguna/tambah', 'manajemenPenggunaController@tambah_pengguna');
    Route::post('/pengaturan/kelola-pengguna/cekuser', 'manajemenPenggunaController@cek_user');
    Route::post('/pengaturan/kelola-pengguna/simpan', 'manajemenPenggunaController@simpan_pengguna');
    Route::match(['get', 'post'], '/pengaturan/kelola-pengguna/edit/{id}', 'manajemenPenggunaController@edit_pengguna');
    Route::match(['get', 'post'], '/pengaturan/kelola-pengguna/simpanEdit', 'manajemenPenggunaController@simpan_edit');
    Route::match(['get', 'post'], '/pengaturan/kelola-pengguna/pass/{id}', 'manajemenPenggunaController@ganti_pass');
    Route::match(['get', 'post'], '/pengaturan/kelola-pengguna/simpanPass', 'manajemenPenggunaController@simpan_pass');
    Route::match(['get', 'post'], '/pengaturan/kelola-pengguna/hapus/{id}', 'manajemenPenggunaController@hapus_pengguna');
    Route::match(['get', 'post'], '/pengaturan/kelola-pengguna/getDataEdit', 'manajemenPenggunaController@get_data_edit');
	// End Manajemen Pengguna

    Route::get('/pengaturan/log-kegiatan', 'PengaturanController@log_kegiatan');
    Route::match(['get', 'post'], '/pengaturan/log-kegiatan/dataLog', 'PengaturanController@data_log');
    Route::match(['get', 'post'], '/pengaturan/log-kegiatan/findLog', 'PengaturanController@find_log');
    Route::match(['get', 'post'], '/pengaturan/log-kegiatan/cariLog', 'PengaturanController@cari_userLog');
    Route::get('/pengaturan/log-kegiatan/hapus', 'PengaturanController@hapus_log');

	// End Setting Application

	// main route end
	//=== Penjualan Reguler
    Route::get('penjualan-reguler', 'PenjualanController@index');
    Route::get('penjualan-reguler/get', 'PenjualanController@getPenjualanRegular')->name('penjualan.regular');
    Route::get('penjualan-reguler/get-detail/{id}', 'PenjualanController@getPenjualanRegularDetail');
    Route::get('penjualan-reguler/delete/{id}', 'PenjualanController@delete');
    Route::get('penjualan-reguler/delete-item/{sales}/{item}/{code}', 'PenjualanController@deleteItem');
    Route::get('penjualan-reguler/edit/{id}', 'PenjualanController@editPenjualanRegular');
    Route::get('penjualan-reguler/tambah', 'PenjualanController@add_regular');
    Route::get('penjualan-reguler/simpan-member', 'PenjualanController@saveMember');
    Route::get('penjualan-reguler/cari-member', 'PenjualanController@cariMember');
    Route::get('penjualan-reguler/cari-sales', 'PenjualanController@cariSales');
    Route::get('penjualan-reguler/cari-stock', 'PenjualanController@cariStock');
    Route::get('penjualan-reguler/simpan-penjualan', 'PenjualanController@save');
    Route::get('penjualan-reguler/getdetailmember/{id}', 'PenjualanController@getDetailMember');
    Route::post('penjualan-reguler/simpan', 'PenjualanController@savePenjualan');
    Route::post('penjualan-reguler/edit', 'PenjualanController@editPenjualan');
    Route::get('penjualan-reguler/search-stock', 'PenjualanController@searchStock');
    Route::get('penjualan-reguler/checkStock/{item}', 'PenjualanController@checkStock');
    Route::get('penjualan-reguler/struk/{salesman}/{id}/{totHarga}/{payment_method}/{payment}/{dibayar}/{kembali}', 'PenjualanController@struck');
    Route::get('penjualan-reguler/detailPembayaran/{total}', 'PenjualanController@detailpembayaran');
	//==============

	// =====Penjualan Tempo=====
    Route::get('penjualan-tempo', 'PenjualanController@tempo');
    Route::get('penjualan-tempo/get', 'PenjualanController@getPenjualanTempo')->name('penjualan.tempo');
    Route::get('penjualan-tempo/get-detail/{id}', 'PenjualanController@getPenjualanRegularDetail');
    Route::get('penjualan-tempo/delete/{id}', 'PenjualanController@delete');
    Route::get('penjualan-tempo/delete-item/{sales}/{item}/{code}', 'PenjualanController@deleteItem');
    Route::get('penjualan-tempo/tambah', 'PenjualanController@add_tempo');
    Route::get('penjualan-tempo/edit/{id}', 'PenjualanController@editPenjualanTempo');
    Route::post('penjualan-tempo/edit', 'PenjualanController@editPenjualan');
    Route::get('penjualan-tempo/simpan-member', 'PenjualanController@saveMember');
    Route::get('penjualan-tempo/cari-member', 'PenjualanController@cariMember');
    Route::get('penjualan-tempo/cari-sales', 'PenjualanController@cariSales');
    Route::get('penjualan-tempo/cari-stock', 'PenjualanController@cariStock');
    Route::get('penjualan-tempo/simpan-penjualan', 'PenjualanController@save');
    Route::get('penjualan-tempo/getdetailmember/{id}', 'PenjualanController@getDetailMember');
    Route::post('penjualan-tempo/simpan', 'PenjualanController@savePenjualan');
    Route::get('penjualan-tempo/search-stock', 'PenjualanController@searchStock');
    Route::get('penjualan-tempo/checkStock/{item}', 'PenjualanController@checkStock');
    Route::get('penjualan-tempo/struktempo/{salesman}/{id}/{totHarga}/{payment_method}/{payment}/{dibayar}/{kembali}', 'PenjualanController@struckTempo');
    Route::get('penjualan-tempo/detailpembayarantempo/{total}', 'PenjualanController@detailpembayaranTempo');
	// =========================

	// =====Return Penjualan=====
    Route::get('return-penjualan', 'ReturnPenjualanController@index');
	// =====End Return Penjualan=====

	// =====Distribusi Barang=====
    Route::get('distribusi-barang', 'inventory\DistribusiController@index');
    Route::get('distribusi-barang/proses', 'inventory\DistribusiController@getProses')->name('distribusi.getproses');
    Route::get('distribusi-barang/terima', 'inventory\DistribusiController@getTerima')->name('distribusi.getterima');
    Route::get('distribusi-barang/detail/{id}', 'inventory\DistribusiController@detail');
    Route::get('distribusi-barang/detail-edit/{id}', 'inventory\DistribusiController@detailEdit');
    Route::get('distribusi-barang/detail-delete/{id}', 'inventory\DistribusiController@detailDelete');
    Route::get('distribusi-barang/detail-terima/{id}', 'inventory\DistribusiController@detailTerima');
    Route::get('distribusi/tambah-distribusi', 'inventory\DistribusiController@add');
    Route::get('distribusi-barang/cari-outlet', 'inventory\DistribusiController@cariOutlet');
    Route::get('distribusi-barang/cari-stock', 'inventory\DistribusiController@cariStock');
    Route::get('distribusi-barang/search-stock', 'inventory\DistribusiController@searchStock');
    Route::post('distribusi-barang/simpan', 'inventory\DistribusiController@simpan');
    Route::get('distribusi-barang/edit-distribusi/{id}', 'inventory\DistribusiController@editDistribusi');
    Route::get('distribusi-barang/delete-item/{distribusi}/{item}/{code}', 'inventory\DistribusiController@deleteItem');
    Route::get('distribusi-barang/delete/{id}', 'inventory\DistribusiController@delete');
    Route::post('distribusi-barang/edit', 'inventory\DistribusiController@edit');
    Route::get('distribusi-barang/struk/{id}', 'inventory\DistribusiController@struck');
	// =====End Distribusi barang=====

    //== Layanan Perbaikan
    Route::get('layanan-perbaikan', 'PerbaikanController@index');
    Route::get('layanan-perbaikan/tambah', 'PerbaikanController@tambah');


	// keuangan
    Route::get('keuangan/coa/jenis', 'keuangan\keuangan@index_jenis');
    Route::get('keuangan/coa/kelompok', 'keuangan\keuangan@index_kelompok');
    Route::get('keuangan/coa/bukubesar', 'keuangan\keuangan@index_buku_besar');
    Route::get('keuangan/coa/sub_bukubesar', 'keuangan\keuangan@index_sub_buku_besar');
    Route::POST('/keuangan/keuangan/viewCoa_sub_buku_besar', 'keuangan\keuangan@viewCoa_sub_buku_besar');
    Route::POST('/keuangan/keuangan/get_coaJenis', 'keuangan\keuangan@get_coaJenis');
    Route::POST('/keuangan/keuangan/get_coaKelompok', 'keuangan\keuangan@get_coaKelompok');
    Route::POST('/keuangan/keuangan/get_coaBb', 'keuangan\keuangan@get_coaBb');
    Route::POST('/keuangan/keuangan/get_detail_bb', 'keuangan\keuangan@get_detail_bb');
    Route::POST('/keuangan/keuangan/add_sub_buku_besar', 'keuangan\keuangan@add_sub_buku_besar');

    //Pengelolaan Member
    Route::get('pengelolaan-member', 'PengelolaanMemberController@index');
    Route::get('pengelolaan-member/get-konversi', 'PengelolaanMemberController@getKonversi');
    Route::get('pengelolaan-member/update-konversi', 'PengelolaanMemberController@updateKonversi');
    Route::get('pengelolaan-member/get-saldo-poin', 'PengelolaanMemberController@getSaldoPoin');
    Route::get('pengelolaan-member/simpan-saldo-poin', 'PengelolaanMemberController@saveSaldoPoin');
    Route::get('pengelolaan-member/get-data-setting/{id}', 'PengelolaanMemberController@getDataSetting');
    Route::get('pengelolaan-member/update-setting', 'PengelolaanMemberController@pengelolaan-member');
    Route::get('pengelolaan-member/get-member-poin', 'PengelolaanMemberController@getMemberPoin');
    Route::get('pengelolaan-member/get-member-birth', 'PengelolaanMemberController@getMemberBirth');
    Route::get('pengelolaan-member/get-member-history', 'PengelolaanMemberController@getMemberHistory');

    // Route Dirga

        // Routes keuangan Package Here

            Route::get('modul_keuangan/connection', function () {
                return keuangan::connection()->version();
            });

            // periode keuangan

                Route::post('modul/keuangan/periode/store', 'modul_keuangan\master\periode_keuangan\periode_keuangan_controller@save')->name('modul_keuangan.periode.save');

            // periode keuangan selesai


            // Master Data Group Akun

                Route::get('modul/keuangan/master/group-akun', [
                    "uses"  => 'modul_keuangan\master\group_akun\group_akun_controller@index'
                ])->name('grup-akun.index');

                Route::get('modul/keuangan/master/group-akun/create', [
                    "uses"  => 'modul_keuangan\master\group_akun\group_akun_controller@create'
                ])->name('grup-akun.create');

                Route::get('modul/keuangan/master/group-akun/datatable', [
                    "uses"  => 'modul_keuangan\master\group_akun\group_akun_controller@datatable'
                ])->name('grup-akun.datatable');

                Route::get('modul/keuangan/master/group-akun/form_resource', [
                    "uses"  => 'modul_keuangan\master\group_akun\group_akun_controller@form_resource'
                ])->name('grup-akun.form_resource');

                Route::post('modul/keuangan/master/group-akun/store', [
                    "uses"  => 'modul_keuangan\master\group_akun\group_akun_controller@store'
                ])->name('grup-akun.store');

                Route::post('modul/keuangan/master/group-akun/update', [
                    "uses"  => 'modul_keuangan\master\group_akun\group_akun_controller@update'
                ])->name('grup-akun.update');

                Route::post('modul/keuangan/master/group-akun/delete', [
                    "uses"  => 'modul_keuangan\master\group_akun\group_akun_controller@delete'
                ])->name('grup-akun.delete');

            //  Group Akun End


            // Master Data Akun

                Route::get('modul/keuangan/master/akun', [
                    "uses"  => 'modul_keuangan\master\akun\akun_controller@index'
                ])->name('akun.index');

                Route::get('modul/keuangan/master/akun/create', [
                    "uses"  => 'modul_keuangan\master\akun\akun_controller@create'
                ])->name('akun.create');

                Route::get('modul/keuangan/master/akun/create/form-resource', [
                    "uses"  => 'modul_keuangan\master\akun\akun_controller@form_resource'
                ])->name('akun.form_resource');

                Route::post('modul/keuangan/master/akun/store', [
                    "uses"  => 'modul_keuangan\master\akun\akun_controller@store'
                ])->name('akun.store');

                Route::get('modul/keuangan/master/akun/datatable', [
                    "uses"  => 'modul_keuangan\master\akun\akun_controller@datatable'
                ])->name('akun.datatable');

                Route::post('modul/keuangan/master/akun/update', [
                    "uses"  => 'modul_keuangan\master\akun\akun_controller@update'
                ])->name('akun.update');

                Route::post('modul/keuangan/master/akun/delete', [
                    "uses"  => 'modul_keuangan\master\akun\akun_controller@delete'
                ])->name('akun.delete');

            // Data Akun Selesai


            // Master Data Transaksi

                Route::get('modul/keuangan/master/transaksi', [
                    "uses"  => 'modul_keuangan\master\transaksi\transaksi_controller@index'
                ])->name('transaksi.index');

                Route::get('modul/keuangan/master/transaksi/create', [
                    "uses"  => 'modul_keuangan\master\transaksi\transaksi_controller@create'
                ])->name('transaksi.create');

                Route::get('modul/keuangan/master/transaksi/create/form-resource', [
                    "uses"  => 'modul_keuangan\master\transaksi\transaksi_controller@form_resource'
                ])->name('transaksi.form_resource');

                Route::post('modul/keuangan/master/transaksi/store', [
                    "uses"  => 'modul_keuangan\master\transaksi\transaksi_controller@store'
                ])->name('transaksi.store');

                Route::get('modul/keuangan/master/transaksi/datatable', [
                    "uses"  => 'modul_keuangan\master\transaksi\transaksi_controller@datatable'
                ])->name('transaksi.datatable');

                Route::post('modul/keuangan/master/transaksi/update', [
                    "uses"  => 'modul_keuangan\master\transaksi\transaksi_controller@update'
                ])->name('transaksi.update');

                Route::post('modul/keuangan/master/transaksi/delete', [
                    "uses"  => 'modul_keuangan\master\transaksi\transaksi_controller@delete'
                ])->name('transaksi.delete');

            // Data Transaksi Selesai


            // Golongan Aset

                Route::get('modul/keuangan/manajemen-aset/group-aset', [
                    "uses"  => 'modul_keuangan\aset\group\group_aset_controller@index'
                ])->name('group.aset.index');

                Route::get('modul/keuangan/manajemen-aset/group-aset/create', [
                    "uses"  => 'modul_keuangan\aset\group\group_aset_controller@create'
                ])->name('group.aset.create');

                Route::get('modul/keuangan/manajemen-aset/group-aset/form_resource', [
                    "uses"  => 'modul_keuangan\aset\group\group_aset_controller@form_resource'
                ])->name('group.aset.form_resource');

                Route::post('modul/keuangan/manajemen-aset/group-aset/store', [
                    "uses"  => 'modul_keuangan\aset\group\group_aset_controller@store'
                ])->name('group.aset.store');

                Route::get('modul/keuangan/manajemen-aset/group-aset/datatable', [
                    "uses"  => 'modul_keuangan\aset\group\group_aset_controller@datatable'
                ])->name('group.aset.datatable');

                Route::post('modul/keuangan/manajemen-aset/group-aset/update', [
                    "uses"  => 'modul_keuangan\aset\group\group_aset_controller@update'
                ])->name('group.aset.update');

                Route::post('modul/keuangan/manajemen-aset/group-aset/delete', [
                    "uses"  => 'modul_keuangan\aset\group\group_aset_controller@delete'
                ])->name('group.aset.delete');

            // Golongan Aset


            // Aset

                Route::get('modul/keuangan/manajemen-aset/aset', [
                    "uses"  => 'modul_keuangan\aset\aset\aset_controller@index'
                ])->name('aset.index');

                Route::get('modul/keuangan/manajemen-aset/aset/create', [
                    "uses"  => 'modul_keuangan\aset\aset\aset_controller@create'
                ])->name('aset.create');

                Route::get('modul/keuangan/manajemen-aset/aset/form_resource', [
                    "uses"  => 'modul_keuangan\aset\aset\aset_controller@form_resource'
                ])->name('aset.form_resource');

                Route::post('modul/keuangan/manajemen-aset/aset/store', [
                    "uses"  => 'modul_keuangan\aset\aset\aset_controller@store'
                ])->name('aset.store');

                Route::get('modul/keuangan/manajemen-aset/aset/datatable', [
                    "uses"  => 'modul_keuangan\aset\aset\aset_controller@datatable'
                ])->name('aset.datatable');

                Route::post('modul/keuangan/manajemen-aset/aset/update', [
                    "uses"  => 'modul_keuangan\aset\aset\aset_controller@update'
                ])->name('aset.update');

                Route::post('modul/keuangan/manajemen-aset/aset/delete', [
                    "uses"  => 'modul_keuangan\aset\aset\aset_controller@delete'
                ])->name('aset.delete');

            // Aset


            // Transaksi Kas

                Route::get('modul/keuangan/transaksi/kas', [
                    "uses"  => 'modul_keuangan\transaksi\kas\transaksi_kas_controller@index'
                ])->name('transaksi.kas.index');

                Route::get('modul/keuangan/transaksi/kas/form-resource', [
                    "uses"  => 'modul_keuangan\transaksi\kas\transaksi_kas_controller@form_resource'
                ])->name('transaksi.kas.form_resource');

                Route::post('modul/keuangan/transaksi/kas/store', [
                    "uses"  => 'modul_keuangan\transaksi\kas\transaksi_kas_controller@store'
                ])->name('transaksi.kas.store');

                Route::get('modul/keuangan/transaksi/kas/datatable', [
                    "uses"  => 'modul_keuangan\transaksi\kas\transaksi_kas_controller@datatable'
                ])->name('transaksi.kas.datatable');

                Route::post('modul/keuangan/transaksi/kas/update', [
                    "uses"  => 'modul_keuangan\transaksi\kas\transaksi_kas_controller@update'
                ])->name('transaksi.kas.update');

                Route::post('modul/keuangan/transaksi/kas/delete', [
                    "uses"  => 'modul_keuangan\transaksi\kas\transaksi_kas_controller@delete'
                ])->name('transaksi.kas.delete');

            // Transaksi Kas Selesai


            // Transaksi Bank

                Route::get('modul/keuangan/transaksi/bank', [
                    "uses"  => 'modul_keuangan\transaksi\bank\transaksi_bank_controller@index'
                ])->name('transaksi.bank.index');

                Route::get('modul/keuangan/transaksi/bank/form-resource', [
                    "uses"  => 'modul_keuangan\transaksi\bank\transaksi_bank_controller@form_resource'
                ])->name('transaksi.bank.form_resource');

                Route::post('modul/keuangan/transaksi/bank/store', [
                    "uses"  => 'modul_keuangan\transaksi\bank\transaksi_bank_controller@store'
                ])->name('transaksi.bank.store');

                Route::get('modul/keuangan/transaksi/bank/datatable', [
                    "uses"  => 'modul_keuangan\transaksi\bank\transaksi_bank_controller@datatable'
                ])->name('transaksi.bank.datatable');

                Route::post('modul/keuangan/transaksi/bank/update', [
                    "uses"  => 'modul_keuangan\transaksi\bank\transaksi_bank_controller@update'
                ])->name('transaksi.bank.update');

                Route::post('modul/keuangan/transaksi/bank/delete', [
                    "uses"  => 'modul_keuangan\transaksi\bank\transaksi_bank_controller@delete'
                ])->name('transaksi.bank.delete');

            // Transaksi Bank Selesai


            // Transaksi Memorial

                Route::get('modul/keuangan/transaksi/memorial', [
                    "uses"  => 'modul_keuangan\transaksi\memorial\transaksi_memorial_controller@index'
                ])->name('transaksi.memorial.index');

                Route::get('modul/keuangan/transaksi/memorial/form-resource', [
                    "uses"  => 'modul_keuangan\transaksi\memorial\transaksi_memorial_controller@form_resource'
                ])->name('transaksi.memorial.form_resource');

                Route::post('modul/keuangan/transaksi/memorial/store', [
                    "uses"  => 'modul_keuangan\transaksi\memorial\transaksi_memorial_controller@store'
                ])->name('transaksi.memorial.store');

                Route::get('modul/keuangan/transaksi/memorial/datatable', [
                    "uses"  => 'modul_keuangan\transaksi\memorial\transaksi_memorial_controller@datatable'
                ])->name('transaksi.memorial.datatable');

                Route::post('modul/keuangan/transaksi/memorial/update', [
                    "uses"  => 'modul_keuangan\transaksi\memorial\transaksi_memorial_controller@update'
                ])->name('transaksi.memorial.update');

                Route::post('modul/keuangan/transaksi/memorial/delete', [
                    "uses"  => 'modul_keuangan\transaksi\memorial\transaksi_memorial_controller@delete'
                ])->name('transaksi.memorial.delete');

            // Transaksi Memorial Selesai


            // Penerimaan Piutang

                Route::get('modul/keuangan/transaksi/penerimaan_piutang', [
                    "uses"  => 'modul_keuangan\transaksi\penerimaan_piutang\penerimaan_piutang_controller@index'
                ])->name('transaksi.penerimaan_piutang.index');

                Route::get('modul/keuangan/transaksi/penerimaan_piutang/form-resource', [
                    "uses"  => 'modul_keuangan\transaksi\penerimaan_piutang\penerimaan_piutang_controller@form_resource'
                ])->name('transaksi.penerimaan_piutang.form_resource');

                Route::post('modul/keuangan/transaksi/penerimaan_piutang/store', [
                    "uses"  => 'modul_keuangan\transaksi\penerimaan_piutang\penerimaan_piutang_controller@store'
                ])->name('transaksi.penerimaan_piutang.store');

                Route::get('modul/keuangan/transaksi/penerimaan_piutang/datatable', [
                    "uses"  => 'modul_keuangan\transaksi\penerimaan_piutang\penerimaan_piutang_controller@datatable'
                ])->name('transaksi.penerimaan_piutang.datatable');

                Route::get('modul/keuangan/transaksi/penerimaan_piutang/get/nota', [
                    "uses"  => 'modul_keuangan\transaksi\penerimaan_piutang\penerimaan_piutang_controller@get_nota'
                ])->name('transaksi.penerimaan_piutang.get_nota');

                Route::post('modul/keuangan/transaksi/penerimaan_piutang/update', [
                    "uses"  => 'modul_keuangan\transaksi\penerimaan_piutang\penerimaan_piutang_controller@update'
                ])->name('transaksi.penerimaan_piutang.update');

                Route::post('modul/keuangan/transaksi/penerimaan_piutang/delete', [
                    "uses"  => 'modul_keuangan\transaksi\penerimaan_piutang\penerimaan_piutang_controller@delete'
                ])->name('transaksi.penerimaan_piutang.delete');

            // Penerimaan Piutang


            // Pelunasan Hutang

                Route::get('modul/keuangan/transaksi/pelunasan_hutang', [
                    "uses"  => 'modul_keuangan\transaksi\pelunasan_hutang\pelunasan_hutang_controller@index'
                ])->name('transaksi.pelunasan_hutang.index');

                Route::get('modul/keuangan/transaksi/pelunasan_hutang/form-resource', [
                    "uses"  => 'modul_keuangan\transaksi\pelunasan_hutang\pelunasan_hutang_controller@form_resource'
                ])->name('transaksi.pelunasan_hutang.form_resource');

                Route::post('modul/keuangan/transaksi/pelunasan_hutang/store', [
                    "uses"  => 'modul_keuangan\transaksi\pelunasan_hutang\pelunasan_hutang_controller@store'
                ])->name('transaksi.pelunasan_hutang.store');

                Route::get('modul/keuangan/transaksi/pelunasan_hutang/datatable', [
                    "uses"  => 'modul_keuangan\transaksi\pelunasan_hutang\pelunasan_hutang_controller@datatable'
                ])->name('transaksi.pelunasan_hutang.datatable');

                Route::get('modul/keuangan/transaksi/pelunasan_hutang/get/nota', [
                    "uses"  => 'modul_keuangan\transaksi\pelunasan_hutang\pelunasan_hutang_controller@get_nota'
                ])->name('transaksi.pelunasan_hutang.get_nota');

                Route::post('modul/keuangan/transaksi/pelunasan_hutang/update', [
                    "uses"  => 'modul_keuangan\transaksi\pelunasan_hutang\pelunasan_hutang_controller@update'
                ])->name('transaksi.pelunasan_hutang.update');

                Route::post('modul/keuangan/transaksi/pelunasan_hutang/delete', [
                    "uses"  => 'modul_keuangan\transaksi\pelunasan_hutang\pelunasan_hutang_controller@delete'
                ])->name('transaksi.pelunasan_hutang.delete');

            // Pelunasan Hutang


            // klasifikasi akun

                    Route::get('modul/keuangan/setting/klasifikasi-akun', [
                        "uses"  => 'modul_keuangan\setting\klasifikasi_akun\klasifikasi_akun_controller@index'
                    ])->name('setting.klasifikasi_akun.index');

                    Route::get('modul/keuangan/setting/klasifikasi-akun/form-resource', [
                        "uses"  => 'modul_keuangan\setting\klasifikasi_akun\klasifikasi_akun_controller@form_resource'
                    ])->name('setting.klasifikasi_akun.form_resource');

                    Route::post('modul/keuangan/setting/klasifikasi-akun/save/level_1', [
                        "uses"  => 'modul_keuangan\setting\klasifikasi_akun\klasifikasi_akun_controller@simpan_level_1'
                    ])->name('setting.klasifikasi_akun.simpan.level_1');

                    Route::post('modul/keuangan/setting/klasifikasi-akun/save/level_2', [
                        "uses"  => 'modul_keuangan\setting\klasifikasi_akun\klasifikasi_akun_controller@simpan_level_2'
                    ])->name('setting.klasifikasi_akun.simpan.level_2');

                    Route::post('modul/keuangan/setting/klasifikasi-akun/delete/level_2', [
                        "uses"  => 'modul_keuangan\setting\klasifikasi_akun\klasifikasi_akun_controller@hapus_level_2'
                    ])->name('setting.klasifikasi_akun.hapus.level_2');

                    Route::post('modul/keuangan/setting/klasifikasi-akun/save/subclass', [
                        "uses"  => 'modul_keuangan\setting\klasifikasi_akun\klasifikasi_akun_controller@simpan_subclass'
                    ])->name('setting.klasifikasi_akun.simpan.subclass');

                    Route::post('modul/keuangan/setting/klasifikasi-akun/delete/subclass', [
                        "uses"  => 'modul_keuangan\setting\klasifikasi_akun\klasifikasi_akun_controller@hapus_level_subclass'
                    ])->name('setting.klasifikasi_akun.hapus.subclass');

            // klasifikasi akun


            // Laporan Keuangan

                Route::get('modul/keuangan/laporan', function(){
                    return view('modul_keuangan.laporan.index');
                })->name('laporan.keuangan.index');


                // laporan Jurnal Umum
                    Route::get('modul/keuangan/laporan/jurnal_umum', [
                        'uses'  => 'modul_keuangan\laporan\jurnal\laporan_jurnal_controller@index'
                    ])->name('laporan.keuangan.jurnal_umum');

                    Route::get('modul/keuangan/laporan/jurnal_umum/data_resource', [
                        'uses'  => 'modul_keuangan\laporan\jurnal\laporan_jurnal_controller@dataResource'
                    ])->name('laporan.keuangan.jurnal_umum.data_resource');

                    Route::get('modul/keuangan/laporan/jurnal_umum/print', [
                        'uses'  => 'modul_keuangan\laporan\jurnal\laporan_jurnal_controller@print'
                    ])->name('laporan.keuangan.jurnal_umum.print');

                    Route::get('modul/keuangan/laporan/jurnal_umum/print/excel', [
                        'uses'  => 'modul_keuangan\laporan\jurnal\laporan_jurnal_controller@excel'
                    ])->name('laporan.keuangan.jurnal_umum.print.excel');

                    Route::get('modul/keuangan/laporan/jurnal_umum/print/pdf', [
                        'uses'  => 'modul_keuangan\laporan\jurnal\laporan_jurnal_controller@pdf'
                    ])->name('laporan.keuangan.jurnal_umum.print.pdf');


                // laporan Buku Besar
                    Route::get('modul/keuangan/laporan/buku_besar', [
                        'uses'  => 'modul_keuangan\laporan\buku_besar\laporan_buku_besar_controller@index'
                    ])->name('laporan.keuangan.buku_besar');

                    Route::get('modul/keuangan/laporan/buku_besar/data_resource', [
                        'uses'  => 'modul_keuangan\laporan\buku_besar\laporan_buku_besar_controller@dataResource'
                    ])->name('laporan.keuangan.buku_besar.data_resource');

                    Route::get('modul/keuangan/laporan/buku_besar/print', [
                        'uses'  => 'modul_keuangan\laporan\buku_besar\laporan_buku_besar_controller@print'
                    ])->name('laporan.keuangan.buku_besar.print');

                    Route::get('modul/keuangan/laporan/buku_besar/print/pdf', [
                        'uses'  => 'modul_keuangan\laporan\buku_besar\laporan_buku_besar_controller@pdf'
                    ])->name('laporan.keuangan.buku_besar.print.pdf');

                    Route::get('modul/keuangan/laporan/buku_besar/print/excel', [
                        'uses'  => 'modul_keuangan\laporan\buku_besar\laporan_buku_besar_controller@excel'
                    ])->name('laporan.keuangan.buku_besar.print.excel');


                // laporan Neraca Saldo
                    Route::get('modul/keuangan/laporan/neraca_saldo', [
                        'uses'  => 'modul_keuangan\laporan\neraca_saldo\laporan_neraca_saldo_controller@index'
                    ])->name('laporan.keuangan.neraca_saldo');

                    Route::get('modul/keuangan/laporan/neraca_saldo/data_resource', [
                        'uses'  => 'modul_keuangan\laporan\neraca_saldo\laporan_neraca_saldo_controller@dataResource'
                    ])->name('laporan.keuangan.neraca_saldo.data_resource');

                    Route::get('modul/keuangan/laporan/neraca_saldo/print', [
                        'uses'  => 'modul_keuangan\laporan\neraca_saldo\laporan_neraca_saldo_controller@print'
                    ])->name('laporan.keuangan.neraca_saldo.print');

                    Route::get('modul/keuangan/laporan/neraca_saldo/print/pdf', [
                        'uses'  => 'modul_keuangan\laporan\neraca_saldo\laporan_neraca_saldo_controller@pdf'
                    ])->name('laporan.keuangan.neraca_saldo.print.pdf');

                    Route::get('modul/keuangan/laporan/neraca_saldo/print/excel', [
                        'uses'  => 'modul_keuangan\laporan\neraca_saldo\laporan_neraca_saldo_controller@excel'
                    ])->name('laporan.keuangan.neraca_saldo.print.excel');


                // laporan Neraca
                    Route::get('modul/keuangan/laporan/neraca', [
                        'uses'  => 'modul_keuangan\laporan\neraca\laporan_neraca_controller@index'
                    ])->name('laporan.keuangan.neraca');

                    Route::get('modul/keuangan/laporan/neraca/data_resource', [
                        'uses'  => 'modul_keuangan\laporan\neraca\laporan_neraca_controller@dataResource'
                    ])->name('laporan.keuangan.neraca.data_resource');

                    Route::get('modul/keuangan/laporan/neraca/print', [
                        'uses'  => 'modul_keuangan\laporan\neraca\laporan_neraca_controller@print'
                    ])->name('laporan.keuangan.neraca.print');

                    Route::get('modul/keuangan/laporan/neraca/print/pdf', [
                        'uses'  => 'modul_keuangan\laporan\neraca\laporan_neraca_controller@pdf'
                    ])->name('laporan.keuangan.neraca.print.pdf');

                    Route::get('modul/keuangan/laporan/neraca/print/excel', [
                        'uses'  => 'modul_keuangan\laporan\neraca\laporan_neraca_controller@excel'
                    ])->name('laporan.keuangan.neraca.print.excel');


                // laporan Laba Rugi
                    Route::get('modul/keuangan/laporan/laba_rugi', [
                        'uses'  => 'modul_keuangan\laporan\laba_rugi\laporan_laba_rugi_controller@index'
                    ])->name('laporan.keuangan.laba_rugi');

                    Route::get('modul/keuangan/laporan/laba_rugi/data_resource', [
                        'uses'  => 'modul_keuangan\laporan\laba_rugi\laporan_laba_rugi_controller@dataResource'
                    ])->name('laporan.keuangan.laba_rugi.data_resource');

                    Route::get('modul/keuangan/laporan/laba_rugi/print', [
                        'uses'  => 'modul_keuangan\laporan\laba_rugi\laporan_laba_rugi_controller@print'
                    ])->name('laporan.keuangan.laba_rugi.print');

                    Route::get('modul/keuangan/laporan/laba_rugi/print/pdf', [
                        'uses'  => 'modul_keuangan\laporan\laba_rugi\laporan_laba_rugi_controller@pdf'
                    ])->name('laporan.keuangan.laba_rugi.print.pdf');

                    Route::get('modul/keuangan/laporan/laba_rugi/print/excel', [
                        'uses'  => 'modul_keuangan\laporan\laba_rugi\laporan_laba_rugi_controller@excel'
                    ])->name('laporan.keuangan.laba_rugi.print.excel');


                // laporan Arus Kas
                    Route::get('modul/keuangan/laporan/arus_kas', [
                        'uses'  => 'modul_keuangan\laporan\arus_kas\laporan_arus_kas_controller@index'
                    ])->name('laporan.keuangan.arus_kas');

                    Route::get('modul/keuangan/laporan/arus_kas/data_resource', [
                        'uses'  => 'modul_keuangan\laporan\arus_kas\laporan_arus_kas_controller@dataResource'
                    ])->name('laporan.keuangan.arus_kas.data_resource');

                    Route::get('modul/keuangan/laporan/arus_kas/print', [
                        'uses'  => 'modul_keuangan\laporan\arus_kas\laporan_arus_kas_controller@print'
                    ])->name('laporan.keuangan.arus_kas.print');

                    Route::get('modul/keuangan/laporan/arus_kas/print/pdf', [
                        'uses'  => 'modul_keuangan\laporan\arus_kas\laporan_arus_kas_controller@pdf'
                    ])->name('laporan.keuangan.arus_kas.print.pdf');

                    Route::get('modul/keuangan/laporan/arus_kas/print/excel', [
                        'uses'  => 'modul_keuangan\laporan\arus_kas\laporan_arus_kas_controller@excel'
                    ])->name('laporan.keuangan.arus_kas.print.excel');


                // laporan Hutang
                    Route::get('modul/keuangan/laporan/hutang', [
                        'uses'  => 'modul_keuangan\laporan\hutang\laporan_hutang_controller@index'
                    ])->name('laporan.keuangan.hutang');

                    Route::get('modul/keuangan/laporan/hutang/data_resource', [
                        'uses'  => 'modul_keuangan\laporan\hutang\laporan_hutang_controller@dataResource'
                    ])->name('laporan.keuangan.hutang.data_resource');

                    Route::get('modul/keuangan/laporan/hutang/print', [
                        'uses'  => 'modul_keuangan\laporan\hutang\laporan_hutang_controller@print'
                    ])->name('laporan.keuangan.hutang.print');

                    Route::get('modul/keuangan/laporan/hutang/print/pdf', [
                        'uses'  => 'modul_keuangan\laporan\hutang\laporan_hutang_controller@pdf'
                    ])->name('laporan.keuangan.hutang.print.pdf');

                    Route::get('modul/keuangan/laporan/hutang/print/excel', [
                        'uses'  => 'modul_keuangan\laporan\hutang\laporan_hutang_controller@excel'
                    ])->name('laporan.keuangan.hutang.print.excel');


                // laporan Piutang
                    Route::get('modul/keuangan/laporan/piutang', [
                        'uses'  => 'modul_keuangan\laporan\piutang\laporan_piutang_controller@index'
                    ])->name('laporan.keuangan.piutang');

                    Route::get('modul/keuangan/laporan/piutang/data_resource', [
                        'uses'  => 'modul_keuangan\laporan\piutang\laporan_piutang_controller@dataResource'
                    ])->name('laporan.keuangan.piutang.data_resource');

                    Route::get('modul/keuangan/laporan/piutang/print', [
                        'uses'  => 'modul_keuangan\laporan\piutang\laporan_piutang_controller@print'
                    ])->name('laporan.keuangan.piutang.print');

                    Route::get('modul/keuangan/laporan/piutang/print/pdf', [
                        'uses'  => 'modul_keuangan\laporan\piutang\laporan_piutang_controller@pdf'
                    ])->name('laporan.keuangan.piutang.print.pdf');

                    Route::get('modul/keuangan/laporan/piutang/print/excel', [
                        'uses'  => 'modul_keuangan\laporan\piutang\laporan_piutang_controller@excel'
                    ])->name('laporan.keuangan.piutang.print.excel');

            // laporan Keuangan


            // Analisa Keuangan

                    Route::get('modul/keuangan/analisa', function(){
                        return view('modul_keuangan.analisa.index');
                    })->name('analisa.keuangan.index');

                    // Analisa Net Profitt OCF
                        Route::get('modul/keuangan/analisa/npo', [
                            'uses'  => 'modul_keuangan\analisa\net_profit_ocf\analisa_net_profit_ocf_controller@index'
                        ])->name('analisa.keuangan.npo');

                        Route::get('modul/keuangan/analisa/npo/data_resource', [
                            'uses'  => 'modul_keuangan\analisa\net_profit_ocf\analisa_net_profit_ocf_controller@dataResource'
                        ])->name('analisa.keuangan.npo.data_resource');

                        Route::get('modul/keuangan/analisa/npo/print', [
                            'uses'  => 'modul_keuangan\analisa\net_profit_ocf\analisa_net_profit_ocf_controller@print'
                        ])->name('analisa.keuangan.npo.print');

                        Route::get('modul/keuangan/analisa/npo/print/pdf', [
                            'uses'  => 'modul_keuangan\analisa\net_profit_ocf\analisa_net_profit_ocf_controller@pdf'
                        ])->name('analisa.keuangan.npo.print.pdf');


                    // Analisa Net Profitt OCF
                        Route::get('modul/keuangan/analisa/hutang_piutang', [
                            'uses'  => 'modul_keuangan\analisa\hutang_piutang\analisa_hutang_piutang_controller@index'
                        ])->name('analisa.keuangan.hutang_piutang');

                        Route::get('modul/keuangan/analisa/hutang_piutang/data_resource', [
                            'uses'  => 'modul_keuangan\analisa\hutang_piutang\analisa_hutang_piutang_controller@dataResource'
                        ])->name('analisa.keuangan.hutang_piutang.data_resource');

                        Route::get('modul/keuangan/analisa/hutang_piutang/print', [
                            'uses'  => 'modul_keuangan\analisa\hutang_piutang\analisa_hutang_piutang_controller@print'
                        ])->name('analisa.keuangan.hutang_piutang.print');

                        Route::get('modul/keuangan/analisa/hutang_piutang/print/pdf', [
                            'uses'  => 'modul_keuangan\analisa\hutang_piutang\analisa_hutang_piutang_controller@pdf'
                        ])->name('analisa.keuangan.hutang_piutang.print.pdf');


                    // Analisa Pertumbuhan Aset
                        Route::get('modul/keuangan/analisa/pertumbuhan_aset', [
                            'uses'  => 'modul_keuangan\analisa\pertumbuhan_aset\analisa_pertumbuhan_aset_controller@index'
                        ])->name('analisa.keuangan.pertumbuhan_aset');

                        Route::get('modul/keuangan/analisa/pertumbuhan_aset/data_resource', [
                            'uses'  => 'modul_keuangan\analisa\pertumbuhan_aset\analisa_pertumbuhan_aset_controller@dataResource'
                        ])->name('analisa.keuangan.pertumbuhan_aset.data_resource');

                        Route::get('modul/keuangan/analisa/pertumbuhan_aset/print', [
                            'uses'  => 'modul_keuangan\analisa\pertumbuhan_aset\analisa_pertumbuhan_aset_controller@print'
                        ])->name('analisa.keuangan.pertumbuhan_aset.print');

                        Route::get('modul/keuangan/analisa/pertumbuhan_aset/print/pdf', [
                            'uses'  => 'modul_keuangan\analisa\pertumbuhan_aset\analisa_pertumbuhan_aset_controller@pdf'
                        ])->name('analisa.keuangan.pertumbuhan_aset.print.pdf');


                    // Analisa Aset Terhadap Ekuitas
                        Route::get('modul/keuangan/analisa/aset_ekuitas', [
                            'uses'  => 'modul_keuangan\analisa\aset_ekuitas\analisa_aset_ekuitas_controller@index'
                        ])->name('analisa.keuangan.aset_ekuitas');

                        Route::get('modul/keuangan/analisa/aset_ekuitas/data_resource', [
                            'uses'  => 'modul_keuangan\analisa\aset_ekuitas\analisa_aset_ekuitas_controller@dataResource'
                        ])->name('analisa.keuangan.aset_ekuitas.data_resource');

                        Route::get('modul/keuangan/analisa/aset_ekuitas/print', [
                            'uses'  => 'modul_keuangan\analisa\aset_ekuitas\analisa_aset_ekuitas_controller@print'
                        ])->name('analisa.keuangan.aset_ekuitas.print');

                        Route::get('modul/keuangan/analisa/aset_ekuitas/print/pdf', [
                            'uses'  => 'modul_keuangan\analisa\aset_ekuitas\analisa_aset_ekuitas_controller@pdf'
                        ])->name('analisa.keuangan.aset_ekuitas.print.pdf');


                    // Analisa Aset Terhadap Ekuitas
                        Route::get('modul/keuangan/analisa/common_size', [
                            'uses'  => 'modul_keuangan\analisa\common_size\analisa_common_size_controller@index'
                        ])->name('analisa.keuangan.common_size');

                        Route::get('modul/keuangan/analisa/common_size/data_resource', [
                            'uses'  => 'modul_keuangan\analisa\common_size\analisa_common_size_controller@dataResource'
                        ])->name('analisa.keuangan.common_size.data_resource');

                        Route::get('modul/keuangan/analisa/common_size/print', [
                            'uses'  => 'modul_keuangan\analisa\common_size\analisa_common_size_controller@print'
                        ])->name('analisa.keuangan.common_size.print');

                        Route::get('modul/keuangan/analisa/common_size/print/pdf', [
                            'uses'  => 'modul_keuangan\analisa\common_size\analisa_common_size_controller@pdf'
                        ])->name('analisa.keuangan.common_size.print.pdf');


                    // Analisa Cashflow
                        Route::get('modul/keuangan/analisa/cashflow', [
                            'uses'  => 'modul_keuangan\analisa\cashflow\analisa_cashflow_controller@index'
                        ])->name('analisa.keuangan.cashflow');

                        Route::get('modul/keuangan/analisa/cashflow/data_resource', [
                            'uses'  => 'modul_keuangan\analisa\cashflow\analisa_cashflow_controller@dataResource'
                        ])->name('analisa.keuangan.cashflow.data_resource');

                        Route::get('modul/keuangan/analisa/cashflow/print', [
                            'uses'  => 'modul_keuangan\analisa\cashflow\analisa_cashflow_controller@print'
                        ])->name('analisa.keuangan.cashflow.print');

                        Route::get('modul/keuangan/analisa/cashflow/print/pdf', [
                            'uses'  => 'modul_keuangan\analisa\cashflow\analisa_cashflow_controller@pdf'
                        ])->name('analisa.keuangan.cashflow.print.pdf');

            // Analisa Keuangan

    // Selesai Route Dirga

}); // Middleware Auth


    // Frontend Onlineshop============================================================== //
    Route::prefix('onlineshop')->group(function () {
        Route::get('/', 'OnlineshopController@index')->name('frontend');
        Route::get('/product-all', 'OnlineshopController@product_all')->name('product_all');
        Route::get('/handphone', 'OnlineshopController@product_hp')->name('product_hp');
        Route::get('/accesories', 'OnlineshopController@product_acces')->name('product_acces');
        Route::get('/product-detail/{id}', 'OnlineshopController@product_detail')->name('product_detail');
        Route::get('/shoping-cart/{id}', 'OnlineshopController@shoping_cart')->name('shoping_cart');
        Route::get('/add-cart', 'OnlineshopController@addToCart')->name('addToCart');
        Route::get('/notif-cart', 'OnlineshopController@notifCart')->name('notifCart');
    });



    /*
     *
     * TTTTTTTTTTTTT   HHH       HHH   EEE E E E
     *      TTT        HHH       HHH   EEE
     *      TTT        HHH H H H HHH   EEE E E E
     *      TTT        HHH       HHH   EEE
     *      TTT        HHH       HHH   EEE E E E
     *
     */
