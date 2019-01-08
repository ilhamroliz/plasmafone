@extends('main')

@section('title', 'Purchase Order')

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
            <li>Purchase Order</li>
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
						 Purchase Order
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
                        <h2><strong>Tambah Purchase Order</strong></h2>

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
						<!-- ------------------------------------------------------------------------------------------------------------- -->
						<div class="widget-body">
				
										<form class="form-horizontal">
										{{csrf_field()}}
											<fieldset>
											<div class="form-group">
													
													<label class="col-md-2" for="prepend"> <h4>Pilih Supplier</h4></label>
													<div class="col-md-6">
										                <div class="icon-addon addon-lg">
														<select class="form-control col-md-10" name="" id="dt_supplier" style="padding-right:50%" onchange="reload_table()">
															<option selected="" value="00">----pilih semua Supplier----</option>
														</select>
										                    <label for="email" class="glyphicon glyphicon-search" rel="tooltip" title="" data-original-title="email"></label>
										                </div>
													</div>
													
												</div>

												<div class="form-group">
												<label class="col-md-2" for="prepend"> <h4>Tanggal Di butuhkan</h4></label>
													<div class="col-md-6">
										                <div class="icon-addon addon-lg">
														<input type="text" class="form-control datepicker" id="due_date" name="tgl_awal" placeholder="Due Date" data-dateformat="dd/mm/YYYY">
										                    <label for="email" class="glyphicon glyphicon-list" rel="tooltip" title="" data-original-title="email"></label>
										                </div>
													</div>
													
												</div>
												
											</fieldset>
										</form>
				
									</div>
						<!-- ---------------------------------------------------------------------------------------------------------------------- -->
                            <form id="checkout-form" class="form-inline" role="form">
                                <fieldset class="row">
									
                                </fieldset>
                                <fieldset class="row">
                                    <div class="col-md-12">
                                        <table id="table_addPo" class="table table-striped table-bordered table-hover" width="100%">
                                            <thead>
                                                <tr>
                                                    <th data-hide="phone,tablet" width="75%">Nama Barang</th>
                                                    <th data-hide="phone,tablet" width="10%">Qty</th>
                                                    <th data-hide="phone,tablet" width="15%">Nominal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
									
                                    </div>
									
									
                                </fieldset>
								<div class="form-actions">
										<div class="row">
											<div class="col-md-12">
                                       	 		<button class="btn-lg btn-block btn-primary text-center" onclick="simpanPo()">Buat Purchase Order</button>
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
<script src="{{ asset('template_asset/js/plugin/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('template_asset/js/plugin/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('template_asset/js/plugin/datatables/dataTables.colVis.min.js') }}"></script>
<script src="{{ asset('template_asset/js/plugin/datatables/dataTables.tableTools.min.js') }}"></script>
<script src="{{ asset('template_asset/js/plugin/datatables/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('template_asset/js/plugin/datatable-responsive/datatables.responsive.min.js') }}"></script>
<script src="{{ asset('template_asset/js/plugin/bootstrapvalidator/bootstrapValidator.min.js') }}"></script>
<script src="{{ asset('template_asset/js/notification/SmartNotification.min.js') }}"></script>
<script src="{{ asset('template_asset/js/app.config.js') }}"></script>
<script src="{{ asset('template_asset/js/bootstrap/bootstrap.min.js') }}"></script>


<script type="text/javascript">
// $('#overlay').fadeIn(200);
$('#load-status-text').text('Sedang Mengambil Data...');	

$(document).ready(function () {

	reload_data();
	getSupplier();
	getOutlet_po();
		var breakpointDefinition = {
			tablet : 1024,
			phone : 480
		};
 
		
		$('#dt_').on('change', function(e){
			oTable.draw();
			e.preventDefault();
		})

	

})

function reload_data(){
      // table_registrasi.ajax.reload(null, false);
        table_registrasi= $('#table_addPo').DataTable({
			"language" : dataTableLanguage,
			"searching": false,
            "ajax": {
                    "url": '{{url('/pembelian/purchase-order/list_draftPo')}}',
                    "type": "GET",  
                    "data": function ( data ) {
                        data.supplier = $('#dt_supplier').val();
                        data.outlet = $('#dt_outlet').val();
                    },
                },
        } );
    }

	function reload_table(){
        table_registrasi.ajax.reload(null, false);

    }
			
function getSupplier()
{
	
	$.ajax({
		url : '{{url('/pembelian/purchase-order/getSupplier_po')}}',
		type: "GET",
		data: { 
		},
		dataType: "JSON",
		success: function(data)
		{
		$('#dt_supplier').empty(); 
		row = "<option selected='' value='00'>Pilih Supplier</option>";
		$(row).appendTo("#dt_supplier");
		$.each(data, function(k, v) {
			row = "<option value='"+v.pr_supplier+"'>"+v.s_company+"</option>";
			$(row).appendTo("#dt_supplier");
		});
		},
		
	});  
}

function getOutlet_po()
{
	$.ajax({
		url : '{{url('/pembelian/purchase-order/getOutlet_po')}}',
		type: "GET",
		data: { 
			'id' : $('#dt_supplier').val()

		},
		dataType: "JSON",
		success: function(data)
		{
			$('#dt_outlet').empty(); 
			row = "<option selected='' value='00'>Pilih Outlet</option>";
			$(row).appendTo("#dt_outlet");
			$.each(data, function(k, v) {
				row = "<option value='"+v.pr_comp+"'>"+v.c_name+"</option>";
				$(row).appendTo("#dt_outlet");
			});
			
		},
	}); 
}

// $('#table-rencana').DataTable().ajax.reload();

function formatRupiah(angka, prefix, dec)
{
	var number_string = angka.toString(),
	split	= number_string.split(','),
	sisa 	= split[0].length % 3,
	rupiah 	= split[0].substr(0, sisa),
	ribuan 	= split[0].substr(sisa).match(/\d{3}/gi);

	if (ribuan) {

		separator = sisa ? '.' : '';
		rupiah += separator + ribuan.join('.') + "," + dec;

	}

	rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
	
	return prefix == undefined ? rupiah : (rupiah ? 'Rp' + rupiah : '');
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

function simpanPo(){
	
	$.ajax({
		url : '{{url('/pembelian/purchase-order/simpanPo')}}',
		type: "get",
		data: { 
			"id" : $('#dt_supplier').val(),
			"due_date" : $('#due_date').val(),
		},
		dataType: "JSON",
		success: function(data)
		{
			alert();
			
			if(data.status == 'gagal')
			{
				Swal({
						position: 'top-end',
						type: 'danger',
						title: 'Request Order Gagal Di Ajukan',
						showConfirmButton: false,
						timer: 1500
					});
				// $('#table-rencana').DataTable().ajax.reload();
			}else{
				alert();
				$('#table_addPo').dataTable().ajax.reload();
				Swal({
						position: 'top-end',
						type: 'danger',
						title: 'Request Order Telah Di Ajukan',
						showConfirmButton: false,
						timer: 3500
					});
					reload_table();
			}
			// $('#table-rencana').DataTable().fnDestroy();
			
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
