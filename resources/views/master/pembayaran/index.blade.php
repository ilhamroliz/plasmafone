@extends('main')

@section('title', 'Master Pembayaran')

@section('extra_style')
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('template_asset/css/MonthPicker.css') }}">
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
                                                    <button style="" class="btn btn-success text-center" onclick="tambah_group()">
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

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end widget div -->
                    </div>
                    <!-- end widget -->
                </div>

                <div class="col-md-7">
                    <div class="jarviswidget jarviswidget-sortable" id="wid-id-11" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" role="widget">
                        <header role="heading">
                            <h2><strong>Atur Pembayaran di Outlet</strong></h2>
                        </header>
                        <div role="content">
                            <div class="widget-body no-padding form-horizontal">
                                <div class="form-group padding-10" >
                                    <label class="col-md-2 control-label" for="select-1">Select</label>
                                    <div class="col-md-10">
                                        <select class="form-control" id="select-1">
                                            <option>Amsterdam</option>
                                            <option>Atlanta</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="tab-content padding-10">
                                    <div class="tab-pane fade in active" id="hr1">
                                        <table id="dt_harga" class="table table-striped table-bordered table-hover" width="100%">

                                            <thead>
                                            <tr>
                                                <th width="40%">Jenis Pembayaran</th>
                                                <th width="40%">Outlet</th>
                                                <th class="text-center" width="20%">Aksi</th>
                                            </tr>
                                            </thead>

                                            <tbody id="show-harga">
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-5">
                    <div role="content">
                        <div class="widget-body no-padding">

                        </div>
                    </div>
                </div>
            </div>
            <!-- End Tabel Item for @ GROUP MEMBER -->
            <!-- end row -->
        </section>
    </div>
@endsection

@section('extra_script')
    <script type="text/javascript">
        var pembayaran;
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
                    paging: false,
                    ordering: false,
                    "autoWidth" : true,
                    "language" : dataTableLanguage,
                    "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
                        "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6 pull-right'p>>",
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
        })
    </script>
@endsection
