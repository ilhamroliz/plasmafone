@extends('main')

@section('title', 'Master Jabatan')

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
			<li>Home</li><li>Master</li><li>Master Jabatan</li><li>Tambah</li>
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

		<div class="col-xs-12">
			@if(Session::has('flash_message_success'))
				<?php $mt = '0px'; ?>
				<div class="col-md-12" style="margin-top: 20px;">
					<div class="alert alert-success alert-block">
						<a class="close" data-dismiss="alert" href="#">×</a>
						<h4 class="alert-heading">&nbsp;<i class="fa fa-thumbs-up"></i> &nbsp;Pemberitahuan Berhasil</h4>
						{{ Session::get('flash_message_success') }} 
					</div>
				</div>
			@elseif(Session::has('flash_message_error'))
				<?php $mt = '0px'; ?>
				<div class="col-md-12" style="margin-top: 20px;">
					<div class="alert alert-danger alert-block">
						<a class="close" data-dismiss="alert" href="#">×</a>
						<h4 class="alert-heading">&nbsp;<i class="fa fa-frown-o"></i> &nbsp;Pemberitahuan Gagal</h4>
						{{ Session::get('flash_message_error') }}
					</div>
				</div>
			@endif
		</div>
		
		<!-- widget grid -->
		<section id="widget-grid" class="" style="margin-bottom: 20px; min-height: 500px;">

			<!-- row -->
			<div class="row">

				<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-md-offset-1" style="padding: 10px 20px; margin-top: 20px; background: #fff;">

					{{-- FormTemplate .. --}}

					<form id="jabatan-form" class="form-horizontal" action="{{ url('/master/jabatan/add') }}" method="post">
						{{ csrf_field() }}
						<fieldset>
							<legend>
								Form Tambah Master Jabatan

								<span class="pull-right" style="font-size: 0.6em; font-weight: 600">
									<a href="{{ url('/master/jabatan') }}">
										<i class="fa fa-arrow-left"></i> &nbsp;Kembali Ke Halaman Data Table
									</a>
								</span>
							</legend>

							<div class="field_wrapper">
								<div class="row" style="margin-top:15px;">

									<div class="col-md-6">
										<div class="form-group">
											<label class="col-xs-3 col-lg-3 control-label text-left">Kode Jabatan</label>
											<div class="col-xs-8 col-lg-8 inputGroupContainer">
												<input type="text" class="form-control" name="kode_jabatan" id="kode_jabatan" placeholder="Masukkan kode jabatan" />
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-xs-3 col-lg-3 control-label text-left">Nama Jabatan</label>
											<div class="col-xs-8 col-lg-8 inputGroupContainer">
												<input type="text" class="form-control" name="nama_jabatan" id="nama_jabatan" placeholder="Masukkan nama jabatan" />
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-xs-3 col-lg-3 control-label text-left">Gaji Pokok</label>
											<div class="col-xs-8 col-lg-8 inputGroupContainer">
												<input type="text" class="form-control" name="gaji_pokok" id="gaji_pokok" onkeypress="return isNumberKey(event)" placeholder="Masukkan gaji pokok" />
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-xs-3 col-lg-3 control-label text-left">Tunjangan Jabatan</label>
											<div class="col-xs-8 col-lg-8 inputGroupContainer">
												<input type="text" class="form-control" name="tunjangan_jabatan" id="tunjangan_jabatan" onkeypress="return isNumberKey(event)" placeholder="Masukkan tunjangan jabatan" />
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-xs-3 col-lg-3 control-label text-left">Tunjangan Kehadiran</label>
											<div class="col-xs-8 col-lg-8 inputGroupContainer">
												<input type="text" class="form-control" name="tunjangan_kehadiran" id="tunjangan_kehadiran" onkeypress="return isNumberKey(event)" placeholder="Masukkan tunjangan kehadiran" />
											</div>
										</div>
									</div>	
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-xs-3 col-lg-3 control-label text-left">Tunjangan Makan</label>
											<div class="col-xs-8 col-lg-8 inputGroupContainer">
												<input type="text" class="form-control" name="tunjangan_makan" id="tunjangan_makan" onkeypress="return isNumberKey(event)" placeholder="Masukkan tunjangan makan" />
											</div>
										</div>
									</div>						

								</div>
							</div>

						</fieldset>

						<div class="form-actions">
							<div class="row">
								<div class="col-md-12">
									<button class="btn btn-default" type="submit">
										<i class="fa fa-floppy-o"></i>
										&nbsp;Submit
									</button>
								</div>
							</div>
						</div>
					</form>

					{{-- FormTemplate End .. --}}

				</div>
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
	<script src="{{ asset('template_asset/js/plugin/choosen/chosen.jquery.js') }}"></script>
	<!-- <script src="{{ asset('template_asset/js/plugin/choosen/init.js') }}"></script> -->

	<script type="text/javascript">
		function isNumberKey(evt) {
		    var charCode = (evt.which) ? evt.which : evt.keyCode;
		    if (charCode > 31 && (charCode < 48 || charCode > 57))
		        return false;
		    return true;
		}

		function formatRupiah(angka, prefix)
		{
			var number_string = angka.replace(/[^,\d]/g, '').toString(),
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

		$(document).ready(function(){

			var i_gaji_pokok = document.getElementById('gaji_pokok'),
				i_tunjangan_jabatan = document.getElementById('tunjangan_jabatan'),
				i_tunjangan_kehadiran = document.getElementById('tunjangan_kehadiran'),
				i_tunjangan_makan = document.getElementById('tunjangan_makan');

			i_gaji_pokok.addEventListener('keyup', function(e)
			{
				i_gaji_pokok.value = formatRupiah(this.value, 'Rp');
			});

			i_tunjangan_jabatan.addEventListener('keyup', function(e){
				i_tunjangan_jabatan.value = formatRupiah(this.value, 'Rp');
			});

			i_tunjangan_kehadiran.addEventListener('keyup', function(e){
				i_tunjangan_kehadiran.value = formatRupiah(this.value, 'Rp');
			});

			i_tunjangan_makan.addEventListener('keyup', function(e){
				i_tunjangan_makan.value = formatRupiah(this.value, 'Rp');
			});
	
			// product form

			$('#jabatan-form').bootstrapValidator({
				feedbackIcons : {
					valid : 'glyphicon glyphicon-ok',
					invalid : 'glyphicon glyphicon-remove',
					validating : 'glyphicon glyphicon-refresh'
				},
				fields : {
					kode_jabatan : {
						validators : {
							notEmpty : {
								message : 'Isi kode jabatan'
							}
						}
					},
					nama_jabatan : {
						validators : {
							notEmpty : {
								message : 'Isi nama jabatan'
							}
						}
					},
					gaji_pokok : {
						validators : {
							notEmpty : {
								message : 'Isi gaji pokok'
							}
						}
					},
					tunjangan_jabatan : {
						validators : {
							notEmpty : {
								message : 'Isi tunjangan jabatan'
							}
						}
					},
					tunjangan_kehadiran : {
						validators : {
							notEmpty : {
								message : 'Isi tunjangan kehadiran'
							}
						}
					},
					tunjangan_makan : {
						validators : {
							notEmpty : {
								message : 'Isi tunjangan makan'
							}
						}
					}
				}
			});

			// end product form


			// End select order
		})
	</script>

@endsection