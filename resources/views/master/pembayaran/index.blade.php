@extends('main')

@section('title', 'Master Pembayaran')

@section('extra_style')
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('template_asset/css/MonthPicker.css') }}">
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
            <li>Home</li><li>Data Master</li><li>Master Pembayaran</li>
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
                    Data Master <span><i class="fa fa-angle-double-right"></i> Master Pembayaran </span>
                </h1>
            </div>

        </div>

        <section id="widget-grid" class="">

            <!-- row -->
            <div class="row">

                <!-- LIST GROUP MEMBER -->
                <div class="col-md-5">
                    <!-- Widget ID (each widget will need unique ID)-->
                    <div class="jarviswidget" id="wid-id-0"
                         data-widget-colorbutton="false"
                         data-widget-editbutton="false"
                         data-widget-togglebutton="false"
                         data-widget-deletebutton="false"
                         data-widget-fullscreenbutton="false"
                         data-widget-custombutton="false"
                         data-widget-sortable="false">

                        <header role="heading"><div class="jarviswidget-ctrls" role="menu">   <a href="javascript:void(0);" class="button-icon jarviswidget-toggle-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Collapse"><i class="fa fa-minus "></i></a> <a href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Fullscreen"><i class="fa fa-expand "></i></a> </div>
                            <ul id="widget-tab-1" class="nav nav-tabs pull-left">
                                <li class="active">
                                    <a data-toggle="tab" href="#hr1"> <i style="color: #739E73;" class="fa fa-lg fa-check-square"></i> <span class="hidden-mobile hidden-tablet"> Aktif </span> </a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#hr3"> <i style="color: #A90329;" class="fa fa-lg fa-minus-square"></i> <span class="hidden-mobile hidden-tablet"> Non Aktif </span></a>
                                </li>
                            </ul>
                            <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
                        </header>

                        <div role="content">
                            <div class="widget-body no-padding">
                                <div class="tab-content padding-10">
                                    <div class="tab-pane fade in active" id="hr1">
                                        @if(Plasma::checkAkses(50, 'insert') == true)
                                            <div class="form-group">
                                                <div style="text-align: right">
                                                    <button style="" class="btn btn-success text-center" data-toggle="modal" data-target="#tambah-pembayaran">
                                                        <i class="fa fa-plus"></i>&nbsp;&nbsp;Tambah
                                                    </button>
                                                </div>
                                            </div>
                                        @endif

                                        <table class="jenis-pembayaran table table-striped table-bordered table-hover" width="100%" style="cursor: pointer">
                                            <thead>
                                            <tr>
                                                <th class="text-center" >Jenis Pembayaran</th>
                                                <th class="text-center" >Aksi</th>
                                            </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>

                                    <div class="tab-pane fade" id="hr3">
                                        <table class="pembayaran-non table table-striped table-bordered table-hover" width="100%" style="cursor: pointer">
                                            <thead>
                                            <tr>
                                                <th class="text-center" >Jenis Pembayaran</th>
                                                <th class="text-center" >Aksi</th>
                                            </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end widget div -->
                    </div>
                    <!-- end widget -->
                </div>

                <div class="col-md-7">
                    <div class="jarviswidget" id="wid-id-0"
                         data-widget-colorbutton="false"
                         data-widget-editbutton="false"
                         data-widget-togglebutton="false"
                         data-widget-deletebutton="false"
                         data-widget-fullscreenbutton="false"
                         data-widget-custombutton="false"
                         data-widget-sortable="false">
                        <header role="heading"><div class="jarviswidget-ctrls" role="menu"><a href="javascript:void(0);" class="button-icon jarviswidget-toggle-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Collapse"><i class="fa fa-minus "></i></a> <a href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Fullscreen"><i class="fa fa-expand "></i></a> </div>
                            <h2><strong>Atur Pembayaran di Outlet</strong></h2>
                        </header>
                        <div role="content">
                            <div class="widget-body no-padding form-horizontal">
                                <div class="tab-content padding-10">
                                    <div class="form-group padding-10" >
                                        <label class="col-md-2 control-label" for="select-1">Outlet</label>
                                        <div class="col-md-10">
                                            <select class="select2" id="outlet" onchange="setOutlet()" name="outlet">
                                                <option value="semua">Semua Outlet</option>
                                                @foreach($outlet as $toko)
                                                    <option value="{{ $toko->c_id }}">{{ $toko->c_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade in active" id="hr1">
                                        <table id="outlet_payment" class="table table-striped table-bordered table-hover" width="100%">
                                            <thead>
                                                <tr>
                                                    <th width="40%">Outlet</th>
                                                    <th width="40%">Jenis Pembayaran</th>
                                                    <th class="text-center" width="20%">Aksi</th>
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
            <!-- end row -->

            <!-- Modal -->
            <div class="modal fade" id="tambah-pembayaran" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                &times;
                            </button>
                            <h4 class="modal-title" id="myModalLabel">Tambah Jenis Pembayaran</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <form id="tambahJenis" class="form-horizontal">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Nama</label>
                                        <div class="col-md-9 pull-left">
                                            <input style="text-transform: uppercase;" class="form-control" name="nama" placeholder="Nama Jenis Pembayaran" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Nomor</label>
                                        <div class="col-md-9 pull-left">
                                            <input style="text-transform: uppercase;" class="form-control" name="nomor" placeholder="Nomor Rekening" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Pemilik</label>
                                        <div class="col-md-9 pull-left">
                                            <input style="text-transform: uppercase;" class="form-control" name="alias" placeholder="Nama Pemilik Nomor" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Akun</label>
                                        <div class="col-md-9 pull-left">
                                            <select class="select2" id="akun" name="akun">
                                                <option selected>-- Pilih Akun -- </option>
                                                @foreach($akun as $data)
                                                    <option value="{{ $data->ak_id }}">{{ $data->ak_id }} - {{ $data->ak_nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                Batal
                            </button>
                            <button type="button" class="btn btn-primary" onclick="simpanPembayaran()">
                                Simpan
                            </button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <!-- Modal -->
            <div class="modal fade" id="detail-pembayaran" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                &times;
                            </button>
                            <h4 class="modal-title" id="myModalLabel">Detail Jenis Pembayaran</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <form id="detail" class="form-horizontal">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Nama</label>
                                        <div class="col-md-9 pull-left">
                                            <input style="text-transform: uppercase;" class="form-control detailnama" name="nama" placeholder="Nama Jenis Pembayaran" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Nomor</label>
                                        <div class="col-md-9 pull-left">
                                            <input style="text-transform: uppercase;" class="form-control detailnomor" name="nomor" placeholder="Nomor Rekening" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Pemilik</label>
                                        <div class="col-md-9 pull-left">
                                            <input style="text-transform: uppercase;" class="form-control detailpemilik" name="alias" placeholder="Nama Pemilik Nomor" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Akun</label>
                                        <div class="col-md-9 pull-left">
                                            <select class="select2" id="detailakun" name="akun">
                                                <option selected>-- Pilih Akun -- </option>
                                                @foreach($akun as $info)
                                                    <option value="{{ $info->ak_id }}">{{ $info->ak_id }} - {{ $info->ak_nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                Batal
                            </button>
                            <button type="button" class="btn btn-primary" onclick="updatePembayaran()">
                                Update
                            </button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <!-- Modal -->
            <div class="modal fade" id="add-pembayaran" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                &times;
                            </button>
                            <h4 class="modal-title" id="myModalLabel">Tambahkan Jenis Pembayaran ke Outlet</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <form id="form_add" class="form-horizontal">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Jenis</label>
                                        <div class="col-md-9 pull-left">
                                            <input readonly style="text-transform: uppercase;" class="form-control tambahpembayaran" name="jenis" placeholder="Nama Jenis Pembayaran" type="text">
                                            <input class="form-control idpembayaran" name="idJenis" type="hidden">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Outlet</label>
                                        <div class="col-md-9 pull-left">
                                            <select class="select2" id="toOutlet" name="outlet">
                                                @foreach($outlet as $toko)
                                                    <option value="{{ $toko->c_id }}">{{ $toko->c_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                Batal
                            </button>
                            <button type="button" class="btn btn-primary" onclick="addPaymentMethod()">
                                Tambahkan
                            </button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

        </section>
    </div>
@endsection

@section('extra_script')
    <script type="text/javascript">
        var pembayaran;
        var nonaktif;
        var idGlobal;
        var payment;
        $(document).ready(function () {
            setTimeout(function () {
                pembayaran = $('.jenis-pembayaran').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": "{{ url('/master/pembayaran/get-dataY') }}",
                    "columns":[
                        {"data": "p_detail"},
                        {"data": "aksi"}
                    ],
                    searching: false,
                    info: false,
                    "autoWidth" : true,
                    "language" : dataTableLanguage,
                    "sDom": "<'dt-toolbar'<'col-sm-12 col-xs-12 hidden-xs'l>r>"+"t"+
                        "<'dt-toolbar-footer'<'col-xs-12 col-sm-12 pull-right'p>>",
                    "preDrawCallback" : function() {
                        // Initialize the responsive datatables helper once.
                        if (!responsiveHelper_dt_basic) {
                            responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('.jenis-pembayaran'), breakpointDefinition);
                        }
                    },
                    "rowCallback" : function(nRow) {
                        responsiveHelper_dt_basic.createExpandIcon(nRow);
                    },
                    "drawCallback" : function(oSettings) {
                        responsiveHelper_dt_basic.respond();
                    }
                });
            }, 500);

            setTimeout(function () {
                payment = $('#outlet_payment').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": "{{ url('master/pembayaran/get-outlet-payment') }}",
                        "type": "get",
                        "data": {"outlet": "semua"}
                    },
                    "columns":[
                        {"data": "c_name"},
                        {"data": "p_detail"},
                        {"data": "aksi"}
                    ],
                    "autoWidth" : true,
                    "language" : dataTableLanguage,
                    "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
                        "<'dt-toolbar-footer'<'col-xs-12 col-sm-12 pull-right'p>>",
                    "preDrawCallback" : function() {
                        // Initialize the responsive datatables helper once.
                        if (!responsiveHelper_dt_basic) {
                            responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('.jenis-pembayaran'), breakpointDefinition);
                        }
                    },
                    "rowCallback" : function(nRow) {
                        responsiveHelper_dt_basic.createExpandIcon(nRow);
                    },
                    "drawCallback" : function(oSettings) {
                        responsiveHelper_dt_basic.respond();
                    }
                });
            }, 1000);
        })

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var target = $(e.target).attr("href") // activated tab
            if (target == '#hr1'){
                if ( $.fn.DataTable.isDataTable( '.jenis-pembayaran' ) ) {
                    pembayaran.destroy();
                }
                pembayaran = $('.jenis-pembayaran').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": "{{ url('/master/pembayaran/get-dataY') }}",
                    "columns":[
                        {"data": "p_detail"},
                        {"data": "aksi"}
                    ],
                    searching: false,
                    info: false,
                    "autoWidth" : true,
                    "language" : dataTableLanguage,
                    "sDom": "<'dt-toolbar'<'col-sm-12 col-xs-12 hidden-xs'l>r>"+"t"+
                        "<'dt-toolbar-footer'<'col-xs-12 col-sm-12 pull-right'p>>",
                    "preDrawCallback" : function() {
                        // Initialize the responsive datatables helper once.
                        if (!responsiveHelper_dt_basic) {
                            responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('.jenis-pembayaran'), breakpointDefinition);
                        }
                    },
                    "rowCallback" : function(nRow) {
                        responsiveHelper_dt_basic.createExpandIcon(nRow);
                    },
                    "drawCallback" : function(oSettings) {
                        responsiveHelper_dt_basic.respond();
                    }
                });
            } else if (target == '#hr3'){
                if ( $.fn.DataTable.isDataTable( '.pembayaran-non' ) ) {
                    nonaktif.destroy();
                }
                nonaktif = $('.pembayaran-non').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": "{{ url('/master/pembayaran/get-dataN') }}",
                    "columns":[
                        {"data": "p_detail"},
                        {"data": "aksi"}
                    ],
                    searching: false,
                    info: false,
                    "autoWidth" : true,
                    "language" : dataTableLanguage,
                    "sDom": "<'dt-toolbar'<'col-sm-12 col-xs-12 hidden-xs'l>r>"+"t"+
                        "<'dt-toolbar-footer'<'col-xs-12 col-sm-12 pull-right'p>>",
                    "preDrawCallback" : function() {
                        // Initialize the responsive datatables helper once.
                        if (!responsiveHelper_dt_basic) {
                            responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('.pembayaran-non'), breakpointDefinition);
                        }
                    },
                    "rowCallback" : function(nRow) {
                        responsiveHelper_dt_basic.createExpandIcon(nRow);
                    },
                    "drawCallback" : function(oSettings) {
                        responsiveHelper_dt_basic.respond();
                    }
                });
            }
        });

        function simpanPembayaran() {
            $('#overlay').fadeIn(200);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrl + '/master/pembayaran/simpan',
                type: 'post',
                data: $('#tambahJenis').serialize(),
                success: function(response){
                    if (response.status == "sukses") {
                        $.smallBox({
                            title : "Berhasil",
                            content : 'Data berhasil disimpan...!',
                            color : "#739E73",
                            timeout: 5000,
                            icon : "fa fa-check bounce animated"
                        });
                        $('#overlay').fadeOut(200);
                        $('#tambah-pembayaran').modal('hide');
                        pembayaran.ajax.reload();
                    } else if (response.status == "gagal") {
                        $.smallBox({
                            title : "Gagal",
                            content : "Upsss. Terjadi kesalahan",
                            color : "#A90329",
                            timeout: 5000,
                            icon : "fa fa-times bounce animated"
                        });
                        $('#overlay').fadeOut(200);
                    }
                }, error:function(x, e) {
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

        function detail(id) {
            idGlobal = id;
            $('#overlay').fadeIn(200);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrl + '/master/pembayaran/get-detail',
                type: 'get',
                data: {id: id},
                success: function(response){
                    var data = response.data;
                    $('.detailnama').val(data.p_detail);
                    $('.detailnomor').val(data.p_no);
                    $('.detailpemilik').val(data.p_name);
                    $('#detailakun').val(data.p_akun);
                    $('#detailakun').trigger('change');
                    $('#overlay').fadeOut(200);
                }, error:function(x, e) {
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

        function nonaktifkan(id) {
            $.SmartMessageBox({
                title : "Apakah anda yakin ?",
                content : "Jenis pembayaran akan dinonaktifkan",
                buttons : '[No][Yes]'
            }, function(ButtonPressed) {
                if (ButtonPressed === "Yes") {
                    $('#overlay').fadeIn(200);
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: baseUrl + '/master/pembayaran/nonaktif',
                        type: 'get',
                        data: {id: id},
                        success: function(response){
                            if (response.status == "sukses") {
                                $.smallBox({
                                    title : "Berhasil",
                                    content : 'Jenis pembayaran berhasil dinonaktifkan...!',
                                    color : "#739E73",
                                    timeout: 5000,
                                    icon : "fa fa-check bounce animated"
                                });
                                pembayaran.ajax.reload();
                            } else if (response.status == "gagal") {
                                $.smallBox({
                                    title : "Gagal",
                                    content : "Upsss. Terjadi kesalahan",
                                    color : "#A90329",
                                    timeout: 5000,
                                    icon : "fa fa-times bounce animated"
                                });
                            }
                            $('#overlay').fadeOut(200);
                        }, error:function(x, e) {
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
                if (ButtonPressed === "No") {
                    $.smallBox({
                        title : "Dibatalkan",
                        content : "<i class='fa fa-clock-o'></i> <i>Jenis pembayran batal dinonaktifkan</i>",
                        color : "#C46A69",
                        iconSmall : "fa fa-times fa-2x fadeInRight animated",
                        timeout : 4000
                    });
                }

            });
            e.preventDefault();
        }

        function tambahkan(id, nama) {
            $('.idpembayaran').val(id);
            $('.tambahpembayaran').val(nama);
        }

        function updatePembayaran() {
            $('#overlay').fadeIn(200);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrl + '/master/pembayaran/update',
                type: 'get',
                data: $('#detail').serialize()+'&id='+idGlobal,
                success: function(response){
                    if (response.status == "sukses") {
                        $.smallBox({
                            title : "Berhasil",
                            content : 'Data berhasil diperbarui...!',
                            color : "#739E73",
                            timeout: 5000,
                            icon : "fa fa-check bounce animated"
                        });
                        $('#overlay').fadeOut(200);
                        $('#detail-pembayaran').modal('hide');
                        pembayaran.ajax.reload();
                        nonaktif.ajax.reload();
                    } else if (response.status == "gagal") {
                        $.smallBox({
                            title : "Gagal",
                            content : "Upsss. Terjadi kesalahan",
                            color : "#A90329",
                            timeout: 5000,
                            icon : "fa fa-times bounce animated"
                        });
                        $('#overlay').fadeOut(200);
                    }
                }, error:function(x, e) {
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

        function aktifkan(id) {
            $('#overlay').fadeIn(200);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrl + '/master/pembayaran/aktifkan',
                type: 'get',
                data: {id: id},
                success: function(response){
                    if (response.status == "sukses") {
                        $.smallBox({
                            title : "Berhasil",
                            content : 'Jenis pembayaran berhasil diaktifkan...!',
                            color : "#739E73",
                            timeout: 5000,
                            icon : "fa fa-check bounce animated"
                        });
                        nonaktif.ajax.reload();
                    } else if (response.status == "gagal") {
                        $.smallBox({
                            title : "Gagal",
                            content : "Upsss. Terjadi kesalahan",
                            color : "#A90329",
                            timeout: 5000,
                            icon : "fa fa-times bounce animated"
                        });
                    }
                    $('#overlay').fadeOut(200);
                }, error:function(x, e) {
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

        function setOutlet() {
            var outlet = $('#outlet').val();
            if ( $.fn.DataTable.isDataTable( '#outlet_payment' ) ) {
                payment.destroy();
            }
            payment = $('#outlet_payment').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ url('master/pembayaran/get-outlet-payment') }}",
                    "type": "get",
                    "data": {"outlet": outlet}
                },
                "columns":[
                    {"data": "c_name"},
                    {"data": "p_detail"},
                    {"data": "aksi"}
                ],
                "autoWidth" : true,
                "language" : dataTableLanguage,
                "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
                    "<'dt-toolbar-footer'<'col-xs-12 col-sm-12 pull-right'p>>",
                "preDrawCallback" : function() {
                    // Initialize the responsive datatables helper once.
                    if (!responsiveHelper_dt_basic) {
                        responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('.jenis-pembayaran'), breakpointDefinition);
                    }
                },
                "rowCallback" : function(nRow) {
                    responsiveHelper_dt_basic.createExpandIcon(nRow);
                },
                "drawCallback" : function(oSettings) {
                    responsiveHelper_dt_basic.respond();
                }
            });
        }

        function addPaymentMethod() {
            $('#overlay').fadeIn(200);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrl + '/master/pembayaran/simpan-payment',
                type: 'post',
                data: $('#form_add').serialize(),
                success: function(response){
                    if (response.status == "sukses") {
                        $.smallBox({
                            title : "Berhasil",
                            content : 'Data berhasil disimpan...!',
                            color : "#739E73",
                            timeout: 5000,
                            icon : "fa fa-check bounce animated"
                        });
                        $('#overlay').fadeOut(200);
                        $('#add-pembayaran').modal('hide');
                        payment.ajax.reload();
                    } else if (response.status == "gagal") {
                        $.smallBox({
                            title : "Gagal",
                            content : "Upsss. Terjadi kesalahan",
                            color : "#A90329",
                            timeout: 5000,
                            icon : "fa fa-times bounce animated"
                        });
                        $('#overlay').fadeOut(200);
                    } else if (response.status == "sudah") {
                        $.smallBox({
                            title : "Sudah ada",
                            content : "Data sudah ada",
                            color : "#C79121",
                            timeout: 5000,
                            icon : "fa fa-times bounce animated"
                        });
                        $('#overlay').fadeOut(200);
                    }
                }, error:function(x, e) {
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

        function hapusPayment(id) {
            $.SmartMessageBox({
                title : "Apakah anda yakin ?",
                content : "Jenis pembayaran di outlet akan dihapus",
                buttons : '[No][Yes]'
            }, function(ButtonPressed) {
                if (ButtonPressed === "Yes") {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: baseUrl + '/master/pembayaran/delete-payment',
                        type: 'post',
                        data: {'id': id},
                        success: function(response){
                            if (response.status == "sukses") {
                                $.smallBox({
                                    title : "Berhasil",
                                    content : 'Data berhasil dihapus...!',
                                    color : "#739E73",
                                    timeout: 5000,
                                    icon : "fa fa-check bounce animated"
                                });
                                $('#overlay').fadeOut(200);
                                payment.ajax.reload();
                            } else if (response.status == "gagal") {
                                $.smallBox({
                                    title : "Gagal",
                                    content : "Upsss. Terjadi kesalahan",
                                    color : "#A90329",
                                    timeout: 5000,
                                    icon : "fa fa-times bounce animated"
                                });
                                $('#overlay').fadeOut(200);
                            }
                        }, error:function(x, e) {
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
                if (ButtonPressed === "No") {
                    $.smallBox({
                        title: "Dibatalkan",
                        content: "<i class='fa fa-clock-o'></i> <i>Jenis pembayran batal dihapus</i>",
                        color: "#C46A69",
                        iconSmall: "fa fa-times fa-2x fadeInRight animated",
                        timeout: 4000
                    });
                }
            });
            e.preventDefault();
        }
    </script>
@endsection
