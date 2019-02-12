@extends('main')

@section('title', 'Return Penjualan')

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
            <li>Return Penjualan</li>
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
                    Penjualan <span><i class="fa fa-angle-double-right"></i> Return Penjualan </span>
                </h1>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-align-right padding-top-10">
                @if(Access::checkAkses(20, 'insert') == true)
                    <a class="btn btn-success" type="button" href="{{ url('penjualan/return-penjualan/tambah') }}"><i
                            class="fa fa-plus"></i>&nbsp;Tambah Data</a>
                @endif
            </div>

        </div>

        <section id="widget-grid" class="">
            <!-- row -->
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="jarviswidget" id="wid-id-11" data-widget-editbutton="false"
                         data-widget-colorbutton="false" data-widget-deletebutton="false">
                        <header>
                            <ul id="widget-tab-1" class="nav nav-tabs pull-left">
                                <li class="active">
                                    <a data-toggle="tab" href="#hr1"> <i style="color: #C79121;" class="fa fa-lg fa-rotate-right fa-spin"></i>
                                        <span class="hidden-mobile hidden-tablet"> Diproses </span>
                                    </a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#hr2"> <i style="color: #739E73;" class="fa fa-lg fa-check"></i>
                                        <span class="hidden-mobile hidden-tablet"> Selesai </span>
                                    </a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#hr3"> <i style="color: #A90329;" class="fa fa-lg fa-remove"></i>
                                        <span class="hidden-mobile hidden-tablet"> Batal </span>
                                    </a>
                                </li>
                            </ul>
                        </header>
                        <!-- widget div-->
                        <div>
                            <!-- widget content -->
                            <div class="widget-body no-padding">
                                <!-- widget body text-->
                                <div class="tab-content padding-10">
                                    <div class="tab-pane fade in active" id="hr1">
                                        <table id="dt_menunggu" class="table table-striped table-bordered table-hover"
                                               width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Tanggal</th>
                                                    <th>Nota</th>
                                                    <th>Pelanggan</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>

                                            <tbody></tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="hr2">
                                        <table id="dt_selesai" class="table table-striped table-bordered table-hover"
                                               width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Tanggal</th>
                                                    <th>Nota</th>
                                                    <th>Pelanggan</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>

                                            <tbody></tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="hr3">
                                        <table id="dt_batal" class="table table-striped table-bordered table-hover"
                                               width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Tanggal</th>
                                                    <th>Nota</th>
                                                    <th>Pelanggan</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>

                                            <tbody></tbody>
                                        </table>
                                    </div>
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
                                                    <td><strong>Tanggal</strong></td>
                                                    <td><strong>:</strong></td>
                                                    <td id="dt_tanggal"></td>
                                                </tr>

                                                <tr>
                                                    <td><strong>Nota Return</strong></td>
                                                    <td><strong>:</strong></td>
                                                    <td id="dt_notareturn"></td>
                                                </tr>

                                                <tr>
                                                    <td><strong>Nota Penjualan</strong></td>
                                                    <td><strong>:</strong></td>
                                                    <td id="dt_notapenjualan"></td>
                                                </tr>

                                                <tr>
                                                    <td><strong>Jenis Return</strong></td>
                                                    <td><strong>:</strong></td>
                                                    <td id="dt_jenisreturn"></td>
                                                </tr>

                                                <tr>
                                                    <td><strong>Status</strong></td>
                                                    <td><strong>:</strong></td>
                                                    <td id="dt_status"></td>
                                                </tr>

                                                <tr>
                                                    <td><strong>Member</strong></td>
                                                    <td><strong>:</strong></td>
                                                    <td id="dt_member"></td>
                                                </tr>

                                                <tr>
                                                    <td><strong>Telp.</strong></td>
                                                    <td><strong>:</strong></td>
                                                    <td id="dt_telp"></td>
                                                </tr>

                                                </tbody>

                                            </table>

                                            <table class="table table-bordered" id="table_item_return">
                                                <thead>
                                                    <tr class="text-center">
                                                        <td>Item</td>
                                                        <td>Qty</td>
                                                        <td>Keterangan</td>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>

                                            <div style="border: .6px dashed; border-color: #CCCCCC;"></div>

                                            <div>
                                                <legend style="padding-left: 10px;"><i><strong>BARANG PENGGANTI</strong></i></legend>
                                            </div>

                                            <table class="table table-bordered" id="table_item_ganti">
                                                <thead>
                                                <tr class="text-center">
                                                    <td>Item</td>
                                                    <td>Qty</td>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
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
        var proses, done, cancel;
        $(document).ready(function () {
            var responsiveHelper_dt_basic = undefined;
            var breakpointDefinition = {
                tablet: 1024,
                phone: 480
            };

            setTimeout(function () {

                proses = $('#dt_menunggu').dataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": "{{ route('get-return-proses') }}",
                    "columns": [
                        {"data": "tanggal"},
                        {"data": "notareturn"},
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
                            responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_menunggu'), breakpointDefinition);
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

                done = $('#dt_selesai').dataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": "{{ route('get-return-done') }}",
                    "columns": [
                        {"data": "tanggal"},
                        {"data": "notareturn"},
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
                            responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_menunggu'), breakpointDefinition);
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

                cancel = $('#dt_batal').dataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": "{{ route('get-return-cancel') }}",
                    "columns": [
                        {"data": "tanggal"},
                        {"data": "notareturn"},
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
                            responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_menunggu'), breakpointDefinition);
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
        })

        function detail(id) {
            $('#overlay').fadeIn(200);
            $('#load-status-text').text('Sedang Mengambil data...');

            axios.get(baseUrl + '/penjualan/return-penjualan/get-detail-return/' + id).then(response => {

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
                    var jenis = '';
                    $('.tr').remove();
                    $('#title_detail').html('<strong>Detail Return Penjualan</strong>');
                    $('#dt_tanggal').text(response.data[0].tgl_return);
                    $('#dt_notareturn').text(response.data[0].nota_return);
                    $('#dt_notapenjualan').text(response.data[0].nota_penjualan);
                    $('#dt_status').text(response.data[0].rp_status);
                    if (response.data[0].jenis_return == "GBS") {
                        jenis = "Ganti Barang Sejenis";
                    } else if (response.data[0].jenis_return == "GBL") {
                        jenis = "Ganti Barang Lain";
                    } else {
                        jenis = "Ganti Uang";
                    }
                    $('#dt_jenisreturn').text(jenis);
                    $('#dt_member').text(response.data[0].nama_member);
                    $('#dt_telp').text(response.data[0].telp_member);
                    response.data.forEach(function (element) {
                        if (element.rpd_code != "") {
                            row = '<tr class="tr"><td>' + element.rpd_code + ' - ' + element.rpd_item + '</td><td align="center">' + element.rpd_qty + '</td><td>' + element.rpd_note + '</td></tr>'
                        } else {
                            row = '<tr class="tr"><td>' + element.rpd_item + ' (' + element.rpd_specificcode + ')' + '</td><td align="center">' + element.rpd_qty + '</td><td>' + element.rpd_note + '</td></tr>'
                        }
                        $('#table_item_return tbody').append(row)
                    });

                    if (response.data[0].jenis_return != "GU") {
                        response.data.forEach(function (element) {
                            if (element.rpg_code != "") {
                                row = '<tr class="tr"><td>' + element.rpg_code + ' - ' + element.rpg_item + '</td><td align="center">' + element.rpg_qty + '</td></tr>'
                            } else {
                                row = '<tr class="tr"><td>' + element.rpg_item + ' (' + element.rpg_specificcode + ')' + '</td><td align="center">' + element.rpg_qty + '</td></tr>'
                            }
                            $('#table_item_ganti tbody').append(row)
                        });
                    }

                    $('#overlay').fadeOut(200);
                    $('#myModal').modal('show');

                }

            })
        }

        function refresh_tab() {
            proses.api().ajax.reload();
            done.api().ajax.reload();
            cancel.api().ajax.reload();
        }

        function remove(id) {
            $.SmartMessageBox({
                title: "Pesan!",
                content: 'Apakah Anda yakin akan membatalkan return penjualan ini?',
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
                        url: baseUrl + '/penjualan/return-penjualan/cancel-return/' + id,
                        type: 'get',
                        success: function (response) {
                            if (response == "Not Found") {
                                $.smallBox({
                                    title: "Gagal",
                                    content: "Data tidak ditemukan",
                                    color: "#A90329",
                                    timeout: 5000,
                                    icon: "fa fa-times bounce animated"
                                });
                                $('#overlay').fadeOut(200);

                            } else if (response == "false") {
                                $.smallBox({
                                    title: "Gagal",
                                    content: "Upsss. Terjadi kesalahan",
                                    color: "#A90329",
                                    timeout: 5000,
                                    icon: "fa fa-times bounce animated"
                                });
                                $('#overlay').fadeOut(200);

                            } else {
                                $.smallBox({
                                    title: "Berhasil",
                                    content: 'Transaksi Anda berhasil dibatalkan...!',
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
    </script>
@endsection
