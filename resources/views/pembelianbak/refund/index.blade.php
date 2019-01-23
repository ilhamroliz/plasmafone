@extends('main')

@section('title', 'Refund')

@section('extra_style')
    <style>
    </style>
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
            <li>Home</li><li>Pembelian</li><li>Refund</li>
        </ol>

    </div>
    <!-- END RIBBON -->
@endsection

@section('main_content')
    <div id="content">

        <div class="row">

            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <h1 class="page-title txt-color-blueDark">
                    <i class="fa-fw fa fa-asterisk"></i>
                    Pembelian <span><i class="fa fa-angle-double-right"></i> Refund </span>
                </h1>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-align-right padding-top-10">
                @if(Plasma::checkAkses(6, 'insert') == true)
                    <a class="btn btn-success" type="button" href="{{ url('pembelian/refund/tambah') }}"><i class="fa fa-plus"></i>&nbsp;Tambah Refund</a>
                @endif
            </div>

        </div>

        <section id="widget-grid" class="">

            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="jarviswidget" id="wid-id-0"
                         data-widget-colorbutton="false"
                         data-widget-editbutton="false"
                         data-widget-togglebutton="false"
                         data-widget-deletebutton="false"
                         data-widget-fullscreenbutton="false"
                         data-widget-custombutton="false"
                         data-widget-sortable="false">
                        <header role="heading"><div class="jarviswidget-ctrls" role="menu"><a href="javascript:void(0);" class="button-icon jarviswidget-toggle-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Collapse"><i class="fa fa-minus "></i></a> <a href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Fullscreen"><i class="fa fa-expand "></i></a> </div>
                            <h2><strong>Refund</strong></h2>
                        </header>
                        <div role="content">
                            <div class="widget-body no-padding form-horizontal">
                                <div class="tab-content padding-10">
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <div>
                                                <div class="input-group input-daterange" id="date-range" style="">
                                                    <input type="text" class="form-control" id="tglAwal" name="tglAwal" placeholder="Start" >
                                                    <span class="input-group-addon bg-custom text-white b-0"></span>
                                                    <input type="text" class="form-control" id="tglAkhir" name="tglAkhir" placeholder="End">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <select class="select2" id="status">
                                                <option value="all">Semua</option>
                                                <option value="Y">Disetujui</option>
                                                <option value="P">Menunggu</option>
                                                <option value="N">Ditolak</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <select class="select2" id="supplier">
                                                <option value="Y">Semua Supplier</option>
                                                @foreach($supplier as $dataSup)
                                                    <option value="{{ $dataSup->s_id }}">{{ $dataSup->s_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" id="namaitem" placeholder="Masukan Nama Barang" style="text-transform: uppercase">
                                            <input type="hidden" class="form-control" id="item">
                                        </div>
                                        <div class="col-md-1">
                                            <button class="btn btn-primary" type="button"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <table class="table table-striped table-bordered table-hover" width="100%" id="historyrefund" style="cursor: pointer">
                                                <thead>
                                                <tr>
                                                    <th style="width: 15%;">Tanggal</th>
                                                    <th style="width: 15%;">Supplier</th>
                                                    <th style="width: 15%;">Nota</th>
                                                    <th style="width: 35%;">Barang</th>
                                                    <th style="width: 10%;">Status</th>
                                                    <th style="width: 10%;">Aksi</th>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </section>
    </div>
@endsection

@section('extra_script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#date-range').datepicker({
                autoclose: true,
                todayHighlight: true
            });
            $( "#namaitem" ).autocomplete({
                source: baseUrl+'/penjualan-reguler/cari-sales',
                minLength: 1,
                select: function(event, data) {
                    $("#salesman").val(data.item.id);
                    $("#cari-member").focus();
                }
            });
        })
    </script>
@endsection
