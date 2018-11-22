@extends('main')

@section('title', 'Distribusi Barang')


@section('extra_style')

@endsection

<style type="text/css">
	.center{
		margin-left: 25%;
		margin-right: 25%;
	}

	.parallelogram {
	   height: 35px;
	   width: 100%;
	   border: 2px solid #8C8C8C;
	   -webkit-transform: skew(-20deg); 
	   -moz-transform: skew(-20deg); 
	   -o-transform: skew(-20deg);
	   transform: skew(-20deg);
	}

	.parallelogram > label {
		font-size: 16px;
		padding-top: 4px;
		padding-left: 10px;
		font-family: Arial, Helvetica, sans-serif;
		font-weight: bold;
	}

	.table-bukti {
		margin-left: auto;
		margin-right: auto;
	}

	.table-bukti td {
		padding: 15px;
    	text-align: left;
	}

	@media screen {
		#printSection {
			display: none;
		}
	}

	@media print {
		body * {
			visibility: hidden;
		}
		#printSection, #printSection * {
			visibility: visible;
		}
		#printSection {
			position: absolute;
			left: 0;
			top: 0;
		}
	}
</style>

<?php 
	function tgl_indo($tanggal){
		$bulan = array (
			1 =>   'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember'
		);
		$pecahkan = explode('-', $tanggal);
		
		// variabel pecahkan 0 = tanggal
		// variabel pecahkan 1 = bulan
		// variabel pecahkan 2 = tahun
	 
		return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
	}
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
			<li>Home</li><li>Inventory</li><li>Distribusi Barang</li>
		</ol>
		<!-- end breadcrumb -->

		<!-- You can also add more buttons to the
		ribbon for further usability

		Example below:

		<span class="ribbon-button-alignment pull-right">
		<span id="search" class="btn btn-ribbon hidden-xs" data-title="search"><i class="fa-grid"></i> Change Grid</span>
		<span id="add" class="btn btn-ribbon hidden-xs" data-title="add"><i class="fa-plus"></i> Add</span>
		<span id="search" class="btn btn-ribbon" data-title="search"><i class="fa-search"></i> <span class="hidden-mobile">Search</span></span>
		</span> -->

	</div>
	<!-- END RIBBON -->
@endsection


@section('main_content')

	<!-- MAIN CONTENT -->
	<div id="content">

		<!-- widget grid -->
		<section id="widget-grid" class="" style="margin-bottom: 20px; min-height: 500px;">

			<!-- row -->
			<div class="row">
				<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-md-offset-1" style="padding: 10px 20px; margin-top: 20px; background: #fff;">

					{{-- FormTemplate .. --}}

						<fieldset>
							<legend>
								Distribusi Barang
							</legend>

							<div class="row" style="margin-top: 15px" >
								<div class="col-md-12">
									<!-- <form id="form_search" method="post" action=""> -->
										<table border="0" class="center">
	                                        <tbody>
	                                            <tr>
	                                                <td style="width: 100%;">
	                                                    <input type="text" list="list_purchase" class="form-control input-lg input-rounded" name="purchase_order" id="purchase_order" placeholder="Masukkan nomor purchase order...." autocomplete="off" autofocus="" onchange="showPurchase()">
														<datalist id="list_purchase">
															@foreach($purchase as $purchase)
															<option value="{{ $purchase->i_po }}">{{ $purchase->i_po }}</option>
															@endforeach
														</datalist>
	                                                </td>
	                                                <td>
	                                                    <button type="submit" class="btn btn-primary" style="height: 45px; width: 45px;">
	                                                        <i class="fa fa-search" aria-hidden="true" style="font-size: 18px;"></i>
	                                                    </button>
	                                                </td>
	                                            </tr>
	                                        </tbody>
	                                    </table>
                                    <!-- </form> -->
								</div>
							</div>
							<hr>

							

						</fieldset>

					{{-- FormTemplate End .. --}}

				</div>

				<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-md-offset-1" style="padding: 10px 20px; margin-top: 20px; background: #fff;">

					{{-- FormTemplate .. --}}
					<form method="post" action="{{ url('/inventory/distribusi/print') }}">{{ csrf_field() }}
						<fieldset>
							<legend>
								Surat jalan/Delivery Order
							</legend>

							<div class="row" style="margin-top: 15px" >
								<div class="col-md-12">
									<div>
										<img src="{{ asset('template_asset/img/hsj.png') }}" width="100%">
									</div>
									<div class="col-sm-12" style="margin-top: 20px;">
										<h2 class="text-center"><strong>BUKTI PENGELUARAN BARANG</strong></h2>
									</div>
									<div class="col-sm-12" style="margin-top: 40px;">
										<input type="hidden" name="nourut" id="nourut">
										<table class="table-bukti">
											<tr>
												<td>No. Bukti</td>
												<td class="text-center">:</td>
												<td><strong><input type="text" name="no_bukti" id="no_bukti" class="form-control" readonly placeholder="Masukkan nomor bukti"></strong></td>
												<td>Tanggal</td>
												<td class="text-center">:</td>
												<td><strong><?php echo tgl_indo(date('Y-m-d')); ?></strong></td>
											</tr>
											<tr>
												<td>Ditujukan Untuk</td>
												<td class="text-center">:</td>
												<td><strong><input type="text" name="tujuan" id="tujuan" class="form-control" readonly placeholder="Masukkan tujuan delivery"></strong></td>
												<td>PO. Nomor</td>
												<td class="text-center">:</td>
												<td id="nopo1"></td>
												<input type="hidden" name="nomor_purchase" id="nomor_purchase">
											</tr>
										</table>
									</div>
									<div class="col-sm-12" style="margin-top: 10px;">
										<table class="table table-bordered" id="table_barang">
											<thead>
												<tr>
													<th class="text-center">KODE BARANG</th>
													<th class="text-center">NAMA BARANG</th>
													<th class="text-center">QTY</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td colspan="3"><center>Tidak ada data</center></td>
												</tr>
											</tbody>
										</table>
									</div>
									<div class="col-sm-6">
										<div class="parallelogram">
											<label id="nopo2"></label>
										</div>
									</div>
									<div class="col-sm-12" style="margin-top: 30px;">
										<table style="width: 100%">
											<tr>
												<td class="text-center">Yang Mengeluarkan,</td>
												<td class="text-center">Mengetahui,</td>
											</tr>
											<tr>
												<td style="padding-top: 100px; padding-left: 10%; padding-right: 10%;"><input type="text" name="mengeluarkan" id="mengeluarkan" class="form-control" placeholder="Masukkan nama"></td>
												<td style="padding-top: 100px; padding-right: 10%; padding-left: 10%;"><input type="text" name="mengetahui" id="mengetahui" class="form-control" placeholder="Masukkan nama"></td>
											</tr>
										</table>
									</div>
								</div>
							</div>
							<hr>

						</fieldset>

						<div class="col-md-12">
							<button class="btn btn-primary pull-right" type="submit" id="cetak">
								<i class="fa fa-print"></i>
								&nbsp;Cetak
							</button>
						</div>
					</form>
					{{-- FormTemplate End .. --}}

				</div>
			</div>

			<!-- Modal -->
			<div id="printThis">
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
								&times;
							</button>
							<h4 class="modal-title">
								<img src="{{ asset('template_asset/img/logo.png') }}" width="150" alt="SmartAdmin">
							</h4>
						</div>
						<div class="modal-body">

							<form id="view-form" class="smart-form">

								<fieldset>
									<legend>
										Surat jalan/Delivery Order
									</legend>

									<div class="row" style="margin-top: 15px" >
										<div class="col-md-12">
											<div>
												<img src="{{ asset('template_asset/img/hsj.png') }}" width="100%">
											</div>
											<div class="col-sm-12" style="margin-top: 20px;">
												<h2 class="text-center"><strong>BUKTI PENGELUARAN BARANG</strong></h2>
											</div>
											<div class="col-sm-12" style="margin-top: 40px;">
												<table class="table-bukti">
													<tr>
														<td>No. Bukti</td>
														<td class="text-center">:</td>
														<td id="no_bukti_print"></td>
														<td>Tanggal</td>
														<td class="text-center">:</td>
														<td><strong><?php echo tgl_indo(date('Y-m-d')); ?></strong></td>
													</tr>
													<tr>
														<td>Ditujukan Untuk</td>
														<td class="text-center">:</td>
														<td id="tujuan_print"></td>
														<td>PO. Nomor</td>
														<td class="text-center">:</td>
														<td id="nopo1_print"></td>
													</tr>
												</table>
											</div>
											<div class="col-sm-12" style="margin-top: 10px;">
												<table class="table table-bordered" id="table_barang_print">
													<thead>
														<tr>
															<th class="text-center">KODE BARANG</th>
															<th class="text-center">NAMA BARANG</th>
															<th class="text-center">QTY</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td colspan="3"><center>Tidak ada data</center></td>
														</tr>
													</tbody>
												</table>
											</div>
											<div class="col-sm-6" style="margin-top: 20px;">
												<div class="parallelogram">
													<label id="nopo2_print"></label>
												</div>
											</div>
											<div class="col-sm-12" style="margin-top: 30px;">
												<table style="width: 100%">
													<tr>
														<td class="text-center">Yang Mengeluarkan,</td>
														<td class="text-center">Mengetahui,</td>
													</tr>
													<tr>
														<td style="padding-top: 100px; padding-left: 10%; padding-right: 10%;" id="mengeluarkan_print"></td>
														<td style="padding-top: 100px; padding-right: 10%; padding-left: 10%;" id="mengetahui_print"></td>
													</tr>
												</table>
											</div>
										</div>
									</div>
									<hr>

								</fieldset>
								
							</form>						


						</div>

						<div class="modal-footer">
							<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
							<button type="button" id="btnPrint" class="btn btn-primary">Cetak</button>
						</div>

					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->
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
	
	<!-- PAGE RELATED PLUGIN(S) -->
<script src="{{ asset('template_asset/js/plugin/bootstrapvalidator/bootstrapValidator.min.js') }}"></script>

<script type="text/javascript">
	// location.reload();
	$(window).on('popstate', function (e) {
	    var state = e.originalEvent.state;
	    if (state !== null) {
	        location.reload();
	    }
	});
	function showPurchase() 
	{
		$('#form-load-section-status').fadeIn(200);
		this.reset();
		var parameter = $("#purchase_order").val();
		if (parameter == "") {
			$("#table_barang tr:has(td)").remove();
			var trHTML = '';
			trHTML += '<tr><td colspan="3"><center>Tidak ada data</center></td></tr>';
			$('#table_barang').append(trHTML);
			$.toast({
				text: 'Ups . Masukkan nomor purchase!',
				showHideTransition: 'fade',
				icon: 'error'
			})
			$('#form-load-section-status').fadeOut(200);
			$("#purchase_order").focus();
		} else {
			axios.get(baseUrl+'/inventory/distribusi/get-purchase/'+parameter)
			.then((response) => {
				// console.log(response.data[1][0]);
				if(response.data[1] == null){
					$("#table_barang tr:has(td)").remove();
					var trHTML = '';
					trHTML += '<tr><td colspan="3"><center>Tidak ada data</center></td></tr>';
					$('#table_barang').append(trHTML);
					$.toast({
						text: 'Ups . Data Yang Anda pilih belum diterima atau sudah dihapus atau sudah di distribusikan!',
						showHideTransition: 'fade',
						icon: 'error'
					})
					$('#form-load-section-status').fadeOut(200);
				}else{
					// console.log(response.data);
					initiate(response.data);
					$('#form-load-section-status').fadeOut(200);
				}
			})
			.catch((err) => {
				console.log(err);
			})
		}
		
	}

	function initiate(data)
	{
		$('#nourut').val(data[2]);
		$('#no_bukti').val(data[0]);
		$('#nopo1').html("<strong>"+data[1][0].i_po+"</strong>");
		$('#nomor_purchase').val(data[1][0].i_po);
		$('#nopo1_print').html("<strong>"+data[1][0].i_po+"</strong>");
		$('#nopo2').html("<strong>"+"PO. Nomor : "+data[1][0].i_po+"</strong>");
		$('#nopo2_print').html("<strong>"+"PO. Nomor : "+data[1][0].i_po+"</strong>");
		$('#tujuan').val(data[1][0].c_nama)
		$("#table_barang tr:has(td)").remove();
		$("#table_barang_print tr:has(td)").remove();
		var trHTML = '';
		$.each(data[1], function (i, item) {
            trHTML += '<tr><td>' + item.i_kode_barang + '</td><td>' + item.i_nama_barang + '</td><td><center>' + item.i_qty + '<center></td></tr>';
        });
        $('#table_barang').append(trHTML);
        $('#table_barang_print').append(trHTML);
        $('#cetak').removeAttr('disabled');
	}

	function reset()
	{
		$('#nopo1').html('');
		$('#nopo2').html('');
	}

	function printElement(elem){
		var domClone = elem.cloneNode(true);
		var $printSection = document.getElementById("printSection");
		if (!$printSection) {
			var $printSection = document.createElement("div");
			$printSection.id = "printSection";
			document.body.appendChild($printSection);
		}
		$printSection.innerHTML = "";
		$printSection.appendChild(domClone);
		window.print();
	}

	document.getElementById("btnPrint").onclick = function() {
		printElement(document.getElementById("printThis"));
	}

	$(document).ready(function(){
		$('#no_bukti').val('');
		$('#tujuan').val('');
		$('#mengeluarkan').val('');
		$('#mengetahui').val('');
		$('#cetak').prop('disabled', true);
		$('#form_search').bootstrapValidator({
			feedbackIcons : {
				valid : 'glyphicon glyphicon-ok',
				invalid : 'glyphicon glyphicon-remove',
				validating : 'glyphicon glyphicon-refresh'
			},
			fields : {
				purchase_order : {
					validators : {
						notEmpty : {
							message : '*) Masukkan nomor purchase order'
						}
					}
				}
			}
		});

		// $('#cetak').on('click', function(){
		// 	if ($('#no_bukti').val() == "" || $('#tujuan').val() == "" || $('#mengeluarkan').val() == "" || $('#mengetahui').val() == "") {
		// 		return alert('Lengakapi surat pengiriman barang!');
		// 	}
		// 	$('#no_bukti_print').html("<strong>"+$('#no_bukti').val()+"</strong>");
		// 	$('#tujuan_print').html("<strong>"+$('#tujuan').val()+"</strong>");
		// 	$('#mengeluarkan_print').html("<center><strong>"+$('#mengeluarkan').val()+"</strong></center>");
		// 	$('#mengetahui_print').html("<center><strong>"+$('#mengetahui').val()+"</strong></center>");
		// 	$('#myModal').modal('show');
			
		// })

		
	})
</script>

@endsection