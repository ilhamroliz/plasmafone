@extends('main')

@section('title', 'Master Outlet')

@section('extra_style')

@endsection

@section('ribbon')
    <!-- RIBBON -->
    <div id="ribbon">

		<span class="ribbon-button-alignment">
			<span id="refresh" class="btn btn-ribbon" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Refresh Halaman? Semua Perubahan Yang Belum Tersimpan Akan Hilang.." data-html="true" onclick="location.reload()">
				<i class="fa fa-refresh"></i>
			</span>
		</span>

        <!-- breadcrumb -->
        <ol class="breadcrumb">
            <li>Home</li><li>Penjualan</li><li>Penjualan Reguler</li>
        </ol>

    </div>
    <!-- END RIBBON -->
@endsection


@section('main_content')

    <!-- MAIN CONTENT -->
    <div id="content">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <h1 class="page-title txt-color-blueDark">
                    <i class="fa-fw fa fa-lg fa-handshake-o"></i>
                    Penjualan <span><i class="fa fa-angle-double-right"></i> Penjualan Reguler </span>
                </h1>
            </div>
        </div>
        <!-- widget grid -->
        <section id="widget-grid" class="">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="jarviswidget" id="wid-id-11" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
                        <header>
                            <h2><strong>Penjualan Reguler</strong></h2>
                        </header>
                        <div role="content">
                            <!-- widget content -->
                            <div class="widget-body">
                                <form class="form-horizontal">
                                    <fieldset>
                                        <div class="form-group">
                                            <div class="col-md-4">
                                                <div class="input-icon-left">
                                                    <i class="fa fa-user"></i>
                                                    <input class="form-control" placeholder="Masukkan Nama Pembeli" type="text">
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" class="btn btn-primary" title="Tambah Pembeli"><i class="fa fa-user-plus"></i></button>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <div class="input-icon-left">
                                                    <i class="fa fa-barcode"></i>
                                                    <input class="form-control" placeholder="Masukkan Nama Barang" type="text">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="input-icon-left">
                                                    <i class="fa fa-sort-numeric-asc"></i>
                                                    <input class="form-control" placeholder="Qty" type="text">
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i></button>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <table class="table table-responsive table-striped table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th>Nama Barang</th>
                                                        <th>Qty</th>
                                                        <th>Harga @</th>
                                                        <th>Diskon %</th>
                                                        <th>Diskon Rp</th>
                                                        <th>Total</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button class="btn btn-primary" type="submit">
                                                    <i class="fa fa-save"></i>
                                                    Simpan
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </form>

                            </div>
                            <!-- end widget content -->

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end widget grid -->

    </div>
    <!-- END MAIN CONTENT -->
@endsection

@section('extra_script')
<script>
    $(document).ready(function(){
        $('.togel').click();
    })
</script>
@endsection
