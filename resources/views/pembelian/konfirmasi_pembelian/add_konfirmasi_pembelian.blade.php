@extends('main')

@section('title', 'Tambah Konfirmasi')

<?php 
	use App\Http\Controllers\PlasmafoneController as Access;

	function rupiah($angka){
		$hasil_rupiah = "Rp" . number_format($angka,2,',','.');
		return $hasil_rupiah;
	}
?>

@section('extra_style')
	<style type="text/css">
		.dataTables_length {
			float: right;
		}
		.dt-toolbar-footer > :last-child, .dt-toolbar > :last-child {
    		padding-right: 0 !important;
		}
		.col-sm-1.col-xs-12.hidden-xs {
		    padding: 0px;
		}
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

			<li>Home</li><li>Pembelian</li><li>Konfirmasi Pembelian</li>

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
                    <i class="fa-fw fa fa-credit-card"></i>
                    Pembelian
                    <span>
						<i class="fa fa-angle-double-right"></i>
						 Konfirmasi Pembelian
					</span>
                </h1>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-align-right">

                <div class="page-title">

                    <a href="{{ url('pembelian/konfirmasi-pembelian') }}" class="btn btn-default"><i class="fa fa-arrow-left"></i>&nbsp;Kembali</a>

                </div>

            </div>
        </div>
		<!-- widget grid -->
		<section id="widget-grid" class="">

			<?php $mt = '20px'; ?>

			@if(Session::has('flash_message_success'))
				<?php $mt = '0px'; ?>
				<div class="col-md-12">
					<div class="alert alert-success alert-block">
						<a class="close" data-dismiss="alert" href="#">×</a>
						<h4 class="alert-heading">&nbsp;<i class="fa fa-thumbs-up"></i> &nbsp;Pemberitahuan Berhasil</h4>
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
					
					<div class="jarviswidget" id="wid-id-11" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">

                    <header role="heading">
                        <div class="jarviswidget-ctrls" role="menu">   <a href="javascript:void(0);" class="button-icon jarviswidget-toggle-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Collapse"><i class="fa fa-minus "></i></a> <a href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Fullscreen"><i class="fa fa-expand "></i></a>
                        </div>
                        <h2><strong>Tambah Konfirmasi Pembelian</strong></h2>

                    <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span></header>

						<!-- widget div-->
						<div>
							
							<!-- widget content -->
							<div class="widget-body no-padding">

								<!-- widget body text-->
								
								<div class="tab-content padding-10">

									<div class="tab-pane fade in active" id="hr1">
										
										<table id="dt_tambah" class="table table-striped table-bordered table-hover" width="100%">

											<thead>			                

												<tr>
                                                    <th data-hide="phone,tablet">No</th>
                                                    <th data-hide="phone,tablet">Nama Supplier</th>
                                                    <th data-hide="phone,tablet">Nama Barang</th>
                                                    <th data-hide="phone,tablet">Qty</th>
                                                    <th data-hide="phone,tablet">Aksi</th>

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

		<!-- Modal -->
        <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
									&times;
								</button>
								<!-- <h4 class="modal-title" id="myModalLabel">Article Post</h4> -->
							</div>
							<div class="modal-body">
                                <div class="jarviswidget" id="wid-id-4" data-widget-editbutton="false" data-widget-custombutton="false">
				
                                    <header>
                                    
                                        <span class="widget-icon"> <i class="fa fa-edit"></i> </span>
                                        <h2 id="myModalLabel"> </h2>				
                                        
                                    </header>

                                    <!-- widget div-->
                                    <div>
                                        
                                        <!-- widget edit box -->
                                        <div class="jarviswidget-editbox">
                                            <!-- This area used as dropdown edit box -->
                                            
                                        </div>
                                        <!-- end widget edit box -->
                                        
                                        <!-- widget content -->
                                        <div class="widget-body no-padding">
                                            
                                            <form id="smart-form-register" class="smart-form" name="autoSumForm">
                                                <header>
                                                    Detail Item
                                                </header>

                                                <fieldset>
                                                    <section>
                                                        <div style="margin-bottom: 15px;" class="preview thumbnail">
                                                            <img id="dt_image" src="">
                                                        </div>
                                                    </section>
                                                    <section>
                                                        <label class="label">Nama Item</label>
                                                        <label class="input"> <i class="icon-append fa fa-user"></i>
                                                            <input type="text" id="dt_item" placeholder="" disabled="">
                                                            <b class="tooltip tooltip-bottom-right">Needed to enter the website</b> </label>
                                                    </section>
                                                    <section>
                                                        <label class="label">Kelompok</label>
                                                        <label class="input"> <i class="icon-append fa fa-envelope-o"></i>
                                                            <input type="text" id="dt_kelompok" placeholder="" disabled="">
                                                            <b class="tooltip tooltip-bottom-right">Needed to enter the website</b> </label>
                                                    </section>
                                                    <section>
                                                        <label class="label">Merk</label>
                                                        <label class="input"> <i class="icon-append fa fa-lock"></i>
                                                            <input type="text" id="dt_merk" placeholder="" disabled="">
                                                            <b class="tooltip tooltip-bottom-right">Needed to enter the website</b> </label>
                                                    </section>
                                                    <section>
                                                        <label class="label">Spesifik Kode</label>
                                                        <label class="input"> <i class="icon-append fa fa-user"></i>
                                                            <input type="text" id="dt_code" placeholder="" disabled="">
                                                            <b class="tooltip tooltip-bottom-right">Needed to enter the website</b> </label>
                                                    </section>
                                                    <div class="row">
                                                        <section class="col col-6">
                                                        <label class="label">Harga Satuan</label>
                                                            <label class="input">
                                                                <input type="text" name="firstBox" placeholder="Harga Satuan" value="" onkeyup="calc(1)"  id="dt_harga" >	
                                                            </label>
                                                        </section>
                                                        <section class="col col-6">
                                                            <label class="label">Qty</label>
                                                            <label class="input">
                                                                <input type="text" name="secondBox" placeholder="Qty" value="" onkeyup="calc(2)" id="dt_qty">
                                                            </label>
                                                        </section>
                                                    </div>
													
                                                    <section>
                                                        <label class="label">Sub Total</label>
                                                        <label class="input"> <i class="icon-append fa fa-user"></i>
                                                            <input type="text" name="thirdBox" placeholder="Sub Total" value="" onkeyup="calc(3)" disabled="disabled" id="dt_subTotal">
															
                                                            <b class="tooltip tooltip-bottom-right">Needed to enter the website</b> </label>
                                                    </section>
                                                    
                                                    
                                                </fieldset>

                                                <header>
                                                    Detail Supplier
                                                </header>

                                                <fieldset>
                                                    <div class="row">
                                                    <section class="col col-6">
                                                            <label class="label">Supplier</label>
                                                            <label class="select">
                                                                <select id="dt_supplier" onchange="getTelp()">
                                                                    <option value="0" disabled="">Pilih Supplier</option>
                                                                </select> <i></i> </label>
                                                        </section>
                                                        <!-- <section class="col col-6">
                                                            <label class="label">No Telepon</label>
                                                            <label class="input">
                                                                <input type="text" name="telepon" placeholder="" id="dt_telepon" disabled="">
                                                            </label>
                                                        </section> -->
                                                    </div>
                                                    
                                                </fieldset>
                                                <footer>
                                                    <button  class="btn btn-danger" id="btn_ditolak" onclick="tolak()">
                                                        Rencana Di Tolak
                                                    </button>
                                                    <button  class="btn btn-primary" id="btn_disetujui" onclick="setuju()">
                                                        Rencana Di Setujui
                                                    </button>
                                                    <button  class="btn btn-warning" id="btn_tutup" onclick="tutup()">
                                                        Tutup
                                                    </button>
                                                </footer>
                                            </form>						
                                            
                                        </div>
                                        <!-- end widget content -->
                                        
                                    </div>
                                    <!-- end widget div -->
                                    
                                </div>
                                <!-- end widget -->
				
							</div>
							<!-- <div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">
									Cancel
								</button>
								<button type="button" class="btn btn-primary">
									Post Article
								</button>
							</div> -->
						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div><!-- /.modal -->

	</div>
	<!-- END MAIN CONTENT -->
@endsection

@section('extra_script')


	<script type="text/javascript">
		var tambahKonfirmasi;
		var input = $('#dt_harga2').val();
		var input2 = $('#dt_angka').val();

        $(document).ready(function () {
           load_table();

		//    var tanpa_rupiah = document.getElementById('dt_harga');
		// 	tanpa_rupiah.addEventListener('keyup', function(e)
		// 	{
		// 		tanpa_rupiah.value = formatRupiah(this.value);
		// 	});



			

        });



function formatRupiah(angka, prefix)
    {
			var number_string = angka.replace(/[^,\d]/g, '').toString(),
				split    = number_string.split(','),
				sisa     = split[0].length % 3,
				rupiah     = split[0].substr(0, sisa),
				ribuan     = split[0].substr(sisa).match(/\d{3}/gi);
				
			if (ribuan) {
				separator = sisa ? '.' : '';
				rupiah += separator + ribuan.join('.');
			}
			
			rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
			return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
		}

        function tutup(){
            $('#detailModal').modal('hide');
        }

		function load_table()
		{

			var tambahKonfirmasi;
			var responsiveHelper_dt_basic = undefined;
            var responsiveHelper_datatable_fixed_column = undefined;
            var responsiveHelper_datatable_col_reorder = undefined;
            var responsiveHelper_datatable_tabletools = undefined;

            var breakpointDefinition = {
                tablet : 1024,
                phone : 480
            };

            setTimeout(function () {

                tambahKonfirmasi = $('#dt_tambah').dataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ url('/pembelian/konfirmasi-pembelian/view_confirmAdd') }}",
                "fnCreatedRow": function (row, data, index) {
                    $('td', row).eq(0).html(index + 1);
                    },
                "columns":[
                    {"data": "pr_idPlan"},
                    {"data": "c_name"},
                    {"data": "i_nama"},
                    {"data": "pr_qtyApp"},
                    {"data": "aksi"}
                ],
                "autoWidth" : true,
                "language" : dataTableLanguage,
                "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
                "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
                "preDrawCallback" : function() {
                    // Initialize the responsive datatables helper once.
                    if (!responsiveHelper_dt_basic) {
                        responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_tambah'), breakpointDefinition);
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
		}

		function getTelp(){
			$.ajax({
				url : '{{url('/pembelian/konfirmasi-pembelian/getTelp')}}',
				type: "GET",
				data: { 
					"s_id" : $('dt_supplier').val(),
				},
				dataType: "JSON",
				success: function(data)
					{	
						$('#dt_telepon').val("");
						$('#dt_telepon').val(data.data.s_phone);
					},
			});
		}


        function getPlan_id(id){

            $.ajax({
                url : '{{url('/pembelian/konfirmasi-pembelian/getPlan_id')}}',
                type: "GET",
                data: { 
					id : id,
                },
                dataType: "JSON",
                success: function(data) 
                {
					pr_idPlan = data.data.pr_idPlan;
					i_item = data.data.i_id;
					pr_comp = data.data.pr_comp;
					supplier = data.data.s_id;

					if (data.data.i_img == "") {

						$('img#dt_image').attr("src", "{{asset('img/image-not-found.png')}}");

					}else{

						$('img#dt_image').attr("src", "{{asset('img/items/')}}"+"/"+data.data.i_img);

					}
					$('#dt_item').val(data.data.i_nama);
					$('#dt_merk').val(data.data.i_merk);
					$('#dt_kelompok').val(data.data.i_kelompok);
					$('#dt_code').val(data.data.i_specificcode);
					$('#dt_harga').val(data.data.i_price);
					$('#dt_qty').val(data.data.pr_qtyApp);
					$('#dt_telepon').val(data.data.s_phone);

					$.ajax({
						url : '{{url('/pembelian/konfirmasi-pembelian/getSupplier')}}',
						type: "GET",
						data: { 
						},
						dataType: "JSON",
						success: function(data)
                          {
                            $('#dt_supplier').empty(); 
                            row = "<option value='0'>Pilih Supplier</option>";
                            $(row).appendTo("#dt_supplier");
                            $.each(data, function(k, v) {
                              if (v.s_id == supplier) {
                                row = "<option selected='' value='"+v.s_id+"'>"+v.s_company+"</option>";
                              }else{
                                row = "<option value='"+v.s_id+"'>"+v.s_company+"</option>";
                              }
                              $(row).appendTo("#dt_supplier");
                            });
                          },
					});
					
					$('#myModalLabel').text('FORM DETAIL KONFIRMASI PEMBELIAN');
					$('#detailModal').modal('show');
                    $('#btn_disetujui').show();
                    $('#btn_ditutup').show();
                    $('#btn_ditolak').hide();
                },
                
            }); 

			
            
        }

        function getTolak(id){
           
            $.ajax({
                url : '{{url('/pembelian/konfirmasi-pembelian/getPlan_id')}}',
                type: "GET",
                data: { 
					id : id,
                },
                dataType: "JSON",
                success: function(data) 
                {
					pr_idPlan = data.data.pr_idPlan;
					i_item = data.data.i_id;
					pr_comp = data.data.pr_comp;
					supplier = data.data.s_id;

					if (data.data.i_img == "") {

						$('img#dt_image').attr("src", "{{asset('img/image-not-found.png')}}");

					}else{

						$('img#dt_image').attr("src", "{{asset('img/items/')}}"+"/"+data.data.i_img);

					}
					$('#dt_item').val(data.data.i_nama);
					$('#dt_merk').val(data.data.i_merk);
					$('#dt_kelompok').val(data.data.i_kelompok);
					$('#dt_code').val(data.data.i_specificcode);
					$('#dt_harga').val(data.data.i_price);
					$('#dt_qty').val(data.data.pr_qtyApp);
					$('#dt_telepon').val(data.data.s_phone);

					$.ajax({
						url : '{{url('/pembelian/konfirmasi-pembelian/getSupplier')}}',
						type: "GET",
						data: { 
						},
						dataType: "JSON",
						success: function(data)
                          {
                            $('#dt_supplier').empty(); 
                            row = "<option value='0'>Pilih Supplier</option>";
                            $(row).appendTo("#dt_supplier");
                            $.each(data, function(k, v) {
                              if (v.s_id == supplier) {
                                row = "<option selected='' value='"+v.s_id+"'>"+v.s_company+"</option>";
                              }else{
                                row = "<option value='"+v.s_id+"'>"+v.s_company+"</option>";
                              }
                              $(row).appendTo("#dt_supplier");
                            });
                          },
					});
					
					$('#myModalLabel').text('FORM DETAIL KONFIRMASI PEMBELIAN');
					$('#detailModal').modal('show');
                    $('#btn_disetujui').hide();
                    $('#btn_ditutup').show();
                    $('#btn_ditolak').show();
                },
                
            }); 

            
        }

		function suplier(){
			$.ajax({
                url : '{{url('/pembelian/rencana-pembelian/itemSuplier')}}',
                type: "GET",
                data: { 
                
                },
                dataType: "JSON",
                success: function(data)
                {
                    $('#dt_supplier').empty(); 
					row = "<option selected='' value='0'>Pilih Suplier</option>";
					$(row).appendTo("#dt_supplier");
					$.each(data, function(k, v) {
						row = "<option value='"+v.s_id+"'>"+v.s_company+"</option>";
						$(row).appendTo("#dt_supplier");
					});
                },
                
            });  
		}

		function setuju(){
            $.ajax({
                url : '{{url('/pembelian/konfirmasi-pembelian/confirmSetuju')}}',
                type: "GET",
                data: { 
					pr_idPlan 		: pr_idPlan,
					pr_item 		: i_item,
					pr_comp 		: pr_comp,
					pr_supplier		: $('#dt_supplier').val(),
					pr_price		: $('#dt_harga').val(),
					pr_qtyApp		: $('#dt_qty').val(),
					pr_stsConf		: "CONFIRM",
                },
                dataType: "JSON",
                success: function(data)
                {
                    if(data.status == 'GAGAL'){
						$('#overlay').fadeOut(200);
						
							$.smallBox({
								title : "Gagal",
								content : "Upsss. data Gagal di tambahkan",
								color : "#A90329",
								timeout: 5000,
								icon : "fa fa-times bounce animated"
							});
					}else{
						
							var rule = 	$('#detailModal').modal('hide');
							$('#detailModal').modal('hide');
							
						// var rel = $('#dt_tambah').DataTable().ajax.reload();
						// 	$('#dt_tambah').DataTable().ajax.reload();
							if(!rule)
							{
								$.smallBox({
								title : "Berhasil",
								content : 'Data gagal direload...!',
								color : "#739E73",
								timeout: 4000,
								icon : "fa fa-check bounce animated"
								});
							}else{
								var rule2 = $.smallBox({
								title : "Berhasil",
								content : 'Data telah ditambahkan...!',
								color : "#739E73",
								timeout: 4000,
								icon : "fa fa-check bounce animated"
								});

								$.smallBox({
								title : "Berhasil",
								content : 'Data telah ditambahkan...!',
								color : "#739E73",
								timeout: 4000,
								icon : "fa fa-check bounce animated"
								});

								if(rule)
								{
									$('#dt_tambah').DataTable().ajax.reload();
								}
								
							}
						
						
					}
                },
                
            });  
        }
        
        

        function tolak(){
            $.ajax({
                url : '{{url('/pembelian/konfirmasi-pembelian/confirmTolak')}}',
                type: "GET",
                data: { 
					pr_idPlan 		: pr_idPlan,
					pr_item 		: i_item,
					pr_comp 		: pr_comp,
					pr_supplier		: $('#dt_supplier').val(),
					pr_price		: $('#dt_harga').val(),
					pr_qtyApp		: $('#dt_qty').val(),
					pr_stsConf		: "CONFIRM",
					
                },
                dataType: "JSON",
                success: function(data)
                {
					// alert();
                    if(data.status == 'GAGAL'){
						$('#overlay').fadeOut(200);
							$.smallBox({
								title : "Gagal",
								content : "Upsss. data Gagal di tambahkan",
								color : "#A90329",
								timeout: 5000,
								icon : "fa fa-times bounce animated"
							});
					}else{
						$('#overlay').fadeOut(200);
							$.smallBox({
								title : "Berhasil",
								content : 'Data telah ditambahkan...!',
								color : "#739E73",
								timeout: 4000,
								icon : "fa fa-check bounce animated"
							});
					}
                },
                
            });  
		}
		
	

	function calc(box){
		one = document.autoSumForm.firstBox.value;
		two = document.autoSumForm.secondBox.value; 
		// third = document.autoSumForm.thirdBox.value; 

		if(box == 1){
			if(one == "" || two == ""){
				document.autoSumForm.thirdBox.value = "0";
			}else if(one == "" || two != ""){
				document.autoSumForm.thirdBox.value = parseInt(one) * parseInt(two);
			}else if(one != "" || two == ""){

				document.autoSumForm.thirdBox.value = parseInt(one) * parseInt(two);
			}
			
		}else if(box == 2){
			if(one == "" || two == ""){
				document.autoSumForm.thirdBox.value = "0";
			}else if(one == "" || two != ""){
				document.autoSumForm.thirdBox.value = parseInt(one) * parseInt(two);
			}else if(one != "" || two == ""){

				document.autoSumForm.thirdBox.value = parseInt(one) * parseInt(two);
			}
			
		}

	}

	

	</script>

@endsection