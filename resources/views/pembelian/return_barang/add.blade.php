@extends('main')

@section('title', 'Purchase Return')

@section('extra_style')

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
		<li>Home</li><li>Pembelian</li><li>Return Pembelian</li><li>Tambah</li>
	</ol>


</div>
<!-- END RIBBON -->
@endsection


@section('main_content')
    <div id="content">

        <div class="row">

            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <h1 class="page-title txt-color-blueDark">
                    <i class="fa-fw fa fa-credit-card"></i>
                    Pembelian <span><i class="fa fa-angle-double-right"></i> Return Pembelian </span>
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
                            <h2><strong>Tambah Return Pembelian</strong></h2>
                        </header>
                        <div role="content">
                            <div class="widget-body no-padding form-horizontal">
                                <div class="tab-content padding-10">
                                    <form id="form-pencarian" class="col-lg-12 col-md-12 col-sm-12 text-left form-group" style="margin-top:1%;margin-bottom:1%">
                                        <div class="col-md-4 pull-left">
                                            <div class="input-group input-daterange" id="date-range" style="">
                                                <input type="text" class="form-control" onblur="setDate()" onchange="setDate()" id="tgl_awal" name="tgl_awal" value="" placeholder="Tanggal Pembelian" data-dateformat="dd/mm/yy">
                                                <span class="input-group-addon bg-custom text-white b-0">Sampai</span>
                                                <input type="text" class="form-control" onblur="setDate()" onchange="setDate()" id="tgl_akhir" name="tgl_akhir" value="" placeholder="Tanggal Pembelian" data-dateformat="dd/mm/yy">

                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" onblur="setNota()" onkeyup="setNota()" name="carinota" id="carinota" placeholder="Cari Nota Pembelian/DO">
                                        </div>
                                        <div class="col-md-3">
                                            <select class="select2" id="carisupplier" name="carisupplier">
                                                <option value="kosong">Pilih Supplier</option>
                                                @foreach($supplier as $supp)
                                                    <option value="{{ $supp->s_id }}">{{ $supp->s_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-1 pull-right" style="text-align: right">
                                            <button type="button" class="btn btn-block btn-primary btn-sm icon-btn ml-2" onclick="search()">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </form>
                                    <div class="padding-10 form-group">
                                        <div class="col-md-12 pull-left">
                                            <table class="table table-bordered table-striped table-hover" id="table-nota">
                                                <thead>
                                                <tr>
                                                    <th>Tanggal</th>
                                                    <th>Nota</th>
                                                    <th>Supplier</th>
                                                    <th>Aksi</th>
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

<!-- PAGE RELATED PLUGIN(S) -->
<script src="{{ asset('template_asset/js/plugin/bootstrapvalidator/bootstrapValidator.min.js') }}"></script>

<script type="text/javascript">
    var table;
    var notaGlobal = null;
    $(document).ready(function () {
        $('#date-range').datepicker({
            todayHighlight: true,
            autoclose: true
        });

        table = $('#table-nota').DataTable({
            "autoWidth" : true,
            "language" : dataTableLanguage,
            "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
                "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6 pull-right'p>>",
            "preDrawCallback" : function() {
                // Initialize the responsive datatables helper once.
                if (!responsiveHelper_dt_basic) {
                    responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#table-nota'), breakpointDefinition);
                }
            },
            "rowCallback" : function(nRow) {
                responsiveHelper_dt_basic.createExpandIcon(nRow);
            },
            "drawCallback" : function(oSettings) {
                responsiveHelper_dt_basic.respond();
            }
        });
    })

    function setDate() {
        var awal = $('#tgl_awal').val();
        var akhir = $('#tgl_akhir').val();

        if ((awal == '' || awal == null) && (akhir == '' || akhir == null)){
            $('#carinota').removeAttr('readonly');
        } else {
            $('#carinota').attr('readonly', 'true');
        }
    }

    function setNota() {
        var nota = $('#carinota').val();
        if (nota == null || nota == ''){
            $('#tgl_awal').removeAttr('readonly');
            $('#tgl_akhir').removeAttr('readonly');
            $("#carisupplier").select2("readonly", false);
        } else {
            $('#tgl_awal').val('');
            $('#tgl_akhir').val('');
            $('#tgl_awal').attr('readonly', 'true');
            $('#tgl_akhir').attr('readonly', 'true');
            $("#carisupplier").val("kosong").trigger("change");
            $("#carisupplier").select2("readonly", true);
        }
    }
    
    function search() {
        var awal = $('#tgl_awal').val();
        var akhir = $('#tgl_akhir').val();
        var nota = notaGlobal;
        var supplier = $('#carisupplier').val();
        $("#table-nota").dataTable().fnDestroy();
        table = $('#table-nota').dataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": baseUrl + '/pembelian/purchase-return/getData',
                "type": "get",
                "data": {
                    'awal': awal,
                    'akhir': akhir,
                    'nota': nota,
                    'supplier': supplier
                }
            },
            "columns":[
                {"data": "i_merk"},
                {"data": "i_nama"},
                {"data": "i_code"},
                {"data": "harga"}
            ],
            "autoWidth" : true,
            "language" : dataTableLanguage,
            "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
                "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
            "preDrawCallback" : function() {
                // Initialize the responsive datatables helper once.
                if (!responsiveHelper_dt_basic) {
                    responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#table-nota'), breakpointDefinition);
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
</script>

@endsection
