@extends('main')

@section('title', 'Master Jenis Barang')


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
		<li>Home</li><li>Master</li><li>Jenis Barang</li><li>Edit</li>
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

				<form id="data-form" class="form-horizontal" method="post">
					{{ csrf_field() }}
					<fieldset>
						<legend>
							Form Edit Jenis Barang

							<span class="pull-right" style="font-size: 0.6em; font-weight: 600">
								<a href="{{ url('/master/jenis-barang') }}">
									<i class="fa fa-arrow-left"></i> &nbsp;Kembali Ke Halaman Data Table
								</a>
							</span>
						</legend>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-xs-4 col-lg-4 control-label text-left">Parent</label>
									<div class="col-xs-7 col-lg-7 inputGroupContainer">
										<select class="form-control" id="parent" v-model="form_data.parent" name="parent">
											<option value="0" @if($data[0]->j_parent == '0') selected @endif>Jenis Utama</option>
											<option v-for="(data_jenis, index) in jenis" :value="data_jenis.j_id">@{{ data_jenis.j_name }}</option>
										</select>	
									</div>
								</div>
							</div>
						</div>

						<div class="row" style="margin-top:15px;">
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-xs-4 col-lg-4 control-label text-left">Jenis Barang</label>
									<div class="col-xs-7 col-lg-7 inputGroupContainer">
										<input type="text" class="form-control" id="jenis_barang" name="jenis_barang" v-model="form_data.jenis_barang" placeholder="Masukkan jenis barang" />
									</div>
								</div>
							</div>
						</div>

						<div class="row" style="margin-top:15px;">
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-xs-4 col-lg-4 control-label text-left">Keterangan</label>
									<div class="col-xs-7 col-lg-7 inputGroupContainer">
										<textarea class="form-control" id="keterangan" name="keterangan" v-model="form_data.keterangan" rows="4" placeholder="Masukkan keterangan jenis barang... (Optional)"></textarea>
									</div>
								</div>
							</div>
						</div>

					</fieldset>

					<div class="form-actions">
						<div class="row">
							<div class="col-md-12">
								<button class="btn btn-primary" type="button" id="submit" @click="submit_form" :disabled="btn_save_disabled">
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
		// product form
		var baseUrl = '{{ url('/') }}';

		function validation_regis(){
			$('#data-form').bootstrapValidator({
				feedbackIcons : {
					valid : 'glyphicon glyphicon-ok',
					invalid : 'glyphicon glyphicon-remove',
					validating : 'glyphicon glyphicon-refresh'
				},
				fields : {
					jenis_barang : {
						validators : {
							notEmpty : {
								message : 'Jenis Barang Tidak Boleh Kosong'
							}
						}
					}
				}
			});
		}

		var app = new Vue({
			el 		: '#content',
			data 	: {

				jenis 				: {},
				btn_save_disabled 	: false,

				form_data : {
					parent 			: 0,
					jenis_barang	: '',
					keterangan 		: ''
				}

			},
			mounted: function(){
				validation_regis();
				// console.log(this.form_data.nama_lengkap);
			},
			created: function(){
				axios.get(baseUrl+'/master/jenis-barang/get-resources')
						.then(response => {
							console.log(response.data);
							if (response.data.status == "berhasil") {
								this.jenis 	= response.data.jenis;
								if (this.jenis == '{{ $jenisDetails->j_parent }}') {
									this.selected;
								}
								this.form_data.jenis_barang = '{{ $data[0]->j_name }}';
								this.form_data.keterangan = '{{ $data[0]->j_description }}';
							} else {
								$.toast({
								    text: 'Ada kesalahan dalam proses pengambilan resources, mulai ulang halamn (Refresh Page)...!',
								    showHideTransition: 'fade',
								    icon: 'error'
								})
							}
							
						})
			},
			methods: {
				submit_form: function(e){
					e.preventDefault();

					if($('#data-form').data('bootstrapValidator').validate().isValid()){
						this.btn_save_disabled = true;
						let btn = $('#submit');
						btn.attr('disabled', 'disabled');
						btn.html('<i class="fa fa-floppy-o"></i> &nbsp;Proses...');

						axios.post(baseUrl+'/master/jenis-barang/add', 
							$('#data-form').serialize()
						).then((response) => {

							if(response.data.status == 'berhasil'){

								$.toast({
								    text: 'Data Supplier terbaru Anda berhasil disimpan...!',
								    showHideTransition: 'fade',
								    icon: 'success'
								})

								this.reset_form();
								this.jenis 	= response.data.jenis;
							} else {
								$.toast({
								    text: 'Ada kesalahan dalam proses input data, coba lagi...!',
								    showHideTransition: 'fade',
								    icon: 'error'
								})
							}

						}).catch((err) => {
							console.log(err);
						}).then(() => {
							this.btn_save_disabled = false;
							btn.html('<i class="fa fa-floppy-o"></i> &nbsp;Simpan');
						})

						return false;
					}else{
						$.toast({
						    text: 'Ada Kesalahan Dengan Inputan Anda. Harap Mengecek Ulang..',
						    showHideTransition: 'fade',
						    icon: 'error'
						})
					}
				},

				reset_form:function(){
					this.form_data.parent 		= 0;
					this.form_data.jenis_barang = '';
					this.form_data.keterangan 	= '';
					$('#data-form').data('bootstrapValidator').resetForm();
				}
			}
		});

		// end product form
	})
</script>

@endsection