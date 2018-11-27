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

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-xs-4 col-lg-4 control-label text-left">Nama Barang</label>
										<div class="col-xs-7 col-lg-7 inputGroupContainer">
											<input type="text" class="form-control" name="i_detail" id="i_detail" placeholder="Masukkan Nama Barang" v-model='form_data.i_detail' />
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-xs-4 col-lg-4 control-label text-left">Jenis Barang</label>
										<div class="col-xs-7 col-lg-7 inputGroupContainer">
											<div class="input-group" id="select_jenis">
												<span class="input-group-addon" style="cursor: pointer;" @click="switch_jenis"><i class="fa fa-exchange"></i></span>
												<jenis :options="data_I_jenis" @change="i_jenis_change" v-model="form_data.i_jenis">
											      
											    </jenis>
											</div>

											<div class="input-group" id="input_jenis" style="display: none;">
												<span class="input-group-addon" style="cursor: pointer;" @click="switch_jenis"><i class="fa fa-exchange"></i></span>

												<input type="text" class="form-control" name="i_jenis" v-model="form_data.i_jenis" placeholder="Tambahkan Jenis Barang">
											</div>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="col-xs-4 col-lg-4 control-label text-left">Sub Jenis 1</label>
										<div class="col-xs-7 col-lg-7 inputGroupContainer">
											<div class="input-group" id="select_sub_jenis_1">
												<span class="input-group-addon" style="cursor: pointer;" @click="switch_subjenis1"><i class="fa fa-exchange"></i></span>
												<jenissub :options="data_I_jenissub" :filter="form_data.i_jenis" @change="i_jenissub_change" v-model="form_data.i_jenissub">
											      
											    </jenissub>
											</div>

											<div class="input-group" id="input_sub_jenis_1" style="display: none;">
												<span class="input-group-addon" style="cursor: pointer;" @click="switch_subjenis1"><i class="fa fa-exchange"></i></span>

												<input type="text" class="form-control" name="i_jenissub" v-model="form_data.i_jenissub" placeholder="Tambahkan Sub Jenis 1 Barang">
											</div>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="col-xs-4 col-lg-4 control-label text-left">Sub Jenis 2</label>
										<div class="col-xs-7 col-lg-7 inputGroupContainer">
											<div class="input-group" id="select_sub_jenis_2">
												<span class="input-group-addon" style="cursor: pointer;" @click="switch_subjenis2"><i class="fa fa-exchange"></i></span>
												<class :options="data_class" :filter="form_data.i_jenissub" @change="i_class_change" v-model="form_data.i_class">
											      
											    </class>
											</div>

											<div class="input-group" id="input_sub_jenis_2" style="display: none;">
												<span class="input-group-addon" style="cursor: pointer;" @click="switch_subjenis2"><i class="fa fa-exchange"></i></span>

												<input type="text" class="form-control" name="i_class" v-model="form_data.i_class" placeholder="Tambahkan Sub Jenis 2 Barang">
											</div>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="col-xs-4 col-lg-4 control-label text-left">Sub Jenis 3</label>
										<div class="col-xs-7 col-lg-7 inputGroupContainer">
											<div class="input-group" id="select_sub_jenis_3">
												<span class="input-group-addon" style="cursor: pointer;" @click="switch_subjenis3"><i class="fa fa-exchange"></i></span>
												<classsub :options="data_classsub" :filter="form_data.i_class"  @change="i_classsub_change" v-model="form_data.i_classsub">
											      
											    </classsub>
											</div>

											<div class="input-group" id="input_sub_jenis_3" style="display: none;">
												<span class="input-group-addon" style="cursor: pointer;" @click="switch_subjenis3"><i class="fa fa-exchange"></i></span>

												<input type="text" class="form-control" name="i_classub" v-model="form_data.i_classsub" placeholder="Tambahkan Sub Jenis 3 Barang">
											</div>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="col-xs-4 col-lg-4 control-label text-left">Satuan Barang</label>
										<div class="col-xs-7 col-lg-7 inputGroupContainer">
											<input type="text" class="form-control" name="i_satuan" id="i_satuan" placeholder="Masukkan Satuan Barang" v-model="form_data.i_satuan"/>
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
										<label class="col-xs-4 col-lg-4 control-label text-left">Berat Satuan (gram)</label>
										<div class="col-xs-7 col-lg-7 inputGroupContainer">
											<input type="text" class="form-control" name="i_berat" id="i_berat" placeholder="Masukkan Berat Satuan Barang (gram)" v-model='form_data.i_berat' />
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="col-xs-4 col-lg-4 control-label text-left">Memiliki IMEI</label>
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
										<label class="col-xs-4 col-lg-4 control-label text-left">Status Barang</label>
										<div class="col-xs-7 col-lg-7 inputGroupContainer" v-model="form_data.i_isactive" name="i_isactive">
											<select class="form-control">
												<option value="Y">Aktif</option>
												<option value="N">Tidak</option>
											</select>
										</div>
									</div>
								</div>
							</div>

						</fieldset>

						<fieldset style="margin-top: 20px;">
							<legend>
								<b>Informasi Harga Barang Di Berbagai Supplier</b>

								<button type="button" class="btn btn-success pull-right" @click="add_supplier"><i class="fa fa-plus"></i></button>
							</legend>

							<div :class="'row '+'row_'+n" v-for="(n, idx) in supplier_count">

								<div class="col-md-1">
									<button type="button" class="btn btn-danger btn-xs" @click="remove_supplier(n)" v-if="idx != 0"><i class="fa fa-eraser"></i></button>
								</div>

								<div class="col-md-5">
									<div class="form-group">
										<label class="col-xs-4 col-lg-4 control-label text-left">Supplier</label>
										<div class="col-xs-7 col-lg-7 inputGroupContainer">
											<select class="form-control" name="id_supplier[]">
												<option v-for="supplier in data_supplier" :value="supplier.s_id">@{{ supplier.s_name }}</option>
											</select>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="col-xs-4 col-lg-4 control-label text-left">Harga</label>
										<div class="col-xs-7 col-lg-7 inputGroupContainer">
											<div class="input-group">
												<span class="input-group-addon">Rp.</span>
												<input type="number" class="form-control" name="harga_supplier[]" placeholder="Harga Di Supplier Ini" />
											</div>
										</div>
									</div>
								</div>
							</div>

						</fieldset>

						<div class="form-actions">
							<div class="row">
								<div class="col-md-12">
									<button class="btn btn-default" type="button" @click="submit_form" :disabled="btn_save_disabled">
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

			Vue.component('jenis', {
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

			Vue.component('jenissub', {
			  props: ['options', 'filter'],
			  template: '#select2-template-jenissub',
			  mounted: function () {
			    var vm = this;
			    $(this.$el).select2().on('change', function () {
			        vm.$emit('change', this.value)
			    })
			  },
			  watch: {
			    value: function (value) {
			      // update value
			      $(this.$el).val(value);
			    },
			    filter: function(){
			    	$(this.$el).val('').select2()
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

			Vue.component('class', {
			  props: ['options', 'filter'],
			  template: '#select2-template-class',
			  mounted: function () {
			    var vm = this;
			    $(this.$el).select2().on('change', function () {
			        vm.$emit('change', this.value)
			    })
			  },
			  watch: {
			    value: function (value) {
			      // update value
			      $(this.$el).val(value);
			    },
			    filter: function(){
			    	$(this.$el).val('').select2()
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

			Vue.component('classsub', {
			  props: ['options', 'filter'],
			  template: '#select2-template-classsub',
			  mounted: function () {
			    var vm = this;
			    $(this.$el).select2().on('change', function () {
			        vm.$emit('change', this.value)
			    })
			  },
			  watch: {
			    value: function (value) {
			      // update value
			      $(this.$el).val(value);
			    },
			    filter: function(){
			    	$(this.$el).val('').select2()
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

					jenis : 'select',
					subjenis1: 'select',
					subjenis2: 'select',
					subjenis3: 'select',
					btn_save_disabled 	: false,
					supplier_count: 1,

					data_I_jenis: [],
					data_I_jenissub: [],
					data_class: [],
					data_classsub: [],
					data_supplier: [],

					// jenissub : 'okee',

					form_data : {
						i_jenis: '',
						i_jenissub: '',
						i_class: '',
						i_classsub: '',
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

								this.data_I_jenis = response.data.jenis;
								this.data_I_jenissub = response.data.subjenis;
								this.data_class = response.data.class;
								this.data_classsub = response.data.classsub;
								this.data_supplier = response.data.suplier;

								console.log(this.data_classsub);
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

					switch_jenis: function(){
						if(this.jenis == 'select'){
							this.jenis = 'input';
							$('#select_jenis').hide();
							$("#input_jenis").show();
						}else{
							this.jenis = 'select';
							$('#input_jenis').hide();
							$("#select_jenis").show();
						}
					},

					switch_subjenis1: function(){
						if(this.subjenis1 == 'select'){
							this.subjenis1 = 'input';
							$('#select_sub_jenis_1').hide();
							$("#input_sub_jenis_1").show();
						}else{
							this.subjenis1 = 'select';
							$('#input_sub_jenis_1').hide();
							$("#select_sub_jenis_1").show();
						}
					},

					switch_subjenis2: function(){
						if(this.subjenis2 == 'select'){
							this.subjenis2 = 'input';
							$('#select_sub_jenis_2').hide();
							$("#input_sub_jenis_2").show();
						}else{
							this.subjenis2 = 'select';
							$('#input_sub_jenis_2').hide();
							$("#select_sub_jenis_2").show();
						}
					},

					switch_subjenis3: function(){
						if(this.subjenis3 == 'select'){
							this.subjenis3 = 'input';
							$('#select_sub_jenis_3').hide();
							$("#input_sub_jenis_3").show();
						}else{
							this.subjenis3 = 'select';
							$('#input_sub_jenis_3').hide();
							$("#select_sub_jenis_3").show();
						}
					},

					i_jenis_change: function(v){
						this.form_data.i_jenis = v;
						this.form_data.i_jenissub = '';
						this.form_data.i_class = '';
						this.form_data.i_classsub = '';
					},

					i_jenissub_change: function(v){
						this.form_data.i_jenissub = v;
						this.form_data.i_class = '';
						this.form_data.i_classsub = '';
					},

					i_class_change: function(v){
						this.form_data.i_class = v;
						this.form_data.i_classsub = '';
					},

					i_classsub_change: function(v){
						this.form_data.i_classsub = v;
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