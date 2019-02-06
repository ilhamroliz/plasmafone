@extends('main')

@section('title', 'Purchase Order')

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
            <li>Purchase Order</li>
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
						 Purchase Order
					</span>
                </h1>
            </div>
            @if(Access::checkAkses(4, 'insert') == true)
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-align-right">

                    <div class="page-title">

                        <a href="{{ url('pembelian/purchase-order/tambah') }}" class="btn btn-success"><i
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
                                    <a data-toggle="tab" href="#hr2"> 
                                        <i style="color: #C79121;" class="fa fa-lg fa-history"></i> 
                                        <span class="hidden-mobile hidden-tablet"> History </span>
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

                                    <div class="tab-pane fade in active" id="hr2">

                                        <div class="row form-group">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="col-md-4">
        
                                                    <div>
                                                        <div class="input-group input-daterange" id="date-range">
                                                            <input type="text" class="form-control" id="tgl_awal" name="tgl_awal"  placeholder="Tanggal Awal" data-dateformat="dd/mm/yy">
                                                            <span class="input-group-addon bg-custom text-white b-0">to</span>
                                                            <input type="text" class="form-control" id="tgl_akhir" name="tgl_akhir"  placeholder="Tanggal Akhir" data-dateformat="dd/mm/yy">
                                                        </div>
                                                    </div>
        
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <input type="text" id="nota" class="form-control" name="nota" placeholder="Masukkan No.Nota" style="width: 100%; float: left">
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <input type="hidden" name="idSupp" id="idSupp">
                                                        <input type="text" id="namaSupp" class="form-control" name="namaSupp" placeholder="Masukkan Nama Supplier" style="width: 80%; float: left">
        
                                                        <button type="button" class="btn btn-primary btn-sm icon-btn ml-2" onclick="cariHistory()" style="width: 10%; margin-left: 5%">
                                                            <i class="fa fa-search"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <table id="dt_history" class="table table-striped table-bordered table-hover"
                                               width="100%">
                                            <thead>
                                            <tr>
                                                <th class="text-center" width="10%">No.</th>
                                                <th class="text-center" width="30%">No. Confirm</th>
                                                <th class="text-center" width="40%">Nama Supplier</th>
                                                <th class="text-center" width="20%">Status</th>
                                            </tr>
                                            </thead>

                                            <tbody id="historyBody">
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

        </section>
        <!-- end widget grid -->

    </div>
    <!-- END MAIN CONTENT -->
@endsection

@section('extra_script')

    <script type="text/javascript">
        var semua, purchase, complete;
        $(document).ready(function () {

            let selected = [];

            /* BASIC ;*/
            var responsiveHelper_dt_basic = undefined;
            var responsiveHelper_datatable_fixed_column = undefined;
            var responsiveHelper_datatable_col_reorder = undefined;
            var responsiveHelper_datatable_tabletools = undefined;

            var breakpointDefinition = {
                tablet: 1024,
                phone: 480
            };

            $('#dt_history').DataTable({
                "language": dataTableLanguage
            });

            $( "#namaSupp" ).autocomplete({
				source: baseUrl+'/pembelian/konfirmasi-pembelian/auto-supp',
				minLength: 1,
				select: function(event, data) {
					$('#idSupp').val(data.item.id);
					$('#namaSupp').val(data.item.label);
				}
			});
            
        })

        function cariHistory(){

			var tglAwal = $('#tgl_awal').val();
			var tglAkhir = $('#tgl_akhir').val();
			var nota = $('#nota').val();
			var idSupp = $('#idSupp').val();

			if($('#namaSupp').val() == ''){
				idSupp = null;
			}

			axios.post(baseUrl+'/pembelian/purchase-order/getHistory', {tglAwal: tglAwal, tglAkhir: tglAkhir, nota: nota, idSupp: idSupp}).then((response) => {

				$('#historyBody').html('<tr class="odd"><td valign="top" colspan="6" class="dataTables_empty">Tidak ada data</td></tr>');

				$('#dt_history').DataTable().clear();
				for(var i = 0; i < response.data.data.length; i++){
                    $status = '';
                    if(response.data.data[i].i_status == "Y"){
                        $status = '<span class="label label-success">PURCHASING</span>';
                    }else if(response.data.data[i].i_status == "N"){
                        $status = '<span class="label label-danger">DITOLAK</span>';
                    }else{
                        $status = '<span class="label label-warning">MENUNGGU</span>';
                    }
                    $('#dt_history').DataTable().row.add([
                        i + 1,
                        response.data.data[i].pc_nota,
                        response.data.data[i].s_company,
                        $status
                    ]).draw();
				}

			});

		}
    </script>

@endsection
