@extends('main')

@section('title', 'Master Outlet')

@section('extra_style')

@endsection

<?php
use App\Http\Controllers\PlasmafoneController as Plasma;
?>

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
            <li>Home</li><li>Penjualan</li><li>Setting Harga</li>
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
        <!-- row -->
            <div class="row">

            </div>
            <!-- End Tabel Item for @ GROUP MEMBER -->
            <!-- end row -->

        </section>
        <!-- end widget grid -->

    </div>
    <!-- END MAIN CONTENT -->
@endsection

@section('extra_script')

@endsection
