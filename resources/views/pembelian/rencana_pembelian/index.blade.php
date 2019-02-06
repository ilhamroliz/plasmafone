@extends('main')

@section('title', 'Rencana Pembelian')

@section('extra_style')

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
            <li>Pembelian</li>
            <li>Rencana Pembelian</li>
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
                    <i class="fa-fw fa fa-credit-card"></i>
                    Pembelian
                    <span>
						<i class="fa fa-angle-double-right"></i>
						 Rencana Pembelian
					</span>
                </h1>
            </div>
            @if(Access::checkAkses(2, 'insert') == true)
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-align-right">

                    <div class="page-title">

                        <a href="{{ url('pembelian/rencana-pembelian/tambah') }}" class="btn btn-success"><i
                                class="fa fa-plus"></i>&nbsp;Tambah
                            Data</a>

                    </div>

                </div>
            @endif
        </div>

        <!-- widget grid -->
        <section id="widget-grid" class="">

            <?php $mt = '20px'; ?>

            @if(Session::has('flash_message_success'))
                <?php $mt = '0px'; ?>
                <div class="col-md-12">
                    <div class="alert alert-success alert-block">
                        <a class="close" data-dismiss="alert" href="#">×</a>
                        <h4 class="alert-heading">&nbsp;<i class="fa fa-thumbs-up"></i> &nbsp;Pemberitahuan Berhasil
                        </h4>
                        {{ Session::get('flash_message_success') }}
                    </div>
                </div>
            @elseif(Session::has('flash_message_error'))
                <?php $mt = '0px'; ?>
                <div class="col-md-12">
                    <div class="alert alert-danger alert-block">
                        <a class="close" data-dismiss="alert" href="#">×</a>
                        <h4 class="alert-heading">&nbsp;<i class="fa fa-frown-o"></i> &nbsp;Pemberitahuan Gagal</h4>
                        {{ Session::get('flash_message_error') }}
                    </div>
                </div>
        @endif

        <!-- row -->
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="jarviswidget" id="wid-id-11" data-widget-editbutton="false"
                         data-widget-colorbutton="false" data-widget-deletebutton="false">
                        <header>
                            <ul id="widget-tab-1" class="nav nav-tabs pull-left">
                                <li class="active">
                                    <a data-toggle="tab" href="#hr1"> <i style="color: #739E73;"
                                                                         class="fa fa-lg fa-rotate-right fa-spin"></i>
                                        <span
                                            class="hidden-mobile hidden-tablet"> Menunggu </span> </a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#hr2"> <i style="color: #C79121;"
                                                                         class="fa fa-lg fa-history"></i> <span
                                            class="hidden-mobile hidden-tablet"> History </span></a>
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
                                                <th data-hide="phone,tablet" width="25%">
                                                    <i class="fa fa-calendar text-primary"></i> Tanggal
                                                </th>
                                                <th data-hide="phone,tablet">
                                                    <i class="fa fa-barcode text-primary"></i> Nama Barang
                                                </th>
                                                <th data-hide="phone,tablet" width="15%">
                                                    <i class="fa fa-shopping-cart text-primary"></i> Qty
                                                </th>
                                            </tr>
                                            </thead>

                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="hr2">
                                        <div class="form-group">
                                            <div class="col-md-4">
                                                <div class="input-group input-daterange" id="date-range">
                                                    <input type="text" class="form-control" id="tgl_awal" name="tgl_awal"
                                                           placeholder="Tanggal Awal" data-dateformat="dd/mm/yy" value="{{ Carbon::now('Asia/Jakarta')->format('d/m/Y') }}">
                                                    <span class="input-group-addon bg-custom text-white b-0">to</span>
                                                    <input type="text" class="form-control" id="tgl_akhir" name="tgl_akhir"
                                                           placeholder="Tanggal Akhir" data-dateformat="dd/mm/yy" value="{{ Carbon::now('Asia/Jakarta')->format('d/m/Y') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" class="btn btn-primary" onclick="cari()">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <table id="dt_disetujui"
                                                   class="table table-striped table-bordered table-hover"
                                                   width="100%">
                                                <thead>
                                                <tr>
                                                    <th data-hide="phone,tablet" width="15%"><i
                                                            class="fas fa-store text-primary"></i> Outlet
                                                    </th>
                                                    <th width="30%"><i class="fa fa-barcode text-primary"></i> Nama
                                                        Barang
                                                    </th>
                                                    <th data-hide="phone,tablet" width="15%"><i
                                                            class="fa fa-shopping-cart text-primary"></i> Qty
                                                    </th>
                                                    <!-- <th data-hide="phone,tablet" width="15%">Aksi</th> -->
                                                </tr>
                                                </thead>

                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
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

            <!-- row -->
            <div class="row">
            </div>
            <!-- end row -->
        </section>
        <!-- end widget grid -->

    </div>
    <!-- END MAIN CONTENT -->
@endsection

@section('extra_script')

    <script type="text/javascript">
        var semua, menunggu, disetujui, ditolak;
        $(document).ready(function () {

            var responsiveHelper_dt_basic = undefined;
            var responsiveHelper_datatable_fixed_column = undefined;
            var responsiveHelper_datatable_col_reorder = undefined;
            var responsiveHelper_datatable_tabletools = undefined;

            var breakpointDefinition = {
                tablet: 1024,
                phone: 480
            };

            setTimeout(function () {

                semua = $('#dt_semua').dataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": "{{ url('/pembelian/rencana-pembelian/rencanaSemua') }}",
                    "columns": [

                        {"data": "c_name"},
                        {"data": "i_nama"},
                        {"data": "pp_qtyApp"},
                        // {"data": "aksi"}
                    ],
                    "autoWidth": true,
                    "language": dataTableLanguage,
                    "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>" + "t" +
                        "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
                    "preDrawCallback": function () {
                        // Initialize the responsive datatables helper once.
                        if (!responsiveHelper_dt_basic) {
                            responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_semua'), breakpointDefinition);
                        }
                    },
                    "rowCallback": function (nRow) {
                        responsiveHelper_dt_basic.createExpandIcon(nRow);
                    },
                    "drawCallback": function (oSettings) {
                        responsiveHelper_dt_basic.respond();
                    }
                });
                $('#overlay').fadeOut(200);
            }, 1000);

            setTimeout(function () {

                menunggu = $('#dt_menunggu').dataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": "{{ url('/pembelian/rencana-pembelian/rencanaMenunggu') }}",
                    "columns": [

                        {"data": "pp_date"},
                        {"data": "i_nama"},
                        {"data": "pp_qtyreq"},
                        // {"data": "aksi"}
                    ],
                    "autoWidth": false,
                    "language": dataTableLanguage,
                    "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>" + "t" +
                        "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
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
                $('#overlay').fadeOut(200);
            }, 500);

            setTimeout(function () {
                disetujui = $('#dt_disetujui').dataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": "{{ url('/pembelian/rencana-pembelian/rencanaDisetujui') }}",
                    "columns": [

                        {"data": "pp_date"},
                        {"data": "i_nama"},
                        {"data": "pp_qtyappr"},
                    ],
                    "autoWidth": true,
                    "language": dataTableLanguage,
                    "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>" + "t" +
                        "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
                    "preDrawCallback": function () {
                        // Initialize the responsive datatables helper once.
                        if (!responsiveHelper_dt_basic) {
                            responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_disetujui'), breakpointDefinition);
                        }
                    },
                    "rowCallback": function (nRow) {
                        responsiveHelper_dt_basic.createExpandIcon(nRow);
                    },
                    "drawCallback": function (oSettings) {
                        responsiveHelper_dt_basic.respond();
                    }
                });
                $('#overlay').fadeOut(200);
            }, 500);

            $( "#date-range" ).datepicker({
                language: "id",
                format: 'dd/mm/yyyy',
                prevText: '<i class="fa fa-chevron-left"></i>',
                nextText: '<i class="fa fa-chevron-right"></i>',
                todayHighlight: true
            });

        })

        function cari() {
            var awal = $('#tgl_awal').val();
            var akhir = $('#tgl_akhir').val();
            $('#dt_disetujui').dataTable().fnClearTable();
            $('#dt_disetujui').dataTable().fnDestroy();
            overlay();
            disetujui = $('#dt_disetujui').dataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ url('/pembelian/rencana-pembelian/rencanaDisetujui') }}",
                    "type": "get",
                    "data": {awal: awal, akhir: akhir}
                },
                "columns": [

                    {"data": "pp_date"},
                    {"data": "i_nama"},
                    {"data": "pp_qtyappr"},
                ],
                "autoWidth": true,
                "language": dataTableLanguage,
                "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>" + "t" +
                    "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
                "preDrawCallback": function () {
                    // Initialize the responsive datatables helper once.
                    if (!responsiveHelper_dt_basic) {
                        responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_disetujui'), breakpointDefinition);
                    }
                },
                "rowCallback": function (nRow) {
                    responsiveHelper_dt_basic.createExpandIcon(nRow);
                },
                "drawCallback": function (oSettings) {
                    responsiveHelper_dt_basic.respond();
                }
            });
            out();
        }
    </script>

@endsection
