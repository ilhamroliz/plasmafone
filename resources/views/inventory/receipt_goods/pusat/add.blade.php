@extends('main')

@section('title', 'Inventory Penerimaan Barang Dari Pusat')


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
			<li>Home</li><li>Inventory</li><li>Penerimaan Barang Dari Pusat</li><li>Tambah</li>
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

					<form id="add-form" class="form-horizontal" action="{{ url('/inventory/penerimaan/pusat/add') }}" method="post">
						{{ csrf_field() }}
						<fieldset>
							<legend>
								Form Tambah Penerimaan Barang Dari Pusat

								<span class="pull-right" style="font-size: 0.6em; font-weight: 600">
									<a href="{{ url('/inventory/penerimaan/pusat') }}">
										<i class="fa fa-arrow-left"></i> &nbsp;Kembali Ke Halaman Data Table
									</a>
								</span>
							</legend>

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-xs-4 col-lg-4 control-label text-left">Kategori</label>
										<div class="col-xs-7 col-lg-7 inputGroupContainer">
											<select class="form-control" name="kategori" id="kategori">
												<option value="">---Pilih kategori---</option>
												<option value="Handphone">Handphone</option>
												<option value="Simcard">Simcard</option>
												<option value="Accessories">Accessories</option>
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
											<input type="text" class="form-control" name="imei" id="imei" placeholder="Masukkan IMEI" />
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label id="lbl_kb" class="col-xs-4 col-lg-4 control-label text-left">Kode Barang</label>
										<div class="col-xs-8 col-lg-8 inputGroupContainer">
											<input type="text" class="form-control" name="kode_barang" id="kode_barang" placeholder="Masukkan kode barang" />
										</div>
									</div>
								</div>
							</div>

							<div class="row" style="margin-top:15px;">
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-xs-4 col-lg-4 control-label text-left">Nama Barang</label>
										<div class="col-xs-8 col-lg-8 inputGroupContainer">
											<input type="text" class="form-control" name="nama_barang" id="nama_barang" placeholder="Masukkan nama barang" />
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="col-xs-3 col-lg-3 control-label text-left">Kuantitas</label>
										<div class="col-xs-8 col-lg-8 inputGroupContainer">
											<input type="number" min="1" class="form-control" name="qty" id="qty" placeholder="Masukkan kuantitas barang" />
										</div>
									</div>
								</div>
							</div>

							<div class="row" style="margin-top:15px;">
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-xs-4 col-lg-4 control-label text-left">Tanggal Masuk</label>
										<div class="col-xs-8 col-lg-8 inputGroupContainer">
											<input type="text" class="form-control" name="tgl_masuk" id="tgl_masuk" placeholder="Masukkan tanggal masuk barang" />
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
		}

		$('#add-form').bootstrapValidator({
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

		$('#kategori').on('change', function(e){
			var context = $(this);
			if (context.val() == "Handphone") {
				$('#imei').val('');
				$('#field_imei').show();
				$('#lbl_kb').removeClass( "col-xs-4 col-lg-4" ).addClass( "col-xs-3 col-lg-3" );
			} else {
				$('#imei').val('');
				$('#field_imei').hide();
				$('#lbl_kb').removeClass( "col-xs-3 col-lg-3" ).addClass( "col-xs-4 col-lg-4" );
			}
		})
	})
</script>

@endsection