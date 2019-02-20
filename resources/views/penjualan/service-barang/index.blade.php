@extends('main')

@section('title', 'Service Barang')

@section('extra_style')
    <style type="text/css">

    </style>
@endsection


@section('ribbon')
    <!-- RIBBON -->
    <div id="ribbon">
		<span class="ribbon-button-alignment">
			<span id="refresh" class="btn btn-ribbon" data-title="refresh" rel="tooltip" data-placement="bottom"
                  data-original-title="<i class='text-warning fa fa-warning'></i> Refresh Halaman? Semua Perubahan Yang Belum Tersimpan Akan Hilang.."
                  data-html="true" onclick="location.reload()">
				<i class="fa fa-refresh"></i>
			</span>
		</span>

        <!-- breadcrumb -->
        <ol class="breadcrumb">
            <li>Home</li>
            <li>Penjualan</li>
            <li>Service Barang</li>
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
                    <i class="fa-fw fa fa-handshake-o"></i>
                    Penjualan <span><i class="fa fa-angle-double-right"></i> Service Barang </span>
                </h1>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-align-right padding-top-10">
                @if(Access::checkAkses(21, 'insert') == true)
                    <a class="btn btn-success" type="button" href="{{ route('service-add') }}"><i class="fa fa-plus"></i>&nbsp;Tambah Data</a>
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
                            <h2><strong>Cari Daftar Service Barang</strong></h2>
                        </header>
                        <div role="content">
                            <div class="widget-body">
                                <form class="form-horizontal" id="form_return">
                                    <fieldset>
                                        <div class="row">
                                            <article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

                                                <div class="form-group">
                                                    <label class="col-md-3 control-label text-left">Nota Service</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group input-group-md">
                                                            <span class="input-group-addon"><i class="glyphicon glyphicon-book"></i></span>
                                                            <div class="icon-addon addon-md">
                                                                <input class="form-control" id="nota" name="nota" placeholder="Masukkan Nota Service" type="text"  style="text-transform: uppercase">
                                                                <label for="nota" class="glyphicon glyphicon-search" rel="tooltip" title="Nota Service"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-3 control-label text-left">Tanggal</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group input-daterange" id="date-range">
                                                            <input type="text" class="form-control" id="tgl_awal" name="tgl_awal"  placeholder="Tanggal Awal">
                                                            <span class="input-group-addon bg-custom text-white b-0">to</span>
                                                            <input type="text" class="form-control" id="tgl_akhir" name="tgl_akhir"  placeholder="Tanggal Akhir">
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    </fieldset>
                                    <div class="form-action">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <button class="btn btn-primary pull-right" id="btn_search"><i class="fa fa-search"></i> Cari</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </section>

        <section id="widget-grid" class="">
            <!-- row -->
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="jarviswidget" id="wid-id-11" data-widget-editbutton="false"
                         data-widget-colorbutton="false" data-widget-deletebutton="false">
                        <header>
                            <ul id="widget-tab-1" class="nav nav-tabs pull-left">
                                <li class="active">
                                    <a data-toggle="tab" href="#hr1"> <i style="color: #3276B1;" class="fa fa-lg fa-list"></i>
                                        <span class="hidden-mobile hidden-tablet"> Daftar Service Barang </span>
                                    </a>
                                </li>
                                {{--<li>--}}
                                    {{--<a data-toggle="tab" href="#hr2"> <i style="color: #A90329;" class="fa fa-lg fa-remove"></i>--}}
                                        {{--<span class="hidden-mobile hidden-tablet"> Tolak </span>--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                    {{--<a data-toggle="tab" href="#hr3"> <i style="color: #3276B1;" class="fa fa-lg fa-rotate-right fa-spin"></i>--}}
                                        {{--<span class="hidden-mobile hidden-tablet"> Proses </span>--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                    {{--<a data-toggle="tab" href="#hr4"> <i style="color: #739E73;" class="fa fa-lg fa-check"></i>--}}
                                        {{--<span class="hidden-mobile hidden-tablet"> Selesai </span>--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                            </ul>
                        </header>
                        <!-- widget div-->
                        <div>
                            <!-- widget content -->
                            <div class="widget-body no-padding">
                                <!-- widget body text-->
                                <div class="tab-content padding-10">
                                    <div class="tab-pane fade in active" id="hr1">
                                        <table id="dt_table" class="table table-striped table-bordered table-hover" width="100%">
                                            <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Nota Service</th>
                                                <th>Pelanggan</th>
                                                <th>Posisi Barang</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                    {{--<div class="tab-pane fade in active" id="hr1">--}}
                                        {{--<table id="dt_pending" class="table table-striped table-bordered table-hover" width="100%">--}}
                                            {{--<thead>--}}
                                                {{--<tr>--}}
                                                    {{--<th>Tanggal</th>--}}
                                                    {{--<th>Nama Barang</th>--}}
                                                    {{--<th>Pelanggan</th>--}}
                                                    {{--<th>Posisi Barang</th>--}}
                                                    {{--<th>Aksi</th>--}}
                                                {{--</tr>--}}
                                            {{--</thead>--}}
                                            {{--<tbody></tbody>--}}
                                        {{--</table>--}}
                                    {{--</div>--}}
                                    {{--<div class="tab-pane fade" id="hr2">--}}
                                        {{--<table id="dt_tolak" class="table table-striped table-bordered table-hover" width="100%">--}}
                                            {{--<thead>--}}
                                                {{--<tr>--}}
                                                    {{--<th>Tanggal</th>--}}
                                                    {{--<th>Nota</th>--}}
                                                    {{--<th>Pelanggan</th>--}}
                                                    {{--<th>Aksi</th>--}}
                                                {{--</tr>--}}
                                            {{--</thead>--}}
                                            {{--<tbody></tbody>--}}
                                        {{--</table>--}}
                                    {{--</div>--}}
                                    {{--<div class="tab-pane fade" id="hr3">--}}
                                        {{--<table id="dt_proses" class="table table-striped table-bordered table-hover" width="100%">--}}
                                            {{--<thead>--}}
                                                {{--<tr>--}}
                                                    {{--<th>Tanggal</th>--}}
                                                    {{--<th>Nota</th>--}}
                                                    {{--<th>Pelanggan</th>--}}
                                                    {{--<th>Aksi</th>--}}
                                                {{--</tr>--}}
                                            {{--</thead>--}}
                                            {{--<tbody></tbody>--}}
                                        {{--</table>--}}
                                    {{--</div>--}}
                                    {{--<div class="tab-pane fade" id="hr4">--}}
                                        {{--<table id="dt_selesai" class="table table-striped table-bordered table-hover" width="100%">--}}
                                            {{--<thead>--}}
                                                {{--<tr>--}}
                                                    {{--<th>Tanggal</th>--}}
                                                    {{--<th>Nota</th>--}}
                                                    {{--<th>Pelanggan</th>--}}
                                                    {{--<th>Aksi</th>--}}
                                                {{--</tr>--}}
                                            {{--</thead>--}}
                                            {{--<tbody></tbody>--}}
                                        {{--</table>--}}
                                    {{--</div>--}}
                                </div>
                                <!-- end widget body text-->

                                <!-- widget footer -->
                                <div class="widget-footer text-right">
                                </div>
                                <!-- end widget footer -->
                            </div>
                            <!-- end widget content -->
                        </div>
                        <!-- end widget div -->
                    </div>
                </div>
            </div>
            <!-- end row -->
        </section>

        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">

            <div class="modal-dialog">

                <div class="modal-content">

                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            &times;
                        </button>

                        <h4 class="modal-title" id="myModalLabel">Detail</h4>

                    </div>

                    <div class="modal-body">

                        <div class="row">

                            <!-- Widget ID (each widget will need unique ID)-->
                            <div class="jarviswidget jarviswidget-color-greenLight" id="wid-id-3"
                                 data-widget-editbutton="false" data-widget-colorbutton="false"
                                 data-widget-deletebutton="false">

                                <header>

                                    <span class="widget-icon"> <i class="fa fa-table"></i> </span>

                                    <h2 id="title_detail"></h2>

                                </header>

                                <!-- widget div-->
                                <div>

                                    <!-- widget content -->
                                    <div class="widget-body no-padding">

                                        <div class="table-responsive">

                                            <table class="table">

                                                <tbody>

                                                    <tr>
                                                        <td><strong>Posisi</strong></td>
                                                        <td><strong>:</strong></td>
                                                        <td id="dt_posisi"></td>
                                                    </tr>

                                                    <tr>
                                                        <td><strong>Tanggal</strong></td>
                                                        <td><strong>:</strong></td>
                                                        <td id="dt_tanggal"></td>
                                                    </tr>

                                                    <tr>
                                                        <td><strong>Nota Service</strong></td>
                                                        <td><strong>:</strong></td>
                                                        <td id="dt_notaservice"></td>
                                                    </tr>

                                                    <tr>
                                                        <td><strong>Nota Penjualan</strong></td>
                                                        <td><strong>:</strong></td>
                                                        <td id="dt_notapenjualan"></td>
                                                    </tr>

                                                    <tr>
                                                        <td><strong>Pelanggan</strong></td>
                                                        <td><strong>:</strong></td>
                                                        <td id="dt_pelanggan"></td>
                                                    </tr>

                                                    <tr>
                                                        <td><strong>Status</strong></td>
                                                        <td><strong>:</strong></td>
                                                        <td id="dt_status"></td>
                                                    </tr>

                                                    <tr>
                                                        <td><strong>Petugas</strong></td>
                                                        <td><strong>:</strong></td>
                                                        <td id="dt_petugas"></td>
                                                    </tr>

                                                </tbody>

                                            </table>

                                            <table class="table table-bordered" id="table_item_service">
                                                <thead>
                                                <tr>
                                                    <td>Item</td>
                                                    <td class="text-center">Qty</td>
                                                    <td>Keterangan</td>
                                                </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>

                                        </div>

                                    </div>
                                    <!-- end widget content -->

                                </div>
                                <!-- end widget div -->

                            </div>
                            <!-- end widget -->
                        </div>

                    </div>

                </div><!-- /.modal-content -->

            </div><!-- /.modal-dialog -->

        </div>
        <!-- /.modal -->

    </div>
    <!-- END MAIN CONTENT -->
@endsection

@section('extra_script')

    <script type="text/javascript">
        var tabel;
        // var pending, tolak, proses, done;
        $(document).ready(function () {
            var responsiveHelper_dt_basic = undefined;
            var breakpointDefinition = {
                tablet: 1024,
                phone: 480
            };

            $( "#date-range" ).datepicker({
                language: "id",
                format: 'dd-mm-yyyy',
                prevText: '<i class="fa fa-chevron-left"></i>',
                nextText: '<i class="fa fa-chevron-right"></i>',
                autoclose: true,
                todayHighlight: true
            });

            $("#btn_search").on("click", function (evt) {
                evt.preventDefault();
                if (
                    $("#nota").val() == "" &&
                    $("#tgl_awal").val() == "" &&
                    $("#tgl_akhir").val() == ""
                ) {
                    $.smallBox({
                        title : "Pesan!",
                        content : "Tambahkan parameter untuk melakukan pencarian!",
                        color : "#A90329",
                        timeout: 5000,
                        icon : "fa fa-times bounce animated"
                    });
                } else {
                    getNota();
                }
            })

            function getNota() {
                // console.log(id);
                $('#overlay').fadeIn(200);

                if ( $.fn.DataTable.isDataTable('#dt_table') ) {
                    $('#dt_table').DataTable().destroy();
                }

                $('#dt_table').dataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": "{{ url('/penjualan/service-barang/cari-data-service?') }}"+$("#form_return").serialize(),
                    "columns":[
                        {"data": "tanggal"},
                        {"data": "nota"},
                        {"data": "pelanggan"},
                        {"data": "posisi"},
                        {"data": "status"},
                        {"data": "aksi"}
                    ],
                    "autoWidth" : true,
                    "language" : dataTableLanguage,
                    "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
                        "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6 pull-right'p>>",
                    "preDrawCallback" : function() {
                        // Initialize the responsive datatables helper once.
                        if (!responsiveHelper_dt_basic) {
                            responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_table'), breakpointDefinition);
                        }
                    },
                    "rowCallback" : function(nRow) {
                        responsiveHelper_dt_basic.createExpandIcon(nRow);
                    },
                    "drawCallback" : function(oSettings) {
                        responsiveHelper_dt_basic.respond();
                        $('#overlay').fadeOut(200);
                    }
                });
            }

            setTimeout(function () {

                tabel = $('#dt_table').dataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": "{{ route('get-data-service') }}",
                    "columns": [
                        {"data": "tanggal"},
                        {"data": "nota"},
                        {"data": "pelanggan"},
                        {"data": "posisi"},
                        {"data": "status"},
                        {"data": "aksi"}
                    ],
                    "autoWidth": true,
                    "language": dataTableLanguage,
                    "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>" + "t" +
                        "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6 pull-right'p>>",
                    "preDrawCallback": function () {
                        // Initialize the responsive datatables helper once.
                        if (!responsiveHelper_dt_basic) {
                            responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_table'), breakpointDefinition);
                        }
                    },
                    "rowCallback": function (nRow) {
                        responsiveHelper_dt_basic.createExpandIcon(nRow);
                    },
                    "drawCallback": function (oSettings) {
                        responsiveHelper_dt_basic.respond();
                    }
                });

            }, 100);

            /*
            setTimeout(function () {

                pending = $('#dt_pending').dataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": "",
                    "columns": [
                        {"data": "tanggal"},
                        {"data": "nota"},
                        {"data": "pelanggan"},
                        {"data": "aksi"}
                    ],
                    "autoWidth": true,
                    "language": dataTableLanguage,
                    "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>" + "t" +
                        "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6 pull-right'p>>",
                    "preDrawCallback": function () {
                        // Initialize the responsive datatables helper once.
                        if (!responsiveHelper_dt_basic) {
                            responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_pending'), breakpointDefinition);
                        }
                    },
                    "rowCallback": function (nRow) {
                        responsiveHelper_dt_basic.createExpandIcon(nRow);
                    },
                    "drawCallback": function (oSettings) {
                        responsiveHelper_dt_basic.respond();
                    }
                });

            }, 10);

            setTimeout(function () {

                tolak = $('#dt_tolak').dataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": "",
                    "columns": [
                        {"data": "tanggal"},
                        {"data": "nota"},
                        {"data": "pelanggan"},
                        {"data": "aksi"}
                    ],
                    "autoWidth": true,
                    "language": dataTableLanguage,
                    "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>" + "t" +
                        "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6 pull-right'p>>",
                    "preDrawCallback": function () {
                        // Initialize the responsive datatables helper once.
                        if (!responsiveHelper_dt_basic) {
                            responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_tolak'), breakpointDefinition);
                        }
                    },
                    "rowCallback": function (nRow) {
                        responsiveHelper_dt_basic.createExpandIcon(nRow);
                    },
                    "drawCallback": function (oSettings) {
                        responsiveHelper_dt_basic.respond();
                    }
                });

            }, 100);

            setTimeout(function () {

                proses = $('#dt_proses').dataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": "",
                    "columns": [
                        {"data": "tanggal"},
                        {"data": "nota"},
                        {"data": "pelanggan"},
                        {"data": "aksi"}
                    ],
                    "autoWidth": true,
                    "language": dataTableLanguage,
                    "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>" + "t" +
                        "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6 pull-right'p>>",
                    "preDrawCallback": function () {
                        // Initialize the responsive datatables helper once.
                        if (!responsiveHelper_dt_basic) {
                            responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_proses'), breakpointDefinition);
                        }
                    },
                    "rowCallback": function (nRow) {
                        responsiveHelper_dt_basic.createExpandIcon(nRow);
                    },
                    "drawCallback": function (oSettings) {
                        responsiveHelper_dt_basic.respond();
                    }
                });

            }, 1000);

            setTimeout(function () {

                done = $('#dt_selesai').dataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": "",
                    "columns": [
                        {"data": "tanggal"},
                        {"data": "nota"},
                        {"data": "pelanggan"},
                        {"data": "aksi"}
                    ],
                    "autoWidth": true,
                    "language": dataTableLanguage,
                    "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>" + "t" +
                        "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6 pull-right'p>>",
                    "preDrawCallback": function () {
                        // Initialize the responsive datatables helper once.
                        if (!responsiveHelper_dt_basic) {
                            responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_selesai'), breakpointDefinition);
                        }
                    },
                    "rowCallback": function (nRow) {
                        responsiveHelper_dt_basic.createExpandIcon(nRow);
                    },
                    "drawCallback": function (oSettings) {
                        responsiveHelper_dt_basic.respond();
                    }
                });

            }, 1500);
            */
        })

        function detail(id) {
            $('#overlay').fadeIn(200);
            $('#load-status-text').text('Sedang Mengambil data...');

            axios.get(baseUrl + '/penjualan/service-barang/get-detail-service/' + id).then(response => {

                if (response.data == 'Not Found') {

                    $('#overlay').fadeOut(200);
                    $.smallBox({
                        title: "Gagal",
                        content: "Upsss. Data tidak ditemukan...!",
                        color: "#A90329",
                        timeout: 5000,
                        icon: "fa fa-times bounce animated"
                    });

                } else {
                    var row = '';
                    var posisi = '';
                    $('.tr').remove();
                    $('#title_detail').html('<strong>Detail Service Barang</strong>');
                    if (response.data[0].shipping_status == "On Outlet") {
                        posisi = response.data[0].position;
                    } else if (response.data[0].shipping_status == "Delivery to Center") {
                        posisi = 'Sedang Dikirim ke Pusat';
                    } else if (response.data[0].shipping_status == "Delivery to Outlet") {
                        posisi = 'Sedang Dikirim ke Outlet';
                    } else if (response.data[0].shipping_status == "On Center") {
                        posisi = response.data[0].position;
                    }
                    $('#dt_posisi').text(posisi);
                    $('#dt_tanggal').text(response.data[0].date);
                    $('#dt_notaservice').text(response.data[0].nota_service);
                    $('#dt_notapenjualan').text(response.data[0].nota_sales);
                    $('#dt_pelanggan').text(response.data[0].buyer);
                    $('#dt_status').text(response.data[0].status);
                    $('#dt_petugas').text(response.data[0].officer);

                    response.data.forEach(function (element) {
                        if (element.code != "") {
                            row = '<tr class="tr"><td>' + element.code + ' - ' + element.item + '</td><td align="center">' + element.qty + '</td><td>' + element.note + '</td></tr>'
                        } else {
                            row = '<tr class="tr"><td>' + element.item + ' (' + element.specificcode + ')' + '</td><td align="center">' + element.qty + '</td><td>' + element.note + '</td></tr>'
                        }
                        $('#table_item_service tbody').append(row)
                    });

                    $('#overlay').fadeOut(200);
                    $('#myModal').modal('show');

                }

            })
        }

        function servicePenjualan(id) {
            $.SmartMessageBox({
                title: "Pesan!",
                content: 'Kirim barang ini ke pusat untuk diperbaiki?',
                buttons: '[Batal][Ya]'
            }, function (ButtonPressed) {
                if (ButtonPressed === "Ya") {

                    $('#overlay').fadeIn(200);
                    $('#load-status-text').text('Sedang Memproses...');

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: baseUrl + '/penjualan/service-barang/send-service/' + id,
                        type: 'get',
                        success: function (response) {
                            if (response.status == "Not Found") {
                                $.smallBox({
                                    title: "Gagal",
                                    content: "Data tidak ditemukan",
                                    color: "#A90329",
                                    timeout: 5000,
                                    icon: "fa fa-times bounce animated"
                                });
                                $('#overlay').fadeOut(200);

                            } else if (response.status == "False") {
                                $.smallBox({
                                    title: "Gagal",
                                    content: "Upsss. Terjadi kesalahan",
                                    color: "#A90329",
                                    timeout: 5000,
                                    icon: "fa fa-times bounce animated"
                                });
                                $('#overlay').fadeOut(200);

                            } else if (response.status == "True") {
                                $.smallBox({
                                    title: "Berhasil",
                                    content: 'Barang sedang dikirim ke pusat untuk perbaikan',
                                    color: "#739E73",
                                    timeout: 5000,
                                    icon: "fa fa-check bounce animated"
                                });
                                $('#overlay').fadeOut(200);
                                $('#deleteModal').modal('hide');
                                refresh_tab();

                            }
                        }, error: function (x, e) {
                            if (x.status == 0) {
                                alert('ups !! gagal menghubungi server, harap cek kembali koneksi internet anda');
                                $('#overlay').fadeOut(200);
                            } else if (x.status == 404) {
                                alert('ups !! Halaman yang diminta tidak dapat ditampilkan.');
                                $('#overlay').fadeOut(200);
                            } else if (x.status == 500) {
                                alert('ups !! Server sedang mengalami gangguan. harap coba lagi nanti');
                                $('#overlay').fadeOut(200);
                            } else if (e == 'parsererror') {
                                alert('Error.\nParsing JSON Request failed.');
                                $('#overlay').fadeOut(200);
                            } else if (e == 'timeout') {
                                alert('Request Time out. Harap coba lagi nanti');
                                $('#overlay').fadeOut(200);
                            } else {
                                alert('Unknow Error.\n' + x.responseText);
                                $('#overlay').fadeOut(200);
                            }
                        }
                    })

                }

            });
        }

        function serviceTolak(id) {
            $.SmartMessageBox({
                title: "Pesan!",
                content: 'Tolak barang ini untuk diperbaiki?',
                buttons: '[Batal][Ya]'
            }, function (ButtonPressed) {
                if (ButtonPressed === "Ya") {
                    $('#overlay').fadeIn(200);
                    $('#load-status-text').text('Sedang Memproses...');

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: baseUrl + '/penjualan/service-barang/tolak-barang/' + id,
                        type: 'get',
                        success: function (response) {
                            if (response.status == "Not Found") {
                                $.smallBox({
                                    title: "Gagal",
                                    content: "Data tidak ditemukan",
                                    color: "#A90329",
                                    timeout: 5000,
                                    icon: "fa fa-times bounce animated"
                                });
                                $('#overlay').fadeOut(200);

                            } else if (response.status == "False") {
                                $.smallBox({
                                    title: "Gagal",
                                    content: "Upsss. Terjadi kesalahan",
                                    color: "#A90329",
                                    timeout: 5000,
                                    icon: "fa fa-times bounce animated"
                                });
                                $('#overlay').fadeOut(200);

                            } else if (response.status == "True") {
                                $.smallBox({
                                    title: "Berhasil",
                                    content: 'Barang berhasil ditolak',
                                    color: "#739E73",
                                    timeout: 5000,
                                    icon: "fa fa-check bounce animated"
                                });
                                $('#overlay').fadeOut(200);
                                $('#deleteModal').modal('hide');
                                refresh_tab();

                            }
                        }, error: function (x, e) {
                            if (x.status == 0) {
                                alert('ups !! gagal menghubungi server, harap cek kembali koneksi internet anda');
                                $('#overlay').fadeOut(200);
                            } else if (x.status == 404) {
                                alert('ups !! Halaman yang diminta tidak dapat ditampilkan.');
                                $('#overlay').fadeOut(200);
                            } else if (x.status == 500) {
                                alert('ups !! Server sedang mengalami gangguan. harap coba lagi nanti');
                                $('#overlay').fadeOut(200);
                            } else if (e == 'parsererror') {
                                alert('Error.\nParsing JSON Request failed.');
                                $('#overlay').fadeOut(200);
                            } else if (e == 'timeout') {
                                alert('Request Time out. Harap coba lagi nanti');
                                $('#overlay').fadeOut(200);
                            } else {
                                alert('Unknow Error.\n' + x.responseText);
                                $('#overlay').fadeOut(200);
                            }
                        }
                    })
                }
            });
        }

        function serviceTerima(id) {
            $.SmartMessageBox({
                title: "Pesan!",
                content: 'Terima barang ini untuk diperbaiki?',
                buttons: '[Batal][Ya]'
            }, function (ButtonPressed) {
                if (ButtonPressed === "Ya") {
                    $('#overlay').fadeIn(200);
                    $('#load-status-text').text('Sedang Memproses...');

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: baseUrl + '/penjualan/service-barang/terima-barang/' + id,
                        type: 'get',
                        success: function (response) {
                            if (response.status == "Not Found") {
                                $.smallBox({
                                    title: "Gagal",
                                    content: "Data tidak ditemukan",
                                    color: "#A90329",
                                    timeout: 5000,
                                    icon: "fa fa-times bounce animated"
                                });
                                $('#overlay').fadeOut(200);

                            } else if (response.status == "False") {
                                $.smallBox({
                                    title: "Gagal",
                                    content: "Upsss. Terjadi kesalahan",
                                    color: "#A90329",
                                    timeout: 5000,
                                    icon: "fa fa-times bounce animated"
                                });
                                $('#overlay').fadeOut(200);

                            } else if (response.status == "True") {
                                $.smallBox({
                                    title: "Berhasil",
                                    content: 'Barang berhasil diterima',
                                    color: "#739E73",
                                    timeout: 5000,
                                    icon: "fa fa-check bounce animated"
                                });
                                $('#overlay').fadeOut(200);
                                $('#deleteModal').modal('hide');
                                refresh_tab();

                            }
                        }, error: function (x, e) {
                            if (x.status == 0) {
                                alert('ups !! gagal menghubungi server, harap cek kembali koneksi internet anda');
                                $('#overlay').fadeOut(200);
                            } else if (x.status == 404) {
                                alert('ups !! Halaman yang diminta tidak dapat ditampilkan.');
                                $('#overlay').fadeOut(200);
                            } else if (x.status == 500) {
                                alert('ups !! Server sedang mengalami gangguan. harap coba lagi nanti');
                                $('#overlay').fadeOut(200);
                            } else if (e == 'parsererror') {
                                alert('Error.\nParsing JSON Request failed.');
                                $('#overlay').fadeOut(200);
                            } else if (e == 'timeout') {
                                alert('Request Time out. Harap coba lagi nanti');
                                $('#overlay').fadeOut(200);
                            } else {
                                alert('Unknow Error.\n' + x.responseText);
                                $('#overlay').fadeOut(200);
                            }
                        }
                    })
                }
            });
        }

        function serviceProses(id) {
            $.SmartMessageBox({
                title: "Pesan!",
                content: 'Proses perbaikan untuk barang ini?',
                buttons: '[Batal][Ya]'
            }, function (ButtonPressed) {
                if (ButtonPressed === "Ya") {
                    $('#overlay').fadeIn(200);
                    $('#load-status-text').text('Sedang Memproses...');

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: baseUrl + '/penjualan/service-barang/proses-perbaikan/' + id,
                        type: 'get',
                        success: function (response) {
                            if (response.status == "Not Found") {
                                $.smallBox({
                                    title: "Gagal",
                                    content: "Data tidak ditemukan",
                                    color: "#A90329",
                                    timeout: 5000,
                                    icon: "fa fa-times bounce animated"
                                });
                                $('#overlay').fadeOut(200);

                            } else if (response.status == "False") {
                                $.smallBox({
                                    title: "Gagal",
                                    content: "Upsss. Terjadi kesalahan",
                                    color: "#A90329",
                                    timeout: 5000,
                                    icon: "fa fa-times bounce animated"
                                });
                                $('#overlay').fadeOut(200);

                            } else if (response.status == "True") {
                                $.smallBox({
                                    title: "Berhasil",
                                    content: 'Status berhasil diperbarui ke proses perbaikan',
                                    color: "#739E73",
                                    timeout: 5000,
                                    icon: "fa fa-check bounce animated"
                                });
                                $('#overlay').fadeOut(200);
                                $('#deleteModal').modal('hide');
                                refresh_tab();

                            }
                        }, error: function (x, e) {
                            if (x.status == 0) {
                                alert('ups !! gagal menghubungi server, harap cek kembali koneksi internet anda');
                                $('#overlay').fadeOut(200);
                            } else if (x.status == 404) {
                                alert('ups !! Halaman yang diminta tidak dapat ditampilkan.');
                                $('#overlay').fadeOut(200);
                            } else if (x.status == 500) {
                                alert('ups !! Server sedang mengalami gangguan. harap coba lagi nanti');
                                $('#overlay').fadeOut(200);
                            } else if (e == 'parsererror') {
                                alert('Error.\nParsing JSON Request failed.');
                                $('#overlay').fadeOut(200);
                            } else if (e == 'timeout') {
                                alert('Request Time out. Harap coba lagi nanti');
                                $('#overlay').fadeOut(200);
                            } else {
                                alert('Unknow Error.\n' + x.responseText);
                                $('#overlay').fadeOut(200);
                            }
                        }
                    })
                }
            });
        }

        function serviceSelesai(id) {
            $.SmartMessageBox({
                title: "Pesan!",
                content: 'Proses perbaikan selesai untuk barang ini?',
                buttons: '[Batal][Ya]'
            }, function (ButtonPressed) {
                if (ButtonPressed === "Ya") {
                    $('#overlay').fadeIn(200);
                    $('#load-status-text').text('Sedang Memproses...');

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: baseUrl + '/penjualan/service-barang/selesai-perbaikan/' + id,
                        type: 'get',
                        success: function (response) {
                            if (response.status == "Not Found") {
                                $.smallBox({
                                    title: "Gagal",
                                    content: "Data tidak ditemukan",
                                    color: "#A90329",
                                    timeout: 5000,
                                    icon: "fa fa-times bounce animated"
                                });
                                $('#overlay').fadeOut(200);

                            } else if (response.status == "False") {
                                $.smallBox({
                                    title: "Gagal",
                                    content: "Upsss. Terjadi kesalahan",
                                    color: "#A90329",
                                    timeout: 5000,
                                    icon: "fa fa-times bounce animated"
                                });
                                $('#overlay').fadeOut(200);

                            } else if (response.status == "True") {
                                $.smallBox({
                                    title: "Berhasil",
                                    content: 'Status berhasil diperbarui ke selesai perbaikan',
                                    color: "#739E73",
                                    timeout: 5000,
                                    icon: "fa fa-check bounce animated"
                                });
                                $('#overlay').fadeOut(200);
                                $('#deleteModal').modal('hide');
                                refresh_tab();

                            }
                        }, error: function (x, e) {
                            if (x.status == 0) {
                                alert('ups !! gagal menghubungi server, harap cek kembali koneksi internet anda');
                                $('#overlay').fadeOut(200);
                            } else if (x.status == 404) {
                                alert('ups !! Halaman yang diminta tidak dapat ditampilkan.');
                                $('#overlay').fadeOut(200);
                            } else if (x.status == 500) {
                                alert('ups !! Server sedang mengalami gangguan. harap coba lagi nanti');
                                $('#overlay').fadeOut(200);
                            } else if (e == 'parsererror') {
                                alert('Error.\nParsing JSON Request failed.');
                                $('#overlay').fadeOut(200);
                            } else if (e == 'timeout') {
                                alert('Request Time out. Harap coba lagi nanti');
                                $('#overlay').fadeOut(200);
                            } else {
                                alert('Unknow Error.\n' + x.responseText);
                                $('#overlay').fadeOut(200);
                            }
                        }
                    })
                }
            });
        }

        function serviceHapus(id) {
            $.SmartMessageBox({
                title: "Pesan!",
                content: 'Hapus untuk service barang ini?',
                buttons: '[Batal][Ya]'
            }, function (ButtonPressed) {
                if (ButtonPressed === "Ya") {
                    overlay();

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: baseUrl + '/penjualan/service-barang/delete/' + id,
                        type: 'get',
                        success: function (response) {
                            if (response.status == "Not Found") {
                                $.smallBox({
                                    title: "Gagal",
                                    content: "Data tidak ditemukan",
                                    color: "#A90329",
                                    timeout: 5000,
                                    icon: "fa fa-times bounce animated"
                                });
                                out();

                            } else if (response.status == "False") {
                                $.smallBox({
                                    title: "Gagal",
                                    content: "Upsss. Terjadi kesalahan",
                                    color: "#A90329",
                                    timeout: 5000,
                                    icon: "fa fa-times bounce animated"
                                });
                                out();

                            } else if (response.status == "True") {
                                $.smallBox({
                                    title: "Berhasil",
                                    content: 'Data service barang berhasil dihapus',
                                    color: "#739E73",
                                    timeout: 5000,
                                    icon: "fa fa-check bounce animated"
                                });
                                out();
                                $('#deleteModal').modal('hide');
                                refresh_tab();

                            }
                        }, error: function (x, e) {
                            if (x.status == 0) {
                                alert('ups !! gagal menghubungi server, harap cek kembali koneksi internet anda');
                                $('#overlay').fadeOut(200);
                            } else if (x.status == 404) {
                                alert('ups !! Halaman yang diminta tidak dapat ditampilkan.');
                                $('#overlay').fadeOut(200);
                            } else if (x.status == 500) {
                                alert('ups !! Server sedang mengalami gangguan. harap coba lagi nanti');
                                $('#overlay').fadeOut(200);
                            } else if (e == 'parsererror') {
                                alert('Error.\nParsing JSON Request failed.');
                                $('#overlay').fadeOut(200);
                            } else if (e == 'timeout') {
                                alert('Request Time out. Harap coba lagi nanti');
                                $('#overlay').fadeOut(200);
                            } else {
                                alert('Unknow Error.\n' + x.responseText);
                                $('#overlay').fadeOut(200);
                            }
                        }
                    })
                }
            });
        }

        function serviceTerimaOutlet(id) {
            $.SmartMessageBox({
                title: "Pesan!",
                content: 'Terima barang perbaikan dari pusat?',
                buttons: '[Batal][Ya]'
            }, function (ButtonPressed) {
                if (ButtonPressed === "Ya") {
                    $('#overlay').fadeIn(200);
                    $('#load-status-text').text('Sedang Memproses...');

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: baseUrl + '/penjualan/service-barang/terima-barang-pusat/' + id,
                        type: 'get',
                        success: function (response) {
                            if (response.status == "Not Found") {
                                $.smallBox({
                                    title: "Gagal",
                                    content: "Data tidak ditemukan",
                                    color: "#A90329",
                                    timeout: 5000,
                                    icon: "fa fa-times bounce animated"
                                });
                                $('#overlay').fadeOut(200);

                            } else if (response.status == "False") {
                                $.smallBox({
                                    title: "Gagal",
                                    content: "Upsss. Terjadi kesalahan",
                                    color: "#A90329",
                                    timeout: 5000,
                                    icon: "fa fa-times bounce animated"
                                });
                                $('#overlay').fadeOut(200);

                            } else if (response.status == "True") {
                                $.smallBox({
                                    title: "Berhasil",
                                    content: 'Berhasil diterima',
                                    color: "#739E73",
                                    timeout: 5000,
                                    icon: "fa fa-check bounce animated"
                                });
                                $('#overlay').fadeOut(200);
                                $('#deleteModal').modal('hide');
                                refresh_tab();

                            }
                        }, error: function (x, e) {
                            if (x.status == 0) {
                                alert('ups !! gagal menghubungi server, harap cek kembali koneksi internet anda');
                                $('#overlay').fadeOut(200);
                            } else if (x.status == 404) {
                                alert('ups !! Halaman yang diminta tidak dapat ditampilkan.');
                                $('#overlay').fadeOut(200);
                            } else if (x.status == 500) {
                                alert('ups !! Server sedang mengalami gangguan. harap coba lagi nanti');
                                $('#overlay').fadeOut(200);
                            } else if (e == 'parsererror') {
                                alert('Error.\nParsing JSON Request failed.');
                                $('#overlay').fadeOut(200);
                            } else if (e == 'timeout') {
                                alert('Request Time out. Harap coba lagi nanti');
                                $('#overlay').fadeOut(200);
                            } else {
                                alert('Unknow Error.\n' + x.responseText);
                                $('#overlay').fadeOut(200);
                            }
                        }
                    })
                }
            });
        }

        function refresh_tab() {
            tabel.api().ajax.reload();
            // pending.api().ajax.reload();
            // tolak.api().ajax.reload();
            // proses.api().ajax.reload();
            // done.api().ajax.reload();
        }
    </script>
@endsection
