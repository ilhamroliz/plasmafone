@extends('main')

@section('title', 'Pembuatan Rencana Penjualan')

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
        <span id="refresh" class="btn btn-ribbon" data-title="refresh" rel="tooltip" data-placement="bottom"
            data-original-title="<i class='text-warning fa fa-warning'></i> Refresh Halaman? Semua Perubahan Yang Belum Tersimpan Akan Hilang.."
            data-html="true" onclick="location.reload()">
            <i class="fa fa-refresh"></i>
        </span>
    </span>

    <!-- breadcrumb -->
    <ol class="breadcrumb">
        <li>Home</li>
        <li>Inventory</li>
        <li>Opname Barang Outlet</li>
    </ol>

</div>
<!-- END RIBBON -->
@endsection

@section('main_content')
<div id="content">

    <div class="row">

        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <h1 class="page-title txt-color-blueDark">
                <i class="fa-fw fa fa-cube"></i>
                Inventory <span><i class="fa fa-angle-double-right"></i> Opname Barang Outlet </span>
            </h1>
        </div>

        @if(Plasma::checkAkses(12, 'insert') == true)
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-align-right padding-top-10">
            <button class="btn btn-success" onclick="tambah()"><i class="fa fa-plus"></i>&nbsp;Tambah Opname Outlet</button>
        </div>
        @endif

    </div>

    <section id="widget-grid" class="">

        <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                <div class="jarviswidget" id="wid-id-11" data-widget-editbutton="false" data-widget-colorbutton="false"
                    data-widget-deletebutton="false">

                    <header>
                        <ul id="widget-tab-1" class="nav nav-tabs pull-left">
                            <li class="active">
                                <a data-toggle="tab" href="#hr1"> <i style="color: #C79121;" class="fa fa-lg fa-align-justify"></i>
                                    <span class="hidden-mobile hidden-tablet"> Pending </span></a>
                            </li>

                            <li>
                                <a data-toggle="tab" href="#hr2"> <i style="color: #739E73;" class="fa fa-lg fa-check-square"></i>
                                    <span class="hidden-mobile hidden-tablet"> Approved </span> </a>
                            </li>
                        </ul>
                    </header>

                    <div>
                        <div class="widget-body no-padding">
                            <form id="cariMPForm">
                                <div class="col-md-12 no-padding padding-top-15">
                                    <div class="col-md-4">
                                        <div>
                                            <div class="input-group input-daterange" id="date-range">
                                                <input type="text" class="form-control" id="tglAwal" name="tglAwal"
                                                    placeholder="Tanggal Awal" data-dateformat="dd/mm/yy" value="{{ $date }}">
                                                <span class="input-group-addon bg-custom text-white b-0">to</span>
                                                <input type="text" class="form-control" id="tglAkhir" name="tglAkhir"
                                                    placeholder="Tanggal Akhir" data-dateformat="dd/mm/yy" value="{{ $date }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="hidden" id="osItemId" name="osItemId">
                                            <input type="text" class="form-control osItemName" placeholder="Masukkan Nama Barang"
                                                style="text-transform: uppercase">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            @if(Auth::user()->m_comp != "PF00000001")
                                            <input type="hidden" id="osCompId" name="osCompId" value="{{ Auth::user()->m_comp }}">
                                            <input type="text" class="form-control osCompName" value="{{ $getCN->c_name }}"
                                                readonly>
                                            @else
                                            <input type="hidden" id="osCompId" name="osCompId">
                                            <input type="text" class="form-control osCompName" id="osCompName"
                                                placeholder="Masukkan Lokasi Barang" style="text-transform:uppercase">
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <a class="btn btn-primary" onclick="cari()" style="width:100%"><i class="fa fa-search"></i></a>
                                    </div>
                                </div>
                            </form>

                            <div class="tab-content padding-10">

                                <div class="tab-pane fade in active" id="hr1">
                                    <table id="pendTable" class="table table-striped table-bordered table-hover" width="100%">

                                        <thead>
                                            <tr>
                                                <th style="width: 15%"><i class="fa fa-fw fa-barcode txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;No.
                                                    Nota</th>
                                                <th style="width: 15%"><i class="fa fa-fw fa-calendar txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Tanggal
                                                    Opname</th>
                                                <th style="width: 20%"><i class="fa fa-fw fa-building txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Nama
                                                    Cabang</th>
                                                <th style="width: 35%"><i class="fa fa-fw fa-barcode txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Nama
                                                    Item</th>
                                                <th style="width: 15%" class="text-center"><i class="fa fa-fw fa-wrench txt-color-blue"></i>&nbsp;Aksi</th>
                                            </tr>
                                        </thead>

                                        <tbody id="pendshowdata">
                                        </tbody>

                                    </table>
                                </div>

                                <div class="tab-pane fade" id="hr2">

                                    <table id="apprTable" class="table table-striped table-bordered table-hover" width="100%">

                                        <thead>
                                            <tr>
                                                <th style="width: 15%"><i class="fa fa-fw fa-barcode txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;No.
                                                    Nota</th>
                                                <th style="width: 15%"><i class="fa fa-fw fa-calendar txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Tanggal
                                                    Opname</th>
                                                <th style="width: 20%"><i class="fa fa-fw fa-building txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Nama
                                                    Cabang</th>
                                                <th style="width: 35%"><i class="fa fa-fw fa-barcode txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Nama
                                                    Item</th>
                                                <th style="width: 15%" class="text-center"><i class="fa fa-fw fa-wrench txt-color-blue"></i>&nbsp;Aksi</th>
                                            </tr>
                                        </thead>

                                        <tbody id="apprshowdata">
                                        </tbody>

                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </section>



    <!-- Modal untuk Detil Opname Barang -->
    <div class="modal fade" id="detilModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>

                    <h4 class="modal-title" id="myModalLabel">Detail Opname Barang Pusat</h4>

                </div>

                <div class="modal-body">
                    <div class="row">

                        <!-- Widget ID (each widget will need unique ID)-->
                        <div class="jarviswidget jarviswidget-color-greenLight" id="wid-id-3" data-widget-editbutton="false"
                            data-widget-colorbutton="false" data-widget-deletebutton="false">

                            <header>
                                <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                                <h2 id="title_detail"></h2>
                            </header>

                            <!-- widget div-->
                            <div>

                                <!-- widget content -->
                                <div class="widget-body no-padding">
                                    <div class="table-responsive">

                                        <div class="col-md-12 padding-top-10 ">
                                            <div class="form-group">
                                                <label class="col-md-3" style="float:left"><strong>No. Nota</strong></label>
                                                <label class="col-md-1">:</label>
                                                <label class="col-md-8" id="obNota"></label>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-md-3" style="float:left"><strong>Lokasi Barang</strong></label>
                                                <label class="col-md-1">:</label>
                                                <div class="col-md-8">
                                                    <label id="obCabang"></label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-md-3" style="float:left"><strong>Nama Barang</strong></label>
                                                <label class="col-md-1">:</label>
                                                <div class="col-md-8">
                                                    <label id="obBarang"></label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-md-3" style="float:left"><strong>Qty Sistem</strong></label>
                                                <label class="col-md-1">:</label>
                                                <div class="col-md-8">
                                                    <label id="obQtyS"></label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-md-3" style="float:left"><strong>Qty Real</strong></label>
                                                <label class="col-md-1">:</label>
                                                <div class="col-md-8">
                                                    <label id="obQtyR"></label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-md-3" style="float:left"><strong>AKSI</strong></label>
                                                <label class="col-md-1">:</label>
                                                <div class="col-md-8">
                                                    <label id="obAksi"></label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <!-- Tabel untuk detil opname barang-->
                                    <!-- TABEL C-->
                                    <div class="col-md-12">
                                        <table id="dobCTable" class="table table-striped table-bordered table-hover margin-top-10"
                                            style="display:none; margin-top: 20px;">

                                            <thead id="dobCHead">
                                                <th>No.</th>
                                                <th>Kode Spesifik</th>
                                            </thead>

                                            <tbody id="dobCBody">
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
@endsection

@section('extra_script')
<script src="{{ asset('template_asset/js/MonthPicker.js') }}"></script>
<script src="{{ asset('template_asset/js/plugin/accounting/accounting.js') }}"></script>

<script type="text/javascript">
    var appr, pend;
    var expTable, codeTable, codeExpTable;
    var apprTab, pendTab;
    var speccode, expired;
    var idItem, idComp;

    $(document).ready(function () {
        $("#date-range").datepicker({
            language: "id",
            format: 'dd/mm/yyyy',
            prevText: '<i class="fa fa-chevron-left"></i>',
            nextText: '<i class="fa fa-chevron-right"></i>',
            autoclose: true,
            todayHighlight: true
        });

        dobCTable = $('#dobCTable').DataTable({
            "order": [],
            "searching": false,
            "autoWidth": true,
            "pageLength": 5,
            "info": false,
        });

        $('.osItemName').autocomplete({
            // "option", "appendTo", ".eventInsForm",
            source: baseUrl + '/penjualan/pemesanan-barang/get-item',
            minLength: 2,
            select: function (event, data) {
                $('#osItemId').val(data.item.id);
            }
        })

        $('.osCompName').autocomplete({
            source: baseUrl + '/inventory/opname-barang/auto-comp-noPusat',
            minLength: 2,
            select: function (event, data) {
                $('#osCompId').val(data.item.id);
            }
        })


        setTimeout(function () {

            pendTab = $('#pendTable').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [],
                "ajax": "{{ url('/inventory/opname-barang/pendO') }}",
                "columns": [{
                        "data": "o_reff"
                    },
                    {
                        "data": "o_date"
                    },
                    {
                        "data": "c_name"
                    },
                    {
                        "data": "i_nama"
                    },
                    {
                        "data": "aksi"
                    }
                ],
                "autoWidth": true,
                "language": dataTableLanguage,
                "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>" +
                    "t" +
                    "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
                "preDrawCallback": function () {
                    // Initialize the responsive datatables helper once.
                    if (!responsiveHelper_dt_basic) {
                        responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($(
                            '#pendTable'), breakpointDefinition);
                    }
                },
                "rowCallback": function (nRow) {
                    responsiveHelper_dt_basic.createExpandIcon(nRow);
                },
                "drawCallback": function (oSettings) {
                    responsiveHelper_dt_basic.respond();
                }
            });

        }, 500);

        setTimeout(function () {

            apprTab = $('#apprTable').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [],
                "ajax": "{{ url('/inventory/opname-barang/apprO') }}",
                "columns": [{
                        "data": "o_reff"
                    },
                    {
                        "data": "o_date"
                    },
                    {
                        "data": "c_name"
                    },
                    {
                        "data": "i_nama"
                    },
                    {
                        "data": "aksi"
                    }
                ],
                "autoWidth": true,
                "language": dataTableLanguage,
                "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>" +
                    "t" +
                    "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6 pull-right'p>>",
                "preDrawCallback": function () {
                    // Initialize the responsive datatables helper once.
                    if (!responsiveHelper_dt_basic) {
                        responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($(
                            '#apprTable'), breakpointDefinition);
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

    });


    function detail(id) {
        axios.post(baseUrl + '/inventory/opname-barang/detail?id=' + id).then((response) => {

            $('#obNota').html(response.data.data[0].o_reff);
            $('#obCabang').html(response.data.data[0].c_name);
            $('#obBarang').html(response.data.data[0].i_nama);
            if (response.data.data[0].o_action == 'REAL') {
                $('#obAksi').html('Menyesuaikan Qty Real')
            } else if (response.data.data[0].o_action == 'SYSTEM') {
                $('#obAksi').html('Menyesuaikan Qty System')
            }

            $qtyR = 0;
            $qtyS = 0;

            dobCTable.clear();

            for ($ob = 0; $ob < response.data.data.length; $ob++) {
                $qtyR = $qtyR + parseInt(response.data.data[$ob].od_qty_real);
                $qtyS = $qtyS + parseInt(response.data.data[$ob].od_qty_system);

                $sc = response.data.data[$ob].i_specificcode;
                $ex = response.data.data[$ob].i_expired;

                if ($sc == 'Y' && $ex == 'N') {

                    dobCTable.row.add([
                        ($ob + 1),
                        response.data.data[$ob].od_specificcode
                    ]).draw(false);

                }

            }
            $('#dobCTable').css("display", "block");

            $('#obQtyS').html($qtyS + ' Unit');
            $('#obQtyR').html($qtyR + ' Unit');

        })

        $('#detilModal').modal('show');
    }

    function cari() {

        $('#overlay').fadeIn(200);
        $('#load-status-text').text('Sedang Mencari Data ...');

        var status;
        var awal = $('#tglAwal').val();
        var akhir = $('#tglAkhir').val();
        var idItem = $('#osItemId').val();
        var idComp = $('#osCompId').val();

        if ($('#hr2').hasClass("active") == true) {

            $('#apprTable').DataTable().destroy();

            $('#apprTable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ url('/inventory/opname-barang/pencarian') }}"+"cb=out&x=a&awal="+awal+"&akhir="+akhir+'&ii='+idItem+'&ic='+idComp,
                "columns": [
                    {"data": "o_reff"},
                    {"data": "o_date"},
                    {"data": "c_name"},
                    {"data": "i_nama"},
                    {"data": "aksi"}
                ],
                "autoWidth": true,
                "language": dataTableLanguage,
                "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>" + "t" +
                    "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6 pull-right'p>>",
                "preDrawCallback": function () {
                    // Initialize the responsive datatables helper once.
                    if (!responsiveHelper_dt_basic) {
                        responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#apprTable'),
                            breakpointDefinition);
                    }
                },
                "rowCallback": function (nRow) {
                    responsiveHelper_dt_basic.createExpandIcon(nRow);
                },
                "drawCallback": function (oSettings) {
                    responsiveHelper_dt_basic.respond();
                }
            });

        } else if ($('#hr1').hasClass("active") == true) {

            $('#pendTable').DataTable().destroy();

            $('#pendTable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ url('/inventory/opname-barang/pencarian') }}"+"cb=out&x=a&awal="+awal+"&akhir="+akhir+'&ii='+idItem+'&ic='+idComp,
                "columns": [
                        {"data": "o_reff"},
						{"data": "o_date"},
						{"data": "c_name"},
						{"data": "i_nama"},
						{"data": "aksi"}
                ],
                "autoWidth": true,
                "language": dataTableLanguage,
                "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>" + "t" +
                    "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
                "preDrawCallback": function () {
                    // Initialize the responsive datatables helper once.
                    if (!responsiveHelper_dt_basic) {
                        responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#pendTable'),
                            breakpointDefinition);
                    }
                },
                "rowCallback": function (nRow) {
                    responsiveHelper_dt_basic.createExpandIcon(nRow);
                },
                "drawCallback": function (oSettings) {
                    responsiveHelper_dt_basic.respond();
                }
            });

        }
        $('#irpCompId').val('');
        $('#overlay').fadeOut(200);
    }


    function tambah(){
        location.href = ('{{ url("/inventory/opname-barang/tambahOutlet") }}');
    }

    function edit(id){
        location.href = ('{{ url("/inventory/opname-barang/editOutlet?id=") }}' + id);
    }

    function approve(id) {

        $('#overlay').fadeIn(200);
        $('#load-status-text').text('Sedang Menyimpan Perubahan Data...');

        axios.get(baseUrl + '/man-penjualan/rencana-penjualan/approve' + '/' + id).then((response) => {

            if (response.data.status == 'apprSukses') {
                $('#overlay').fadeOut(200);
                $.smallBox({
                    title: "Berhasil",
                    content: 'Approval Berhasil Dilakukan !',
                    color: "#739E73",
                    timeout: 4000,
                    icon: "fa fa-check bounce animated"
                });
                location.reload();
            } else {
                $('#overlay').fadeOut(200);
                $.smallBox({
                    title: "Gagal",
                    content: "Maaf, Approval Gagal Dilakukan ",
                    color: "#A90329",
                    timeout: 4000,
                    icon: "fa fa-times bounce animated"
                });
            }

        })

    }

    function hapus(id) {
        $.SmartMessageBox({
            title: "Pesan!",
            content: 'Apakah Anda yakin akan manghapus data Opname Barang ini ?',
            buttons: '[Batal][Ya]'
        }, function (ButtonPressed) {
            if (ButtonPressed === "Ya") {

                $('#overlay').fadeIn(200);
                $('#load-status-text').text('Sedang Menyimpan Perubahan Data...');

                axios.post(baseUrl + '/inventory/opname-barang/hapus?id=' + id).then((response) => {
                    if (response.data.status == 'hobSukses') {
                        $('#overlay').fadeOut(200);
                        $.smallBox({
                            title: "Berhasil",
                            content: 'Data Opname Barang ' + response.data.data +
                                ' Berhasil Dihapus !',
                            color: "#739E73",
                            timeout: 4000,
                            icon: "fa fa-check bounce animated"
                        });
                        location.reload();
                    } else {
                        $('#overlay').fadeOut(200);
                        $.smallBox({
                            title: "Gagal",
                            content: "Maaf, Data Opname Barang " + response.data.data +
                                " Gagal Dihapus ",
                            color: "#A90329",
                            timeout: 4000,
                            icon: "fa fa-times bounce animated"
                        });
                    }
                });
            }
        });
    }

</script>
@endsection
