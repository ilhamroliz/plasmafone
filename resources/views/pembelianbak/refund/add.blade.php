@extends('main')

@section('title', 'Refund')

@section('extra_style')
    <style>
        .smart-form fieldset {
            padding: 10px 14px 5px;
        }
        .smart-form .btn-khusus {
            display: inline-block;
            margin-bottom: 0;
            font-weight: 400;
            text-align: center;
            vertical-align: middle;
            touch-action: manipulation;
            cursor: pointer;
            background-image: none;
            border: 1px solid transparent;
            white-space: nowrap;
            padding: 6px 12px;
            font-size: 13px;
            line-height: 1.42857143;
            border-radius: 2px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            float: right;
        }
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
                    <button class="btn btn-success" onclick="tambah()"><i class="fa fa-plus"></i>&nbsp;Tambah <Refund></Refund></button>
                @endif
            </div>

        </div>

        <section id="widget-grid" class="">

            <!-- row -->
            <div class="row">
                <div class="col-md-8">
                    <div class="jarviswidget" id="wid-id-0"
                         data-widget-colorbutton="false"
                         data-widget-editbutton="false"
                         data-widget-togglebutton="false"
                         data-widget-deletebutton="false"
                         data-widget-fullscreenbutton="false"
                         data-widget-custombutton="false"
                         data-widget-sortable="false">
                        <header role="heading"><div class="jarviswidget-ctrls" role="menu"><a href="javascript:void(0);" class="button-icon jarviswidget-toggle-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Collapse"><i class="fa fa-minus "></i></a> <a href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Fullscreen"><i class="fa fa-expand "></i></a> </div>
                            <h2><strong>Tambah Refund</strong></h2>
                        </header>
                        <div role="content">
                            <!-- widget content -->
                            <div class="widget-body padding-10">
                                <form id="form-tambah" class="smart-form form-horizontal">
                                    <section class="form-group">
                                        <div class="col-md-11">
                                            <label class="input"> <i class="icon-append fa fa-font"></i>
                                                <input type="text" name="username" id="namabarang" placeholder="Masukkan Nama/Kode Barang" style="text-transform: uppercase">
                                                <b class="tooltip tooltip-bottom-right">Masukkan Nama/Kode Barang</b>
                                            </label>
                                        </div>
                                        <div class="col-md-1">
                                            <button type="button" class="btn btn-primary btn-khusus" onclick="cari()"><i class="fa fa-search"></i></button>
                                        </div>
                                    </section>
                                    <section class="form-group baris-1" style="display: none">
                                        <div class="col col-6 padding-left-0">
                                            <label class="input"> <i class="icon-append fa fa-money"></i>
                                                <input type="text" name="username" id="namabarang" placeholder="Harga Baru" style="text-transform: uppercase">
                                                <b class="tooltip tooltip-bottom-right">Harga Baru</b>
                                            </label>
                                        </div>
                                        <div class="col col-6 padding-right-0">
                                            <label class="input"> <i class="icon-append fa fa-money"></i>
                                                <input type="text" name="username" id="namabarang" placeholder="Harga Terakhir" style="text-transform: uppercase">
                                                <b class="tooltip tooltip-bottom-right">Harga Terakhir</b>
                                            </label>
                                        </div>
                                    </section>
                                    <section class="form-group baris-1" style="display: none">
                                        <div class="col-md-12">
                                            <label class="input"> <i class="icon-append fa fa-barcode"></i>
                                                <input type="text" name="username" placeholder="Masukkan Kode Spesifik" style="text-transform: uppercase">
                                                <b class="tooltip tooltip-bottom-right">Masukkan Kode Spesifik</b>
                                            </label>
                                        </div>
                                    </section>
                                    <section class="form-group baris-1" style="display: none">
                                        <table class="table table-striped table-bordered table-hover" width="100%" id="listkode" style="cursor: pointer">
                                            <thead>
                                            <tr>
                                                <th style="width: 25%;">Posisi</th>
                                                <th style="width: 40%;">Kode Spesifik</th>
                                                <th style="width: 20%;">Harga</th>
                                                <th style="width: 15%;">Aksi</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </section>
                                </form>

                            </div>
                            <!-- end widget content -->

                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="jarviswidget" id="wid-id-0"
                         data-widget-colorbutton="false"
                         data-widget-editbutton="false"
                         data-widget-togglebutton="false"
                         data-widget-deletebutton="false"
                         data-widget-fullscreenbutton="false"
                         data-widget-custombutton="false"
                         data-widget-sortable="false">
                        <header role="heading"><div class="jarviswidget-ctrls" role="menu"><a href="javascript:void(0);" class="button-icon jarviswidget-toggle-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Collapse"><i class="fa fa-minus "></i></a> <a href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Fullscreen"><i class="fa fa-expand "></i></a> </div>
                            <h2><strong></strong></h2>
                        </header>
                        <div role="content">
                            <div class="widget-body no-padding">
                                <form id="form-tambah-supp" class="smart-form form-horizontal">
                                    <fieldset>
                                        <section>
                                            <label class="input"> <i class="icon-prepend fa fa-truck"></i>
                                                <input type="text" name="fname" placeholder="Supplier">
                                            </label>
                                        </section>
                                        <section>
                                            <label class="input"> <i class="icon-prepend fa fa-calendar"></i>
                                                <input type="text" name="fname" placeholder="Tanggal">
                                            </label>
                                        </section>
                                    </fieldset>
                                    <footer>
                                        <button type="button" class="btn btn-primary">
                                            Simpan
                                        </button>
                                        <button type="button" class="btn btn-default" onclick="window.history.back();">
                                            Batal
                                        </button>
                                    </footer>
                                </form>
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
        var kodespesifik = [];
        var tablekode;
        $(document).ready(function () {
            tablekode = $('#listkode').DataTable({
                "language" : dataTableLanguage,
                "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
                    "<'dt-toolbar-footer'<'col-xs-12 col-sm-12 pull-right'p>>",
                "preDrawCallback" : function() {
                    // Initialize the responsive datatables helper once.
                    if (!responsiveHelper_dt_basic) {
                        responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#listkode'), breakpointDefinition);
                    }
                },
                "rowCallback" : function(nRow) {
                    responsiveHelper_dt_basic.createExpandIcon(nRow);
                },
                "drawCallback" : function(oSettings) {
                    responsiveHelper_dt_basic.respond();
                }
            });
            $( "#namabarang" ).autocomplete({
                source: baseUrl+'/pembelian/refund/get-item',
                minLength: 1,
                select: function(event, data) {
                    setData(data);
                }
            });
        })

        function setData(data) {
            overlay();
            var id = data.item.id;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrl + '/pembelian/refund/get-data',
                type: 'get',
                data: {id: id},
                success: function(response){
                    console.log(response);
                    for (var i = 0; i < response.length; i++){
                        tablekode.row.add( [
                            response[i].posisi,
                            response[i].sd_specificcode,
                            convertToRupiah(response[i].sm_hpp.replace('.00', '')),
                            "<div class='text-center'><button type='button' class='btn btn-danger btn-xs'><i class='fa fa-minus'></i></button></div>",
                        ] ).draw(false);
                    }
                    out();
                }, error:function(x, e) {
                    out();
                    if (x.status == 0) {
                        alert('ups !! gagal menghubungi server, harap cek kembali koneksi internet anda');
                    } else if (x.status == 404) {
                        alert('ups !! Halaman yang diminta tidak dapat ditampilkan.');
                    } else if (x.status == 500) {
                        alert('ups !! Server sedang mengalami gangguan. harap coba lagi nanti');
                    } else if (e == 'parsererror') {
                        alert('Error.\nParsing JSON Request failed.');
                    } else if (e == 'timeout'){
                        alert('Request Time out. Harap coba lagi nanti');
                    } else {
                        alert('Unknow Error.\n' + x.responseText);
                    }
                }
            })
        }

        function cari() {
            $('.baris-1').show('slow');
        }

    </script>
@endsection
