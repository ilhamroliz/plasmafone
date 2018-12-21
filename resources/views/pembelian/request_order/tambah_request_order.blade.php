@extends('main')

@section('title', 'Request Order')

@section('extra_style')
    <style type="text/css">
        
    </style>
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
            <li>Pembelian</li>
            <li>Request Order</li>
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
                    <i class="fa-fw fa fa-credit-card"></i>
                    Pembelian
                    <span>
						<i class="fa fa-angle-double-right"></i>
						 Request Order
					</span>
                </h1>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-align-right">

                <div class="page-title">

                    <a href="{{ url('pembelian/request-pembelian') }}" class="btn btn-default"><i class="fa fa-arrow-left"></i>&nbsp;Kembali</a>

                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">

            <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget" id="wid-id-0" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false" data-widget-sortable="false" role="widget">
                    
                    <header role="heading">
                        <div class="jarviswidget-ctrls" role="menu">   <a href="javascript:void(0);" class="button-icon jarviswidget-toggle-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Collapse"><i class="fa fa-minus "></i></a> <a href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Fullscreen"><i class="fa fa-expand "></i></a>
                        </div>
                        <h2><strong>Tambah Request Order</strong></h2>

                    <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span></header>

                    <!-- widget div-->
                    <div role="content">

                        <!-- widget edit box -->
                        <div class="jarviswidget-editbox">
                            <!-- This area used as dropdown edit box -->

                        </div>
                        <!-- end widget edit box -->

                        <!-- widget content -->
                        <div class="widget-body">
                            <form id="checkout-form" class="form-inline" role="form">
                                <fieldset class="row">
								<div class="form-group col-md-8">
                                        <label class="sr-only" for="namabarang">Nama Barang</label>
                                        <input type="text" class="form-control" id="namabarang" name="item" placeholder="Masukkan Nama/Kode Barang" style="width: 100%">
                                        <input type="hidden" class="kodeItem">
                                    </div>
                                    <!-- <div class="form-group col-md-8">
										<div class="input-group col-xs-10 col-lg-10" id="select_kelompok">
												<kelompok :options="data_I_kelompok" @change="i_kelompok_change" v-model="form_data.i_kelompok">
													</kelompok>
												</div>
                                    </div> -->
                                    <div class="form-group col-md-2">
                                        <label class="sr-only" for="kuantitas">QTY</label>
                                        <input type="text" class="form-control" id="qty" name="kuantitas" placeholder="QTY" style="width: 100%">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <button class="btn btn-primary" onclick="tambah()">Tambah</button>
                                    </div>
                                </fieldset>
                                <fieldset class="row">
                                    <dir class="col-md-12">
                                        <table id="table-rencana" class="table table-striped table-bordered table-hover" width="100%">
                                            <thead>
                                                <tr>
                                                    <th data-hide="phone,tablet" width="75%">Nama Barang</th>
                                                    <th data-hide="phone,tablet" width="10%">Qty</th>
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
                                       	 		<button class="btn-lg btn-block btn-primary text-center" onclick="simpanRequest()">Kirim Permintaan</button>
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
        </div>

    </div>
    <!-- END MAIN CONTENT -->

@endsection

@section('extra_script')

<script src="{{ asset('template_asset/js/plugin/bootstrapvalidator/bootstrapValidator.min.js') }}"></script>
<script src="{{ asset('template_asset/js/notification/SmartNotification.min.js') }}"></script>
<script src="{{ asset('template_asset/js/app.config.js') }}"></script>

	<script type="text/x-template" id="select2-template-kelompok">
	  <select style="width:100%" name="i_kelompok" required id="item_kelompok" >
	  	<option value="">CARI ITEM </option>
	    <!-- <option v-for="option in options" :value="option.i_kelompok">@{{ option.i_kelompok }}</option> -->
	  </select>
	</script>

    <script type="text/javascript">
		var requestDumy;

        $(document).ready(function () {
			load_data();

		$( "#namabarang" ).autocomplete({
			source: '{{url('/pembelian/request-pembelian/getInput')}}',
			minLength: 1,
			select: function(event, data) {
				tanam(data.list);
				
			}
		});

		function tanam(list){
					console.log(list);
				}

		})

            

            

            
// $('#tabs').tabs();
		
// clearData();
						
				

		// function clearData(){
		// 	$.ajax({
		// 			url : '{{url('/pembelian/request-pembelian/clearData')}}',
		// 			type: "GET",
		// 			data: { 
		// 			},
		// 			dataType: "JSON",
		// 			success: function(data)
		// 			{
		// 				load_data();
		// 			},
					
		// 	}); 
		// }

		function hapusData(id){
			$.ajax({
				url : '{{url('/pembelian/request-pembelian/hapusDumy')}}',
				type: "GET",
				data: { 
					id : id,
				},
				dataType: "JSON",
				success: function(data)
				{
					$('#table-rencana').DataTable().fnDestroy();
				},
				
			}); 
			alert(); 
		}

		function load_data(){
			requestDumy = $('#table-rencana').DataTable({
                    "ajax": {
                                "url": '{{url('/pembelian/request-pembelian/ddRequest_dummy')}}',
                                "type": 'GET',  
                                "data": function ( data ) {
                                },
                            },
                    } );
					
				}

		// function reload_table_requestOrder(){
		// 	requestDumy.ajax.reload(null, false);
		
		// 	};
				
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

        function tambah(){
			$.ajax({
						url : '{{url('/pembelian/request-pembelian/addDumyReq')}}',
						type: "GET",
						data: { 
							'qty' : $('#qty').val(),
							'item' : $('#namabarang').val(),

						},
						dataType: "JSON",
						success: function(data)
						{
							$('#table-rencana').DataTable().fnDestroy();
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
							$('#table-rencana').DataTable().fnDestroy();
							
						},
						
				}); 
		}

		function simpanRequest(){
			$.ajax({
				url : '{{url('/pembelian/request-pembelian/simpanRequest')}}',
				type: "GET",
				data: { 
				},
				dataType: "JSON",
				success: function(data)
				{
					// $('#table-rencana').DataTable().fnDestroy();
					
				},
					
			}); 
			alert();
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
