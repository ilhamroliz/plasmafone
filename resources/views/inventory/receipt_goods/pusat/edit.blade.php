@extends('main')

@section('title', 'Inventory | Penerimaan Barang Dari Pusat')


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
			<li>Home</li><li>Inventory</li><li>Penerimaan Barang Dari Pusat</li><li>Edit</li>
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

					<form id="form-edit" class="form-horizontal" method="post">
						{{ csrf_field() }}
						<fieldset>
							<legend>
								Form Edit Penerimaan Barang Dari Pusat

								<span class="pull-right" style="font-size: 0.6em; font-weight: 600">
									<a href="{{ url('/inventory/penerimaan/pusat') }}">
										<i class="fa fa-arrow-left"></i> &nbsp;Kembali Ke Halaman Data Table
									</a>
								</span>
							</legend>

							<div class="row" style="border-bottom: 1px dotted #aaa; margin-bottom: 20px;">
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-xs-4 col-lg-4 control-label text-left">Pilih Data Yang Diedit</label>
										<div class="col-xs-7 col-lg-7 inputGroupContainer">
											<select class="form-control" name="i_id" id="id">
												@foreach($data as $key => $barang)
													<option value="{{ $barang->i_id }}">{{ $barang->i_kode_barang }} - {{ $barang->i_nama_barang }}</option>
												@endforeach
											</select>
										</div>
									</div>
								</div>

								<div class="col-md-6 text-left" style="padding: 10px 0px; display: none;" id="form-load-section-status">
									<i class="fa fa-cog fa-spin fa-fw"></i> &nbsp;
									<small>Sedang Mengambil Data Baru...</small>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-xs-4 col-lg-4 control-label text-left">Kategori</label>
										<div class="col-xs-7 col-lg-7 inputGroupContainer">
											<select class="form-control" name="kategori" id="kategori">
												<option value="" @if($data[0]->i_kategori == "") selected @endif>---Pilih kategori---</option>
												<option value="Handphone" @if($data[0]->i_kategori == "Handphone") selected @endif>Handphone</option>
												<option value="Simcard" @if($data[0]->i_kategori == "Simcard") selected @endif>Simcard</option>
												<option value="Accessories" @if($data[0]->i_kategori == "Accessories") selected @endif>Accessories</option>
											</select>
										</div>
									</div>
								</div>
							</div>

							<div class="row" style="margin-top:15px;">
								<div class="col-md-6" id="field_imei">
									<div class="form-group">
										<label class="col-xs-4 col-lg-4 control-label text-left">IMEI</label>
										<div class="col-xs-8 col-lg-8 inputGroupContainer">
											<input type="text" class="form-control" name="imei" id="imei" value="@if($data[0]->i_imei != null) {{ $data[0]->i_imei }} @endif" placeholder="Masukkan IMEI" />
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label id="lbl_kb" class="col-xs-4 col-lg-4 control-label text-left">Kode Barang</label>
										<div class="col-xs-8 col-lg-8 inputGroupContainer">
											<input type="text" class="form-control" name="kode_barang" id="kode_barang" value="{{ $data[0]->i_kode_barang }}" placeholder="Masukkan kode barang" />
										</div>
									</div>
								</div>
							</div>

							<div class="row" style="margin-top:15px;">
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-xs-4 col-lg-4 control-label text-left">Nama Barang</label>
										<div class="col-xs-8 col-lg-8 inputGroupContainer">
											<input type="text" class="form-control" name="nama_barang" id="nama_barang" value="{{ $data[0]->i_nama_barang }}" placeholder="Masukkan nama barang" />
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="col-xs-3 col-lg-3 control-label text-left">Kuantitas</label>
										<div class="col-xs-8 col-lg-8 inputGroupContainer">
											<input type="number" min="1" class="form-control" name="qty" id="qty" value="{{ $data[0]->i_qty }}" placeholder="Masukkan kuantitas barang" />
										</div>
									</div>
								</div>
							</div>

							<div class="row" style="margin-top:15px;">
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-xs-4 col-lg-4 control-label text-left">Tanggal Masuk</label>
										<div class="col-xs-8 col-lg-8 inputGroupContainer">
											<input type="text" class="form-control" name="tgl_masuk" id="tgl_masuk" value="{{ $data[0]->i_tgl_masuk }}" placeholder="Masukkan tanggal masuk barang" />
										</div>
									</div>
								</div>
							</div>

						</fieldset>

						<div class="form-actions">
							<div class="row">
								<div class="col-md-12">
									<button class="btn btn-default" id="submit">
										<i class="fa fa-floppy-o"></i>
										&nbsp;Simpan
									</button>
								</div>
							</div>
						</div>
					</form>

					{{-- FormTemplate End .. --}}

				</div>
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
	$(document).ready(function(){

		$('#tgl_masuk').datepicker({
			dateFormat: 'yy-mm-dd',
		    prevText: '<i class="fa fa-chevron-left"></i>',
		    nextText: '<i class="fa fa-chevron-right"></i>'
		});

		if ($('#kategori').val() == "" || $('#kategori').val() != "Handphone") {
			$('#imei').val('');
			$('#field_imei').hide();
		} else {
			$('#field_imei').show();
			$('#lbl_kb').removeClass( "col-xs-4 col-lg-4" ).addClass( "col-xs-3 col-lg-3" );
		}

		// validator

		$('#form-edit').bootstrapValidator({
			feedbackIcons : {
				valid : 'glyphicon glyphicon-ok',
				invalid : 'glyphicon glyphicon-remove',
				validating : 'glyphicon glyphicon-refresh'
			},
			fields : {
				kategori : {
					validators : {
						notEmpty : {
							message : 'Pilih kategori'
						}
					}
				},
				imei : {
					validators : {
						notEmpty : {
							message : 'Masukkan IMEI'
						}
					}
				},
				kode_barang : {
					validators : {
						notEmpty : {
							message : 'Masukkan kode barang'
						}
					}
				},
				nama_barang : {
					validators : {
						notEmpty : {
							message : 'Masukkan nama barang'
						}
					}
				},
				qty : {
					validators : {
						notEmpty : {
							message : 'Masukkan kuantitas barang'
						},
						numeric : {
							message : 'Isi hanya dengan angka'
						}
					}
				},
				tgl_masuk : {
					validators : {
						notEmpty : {
							message : 'Masukkan tanggal masuk barang'
						}
					}
				}
			}
		});

		// end validator

		$('#id').change(function(evt){
			evt.preventDefault(); let context = $(this);
			$('#form-load-section-status').fadeIn(200);

			axios.get(baseUrl+'/inventory/penerimaan/pusat/get-current-receipt-pusat/'+context.val())
				.then((response) => {
					if(response.data == null){
						context.children('option:selected').attr('disabled', 'disabled');
						$.toast({
						    text: 'Ups . Data Yang Ingin Anda Edit Sudah Tidak Ada..',
						    showHideTransition: 'fade',
						    icon: 'error'
						})
						$('#form-load-section-status').fadeOut(200);
					}else{
						initiate(response.data);
						console.log(response.data);
						$('#form-load-section-status').fadeOut(200);
					}
				})
				.catch((err) => {
					console.log(err);
				})
			
		})

		function initiate(data){
			if (data.i_imei == null) {
				$("#kategori").val(data.i_kategori);
				$("#imei").val('');
				$("#kode_barang").val(data.i_kode_barang);
				$("#nama_barang").val(data.i_nama_barang);
				$("#qty").val(data.i_qty);
				$("#tgl_masuk").val(data.i_tgl_masuk);
				$('#field_imei').hide();
				$('#lbl_kb').removeClass( "col-xs-3 col-lg-3" ).addClass( "col-xs-4 col-lg-4" );
			} else {
				$("#kategori").val(data.i_kategori);
				$("#imei").val(data.i_imei);
				$("#kode_barang").val(data.i_kode_barang);
				$("#nama_barang").val(data.i_nama_barang);
				$("#qty").val(data.i_qty);
				$("#tgl_masuk").val(data.i_tgl_masuk);
				$('#field_imei').show();
				$('#lbl_kb').removeClass( "col-xs-4 col-lg-4" ).addClass( "col-xs-3 col-lg-3" );
			}
			
		}

		$('#form-edit').submit(function(evt){
			evt.preventDefault();
			if($(this).data('bootstrapValidator').validate().isValid()){
				
				let btn = $('#submit');
				btn.attr('disabled', 'disabled');

				axios.post(baseUrl+'/inventory/penerimaan/pusat/update', $('#form-edit').serialize())
				.then((response) => {
					if(response.data.status == 'berhasil'){
						$.toast({
						    text: 'Data Ini berhasil Diupdate',
						    showHideTransition: 'fade',
						    icon: 'success'
						})
					}else if(response.data.status == 'tidak ada'){
						$.toast({
						    text: 'Ups . Data Yang Ingin Anda Edit Sudah Tidak Ada..',
						    showHideTransition: 'fade',
						    icon: 'error'
						})
					}
				}).catch((err) => {
					console.log(err);
				}).then(function(){
					btn.removeAttr('disabled');
				})
			}

		})

		
	})
</script>

@endsection