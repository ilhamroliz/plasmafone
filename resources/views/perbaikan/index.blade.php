@extends('main')

@section('title', 'Perbaikan Barang')

@section('extra_style')
    <style type="text/css">

    </style>
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
            <li>Home</li><li>Layanan Perbaikan</li><li>Perbaikan Barang</li>
        </ol>
        <!-- end breadcrumb -->
    </div>
    <!-- END RIBBON -->
@endsection


@section('main_content')

    <!-- MAIN CONTENT -->
    <div id="content">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <h1 class="page-title txt-color-blueDark">
                    <i class="fa fa-lg fa-fw fa-wrench"></i>
                    Layanan Perbaikan <span><i class="fa fa-angle-double-right"></i> Perbaikan Barang </span>
                </h1>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT -->
@endsection

@section('extra_script')

@endsection
