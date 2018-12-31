@extends('main')
    
@section('title', 'Setting Harga')
    
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
            <li>Penjualan</li>
            <li>Setting Harga Outlet</li>
        </ol> 

    </div>
    <!-- END RIBBON -->
    
@endsection

@section('main_content')

    <div id="content">
  		<section id="widget-grid" class="">
            <div class="row">

                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <h1 class="page-title txt-color-blueDark">
                        <i class="fa fa-handshake-o fa-lg"></i> 
                        Penjualan <span>
                        <i class="fa fa-angle-double-right"></i> 
                        Setting Harga Outlet</span>
                    </h1>
                </div>

                <!-- NEW WIDGET START -->
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<!-- Widget ID (each widget will need unique ID)-->
					<div class="jarviswidget" id="wid-id-0" 
						data-widget-colorbutton="false" 
						data-widget-deletebutton="false" 
						data-widget-editbutton="false"
						data-widget-custombutton="false"
						data-widget-sortable="false">

						<header>
							<h2><strong>Setting Harga Outlet</strong></h2>											
						</header>

						<!-- widget div-->
						<div>

							<!-- widget edit box -->
						    <div class="jarviswidget-editbox">
								<!-- This area used as dropdown edit box -->
								<input class="form-control" type="text">
								<span class="note"><i class="fa fa-check text-success"></i> Change title to update and save instantly!</span>
								
							</div>
							<!-- end widget edit box -->
							
							<!-- widget content -->
							<div class="widget-body">
								
								<div class="row form-group">
									<div class="col-lg-12 col-md-12 col-sm-12">
										<div class="col-md-9">
											<input type="text" id="shoItemNama" class="form-control" name="shoItemNama" placeholder="Masukkan Nama Barang">
											<input type="hidden" name="shoItemId" id="shoItemId">
										</div>
										<div class="col-md-3">
											<span class="input-group-append" >
												<button type="button" class="btn btn-primary btn-sm icon-btn ml-2" onclick="shoModal()" style="width: 100%">
													<i class="fa fa-plus"></i>&nbsp;Set Harga
												</button>
											</span>
										</div>
									</div>
								</div>

								{!! csrf_field() !!}
								
							</div>
							<!-- end widget content -->
							
						</div>
						<!-- end widget div -->
						
					</div>
					<!-- end widget -->
				</article>

            </div>

            <!-- Modal untuk Detil Pemesanan -->
			<div class="modal fade" id="shoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog" style="width: 60%">
					<div class="modal-content">
						<div class="modal-header">

							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
								&times;
							</button>

							<h4 class="modal-title" id="myModalLabel">Set Harga Outlet</h4>

						</div>

						<div class="modal-body">			
							<div class="row">

								<!-- Widget ID (each widget will need unique ID)-->
								<div class="jarviswidget jarviswidget-color-greenLight" id="wid-id-3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">

									<header>
										<span class="widget-icon"> <i class="fa fa-table"></i> </span>
										<h2 id="title_detail"></h2>
									</header>

									<!-- widget div-->
									<div>

										<!-- widget content -->
										<div class="widget-body no-padding">											
											<div class="table-responsive">

                                                <div class="col-md-12 padding-top-10 margin-bottom-10">
                                                    <div class="form-group">
                                                        <label class="col-md-2" style="float:left"><strong>Nama Item</strong></label>
                                                        <label class="col-md-1">:</label>
                                                        <label class="col-md-9" id="shoItemNama">ACER</label>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label class="col-md-2" style="float:left"><strong>HPP</strong></label>
                                                        <label class="col-md-1">:</label>
                                                        <label class="col-md-9" id="shoHPP">Rp. xxxx</label>
                                                    </div>	
                                                </div>

                                                <table id="dt_detail" class="table table-striped table-bordered table-hover margin-bottom-10">
                                                    <thead>		
                                                        <tr>
                                                            <th width="60%"><i class="fa fa-fw fa-building txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Nama Outlet</th>
                                                            <th width="40%"><i class="fa fa-fw fa-dollar txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Harga Satuan</th>
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
  		</section>
    </div>
    
@endsection

@section('extra_script')

<!-- PAGE RELATED PLUGIN(S) -->

<script type="text/javascript">
	var table;
	$(document).ready(function(){
		$( "#shoItemNama" ).autocomplete({
			source: baseUrl+'/penjualan/set-harga/outlet/auto-CodeNItem',
			minLength: 2,
			select: function(event, data) {
				$('#shoItemId').val(data.item.id);
                $('#shoItemNama').val(data.item.label);
			}
		});
	}); 

    function shoModal(){
        $('#shoModal').modal('show');
    }

	function search(){
		
		$('#showdata').html('<tr class="odd"><td valign="top" colspan="6" class="dataTables_empty">Tidak ada data</td></tr>');
		var tgl_awal = $('#tgl_awal').val();
		var tgl_akhir = $('#tgl_akhir').val();
		var nama = $('#searchhidden').val();
		
		$('#overlay').fadeIn(200);
		$('#load-status-text').text('Sedang Mencari Data');
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.ajax({
			url: '{{ url('/pengaturan/log-kegiatan/findLog') }}',
			type: 'get',
			data: {tgl_awal:tgl_awal, tgl_akhir:tgl_akhir, nama:nama},
			success: function(response){
				$('#searchhidden').val('');
				table.clear();
				for (var i = 0; i < response.length; i++) {
					table.row.add([
						response[i].m_name,
						response[i].c_name,
						response[i].la_activity,
						response[i].la_date
					]).draw( false );
				}
			}
		});
		$('#overlay').fadeOut(200);
	}
</script>
@endsection