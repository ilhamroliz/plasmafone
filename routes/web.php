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

	// Route::get('/master/outlet/delete/{id}', 'master\outlet\outlet_controller@delete');

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
	Route::match(['get', 'post'], '/master/member/simpan-edit', 'master\member\member_controller@simpan_edit');


	Route::get('/master/member/active/{id}', 'master\member\member_controller@active');
	Route::get('/master/member/nonactive/{id}', 'master\member\member_controller@nonactive');
	Route::get('/master/member/delete/{id}', 'master\member\member_controller@delete');

	// End Master Member

	// Pembelian

	// Request Order

	Route::get('/pembelian/request-pembelian', 'PembelianController@request_order');

	Route::match(['get', 'post'], '/pembelian/request-order/add', 'PembelianController@form_add_request');

	Route::post('/pembelian/request-order/edit-multiple', 'PembelianController@edit_multiple');

	Route::get('/pembelian/request-order/edit', 'PembelianController@edit_order');

	Route::match(['get', 'post'], '/pembelian/request-order/get/{id}', 'PembelianController@get_order');

	Route::post('/pembelian/request-order/update', 'PembelianController@update_order');

	Route::match(['get', 'post'], '/pembelian/request-order/multiple-delete', 'PembelianController@multiple_delete_order');

	// End Request Order

	// Rencana Pembelian

// <<<<<<< HEAD
// 	Route::get('/pembelian/rencana-pembelian','PembelianController@rencana_pembelian');
// 	Route::get('/pembelian/rencana-pembelian/tambah','PembelianController@addRencana');
// 	Route::get('/pembelian/rencana-pembelian/get-item','PembelianController@getItem');
// 	Route::post('/pembelian/rencana-pembelian/request-order-status','PembelianController@request_order_status');
// =======
// 	Route::get('/pembelian/rencana-pembelian', 'PembelianController@rencana_pembelian');
// 	Route::get('/pembelian/rencana-pembelian/tambah', 'PembelianController@addRencana');

// 	Route::post('/pembelian/rencana-pembelian/request-order-status', 'PembelianController@request_order_status');
// >>>>>>> ff228b106c4823a9d890f856329d75eab291d36e

	Route::get('/pembelian/rencana-pembelian', 'PembelianController@rencana_pembelian');
	Route::get('/pembelian/rencana-pembelian/tambah', 'PembelianController@addRencana');

	Route::post('/pembelian/rencana-pembelian/request-order-status', 'PembelianController@request_order_status');


	Route::get('/pembelian/rencana-pembelian/rencana-pembelian/edit', 'PembelianController@rencana_pembelian_edit');

	Route::post('/pembelian/rencana-pembelian/rencana-pembelian/update', 'PembelianController@update_rencana_pembelian');

	Route::post('/pembelian/rencana-pembelian/rencana-pembelian/edit-multiple', 'PembelianController@multiple_edit_rencana_pembelian');

	// End Rencana Pembelian

	// Konfirmasi Pembelian

	Route::get('/pembelian/konfirmasi-pembelian', 'PembelianController@konfirmasi_pembelian');

	Route::get('/pembelian/konfirmasi-pembelian/get-data-order/{id}', 'PembelianController@get_data_order');

	Route::get('/pembelian/konfirmasi-pembelian/download-pdf/{id}', 'PembelianController@downloadpdf');
	Route::get('/pembelian/konfirmasi-pembelian/generate-pdf/{id}', 'PembelianController@generatePDF');
	Route::get('/pembelian/konfirmasi-pembelian/print/{id}', 'PembelianController@print');

	// End Konfirmasi Pembelian

	// Purchase Order

	Route::get('/pembelian/purchase-order', 'PembelianController@purchase_order');

	Route::get('/pembelian/purchase-order/add', 'PembelianController@purchase_order_add');

	Route::get('/pembelian/purchase-order/get-purchase/{id}', 'PembelianController@get_purchase');

	Route::get('/pembelian/purchase-order/get-request-purchase/{id}', 'PembelianController@get_request_purchase');

	Route::post('/pembelian/purchase-order/add-purchase', 'PembelianController@add_purchase');

	Route::get('/pembelian/purchase-order/get/{id}', 'PembelianController@get_purchase_order');

	Route::get('/pembelian/purchase-order/edit', 'PembelianController@edit_purchase_order');

	Route::post('/pembelian/purchase-order/update', 'PembelianController@update_purchase_order');

	Route::post('/pembelian/purchase-order/edit-multiple', 'PembelianController@multiple_edit_purchase_order');

	Route::match(['get', 'post'], '/pembelian/purchase-order/multiple-delete', 'PembelianController@multiple_delete_purchase_order');

	Route::get('/pembelian/purchase-order/cetak', 'PembelianController@cetak_purchase');

	Route::get('/pembelian/purchase-order/get-purchase-data/{id}', 'PembelianController@get_purchase_data');

	Route::get('/pembelian/purchase-order/print/{id}', 'PembelianController@print_purchase');
	Route::get('/pembelian/purchase-order/purchase-pdf/{id}', 'PembelianController@viewpdf_purchase');
	Route::get('/pembelian/purchase-order/generate-pdf/{id}', 'PembelianController@pdf_purchase');

	// End Purchase Order

	// Return Barang

	Route::get('/pembelian/purchase-return', 'PembelianController@return_barang');

	Route::match(['get', 'post'], '/pembelian/purchase-return/add', 'PembelianController@return_barang_add');

	Route::get('/pembelian/show-purchase/{id}', 'PembelianController@show_purchase');

	Route::get('/pembelian/get-current-return/{id}', 'PembelianController@get_current_return');

	Route::get('/pembelian/purchase-return/edit', 'PembelianController@edit_purchase_return');

	Route::match(['get', 'post'], '/pembelian/purchase-return/update', 'PembelianController@update_purchase_return');

	Route::match(['get', 'post'], '/pembelian/purchase-return/edit-multiple', 'PembelianController@multiple_edit_purchase_return');

	Route::get('/pembelian/purchase-return/get-current-return/{id}', 'PembelianController@get_edit_return');

	Route::match(['get', 'post'], '/pembelian/purchase-return/multiple-delete', 'PembelianController@multiple_delete_purchase_return');

	// Route::get('/newprint', 'PembelianController@new_print');

	// End Return Barang

	// Pembelian end

	// Inventory
	// Penerimaan barang dari supplier
	Route::get('/inventory/penerimaan/supplier', 'inventory\ReceptionController@index_supplier');
	Route::match(['get', 'post'], '/inventory/penerimaan/supplier/add', 'inventory\ReceptionController@add_items_from_supplier');
	Route::get('/inventory/penerimaan/supplier/get-current-receipt/{id}', 'inventory\ReceptionController@get_current_receipt');
	Route::get('/inventory/penerimaan/supplier/edit', 'inventory\ReceptionController@edit');
	Route::match(['get', 'post'], '/inventory/penerimaan/supplier/edit-multiple', 'inventory\ReceptionController@multiple_edit_penerimaan_barang');
	Route::match(['get', 'post'], '/inventory/penerimaan/supplier/update', 'inventory\ReceptionController@update_penerimaan_barang');
	Route::match(['get', 'post'], '/inventory/penerimaan/supplier/multiple-delete', 'inventory\ReceptionController@multiple_delete_penerimaan');
	// End penerimaan barang dari supplier

	// Penerimaan barang dari pusat
	Route::get('/inventory/penerimaan/pusat', 'inventory\ReceptionController@index_pusat');
	Route::match(['get', 'post'], '/inventory/penerimaan/pusat/add', 'inventory\ReceptionController@add_items_from_pusat');
	Route::get('/inventory/penerimaan/pusat/get-current-receipt-pusat/{id}', 'inventory\ReceptionController@get_current_receipt_pusat');
	Route::get('/inventory/penerimaan/pusat/edit', 'inventory\ReceptionController@edit_barang_pusat');
	Route::match(['get', 'post'], '/inventory/penerimaan/pusat/edit-multiple', 'inventory\ReceptionController@multiple_edit_penerimaan_barang_pusat');
	Route::match(['get', 'post'], '/inventory/penerimaan/pusat/update', 'inventory\ReceptionController@update_penerimaan_barang_pusat');
	Route::match(['get', 'post'], '/inventory/penerimaan/pusat/multiple-delete', 'inventory\ReceptionController@multiple_delete_penerimaan_pusat');
	// End penerimaan barang dari pusat

	// Distribusi barang
	Route::get('/inventory/distribusi', 'inventory\DistribusiController@index_distribusi');
	Route::get('/inventory/distribusi/get-purchase/{id}', 'inventory\DistribusiController@show_purchase');
	Route::match(['get', 'post'], '/inventory/distribusi/print', 'inventory\DistribusiController@print');
	// End ditribusi barang
	// End Inventory

	// Setting Application

	// Akses Pengguna
	Route::get('/pengaturan/akses-pengguna', 'PengaturanController@akses_pengguna');
	Route::get('/pengaturan/akses-pengguna/edit/{id}', 'PengaturanController@edit_akses');
	Route::post('/pengaturan/akses-pengguna/simpan', 'PengaturanController@simpan');
	Route::match(['get', 'post'], '/pengaturan/akses-pengguna/dataUser', 'PengaturanController@dataUser');

	// End Akses Pengguna

	// Manajemen Pengguna
	Route::get('/pengaturan/kelola-pengguna/tambah', 'manajemenPenggunaController@tambah_pengguna');
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

	// End Setting Application

	// main route end
	// Route::get('/coba-print', 'PembelianController@coba_print');

});
