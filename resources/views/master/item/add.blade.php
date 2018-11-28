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
			<li>Home</li><li>Master</li><li>Tambah Data Barang</li>
		</ol>
		<!-- end breadcrumb -->

	</div>
	<!-- END RIBBON -->
@endsection


@section('main_content')

	<!-- MAIN CONTENT -->
	<div id="content">

		<!-- widget grid -->
		<section id="widget-grid" class="" style="margin-bottom: 20px; min-height: 500px;">

			@if(Session::has('flash_message_success'))
				<?php $mt = '0px'; ?>
				<div class="col-md-8" style="margin-top: 20px;">
					<div class="alert alert-success alert-block">
						<a class="close" data-dismiss="alert" href="#">×</a>
						<h4 class="alert-heading">&nbsp;<i class="fa fa-thumbs-up"></i> &nbsp;Pemberitahuan Berhasil</h4>
						{{ Session::get('flash_message_success') }} 
					</div>
				</div>
			@elseif(Session::has('flash_message_error'))
				<?php $mt = '0px'; ?>
				<div class="col-md-8" style="margin-top: 20px;">
					<div class="alert alert-danger alert-block">
						<a class="close" data-dismiss="alert" href="#">×</a>
						<h4 class="alert-heading">&nbsp;<i class="fa fa-frown-o"></i> &nbsp;Pemberitahuan Gagal</h4>
						{{ Session::get('flash_message_error') }}
					</div>
				</div>
			@endif
			
			<!-- row -->
			<div class="row">

				<!-- NEW WIDGET START -->
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

					<!-- Widget ID (each widget will need unique ID)-->
					<div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
						<header>
							<h2><strong>Master</strong> &gt; <i>Tambah Data Barang</i></h2>				
							
						</header>

						<!-- widget div-->
						<div>
							
							<!-- widget content -->
							<div class="widget-body">
								
								<form id="data-form" class="form-horizontal" action="{{ route('barang.insert') }}" method="post" enctype="multipart/form-data">
									{{ csrf_field() }}
									<fieldset>
										<legend>
											Form Tambah Data Barang

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

															<input type="text" class="form-control" name="i_kelompok" v-model="form_data.i_kelompok" placeholder="Tambahkan Kelompok Barang">
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
													<div class="col-xs-7 col-lg-7 inputGroupContainer">
														<select class="form-control" v-model="form_data.i_isactive" name="i_isactive">
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
															<input type="file" accept="image/*" style="cursor: pointer;" class="input-xs" name="i_img" id="i_img" placeholder="Masukkan Gambar Barang" v-model='form_data.i_img' @change="onFileChange" onchange="loadFile(event)" />
														</div>
													</div>
												</div>
											</div>

										</div>

										<div class="row">
											<div class="col-md-6">
												<div id="preview" style="margin-bottom: 0;" class="preview thumbnail">
													Lihat Gambar
												</div>
												<div style="top: 0; display: none" id="delete_preview">
													<a onclick="delete_image()" style="width: 100%;" class="btn btn-md btn-danger"><i class="glyphicon glyphicon-trash"></i>&nbsp;Hapus</a>
												</div>
											</div>
										</div>

									</fieldset>

									<div class="form-actions">
										<div class="row">
											<div class="col-md-12">
												<button class="btn btn-primary" type="submit" :disabled="btn_save_disabled">
													<i class="fa fa-floppy-o"></i>
													&nbsp;Simpan
												</button>
											</div>
										</div>
									</div>
								</form>
								
							</div>
							<!-- end widget content -->
							
						</div>
						<!-- end widget div -->
						
					</div>
					<!-- end widget -->

				</article>
				<!-- WIDGET END -->
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
	<script type="text/x-template" id="select2-template-kelompok">
	  <select style="width:100%" name="i_kelompok" required>
	  	<option value="">-- Pilih Kelompok Barang</option>
	    <option v-for="option in options" :value="option.i_kelompok">@{{ option.i_kelompok }}</option>
	  </select>
	</script>

	<script type="text/x-template" id="select2-template-group">
	  <select style="width:100%" name="i_group">
	  	<option value="">-- Pilih Group Barang</option>
	    <option v-for="option in options" :value="option.i_group">@{{ option.i_group }}</option>
	  </select>
	</script>

	<script type="text/x-template" id="select2-template-subgroup">
	  <select style="width:100%" name="i_subgroup">
	  	<option value="">-- Pilih Sub Group Barang</option>
	    <option v-for="option in options" :value="option.i_subgroup">@{{ option.i_subgroup }}</option>
	  </select>
	</script>

	<script type="text/x-template" id="select2-template-merk">
	  <select style="width:100%" name="i_merk">
	  	<option value="">-- Pilih Merk Barang</option>
	    <option v-for="option in options" :value="option.i_merk">@{{ option.i_merk }}</option>
	  </select>
	</script>

	<script type="text/javascript">
		function loadFile(event) {
			$("#preview").html("");
			$("#preview").append("<img id='img_prev' src='"+URL.createObjectURL(event.target.files[0])+"'>");
			$("#delete_preview").show();
		};

		function delete_image(){
			$('#i_img').val('');
			$("#preview img:last-child").remove();
			$('#delete_preview').hide();
			$("#preview").html("Lihat Gambar");

		}
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
						i_kelompok : {
							validators : {
								notEmpty : {
									message : 'Kelompok Barang Tidak Boleh Kosong',
								}
							}
						},

						i_group : {
							validators : {
								notEmpty : {
									message : 'Group Barang Tidak Boleh Kosong',
								}
							}
						},

						i_subgroup : {
							validators : {
								notEmpty : {
									message : 'Sub-Group Barang Tidak Boleh Kosong',
								}
							}
						},

						i_merk : {
							validators : {
								notEmpty : {
									message : 'Merk Barang Tidak Boleh Kosong',
								}
							}
						},

						i_nama : {
							validators : {
								notEmpty : {
									message : 'Nama Barang Tidak Boleh Kosong',
								}
							}
						},

						i_code : {
							validators : {
								notEmpty : {
									message : 'Kode Barang Tidak Boleh Kosong',
								}
							}
						},

						i_minstock : {
							validators : {
								notEmpty : {
									message : 'Min Stock Tidak Boleh Kosong',
								},

								numeric: {
									message : 'Tampaknya Ada Yang Salah Dengan Inputan Min Stock Anda'
								}
							}
						},

						i_berat : {
							validators : {
								notEmpty : {
									message : 'Berat Barang Tidak Boleh Kosong',
								},

								numeric: {
									message : 'Tampaknya Ada Yang Salah Dengan Inputan Berat Barang Anda'
								}
							}
						},

					}
				});
			}

			Vue.component('kelompok', {
			  props: ['options'],
			  template: '#select2-template-kelompok',
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
			  template: '#select2-template-group',
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
			  template: '#select2-template-subgroup',
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
			  template: '#select2-template-merk',
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
					btn_save_disabled 	: false,

					data_I_kelompok: [],
					data_I_group: [],
					data_I_subgroup: [],
					data_I_merk: [],

					// jenissub : 'okee',

					form_data : {
						i_kelompok: '',
						i_group: '',
						i_subgroup: '',
						i_merk: '',
						i_nama: '',
						i_code: '',
						i_img: '',
						i_minstock: '',
						i_berat: '',
						i_specificcode: 'Y',
						i_isactive: 'Y'
						
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
								this.data_I_kelompok 	= response.data.kelompok;
								this.data_I_group 		= response.data.group;
								this.data_I_subgroup 	= response.data.subgroup;
								this.data_I_merk 		= response.data.merk;
								$("#overlay").fadeOut(200);
							})
				},
				methods: {
					onFileChange(e) {
						console.log(e.target.files[0])
		                var fileReader = new FileReader()
		                fileReader.onload = (e) => {
		                	this.form_data.i_img = e.target.result
		                }
		                console.log(this.form_data)
		            },
					submit_form: function(e){
						// e.preventDefault(e);
						console.log(this.form_data.i_img);
						$('#overlay').fadeIn(200);
						$('#load-status-text').text('Sedang memproses penyimpanan data...!');
						if($('#data-form').data('bootstrapValidator').validate().isValid()){
							this.btn_save_disabled = true;
							let data = new FormData();
							data.append('kelompok', this.form_data.i_kelompok);
							data.append('group', this.form_data.i_group);
							data.append('subgroup', this.form_data.i_subgroup);
							data.append('merk', this.form_data.i_merk);
							data.append('nama', this.form_data.i_nama);
							data.append('kode', this.form_data.i_code);
							data.append('status', this.form_data.i_isactive);
							data.append('minstock', this.form_data.i_minstock);
							data.append('berat', this.form_data.i_berat);
							data.append('specificcode', this.form_data.i_specificcode);
							data.append('image', this.form_data.i_img);
							data.append('_method', 'post');
							// data.append('data', $('#data-form').serialize());

							axios.post(baseUrl+'/master/barang/insert', data).then((response) => {
								console.log(response.data);
								$("#overlay").fadeOut(200);
								// if(response.data.status == 'berhasil'){
								// 	$.toast({
								// 	    text: 'Data Barang Terbaru Anda Berhasil Tersimpan...!',
								// 	    showHideTransition: 'fade',
								// 	    icon: 'success'
								// 	})

								// 	this.reset_form();

								// }else if(response.data.status == 'jabatan_not_found'){
								// 	$.toast({
								// 	    text: 'Ada Kesalahan Jabatan Yang Anda Pilih Sudah Tidak Bisa Kami Temukan. Cobalah Untuk Memuat Ulang Halaman..',
								// 	    showHideTransition: 'fade',
								// 	    icon: 'error'
								// 	})
								// }else if(response.data.status == 'posisi_not_found'){
								// 	$.toast({
								// 	    text: 'Ada Kesalahan Posisi Yang Anda Pilih Sudah Tidak Bisa Kami Temukan. Cobalah Untuk Memuat Ulang Halaman..',
								// 	    showHideTransition: 'fade',
								// 	    icon: 'error'
								// 	})
								// }

							}).catch((err) => {
								$("#overlay").fadeOut(200);
								$.toast({
								    text: err,
								    showHideTransition: 'fade',
								    icon: 'error'
								})
								console.log(err);
							}).then(() => {
								this.btn_save_disabled = false;
							})

							return false;
						}else{
							$("#overlay").fadeOut(200);
							$.toast({
							    text: 'Ada Kesalahan Dengan Inputan Anda. Harap Mengecek Ulang...!',
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
						// this.form_data.i_group = '';
						// this.form_data.i_subgroup = '';
						// this.form_data.i_merk = '';
					},

					i_group_change: function(v){
						// this.form_data.i_kelompok = '';
						this.form_data.i_group = v;
						// this.form_data.i_subgroup = '';
						// this.form_data.i_merk = '';
					},

					i_subgroup_change: function(v){
						// this.form_data.i_kelompok = '';
						// this.form_data.i_group = '';
						this.form_data.i_subgroup = v;
						// this.form_data.i_merk = '';
					},

					i_merk_change: function(v){
						// this.form_data.i_kelompok = '';
						// this.form_data.i_group = '';
						// this.form_data.i_subgroup = '';
						this.form_data.i_merk = v;
					},

					reset_form:function(){
						this.form_data.i_kelompok 		= '';
						this.form_data.i_group 			= '';
						this.form_data.i_subgroup 		= '';
						this.form_data.i_merk 			= '';
						this.form_data.i_nama 			= '';
						this.form_data.i_img 			= '';
						this.form_data.i_code 			= '';
						this.form_data.i_isactive 		= 'Y';
						this.form_data.i_minstock 		= '';
						this.form_data.i_berat 			= '';
						this.form_data.i_specificcode 	= 'Y';
						$('#data-form').data('bootstrapValidator').resetForm();
					}
				}
			});


		</script>

@endsection