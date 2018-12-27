@extends('main')

@section('title', 'Pemesanan Barang')

@section('extra_style')

@endsection

@section('ribbon')
    <!-- RIBBON -->
    <div id="ribbon">

	<span class="ribbon-button-alignment"> 
		<span id="refresh" class="btn btn-ribbon" data-title="refresh" rel="tooltip" data-placement="bottom"
              data-original-title="<i class='text-warning fa fa-warning'></i> Refresh Halaman? Semua Perubahan Yang Belum Tersimpan Akan Hilang.."
              data-html="true" onclick="location.reload()">
			<i class="fa fa-refresh"></i>
		</span> 
	</span>

        <!-- breadcrumb -->
        <ol class="breadcrumb">
            <li>Home</li>
            <li>Penjualan</li>
            <li>Pemesanan Barang</li>
        </ol> 

    </div>
    <!-- END RIBBON -->
@endsection


@section('main_content')
    <!-- MAIN CONTENT -->
    <div id="content">

        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <h1 class="page-title txt-color-blueDark">
                    <i class="fa-fw fa fa-handshake-o"></i>
                    Penjualan
                    <span>
						<i class="fa fa-angle-double-right"></i>
						Tambah Pemesanan Barang
					</span>
                </h1>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-align-right">

                <div class="page-title">
                    <a href="{{ url('penjualan/pemesanan-barang') }}" class="btn btn-default"><i class="fa fa-arrow-left"></i>&nbsp;Kembali</a>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">

            <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget" id="wid-id-0" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false" data-widget-sortable="false" role="widget">
                    
                    <header role="heading">
                        <div class="jarviswidget-ctrls" role="menu"><a href="javascript:void(0);" class="button-icon jarviswidget-toggle-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Collapse"><i class="fa fa-minus "></i></a> <a href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Fullscreen"><i class="fa fa-expand "></i></a>
                        </div>
                        <h2><strong>Form Tambah Pemesanan Barang</strong></h2>

                        <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
                    </header>

                    <!-- widget div-->
                    <div role="content">

                        <!-- widget edit box -->
                        <div class="jarviswidget-editbox">
                            <!-- This area used as dropdown edit box -->

                        </div>
                        <!-- end widget edit box -->

                        <!-- widget content -->
                        <div class="widget-body">
                            <form id="tdForm" class="form-inline" role="form">
								{{csrf_field()}}
								<div class="row">
									<div class="col-sm-12 col-md-12 col-lg-12 no-padding padding-bottom-10">										
										<div class="form-group col-md-12">
											<label class="col-md-2"><strong>Nama Member :</strong></label>
											<div class="col-md-4">
												<input type="hidden" id="tpMemberId" name="tpMemberId">
												<input type="text" class="form-control" id="member" name="member" style="width: 100%" placeholder="Masukkan Nama Member">												
											</div>
											<div class="col-md-1">
												<a onclick="modal_tambah()" class="btn btn-success" title="Tambah Member" style="width:100%"><i class="fa fa-plus"></i></a>												
											</div>
										</div>
									</div>
								</div>

                                <fieldset>
									<div class="row">
										<div class="col-sm-12 col-md-12 col-lg-12 no-padding">
											<div class="form-group col-md-12">
												<div class="col-md-7">
													<input type="hidden" id="tpItemId" name="tpItemId">
													<input type="text" class="form-control" id="itemNama" name="itemNama" placeholder="Masukkan Nama/Kode Barang" style="width: 100%">
												</div>
												<div class="col-md-3">
													<input type="text" class="form-control" id="jumlah" name="jumlah" placeholder="Masukkan Jumlah Barang" style="width: 100%" autocomplete="off">
												</div>
												<div class="col-md-2">
													<button class="btn btn-primary" style="width: 100%" onclick="tambah_dummy()"><i class="fa fa-plus"></i>Tambah</button>
												</div>
											</div>
										</div>
									</div>
									
                                    <dir class="col-md-12">

                                        <table id="tpTable" class="table table-striped table-bordered table-hover" width="100%">
                                            <thead>
                                                <tr>
                                                    <th data-hide="phone,tablet" width="65%">Nama Barang</th>
                                                    <th data-hide="phone,tablet" width="20%">Jumlah Barang</th>
                                                    <th data-hide="phone,tablet" width="15%">Aksi</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                            </tbody>
                                        </table>
									
                                    </dir>
                                </fieldset>

								<div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button class="btn-lg btn-block btn-primary text-center" onclick="simpanRequest()">Masukkan Pemesanan Barang</button>
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
			</div>
			
			<!-- Modal Untuk Tambah Member -->
            <div class="modal fade" id="tmModal" tabindex="-1" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4><strong>Form Tambah Member</strong></h4>
                        </div>
                        <div class="modal-body no-padding">

                            <form id="ft-group" class="smart-form">
                                <input type="hidden" name="id" id="id">

                                <fieldset>

                                    <section>
                                        <div class="row">
                                            <label class="label col col-3">Nama Member</label>
                                            <div class="col col-9 has-feedback">
                                                <label class="input">
                                                    <input type="text" name="namaMember" id="namaMember" style="text-transform: uppercase" placeholder="Masukkan Nama Member" required>
                                                </label>
                                            </div>
										</div>
									</section>
									
									<section>
										<div class="row">
                                            <label class="label col col-3">Nomor Telepon</label>
                                            <div class="col col-9 has-feedback">
                                                <label class="input">
                                                    <input type="text" name="noTelp" id="noTelp" placeholder="Masukkan Nomor Telepon/HP Member" required>
                                                </label>
                                            </div>
                                        </div>
									</section>

                                </fieldset>
                                
                                <footer>
                                    <button type="button" class="btn btn-primary" onclick="tmSubmit()"><i class="fa fa-floppy-o"></i>
                                        Simpan
                                    </button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">
                                        Kembali
                                    </button>

                                </footer>
                            </form>						
                                    

                        </div>

                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- Akhir Modal untuk Tambah Group /.modal -->

        </div>

    </div>
    <!-- END MAIN CONTENT -->

@endsection

@section('extra_script')
<script src="{{ asset('template_asset/js/plugin/bootstrapvalidator/bootstrapValidator.min.js') }}"></script>
<script src="{{ asset('template_asset/js/notification/SmartNotification.min.js') }}"></script>
<script src="{{ asset('template_asset/js/app.config.js') }}"></script>
<script src="{{ asset('template_asset/js/bootstrap/bootstrap.min.js') }}"></script>

<script type="text/javascript">
	var requestDumy;

	$(document).ready(function () {

		$( "#itemNama" ).autocomplete({
			source: baseUrl+'/penjualan/pemesanan-barang/get-item',
			minLength: 2,
			select: function(event, data) {
				getItem(data.item);
			}
		});

		$( "#member" ).autocomplete({
			source: baseUrl+'/penjualan/pemesanan-barang/get-member',
			minLength: 2,
			select: function(event, data) {
				getMember(data.item);
			}
		});

		function getItem(data){
			$('#tpItemId').val(data.id);
		}

		function getMember(data){
			$('#tpMemberId').val(data.id);
		}

		load_data();

	})

	function modal_tambah(){
		$('#tmModal').modal('show');
	}

	function tambah_dummy(){
		// axios.post(baseUrl+'/penjualan/pemesanan-barang/addDummy', $('#tdForm').serialize())
		// 	.then((response) => {
				
		// 	});
		
		$.ajax({
			url : '{{url('/penjualan/pemesanan-barang/addDummy')}}',
			type: "post",
			data: { 
				'qty' : $('#jumlah').val(),
				'item' : $('#tpItemId').val(),
			},
			dataType: "JSON",
			success: function(data)
			{
				if(data.status == 'berhasil'){
					$('#tpTable').DataTable.destroy();
					load_data();
				}
			},
		}); 
	}

	function load_data(){
		$('#tpTable').DataTable({
			"ajax": {
				"url": '{{url('/penjualan/pemesanan-barang/loadData')}}',
				"type": 'get',  
				"data": function ( data ) {
				},
			},
		} );	
	}

	function hapusData(id){
		$.ajax({
			url : '{{url('/pejualan/pemesanan-barang/delDummy')}}',
			type: "get",
			data: { 
				id : id,
			},
			dataType: "JSON",
			success: function(data)
			{
				$('#table-rencana').DataTable().ajax.reload();
			},
			
		}); 
	}

	function simpanRequest(){
		
		$.ajax({
			url : '{{url('/pepenjualan/pemesanan-barang/tambah-pemesanan')}}',
			type: "post",
			data: { 
			},
			dataType: "JSON",
			success: function(data)
			{
				
				if(data.status == 'gagal')
				{
					
				}else{
					
					
				}				
			},				
		}); 		
	}





	function getItem(){
		$('#item_kelompok').empty();  
	
		$.ajax({
			url : '{{url('/pembelian/request-pembelian/getBarang')}}',
			type: "GET",
			data: { 
			},
			dataType: "JSON",
			success: function(data)
			{
			$('#item_kelompok').empty(); 
			row = "<option selected='' value='0'>Pilih Item</option>";
			$(row).appendTo("#item_kelompok");
			$.each(data, function(k, v) {
				row = "<option value='"+v.i_id+"'>"+v.i_nama+"</option>";
				$(row).appendTo("#item_kelompok");
			});
			},
			
		});  
	}
		
	function editDumy(id){
		var input = $('#i_nama'+id).val();
		$.ajax({
			url : '{{url('/pembelian/request-pembelian/editDumy')}}',
			type: "GET",
			data: { 
				'id' : id,
				'qty' : input,

			},
			dataType: "JSON",
			success: function(data)
			{
				
				Swal({
						position: 'top-end',
						type: 'danger',
						title: 'Request Order Telah Di edit',
						showConfirmButton: false,
						timer: 7500,
					});
				
				$('#table-rencana').DataTable().ajax.reload();
				
			},				
		}); 
	}
	
</script>

<script type="text/javascript">

var baseUrl = '{{ url('/') }}';

function validation_regis()
{
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




var app = new Vue({
	el 		: '#content',
	data 	: {
		kelompok : 'select',
		group : 'select',
		sub_group : 'select',
		merk : 'select',
		btn_save_disabled 	: false,

		data_I_kelompok: [],
		data_I_group: [],
		data_I_sub_group: [],
		data_I_merk: [],

		form_data : {
			i_kelompok: '',
			i_group: '',
			i_sub_group: '',
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
	

	
	methods: {

		switch_kelompok: function(){
			if(this.kelompok == 'select'){
				this.kelompok = 'input';
				$('#select_kelompok').hide();
				$("#input_kelompok").show();
			}else{
				this.kelompok = 'select';
				this.form_data.i_kelompok = '';
				$('#data-form').data('bootstrapValidator').resetForm();
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
				this.form_data.i_group = '';
				$('#data-form').data('bootstrapValidator').resetForm();
				$('#input_group').hide();
				$("#select_group").show();
			}
		},

	

		i_kelompok_change: function(v){
			this.form_data.i_kelompok = v;
		},

		i_group_change: function(v){
			this.form_data.i_group = v;
		},

		

	}
});

</script>

@endsection
