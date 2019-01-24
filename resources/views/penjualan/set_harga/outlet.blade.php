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
											<input type="text" id="shoItemNama" class="form-control" name="shoItemNama" placeholder="Masukkan Nama Barang" style="text-transform: uppercase">
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

							</div>
							<!-- end widget content -->
							
						</div>
						<!-- end widget div -->
						
					</div>
					<!-- end widget -->
				</article>

            </div>

            <!-- Modal untuk Edit Data by Outlet -->
			<div class="modal fade" id="shoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
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
                                                <form id="shoForm" role="form">
													{{csrf_field()}}
														<input type="hidden" name="shoShowId" id="shoShowId">

                                                     	<div class="col-md-12 padding-top-10 margin-bottom-10">
                                                            <div class="form-group">
                                                                <label style="float:left; width: 20%"><strong>Nama Item</strong></label>
                                                                <label style="width: 5%">:</label>
                                                                <label style="width: 60%" id="shoShowNama"></label>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label style="float:left; width: 20%"><strong>HPP</strong></label>
                                                                <label style="width: 5%">:</label>
                                                                <label style="width: 60%" id="shoHPP"></label>
                                                            </div>	
                                                        </div>

                                                        <table id="shoTable" class="table table-striped table-bordered table-hover margin-bottom-10">
                                                            <thead>		
                                                                <tr>
                                                                    <th style="width: 60%"><i class="fa fa-building txt-color-blue hidden-sm hidden-xs"></i>&nbsp;Nama Outlet</th>
                                                                    <th style="width: 40%"><i class="fa fa-dollar txt-color-blue hidden-sm hidden-xs"></i>&nbsp;Harga Satuan</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody>
                                                            </tbody>

                                                        </table>
                                                                            
                                                    </div>
                                                    
                                                    <div class="col-md-12 margin-bottom-10">
                                                        <div style="width:100%" class="text-align-right">
                                                            <a class="btn btn-primary" id="shoSubmit" onclick="shoSimpan()">
                                                                <i class="fa fa-floppy-o"></i> 
                                                                &nbsp;Simpan
                                                            </a>
                                                        </div>                                              
                                                    </div>

                                                </form>
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
<script src="{{ asset('template_asset/js/plugin/accounting/accounting.js') }}"></script>

<script type="text/javascript">
	$(document).ready(function(){
		$( "#shoItemNama" ).autocomplete({
			source: baseUrl+'/penjualan/set-harga/outlet/auto-CodeNItem',
			minLength: 2,
			select: function(event, data) {
				$('#shoItemId').val(data.item.id);
				$('#shoShowId').val(data.item.id);
                $('#shoItemNama').val(data.item.label);
                $('#shoShowNama').html(data.item.label);           
			}
		});

        $('#shoTable').DataTable();

	}); 

    function shoModal(){
        var id = $('#shoItemId').val();
		$('#shoTable').DataTable().destroy();
		var table = $('#shoTable').DataTable();

		axios.get(baseUrl+'/penjualan/set-harga/outlet/add?id='+id).then((response) => {
			var angka = accounting.formatMoney(response.data.hpp.sm_hpp, "", 2, ".", ",");
            $('#shoHPP').html('Rp. '+angka);

			table.clear().draw();
			for($i=0; $i < response.data.data.length; $i++){
				var price = response.data.data[$i].op_price;
				var pisah = price.split(".");
				var harga = pisah[0];
				table.row.add([
					response.data.data[$i].c_name+'<input type="hidden" name="shoCompId[]" value="'+response.data.data[$i].c_id+'">',
					'<input type="text" class="form-control shoCompPrice" name="shoCompPrice[]" value="'+harga+'">'
				]).draw(false);
				$('.shoCompPrice').maskMoney({ thousands: '.', decimal: ','});
			}
		});
		
		$('#shoModal').modal('show');
    }

	function shoSimpan(){

        $('#overlay').fadeIn(200);
		$('#load-status-text').text('Sedang Menyimpan Data...');
        
        axios.post(baseUrl+'/penjualan/set-harga/outlet/add', $('#shoForm').serialize())
			.then((response) => {
				if(response.data.status == 'sukses'){
					$('#overlay').fadeOut(200);
					$('#shoModal').modal('hide');
					$.smallBox({
						title : "SUKSES",
						content : "Data Setting Harga Outlet berhasil ditambahkan",
						color : "#739E73",
						iconSmall : "fa fa-check animated",
						timeout : 3000
					});
				}
				
			})
	}
</script>
@endsection