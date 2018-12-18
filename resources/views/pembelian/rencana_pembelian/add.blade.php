@extends('main')

@section('title', 'Rencana Pembelian')

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
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-align-right">

                <div class="page-title">

                    <a href="{{ url('pembelian/rencana-pembelian') }}" class="btn btn-default"><i class="fa fa-arrow-left"></i>&nbsp;Kembali</a>

                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">

            <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget" id="wid-id-0" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false" data-widget-sortable="false" role="widget">
                    
                    <header role="heading">
                        <div class="jarviswidget-ctrls" role="menu">   <a href="javascript:void(0);" class="button-icon jarviswidget-toggle-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Collapse"><i class="fa fa-minus "></i></a> <a href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Fullscreen"><i class="fa fa-expand "></i></a>
                        </div>
                        <h2><strong>Tambah Rencana Pembelian</strong></h2>

                    <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span></header>

                    <!-- widget div-->
                    <div role="content">

                        <!-- widget edit box -->
                        <div class="jarviswidget-editbox">
                            <!-- This area used as dropdown edit box -->

                        </div>
                        <!-- end widget edit box -->

                        <!-- widget content -->
                        <div class="widget-body">
                            <form id="checkout-form" class="form-inline" role="form">
                                <fieldset class="row">
                                    <div class="form-group col-md-8">
                                        <label class="sr-only" for="namabarang">Nama Barang</label>
                                        <input type="text" class="form-control" id="namabarang" name="item" placeholder="Masukkan Nama/Kode Barang" style="width: 100%">
                                        <input type="hidden" class="kodeItem">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="sr-only" for="kuantitas">QTY</label>
                                        <input type="text" class="form-control" onkeypress='return event.charCode >= 48 && event.charCode <= 57' id="kuantitas" name="kuantitas" placeholder="QTY" style="width: 100%">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <button class="btn btn-primary" onclick="tambah()">Tambah</button>
                                    </div>
                                </fieldset>
                                <fieldset class="row">
                                    <dir class="col-md-12">
                                        <table id="table-rencana" class="table table-striped table-bordered table-hover" width="100%">
                                            <thead>
                                                <tr>
                                                    <th data-hide="phone,tablet" width="75%">Nama Barang</th>
                                                    <th data-hide="phone,tablet" width="10%">Qty</th>
                                                    <th data-hide="phone,tablet" width="15%">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </dir>
                                </fieldset>
                            </form>
                        </div>
                        <!-- end widget content -->
                    </div>
                    <!-- end widget div -->

                </div>
            <!-- end widget -->
            </div>
        </div>

    </div>
    <!-- END MAIN CONTENT -->

@endsection

@section('extra_script')

    <script type="text/javascript">
        var table = null;
        $(document).ready(function () {
            table = $('#table-rencana').dataTable({
                "autoWidth" : true,
                "language" : dataTableLanguage,
                "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
                "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
                "preDrawCallback" : function() {
                    // Initialize the responsive datatables helper once.
                    if (!responsiveHelper_dt_basic) {
                        responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#table-rencana'), breakpointDefinition);
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
                source: baseUrl+'/pembelian/rencana-pembelian/get-item',
                minLength: 2,
                select: function(event, data) {
                    tanam(data.item);
                }
            });
        })

        function tambah(){

        }

        function tanam(item){
            console.log(item);
        }
    </script>

@endsection
