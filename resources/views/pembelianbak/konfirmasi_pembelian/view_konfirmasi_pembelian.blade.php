@extends('main')

@section('title', 'Request Order')

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
            <li>konfirm Pembelian</li>
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
						 Konfirm Pembelian
					</span>
                </h1>
            </div>
            @if(Access::checkAkses(2, 'insert') == true)
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-align-right">

                    <div class="page-title">

                        <a href="{{ url('/pembelian/konfirmasi-pembelian/view_addKonfirmasi') }}" class="btn btn-success"><i class="fa fa-plus"></i>&nbsp;Tambah
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
                                                                         class="fa fa-lg fa-rotate-right fa-spin"></i> <span
                                            class="hidden-mobile hidden-tablet">Confirm Order </span> </a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#hr2"> <i style="color: #C79121;"
                                                                         class="fa fa-lg fa-check"></i> <span
                                            class="hidden-mobile hidden-tablet">Purchasing</span></a>
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
                                        <table id="dt_co" class="table table-striped table-bordered table-hover"
                                               width="100%">
                                            <thead>
                                            <tr>
                                                <th data-hide="phone,tablet" width="15%">No</th>
                                                <th data-hide="phone,tablet" width="15%">No Confirm</th>
                                                <th width="30%">Nama Barang</th>
                                                <th data-hide="phone,tablet" width="15%">Qty</th>
                                                <th data-hide="phone,tablet" width="15%">Status</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="hr2">
                                        <table id="dt_pr" class="table table-striped table-bordered table-hover"
                                               width="100%">
                                            <thead>
                                            <tr>
                                                
                                                <th data-hide="phone,tablet" width="1%">No</th>
                                                <th data-hide="phone,tablet" width="15%">No Confirm</th>
                                                <th width="30%">Nama Barang</th>
                                                <th data-hide="phone,tablet" width="15%">Harga</th>
                                                <th data-hide="phone,tablet" width="15%">Qty</th>
                                                <th data-hide="phone,tablet" width="15%">Status</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="hr3">
                                        <table id="dt_all" class="table table-striped table-bordered table-hover"
                                               width="100%">
                                            <thead>
                                            <tr>
                                                
                                                <th data-hide="phone,tablet" width="1%">No</th>
                                                <th data-hide="phone,tablet" width="15%">No Confirm</th>
                                                <th width="30%">Nama Barang</th>
                                                <th data-hide="phone,tablet" width="15%">Qty</th>
                                                <th data-hide="phone,tablet" width="15%">Status</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
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
        var co, pr, semua;

        $('#overlay').fadeIn(200);
        $('#load-status-text').text('Sedang Menyiapkan...');

        var baseUrl = '{{ url('/') }}';


        $(document).ready(function(){

            $('#overlay').fadeIn(200);
            $('#load-status-text').text('Sedang Menyiapkan...');

            // $('#tabs').tabs();

            let selected = [];

            /* BASIC ;*/
            var responsiveHelper_dt_basic = undefined;
            var responsiveHelper_datatable_fixed_column = undefined;
            var responsiveHelper_datatable_col_reorder = undefined;
            var responsiveHelper_datatable_tabletools = undefined;

            var breakpointDefinition = {
                tablet : 1024,
                phone : 480
            };

            setTimeout(function () {

            co = $('#dt_co').dataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ url('/pembelian/konfirmasi-pembelian/view_confirmApp') }}",
                "fnCreatedRow": function (row, data, index) {
                    $('td', row).eq(0).html(index + 1);
                    },
                "columns":[
                    {"data": "pr_idConf"},
                    {"data": "pr_confirmNumber"},
                    {"data": "i_nama"},
                    {"data": "pr_qtyApp"},
                    {"data": "pr_stsConf"},
                    // {"data": "input"},
                    // {"data": "aksi"}
                ],
                "autoWidth" : true,
                "language" : dataTableLanguage,
                "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
                "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
                "preDrawCallback" : function() {
                    // Initialize the responsive datatables helper once.
                    if (!responsiveHelper_dt_basic) {
                        responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_co'), breakpointDefinition);
                    }
                },
                "rowCallback" : function(nRow) {
                    responsiveHelper_dt_basic.createExpandIcon(nRow);
                },
                "drawCallback" : function(oSettings) {
                    responsiveHelper_dt_basic.respond();
                }
            });
            $('#overlay').fadeOut(200);
            }, 1000);


            setTimeout(function () {

            pr = $('#dt_pr').dataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ url('/pembelian/konfirmasi-pembelian/view_confirmPurchase') }}",
                "fnCreatedRow": function (row, data, index) {
                    $('td', row).eq(0).html(index + 1);
                    },
                "columns":[
                    {"data": "pr_idConf"},
                    {"data": "pr_confirmNumber"},
                    {"data": "i_nama"},
                    {"data": "pr_price"},
                    {"data": "pr_qtyApp"},
                    {"data": "pr_stsConf"},
                ],
                "autoWidth" : true,
                "language" : dataTableLanguage,
                "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
                "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6 pull-right'p>>",
                "preDrawCallback" : function() {
                    // Initialize the responsive datatables helper once.
                    if (!responsiveHelper_dt_basic) {
                        responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_pr'), breakpointDefinition);
                    }
                },
                "rowCallback" : function(nRow) {
                    responsiveHelper_dt_basic.createExpandIcon(nRow);
                },
                "drawCallback" : function(oSettings) {
                    responsiveHelper_dt_basic.respond();
                }
            });
            $('#overlay').fadeOut(200);
            }, 500);

            setTimeout(function () {

                semua = $('#dt_all').dataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": "{{ url('/pembelian/konfirmasi-pembelian/view_confirmAll') }}",
                    "fnCreatedRow": function (row, data, index) {
                        $('td', row).eq(0).html(index + 1);
                        },
                    "columns":[
                        {"data": "pr_idConf"},
                        {"data": "s_company"},
                        {"data": "i_nama"},
                        {"data": "pr_qtyApp"},
                        {"data": "pr_stsConf"},
                    ],
                    "autoWidth" : true,
                    "language" : dataTableLanguage,
                    "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
                    "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6 pull-right'p>>",
                    "preDrawCallback" : function() {
                        // Initialize the responsive datatables helper once.
                        if (!responsiveHelper_dt_basic) {
                            responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_all'), breakpointDefinition);
                        }
                    },
                    "rowCallback" : function(nRow) {
                        responsiveHelper_dt_basic.createExpandIcon(nRow);
                    },
                    "drawCallback" : function(oSettings) {
                        responsiveHelper_dt_basic.respond();
                    }
                });
                $('#overlay').fadeOut(200);
                }, 500);

        })
    </script>

@endsection
