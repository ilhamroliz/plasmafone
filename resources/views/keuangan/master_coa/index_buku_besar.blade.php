@extends('main')

@section('title', 'Master Akun')

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

			<li>Home</li><li>Keuangan</li><li>Master Akun Keuangan</li>

		</ol>
		<!-- end breadcrumb -->

	</div>
	<!-- END RIBBON -->
@endsection


@section('main_content')

	<!-- MAIN CONTENT -->
	<div id="content">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<ul class="menu-table hide-on-small">
				<li class="">
					<a href="{{ url('/keuangan/coa/jenis') }}">
						<i class="fa fa-table"></i> &nbsp;Master Jenis
					</a>
				</li>
				<!-- <li>
					<a href="{{ url('/keuangan/coa/kelompok') }}">
						<i class="fa fa-plus"></i> &nbsp;Master kelompok
					</a>
				</li> -->

				<li>
					<a href="{{ url('/keuangan/coa/bukubesar') }}" >
						<i class="fa fa-pencil-square"></i> &nbsp;Master Buku Besar
					</a>
				</li>
				<!-- <li>
					<a href="{{ url('/keuangan/coa/sub_bukubesar') }}" >
						<i class="fa fa-eraser"></i> &nbsp;Master Sub Buku Besar
					</a>
				</li> -->

				<li class="right"><i class="fa fa-bars"></i></li>
			</ul>
		</div>
	</div>

    <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <h1 class="page-title txt-color-blueDark">
                    <i class="fa-fw fa fa-credit-card"></i>
                    Keuangan 
                    <span>
						<i class="fa fa-angle-double-right"></i>
						 Master Akun COA
					</span>
                </h1>
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
                        
                        <h2><strong>Master Akun Keuangan</strong></h2>

                    <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span></header>

						<!-- widget div-->
						<div>
							
							<!-- widget content -->
							
							<div class="widget-body no-padding">

								<!-- widget body text-->
								
								<div class="tab-content padding-10">
								<div class="form-group col-md-6">
									<select class="form-control col-md-12" name="" id="jenis" style="padding-right:50%" onchange="reload_all()">
										<option selected="" value="00">----Pilih Akun jenis----</option>
									</select>
								</div>
								<div class="form-group col-md-6">
									<select class="form-control col-md-12" name="" id="kelompok" style="padding-right:50%" onchange="reload_first()">
										<option selected="" value="00">----Pilih akun Kelompok----</option>
									</select>
								</div>
								<div class="form-group col-md-6">
									<select class="form-control col-md-12" name="" id="bb" style="padding-right:50%" onchange="reload_sbb()">
										<option selected="" value="00">----Pilih Akun Buku Besar----</option>
									</select>
								</div>
								<div class="form-group col-md-6">
									<button class="btn btn-primary" id="btn_cari" onclick="tambah_sbb()"><i class="fa fa-plus" ></i>&nbsp;Tambah Sub Buku Besar
									</button>
								</div>
								


									<div class="tab-pane fade in active" id="hr1">
										
										<table id="dt_akun" class="table table-striped table-bordered table-hover" width="100%">

											<thead>			                

												<tr>
                                                    <th data-hide="phone,tablet">--</th>
                                                    <th data-hide="phone,tablet">Jenis</th>
                                                    <th data-hide="phone,tablet">Kelompok</th>
                                                    <th data-hide="phone,tablet">Buku Besar</th>
													<th data-hide="phone,tablet">Kode Akun </th>
                                                    <th data-hide="phone,tablet">Sub Buku Besar</th>

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
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
									&times;
								</button>
								<h4 class="modal-title" id="myModalLabel">Tambah Rekening Perkiraan</h4>
							</div>
							<div class="modal-body">
				
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
										<label for="category"> Akun Jenis</label>
											<select class="form-control" id="modal_jenis"onchange="modal_kelompok()">
											</select>
										</div>
										<div class="form-group">
										<label for="category"> Akun Kelompok</label>
											<select class="form-control" id="modal_kelompok" onchange="modal_bb()">
											</select>
										</div>
										<div class="form-group">
										<label for="category"> Akun Buku Besar</label>
											<select class="form-control" id="modal_bb" onchange="get_detail_bb()">
											</select>
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-md-12">
										<div class="well well-sm well-primary">
											<form class="form form-inline " role="form">
												<div class="form-group">
													<input type="text" class="form-control" id="txtGOLONGAN" disabled/>
												</div>
												<div class="form-group" style="width: 63%;">
													<select class="form-control" style="width: 100%;" id="modal_kas_flow">
														<option value="KEGIATAN OPERASIONAL">CASH FLOW OPERASIONAL</option>
														<option VALUE="KEGIATAN INVESTASI">CASH FLOW INVESTASI</option>
													</select>
												</div>
											</form>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="well well-sm well-primary">
											<form class="form form-inline " role="form">
												<div class="form-group">
													<input type="text" class="form-control" id="txtACCBB" style="width: 20%;"  disabled/>
													<input type="text" class="form-control" id="txtACCSBB" style="width: 10%;"  placeholder="/No"/>
													<input type="text" class="form-control" id="txtKETERANGAN" style="width: 68%;text-transform: uppercase;" placeholder="/Masukkan Keterangan"/>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button class="btn btn-default" data-dismiss="modal">
									Batal
								</button>
								<button class="btn btn-primary" onclick="simpan_akun()">
									Simpan
								</button>
							</div>
						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div><!-- /.modal -->
	</div>
	<!-- END MAIN CONTENT -->
@endsection

@section('extra_script')

	<script type="text/javascript">
		$(document).ready(function(){

		load_akun();
		view_jenis();
		view_kelompok();
		view_bb();

		function formatRupiah(angka, prefix)
		{
			var number_string = angka.toString(),
			split	= number_string.split(','),
			sisa 	= split[0].length % 3,
			rupiah 	= split[0].substr(0, sisa),
			ribuan 	= split[0].substr(sisa).match(/\d{3}/gi);

			if (ribuan) {
				separator = sisa ? '.' : '';
				rupiah += separator + ribuan.join('.');
			}

			rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
			return prefix == undefined ? rupiah : (rupiah ? 'Rp' + rupiah : '');
		}
	})

	function reload_all(){
		view_kelompok();
		reload_first();
	}

	function reload_first(){
		view_bb();
		reload_sbb();

	}

	function reload_sbb(){
		table_akun.ajax.reload(null, false);
	}

	function load_akun(){
		table_akun= $('#dt_akun').DataTable({
                    "ajax": {
							"url": '{{url('/keuangan/keuangan/viewCoa_sub_buku_besar')}}',
							"type": 'post',  
							"data": function ( data ) {
								data.jenis = $('#jenis').val();
								data.kelompok = $('#kelompok').val();
								data.buku_besar = $('#bb').val();
								data._token = '{{ csrf_token() }}';
							},
                            },
                    "fnCreatedRow": function (row, data, index) {
                        $('td', row).eq(0).html(index + 1);
                        },
                    } );
               
	}

	function view_jenis(){
		$.ajax({
                url : '{{url('/keuangan/keuangan/get_coaJenis')}}',
                type: "post",
                data: { 
					_token : '{{ csrf_token() }}'
                },
                dataType: "JSON",
                success: function(data)
                {
                    $('#jenis').empty(); 
					row = "<option selected='' value='00'>SEMUA JENIS AKUN</option>";
					$(row).appendTo("#jenis");
					$.each(data, function(k, v) {
						row = "<option value='"+v.ACCJENIS+"'>"+v.dk_nama_jenis+"</option>";
						$(row).appendTo("#jenis");
					});
                },
                
            });  
	}

	function view_kelompok(){
		$.ajax({
                url : '{{url('/keuangan/keuangan/get_coaKelompok')}}',
                type: "POST",
                data: { 
					jenis : $('#jenis').val(),
					_token : '{{ csrf_token() }}'
                },
                dataType: "JSON",
                success: function(data)
                {
                    $('#kelompok').empty(); 
					row = "<option selected='' value='00'>SEMUA KELOMPOK AKUN</option>";
					$(row).appendTo("#kelompok");
					$.each(data, function(k, v) {
						row = "<option value='"+v.ACCKEL+"'>"+v.KELOMPOK+"</option>";
						$(row).appendTo("#kelompok");
					});
                },
                
            });  
	}

	function view_bb(){
		$.ajax({
                url : '{{url('/keuangan/keuangan/get_coaBb')}}',
                type: "POST",
                data: { 
					jenis : $('#jenis').val(),
					kelompok : $('#kelompok').val(),
					_token : '{{ csrf_token() }}'
                },
                dataType: "JSON",
                success: function(data)
                {
                    $('#bb').empty(); 
					row = "<option selected='' value='00'>SEMUA AKUN BUKU BESAR</option>";
					$(row).appendTo("#bb");
					$.each(data, function(k, v) {
						row = "<option value='"+v.ACCBB+"'>"+v.BUKUBESAR+"</option>";
						$(row).appendTo("#bb");
					});
                },
                
            });  
	}

	function tambah_sbb(){
		$.ajax({
                url : '{{url('/keuangan/keuangan/get_coaJenis')}}',
                type: "post",
                data: { 
					_token : '{{ csrf_token() }}'
                },
                dataType: "JSON",
                success: function(data)
                {
					$('#txtACCBB').val('');
					$('#txtACCSBB').val('');
					$('#txtGOLONGAN').val('');
					$('#txtKETERANGAN').val('');
					
                    $('#modal_jenis').empty();
					$.each(data, function(k, v) {
						row = "<option value='"+v.ACCJENIS+"'>"+v.dk_nama_jenis+"</option>";
						$(row).appendTo("#modal_jenis");
					});

					$('#myModal').modal('show');
					// =======================
					$.ajax({
						url : '{{url('/keuangan/keuangan/get_coaKelompok')}}',
						type: "POST",
						data: { 
							jenis : $('#modal_jenis').val(),
							_token : '{{ csrf_token() }}'
						},
						dataType: "JSON",
						success: function(data)
						{
							$('#modal_kelompok').empty();
							$.each(data, function(k, v) {
								row2 = "<option value='"+v.ACCKEL+"'selected>"+v.KELOMPOK+"</option>";
								$(row2).appendTo("#modal_kelompok");
							});
						},
						
					});  
					// ==========================
					$.ajax({
						url : '{{url('/keuangan/keuangan/get_coaBb')}}',
						type: "POST",
						data: { 
							jenis : $('#modal_jenis').val(),
							kelompok : $('#modal_kelompok').val(),
							_token : '{{ csrf_token() }}'
						},
						dataType: "JSON",
						success: function(data)
						{
							$('#modal_bb').empty(); 
							$.each(data, function(k, v) {
								row3 = "<option value='"+v.ACCBB+"'selected>"+v.BUKUBESAR+"</option>";
								$(row3).appendTo("#modal_bb");
							});
						},
						
					});  
					// ==================================

                },
                
            });  
	}

	function modal_kelompok()
	{
		$.ajax({
                url : '{{url('/keuangan/keuangan/get_coaKelompok')}}',
                type: "POST",
                data: { 
					jenis : $('#modal_jenis').val(),
					_token : '{{ csrf_token() }}'
                },
                dataType: "JSON",
                success: function(data)
                {
                    $('#modal_kelompok').empty();
					$.each(data, function(k, v) {
						row = "<option value='"+v.ACCKEL+"'>"+v.KELOMPOK+"</option>";
						$(row).appendTo("#modal_kelompok");
					});
                },
                
            });  
	}

	function modal_bb(){
		$.ajax({
                url : '{{url('/keuangan/keuangan/get_coaBb')}}',
                type: "POST",
                data: { 
					jenis : $('#modal_jenis').val(),
					kelompok : $('#modal_kelompok').val(),
					_token : '{{ csrf_token() }}'
                },
                dataType: "JSON",
                success: function(data)
                {
                    $('#modal_bb').empty(); 
					$.each(data, function(k, v) {
						row = "<option value='"+v.ACCBB+"'>"+v.BUKUBESAR+"</option>";
						$(row).appendTo("#modal_bb");
					});
                },
                
            });  
	}

	function get_detail_bb(){
		$.ajax({
                url : '{{url('/keuangan/keuangan/get_detail_bb')}}',
                type: "POST",
                data: { 
					bb : $('#modal_bb').val(),
					_token : '{{ csrf_token() }}'
                },
                dataType: "JSON",
                success: function(data)
                {
                    $('#txtACCBB').val(data.accbb);
					$('#txtGOLONGAN').val(data.kategori);
                },
                
            });  
	}

	function simpan_akun(){
		$.ajax({
                url : '{{url('/keuangan/keuangan/add_sub_buku_besar')}}',
                type: "POST",
                data: { 
					accbb : $('#txtACCBB').val(),
					accsbb : $('#txtACCSBB').val(),
					keterangan : $('#txtKETERANGAN').val(),
					cashflow : $('#modal_kas_flow').val(),
					_token : '{{ csrf_token() }}'
                },
                dataType: "JSON",
                success: function(data)
                {
                    if(data.status=="GAGAL"){
						$.smallBox({
								title : "Gagal",
								content : "Upsss. data Gagal di tambahkan",
								color : "#A90329",
								timeout: 5000,
								icon : "fa fa-times bounce animated"
							});
					}else{
						$.smallBox({
								title : "Berhasil",
								content : 'Data telah ditambahkan...!',
								color : "#739E73",
								timeout: 4000,
								icon : "fa fa-check bounce animated"
								});
								reload_sbb();
								$('#myModal').modal('hide');
					}
                },
                
            });  
	}
		
	</script>

@endsection