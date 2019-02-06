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
                    <i class="fa-fw fa fa-wrench"></i>
                    Layanan Perbaikan <span><i class="fa fa-angle-double-right"></i> Perbaikan Barang </span>
                </h1>
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
                            <h2><strong>Tambah Retun Penjualan</strong></h2>
                        </header>
                        <div role="content">
                            <div class="widget-body">
                                <form class="form-horizontal" id="form_return">
                                    <fieldset>
                                        <div class="row">
                                            <article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label text-left">Nama Member</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group input-group-md">
                                                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                            <div class="icon-addon addon-md">
                                                                <input class="form-control" id="cari-member" name="member" placeholder="Masukkan Nama Member" type="text"  style="text-transform: uppercase">
                                                                <label for="cari-member" class="glyphicon glyphicon-search" rel="tooltip" title="Nama Member"></label>
                                                                <input type="hidden" name="idmember" id="idmember">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-3 control-label text-left">Kode Spesifik</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group input-group-md">
                                                            <span class="input-group-addon"><i class="glyphicon glyphicon-barcode"></i></span>
                                                            <div class="icon-addon addon-md">
                                                                <input class="form-control" id="kode" name="kode" placeholder="Masukkan Kode Spesifik" type="text"  style="text-transform: uppercase">
                                                                <label for="kode" class="glyphicon glyphicon-search" rel="tooltip" title="Kode Spesifik"></label>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <input type="hidden" name="idsales" id="idsales">

                                                <div class="form-group">
                                                    <label class="col-md-3 control-label text-left">Nota</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group input-group-md">
                                                            <span class="input-group-addon"><i class="glyphicon glyphicon-book"></i></span>
                                                            <div class="icon-addon addon-md">
                                                                <input class="form-control" id="nota" name="nota" placeholder="Masukkan Nota Penjualan" type="text"  style="text-transform: uppercase">
                                                                <label for="nota" class="glyphicon glyphicon-search" rel="tooltip" title="Nota Penjualan"></label>
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
                            <h2><strong>Daftar Nota Penjualan</strong></h2>
                        </header>
                        <div role="content">
                            <div class="widget-body no-padding">
                                <table id="dt_active" class="table table-striped table-bordered table-hover" width="100%">

                                    <thead>

                                    <tr>

                                        <th><i class="fa fa-fw fa-calendar txt-color-blue"></i>&nbsp;Tanggal</th>

                                        <th><i class="fa fa-fw fa-building txt-color-blue "></i>&nbsp;Nota</th>

                                        <th class="text-center" width="15%"><i class="fa fa-fw fa-wrench txt-color-blue"></i>&nbsp;Aksi</th>

                                    </tr>

                                    </thead>

                                    <tbody>

                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </section>
    </div>
    <!-- END MAIN CONTENT -->
@endsection

@section('extra_script')
    <script type="text/javascript">
        var aktif;
        $(document).ready(function () {
            aktif = $('#dt_active').dataTable();

            var responsiveHelper_dt_basic = undefined;
            var responsiveHelper_datatable_fixed_column = undefined;
            var responsiveHelper_datatable_col_reorder = undefined;
            var responsiveHelper_datatable_tabletools = undefined;

            var breakpointDefinition = {
                tablet : 1024,
                phone : 480
            };

            $("#cari-member").on("keyup", function (evt) {
                evt.preventDefault();
                if (evt.which != 13) {
                    $("#idmember").val('');
                }
            })

            $( "#cari-member" ).autocomplete({
                source: baseUrl+'/penjualan/return-penjualan/cari-member',
                minLength: 1,
                select: function(event, data) {
                    $("#idmember").val(data.item.id);
                }
            });

            $( "#kode" ).autocomplete({
                source: baseUrl+'/penjualan/return-penjualan/cari-kode',
                minLength: 1,
                select: function(event, data) {
                    $("#idsales").val(data.item.id);
                }
            });

            $( "#nota" ).autocomplete({
                source: baseUrl+'/penjualan/return-penjualan/cari-nota',
                minLength: 1,
                select: function(event, data) {
                    $("#idsales").val(data.item.id);
                }
            });

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
                    $("#idmember").val() == "" &&
                    $("#kode").val() == "" &&
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

                if ( $.fn.DataTable.isDataTable('#dt_active') ) {
                    $('#dt_active').DataTable().destroy();
                }

                $('#dt_active').dataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": "{{ url('/penjualan/return-penjualan/cari?') }}"+$("#form_return").serialize(),
                    "columns":[
                        {"data": "tanggal"},
                        {"data": "s_nota"},
                        {"data": "aksi"}
                    ],
                    "autoWidth" : true,
                    "language" : dataTableLanguage,
                    "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
                        "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6 pull-right'p>>",
                    "preDrawCallback" : function() {
                        // Initialize the responsive datatables helper once.
                        if (!responsiveHelper_dt_basic) {
                            responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_active'), breakpointDefinition);
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
        })
    </script>
@endsection
