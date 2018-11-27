@extends('main')

@section('title', 'Master karyawan')


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
			<li>Home</li><li>Master</li><li>Barang</li><li>Tambah</li>
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
								Form Tambah Barang

								<span class="pull-right" style="font-size: 0.6em; font-weight: 600">
									<a href="{{ url('/master/barang') }}">
										<i class="fa fa-arrow-left"></i> &nbsp;Kembali Ke Halaman Data Table
									</a>
								</span>
							</legend>

							<div class="row ">
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-xs-4 col-lg-4 control-label text-left">Kelompok</label>
										<div class="col-xs-7 col-lg-7 inputGroupContainer">
											<div class="input-group" id="select_kelompok">
												<span class="input-group-addon" style="cursor: pointer;" @click="switch_kelompok"><i class="fa fa-exchange"></i></span>
												<kelompok :options="data_I_kelompok" @change="i_kelompok_change" v-model="form_data.i_kelompok">
											      
											    </kelompok>
											</div>

											<div class="input-group" id="input_kelompok" style="display: none;">
												<span class="input-group-addon" style="cursor: pointer;" @click="switch_kelompok"><i class="fa fa-exchange"></i></span>

												<input type="text" class="form-control" name="i_kelompok" v-model="form_data.i_kelompok" placeholder="Tambahkan Jenis Barang">
											</div>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="col-xs-4 col-lg-4 control-label text-left">Kode Barang</label>
										<div class="col-xs-7 col-lg-7 inputGroupContainer">
											<input type="text" class="form-control" name="i_code" id="i_code" placeholder="Masukkan Kode Barang" v-model="form_data.i_code"/>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="col-xs-4 col-lg-4 control-label text-left">Group</label>
										<div class="col-xs-7 col-lg-7 inputGroupContainer">
											<div class="input-group" id="select_group">
												<span class="input-group-addon" style="cursor: pointer;" @click="switch_group"><i class="fa fa-exchange"></i></span>
												<group :options="data_I_group" @change="i_group_change" v-model="form_data.i_group">
											      
											    </group>
											</div>

											<div class="input-group" id="input_group" style="display: none;">
												<span class="input-group-addon" style="cursor: pointer;" @click="switch_group"><i class="fa fa-exchange"></i></span>

												<input type="text" class="form-control" name="i_group" v-model="form_data.i_group" placeholder="Tambahkan Group Barang">
											</div>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="col-xs-4 col-lg-4 control-label text-left">Status Barang</label>
										<div class="col-xs-7 col-lg-7 inputGroupContainer" v-model="form_data.i_isactive" name="i_isactive">
											<select class="form-control">
												<option value="Y">Aktif</option>
												<option value="N">Non Aktif</option>
											</select>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="col-xs-4 col-lg-4 control-label text-left">Sub Group</label>
										<div class="col-xs-7 col-lg-7 inputGroupContainer">
											<div class="input-group" id="select_subgroup">
												<span class="input-group-addon" style="cursor: pointer;" @click="switch_subgroup"><i class="fa fa-exchange"></i></span>
												<subgroup :options="data_I_subgroup" @change="i_subgroup_change" v-model="form_data.i_subgroup">
											      
											    </subgroup>
											</div>

											<div class="input-group" id="input_subgroup" style="display: none;">
												<span class="input-group-addon" style="cursor: pointer;" @click="switch_subgroup"><i class="fa fa-exchange"></i></span>

												<input type="text" class="form-control" name="i_subgroup" v-model="form_data.i_subgroup" placeholder="Tambahkan Sub Group Barang">
											</div>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="col-xs-4 col-lg-4 control-label text-left">Minimun Stok</label>
										<div class="col-xs-7 col-lg-7 inputGroupContainer">
											<input type="text" class="form-control" name="i_minstock" id="i_minstock" placeholder="Masukkan Minimum Stok Barang" v-model='form_data.i_minstock' />
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="col-xs-4 col-lg-4 control-label text-left">Merk</label>
										<div class="col-xs-7 col-lg-7 inputGroupContainer">
											<div class="input-group" id="select_merk">
												<span class="input-group-addon" style="cursor: pointer;" @click="switch_merk"><i class="fa fa-exchange"></i></span>
												<merk :options="data_I_merk" @change="i_merk_change" v-model="form_data.i_merk">
											      
											    </merk>
											</div>

											<div class="input-group" id="input_merk" style="display: none;">
												<span class="input-group-addon" style="cursor: pointer;" @click="switch_merk"><i class="fa fa-exchange"></i></span>

												<input type="text" class="form-control" name="i_merk" v-model="form_data.i_merk" placeholder="Tambahkan Merk Barang">
											</div>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="col-xs-4 col-lg-4 control-label text-left">Berat Satuan (gram)</label>
										<div class="col-xs-7 col-lg-7 inputGroupContainer">
											<input type="text" class="form-control" name="i_berat" id="i_berat" placeholder="Masukkan Berat Satuan Barang (gram)" v-model='form_data.i_berat' />
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="col-xs-4 col-lg-4 control-label text-left">Nama Barang</label>
										<div class="col-xs-7 col-lg-7 inputGroupContainer">
											<input type="text" class="form-control" name="i_nama" id="i_nama" placeholder="Masukkan Nama Barang" v-model='form_data.i_nama' />
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="col-xs-4 col-lg-4 control-label text-left">Specific Code</label>
										<div class="col-xs-7 col-lg-7 inputGroupContainer">
											<select class="form-control" v-model="form_data.i_specificcode" name="i_specificcode">
												<option value="Y">Ya</option>
												<option value="N">Tidak</option>
											</select>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="col-xs-4 col-lg-4 control-label text-left">Gambar</label>
										<div class="col-xs-7 col-lg-7 inputGroupContainer">
											<div class="form-control" style="padding: 0; align-items: center; align-self: center; cursor: pointer;">
												<input type="file" accept="image/*" style="cursor: pointer;" class="input-xs" name="i_img" id="i_img" placeholder="Masukkan Gambar Barang" v-model='form_data.i_img' onchange="loadFile(event)" />
											</div>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div id="preview" class="preview thumbnail" style="width: 100%; height: 150px; line-height: 150px;">
										Preview Image
									</div>
								</div>
							</div>

						</fieldset>

						<div class="form-actions">
							<div class="row">
								<div class="col-md-12">
									<button class="btn btn-primary" type="button" @click="submit_form" :disabled="btn_save_disabled">
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
	<script src="{{ asset('template_asset/js/app.min.js') }}"></script>
	<script src="{{ asset('template_asset/js/plugin/bootstrapvalidator/bootstrapValidator.min.js') }}"></script>
	<script type="text/x-template" id="select2-template">
	  <select style="width:100%" name="i_jenis" required>
	  	<option value="">-- Pilih Jenis Barang</option>
	    <option v-for="option in options" :value="option.i_jenis">@{{ option.i_jenis }}</option>
	  </select>
	</script>

	<script type="text/x-template" id="select2-template-jenissub">
	  <select style="width:100%" name="i_jenissub">
	  	<option value="">-- Pilih Jenis Barang</option>
	    <option v-for="option in options" :value="option.i_jenissub" v-if="option.i_jenis == filter">@{{ option.i_jenissub }}</option>
	  </select>
	</script>

	<script type="text/x-template" id="select2-template-class">
	  <select style="width:100%" name="i_class">
	  	<option value="">-- Pilih Jenis Barang</option>
	    <option v-for="option in options" :value="option.i_class" v-if="option.i_jenissub == filter">@{{ option.i_class }}</option>
	  </select>
	</script>

	<script type="text/x-template" id="select2-template-classsub">
	  <select style="width:100%" name="i_classub">
	  	<option value="">-- Pilih Jenis Barang</option>
	    <option v-for="option in options" :value="option.i_classsub" v-if="option.i_class == filter">@{{ option.i_classsub }}</option>
	  </select>
	</script>

	<script type="text/javascript">
		var loadFile = function(event) {
			$("#preview").html("");
			
			$("#preview").append("<img id='img_prev' style='z-index:1000;' src='"+URL.createObjectURL(event.target.files[0])+"'>");
			$("#preview").append('<div class="transparant"><button type="button" id="delete_preview" class="btn btn-danger btn-circle" style="display: block; margin: 0px auto; text-align: center; z-index: 2000;"><i class="glyphicon glyphicon-remove"></i></button></div>');
		    
		};

		$(document).ready(function () {
		    $('#preview').mouseover(function() {
		    	$('.transparant').show();
		    }).mouseout(function(){
		    	$('.transparant').hide();
		    })
		});
	</script>

		<script type="text/javascript">

			var baseUrl = '{{ url('/') }}';

			function validation_regis(){
				$('#data-form').bootstrapValidator({
					feedbackIcons : {
						valid : 'glyphicon glyphicon-ok',
						invalid : 'glyphicon glyphicon-remove',
						validating : 'glyphicon glyphicon-refresh'
					},
					fields : {
						i_detail : {
							validators : {
								notEmpty : {
									message : 'Nama Barang Tidak Boleh Kosong',
								}
							}
						},

						i_jenis : {
							validators : {
								notEmpty : {
									message : 'Inputan Jenis Tidak Boleh Kosong',
								}
							}
						},

						i_satuan : {
							validators : {
								notEmpty : {
									message : 'Satuan Tidak Boleh Kosong',
								}
							}
						},

						i_minstock : {
							validators : {
								notEmpty : {
									message : 'Minimal Stok Tidak Boleh Kosong',
								},

								numeric: {
									message : 'Tampaknya Ada Yang Salah Dengan Inputan Minimal Stok Anda'
								}
							}
						},

						i_detail : {
							validators : {
								notEmpty : {
									message : 'Nama Barang Tidak Boleh Kosong',
								}
							}
						},

						i_berat : {
							validators : {
								notEmpty : {
									message : 'Berat Tidak Boleh Kosong',
								}
							}
						},

						i_berat : {
							validators : {
								notEmpty : {
									message : 'Nama Barang Tidak Boleh Kosong',
								},

								numeric: {
									message : 'Tampaknya Ada Yang Salah Dengan Inputan Berat Anda'
								}
							}
						},

					}
				});
			}

			Vue.component('kelompok', {
			  props: ['options'],
			  template: '#select2-template',
			  mounted: function () {
			    var vm = this
			    $(this.$el).select2().on('change', function () {
			        vm.$emit('change', this.value)
			    })
			  },
			  watch: {
			    value: function (value) {
			      // update value
			      $(this.$el).val(value);
			    },
			    options: function (options) {
			      // update options
			      // $(this.$el).empty().select2()
			    }
			  },
			  destroyed: function () {
			    $(this.$el).off().select2('destroy')
			  }
			})

			Vue.component('group', {
			  props: ['options'],
			  template: '#select2-template',
			  mounted: function () {
			    var vm = this
			    $(this.$el).select2().on('change', function () {
			        vm.$emit('change', this.value)
			    })
			  },
			  watch: {
			    value: function (value) {
			      // update value
			      $(this.$el).val(value);
			    },
			    options: function (options) {
			      // update options
			      // $(this.$el).empty().select2()
			    }
			  },
			  destroyed: function () {
			    $(this.$el).off().select2('destroy')
			  }
			})

			Vue.component('subgroup', {
			  props: ['options'],
			  template: '#select2-template',
			  mounted: function () {
			    var vm = this
			    $(this.$el).select2().on('change', function () {
			        vm.$emit('change', this.value)
			    })
			  },
			  watch: {
			    value: function (value) {
			      // update value
			      $(this.$el).val(value);
			    },
			    options: function (options) {
			      // update options
			      // $(this.$el).empty().select2()
			    }
			  },
			  destroyed: function () {
			    $(this.$el).off().select2('destroy')
			  }
			})

			Vue.component('merk', {
			  props: ['options'],
			  template: '#select2-template',
			  mounted: function () {
			    var vm = this
			    $(this.$el).select2().on('change', function () {
			        vm.$emit('change', this.value)
			    })
			  },
			  watch: {
			    value: function (value) {
			      // update value
			      $(this.$el).val(value);
			    },
			    options: function (options) {
			      // update options
			      // $(this.$el).empty().select2()
			    }
			  },
			  destroyed: function () {
			    $(this.$el).off().select2('destroy')
			  }
			})


			var app = new Vue({
				el 		: '#content',
				data 	: {
					kelompok : 'select',
					group : 'select',
					subgroup : 'select',
					merk : 'select',
					jenis : 'select',
					subjenis1: 'select',
					subjenis2: 'select',
					subjenis3: 'select',
					btn_save_disabled 	: false,
					supplier_count: 1,

					data_I_kelompok: [],
					data_I_group: [],
					data_I_subgroup: [],
					data_I_merk: [],
					data_supplier: [],

					// jenissub : 'okee',

					form_data : {
						i_kelompok: '',
						i_group: '',
						i_subgroup: '',
						i_merk: '',
						i_detail: '',
						i_satuan: '',
						i_minstock: '',
						i_berat: '',
						i_specificcode: 'Y',
						i_status: 'Y'
						
					}

				},
				mounted: function(){
					validation_regis();
					$('#overlay').fadeIn(200);
					$('#load-status-text').text('Sedang Menyiapkan Form');

					// console.log(this.form_data.nama_lengkap);
				},
				created: function(){
					axios.get(baseUrl+'/master/barang/get/form-resource')
							.then(response => {
								// console.log(response.data);
								this.data_I_kelompok = response.data.kelompok;
								// this.data_I_jenis = response.data.jenis;
								// this.data_I_jenissub = response.data.subjenis;
								// this.data_class = response.data.class;
								// this.data_classsub = response.data.classsub;
								// this.data_supplier = response.data.suplier;

								// console.log(this.data_classsub);
								$("#overlay").fadeOut(200);
							})
				},
				methods: {
					submit_form: function(e){
						e.preventDefault();

						if($('#data-form').data('bootstrapValidator').validate().isValid()){
							this.btn_save_disabled = true;

							axios.post(baseUrl+'/master/barang/insert', 
								$('#data-form').serialize()
							).then((response) => {
								console.log(response.data);
								if(response.data.status == 'berhasil'){
									$.toast({
									    text: 'Data Karyawan Terbaru Anda Berhasil Kami Simpan..',
									    showHideTransition: 'fade',
									    icon: 'success'
									})

									this.reset_form();

								}else if(response.data.status == 'jabatan_not_found'){
									$.toast({
									    text: 'Ada Kesalahan Jabatan Yang Anda Pilih Sudah Tidak Bisa Kami Temukan. Cobalah Untuk Memuat Ulang Halaman..',
									    showHideTransition: 'fade',
									    icon: 'error'
									})
								}else if(response.data.status == 'posisi_not_found'){
									$.toast({
									    text: 'Ada Kesalahan Posisi Yang Anda Pilih Sudah Tidak Bisa Kami Temukan. Cobalah Untuk Memuat Ulang Halaman..',
									    showHideTransition: 'fade',
									    icon: 'error'
									})
								}

							}).catch((err) => {
								console.log(err);
							}).then(() => {
								this.btn_save_disabled = false;
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

					switch_kelompok: function(){
						if(this.kelompok == 'select'){
							this.kelompok = 'input';
							$('#select_kelompok').hide();
							$("#input_kelompok").show();
						}else{
							this.kelompok = 'select';
							$('#input_kelompok').hide();
							$("#select_kelompok").show();
						}
					},

					switch_group: function(){
						if(this.group == 'select'){
							this.group = 'input';
							$('#select_group').hide();
							$("#input_group").show();
						}else{
							this.group = 'select';
							$('#input_group').hide();
							$("#select_group").show();
						}
					},

					switch_subgroup: function(){
						if(this.subgroup == 'select'){
							this.subgroup = 'input';
							$('#select_subgroup').hide();
							$("#input_subgroup").show();
						}else{
							this.subgroup = 'select';
							$('#input_subgroup').hide();
							$("#select_subgroup").show();
						}
					},

					switch_merk: function(){
						if(this.merk == 'select'){
							this.merk = 'input';
							$('#select_merk').hide();
							$("#input_merk").show();
						}else{
							this.merk = 'select';
							$('#input_merk').hide();
							$("#select_merk").show();
						}
					},

					i_kelompok_change: function(v){
						this.form_data.i_kelompok = v;
						this.form_data.i_group = '';
						this.form_data.i_subgroup = '';
						this.form_data.i_merk = '';
					},

					i_group_change: function(v){
						this.form_data.i_kelompok = '';
						this.form_data.i_group = v;
						this.form_data.i_subgroup = '';
						this.form_data.i_merk = '';
					},

					i_subgroup_change: function(v){
						this.form_data.i_kelompok = '';
						this.form_data.i_group = '';
						this.form_data.i_subgroup = v;
						this.form_data.i_merk = '';
					},

					i_merk_change: function(v){
						this.form_data.i_kelompok = '';
						this.form_data.i_group = '';
						this.form_data.i_subgroup = '';
						this.form_data.i_merk = v;
					},

					add_supplier: function(){
						this.supplier_count++;
					},

					remove_supplier: function(id){
						if(this.supplier_count == 1){
							alert('Barang Minimal Harus Memiliki 1 Harga Dari Supplier')
							return false;
						}
						$('div.row.row_'+id).remove();
						// this.supplier_count--;
					},

					reset_form:function(){
						this.form_data.nama_lengkap 		= '';
						this.form_data.id_jabatan 			= this.jabatan[0].id;
						this.form_data.id_posisi 			= this.posisi[0].id_posisi;
						this.form_data.id_kota 				= this.kota[0].id;
						this.form_data.alamat_rumah 		= '';
						this.form_data.nomor_telp 			= '';
						this.form_data.Kewarganegaraan		= '';
						this.form_data.agama 				= '';
						this.form_data.status_pernikahan	= 0;
						this.form_data.pendidikan_sd 		= '';
						this.form_data.pendidikan_smp 		= '';
						this.form_data.pendidikan_sma 		= '';
						this.form_data.pendidikan_kuliah 	= '';
						$('#data-form').data('bootstrapValidator').resetForm();
					}
				}
			});


		</script>

@endsection