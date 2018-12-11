@extends('main')

@section('title', 'Akses Pengguna')

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
		<li>Home</li><li>Pengaturan</li><li>Akses Pengguna</li><li>Edit Akses</li>
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
		<section id="widget-grid" class="">

			<?php $mt = '20px'; ?>

			<!-- row -->
			<div class="wrapper wrapper-content animated fadeInRight">
				<div class="row m-b-lg m-t-lg">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-cog"></i> Pengelolaan Pengguna <span>> Hak Akses</span></h1>
					</div>
					<div class="col-md-6">
						<div class="profile-image col-md-4">
						@foreach($user as $key => $data)
							@if($data->m_img != '' || $data->m_img != null)
								<img src="{{ asset('img/user/'.$data->m_img) }}" 
								class="img-circle circle-border m-b-md"
								alt="profile"
								style="width: 100%; heigth: 100%; margin: 20px 0;">
							@else
								<img src="{{ asset('img/user/default.jpg') }}" 
								class="img-circle circle-border m-b-md"
								alt="profile"
								style="width: 100%; heigth: 100%; margin: 20px 0;">
							@endif
						</div>
						<div class="profile-info col-md-8">
							<div class="">
								<div>
									<h2 class="no-margins">
										
										{{ $data->m_name }}
									</h2>
									<h4>
										{{ $data->nama }}
									</h4>
									<small>
										{{ $data->m_address }}
										@endforeach
									</small>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<table class="table small m-b-xs">
							<tbody>
							<tr>
								<td>
									<strong>Perusahaan</strong>
								</td>
								<td>
									@foreach($user as $key => $data)
									{{ $data->c_name }}
								</td>
							</tr>
							<tr>
								<td>
									<strong>Last Login</strong>
								</td>
								<td>
									{{ $data->m_lastlogin }}
								</td>
							</tr>
							<tr>
								<td>
									<strong>Last Logout</strong>
								</td>
								<td>
									{{ $data->m_lastlogout}}
								</td>
							</tr>
							</tbody>
						</table>
					</div>
					<div class="col-md-3">
						<small>Username</small>
						<h2 class="no-margins">{{ $data->m_username }}</h2>
						<div id="sparkline1"><canvas style="display: inline-block; width: 247px; height: 50px; vertical-align: top;" width="247" height="50"></canvas></div>
					</div>@endforeach
				</div>
				<div class="ibox">
					<div class="ibox-title">
						<h5>Akses Pengguna</h5>
					</div>
					<div class="ibox-content">
						<form class="row form-akses" id="form-akses" style="padding-right: 18px; padding-left: 18px;">
							<input type="hidden" name="id" value="{{ $id }}">
							<table class="table table-bordered table-striped" id="table-akses">
								<thead>
								<tr>
									<th>Nama Fitur</th>
									<th class="text-center">Read</th>
									<th class="text-center">Insert</th>
									<th class="text-center">Update</th>
									<th class="text-center">Delete</th>
								</tr>
								</thead>
								<tbody>
								@foreach($akses as $data)
									<tr>
										<td>
										@if($data->a_parent == $data->a_id) <strong>{{ $data->a_name }}</strong> 
										@else<span style="margin-left: 20px;">{{ $data->a_name }}</span> 
										@endif
										</td>
										<td>
											<div class="text-center">
												<div class="checkbox checkbox-success checkbox-single checkbox-inline">
													<input type="checkbox" class="read{{ $data->a_parent }}"
														@if($data->a_parent == $data->a_id) id="read{{ $data->a_parent }}" onchange="handleChange(this);" @else onchange="checkParent(this, 'read{{ $data->a_parent }}');"
														@endif name="read[]" value="{{ $data->a_id }}" @if($data->ma_read == 'Y') checked @endif>
													<label class=""> </label>
												</div>
											</div>
										</td>
										<td>
											<div class="text-center">
												<div class="checkbox checkbox-primary checkbox-single checkbox-inline">
													<input type="checkbox" class="insert{{ $data->a_parent }}"
														@if($data->a_parent == $data->a_id) id="insert{{ $data->a_parent }}" onchange="handleChange(this);" @else onchange="checkParent(this, 'insert{{ $data->a_parent }}');"
														@endif name="insert[]" value="{{ $data->a_id }}" @if($data->ma_insert == 'Y') checked @endif>
													<label class=""> </label>
												</div>
											</div>
										</td>
										<td>
											<div class="text-center">
												<div class="checkbox checkbox-warning checkbox-single checkbox-inline">
													<input type="checkbox" class="update{{ $data->a_parent }}"
														@if($data->a_parent == $data->a_id) id="update{{ $data->a_parent }}" onchange="handleChange(this);" @else onchange="checkParent(this, 'update{{ $data->a_parent }}');"
														@endif name="update[]" value="{{ $data->a_id }}" @if($data->ma_update == 'Y') checked @endif>
													<label class=""> </label>
												</div>
											</div>
										</td>
										<td>
											<div class="text-center">
												<div class="checkbox checkbox-danger checkbox-single checkbox-inline">
													<input type="checkbox" class="delete{{ $data->a_parent }}"
														@if($data->a_parent == $data->a_id) id="delete{{ $data->a_parent }}" onchange="handleChange(this);" @else onchange="checkParent(this, 'delete{{ $data->a_parent }}');"
														@endif name="delete[]" value="{{ $data->a_id }}" @if($data->ma_delete == 'Y') checked @endif>
													<label class=""> </label>
												</div>
											</div>
										</td>
									</tr>
								@endforeach							
								</tbody>
							</table>
							<ul class="demo-btns pull-right" >
								<li>
									<a class="btn btn-default" href="{{ url('pengaturan/akses-pengguna') }}">Kembali</a>
									<!-- <a style="margin-right: 10px;" type="button" class="btn btn-white" href="{{ url('pengaturan/akses-pengguna') }}">Kembali</a> -->
								</li>
								<li>
									<button class="btn btn-primary" id="submit-akses" onclick=simpan() type="button">
										<i class="fa fa-save"></i> Simpan
									</button>
								</li>
							</ul>
							
						</form>
					</div>
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
<script src="{{ asset('template_asset/js/plugin/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('template_asset/js/plugin/datatables/dataTables.colVis.min.js') }}"></script>
<script src="{{ asset('template_asset/js/plugin/datatables/dataTables.tableTools.min.js') }}"></script>
<script src="{{ asset('template_asset/js/plugin/datatables/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('template_asset/js/plugin/datatable-responsive/datatables.responsive.min.js') }}"></script>

<!-- CUSTOM NOTIFICATION -->
<script src="{{ asset('template_asset/js/notification/SmartNotification.min.js') }}"></script>
<script src="{{ asset('template_asset/js/app.config.js') }}"></script>

<script src="{{ asset('template_asset/js/waitingfor.js') }}"></script>
<script type="text/javascript">
	function handleChange(checkbox) {
		if (checkbox.checked) {
			var klas = checkbox.className;
			$('input[class="'+klas+'"]').prop("checked", true);
		} else {
			var klas = checkbox.className;
			$('input[class="'+klas+'"]').prop("checked", false);
		}
	}

	function checkParent(checkbox, id){
		if (checkbox.checked) {
			$('input[id="'+id+'"]').prop("checked", true);
		}
	}

	function simpan(){
		// --- AXIOS USE ----//
		$('#overlay').fadeIn(200);
		$('#load-status-text').text('Penyimpanan Database Sedang di Proses');
		// let btn = $('#submit-akses');
		// btn.attr('disabled', 'disabled');
		// btn.html('<i class="fa fa-floppy-o"></i> &nbsp;Proses...');

		axios.post(baseUrl+'/pengaturan/akses-pengguna/simpan', $('#form-akses').serialize())
			.then((response) => {
				if(response.data.status == 'sukses'){
					$('#overlay').fadeOut(200);
					// location.reload();
					$.smallBox({
						title : "SUKSES",
						content : "Data Akses Berhasil Diperbarui",
						color : "#739E73",
						iconSmall : "fa fa-check animated",
						timeout : 4000
					});
					// location.reload();
				}else if(response.data.status == 'gagal'){
					$('#overlay').fadeOut(200);
					$.smallBox({
						title : "GAGAL",
						content : "Data Akses Gagal Diperbarui",
						color : "#C46A69",
						iconSmall : "fa fa-times animated",
						timeout : 4000
					});
					// location.reload();
				}
		})

		// --- AJAX USE -- //
		// $('#overlay').fadeIn(200);
		// $('#load-status-text').text('Silahkan Memproses Penyimpanan Data');
        // // waitingDialog.show();
        // $.ajaxSetup({
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     }
        // });
        // $.ajax({
        //     url: '{{ url('/pengaturan/akses-pengguna/simpan') }}',
        //     type: 'get',
        //     data: $('.form-akses').serialize(),
        //     success: function(response){
		// 		if (response.status == 'sukses') {
        //             // waitingDialog.hide();
		// 			$('#overlay').fadeOut(200);
		// 			$.smallBox({
		// 				title : "SUKSES",
		// 				content : "Data Akses Berhasil Diperbarui",
		// 				color : "#739E73",
		// 				iconSmall : "fa fa-check animated",
		// 				timeout : 5000
		// 			});
        //             location.reload();
        //         }
		// 		else if(response.status == 'gagal') {
		// 			// alert('Data Gagal Di Update');	
		// 			// waitingDialog.hide();
		// 			$('#overlay').fadeOut(200);
		// 			$.smallBox({
		// 				title : "GAGAL",
		// 				content : "Data Akses Gagal Diperbarui",
		// 				color : "#C46A69",
		// 				iconSmall : "fa fa-times animated",
		// 				timeout : 5000
		// 			});
		// 			// location.reload();
		// 		}
        //     }, error:function(x, e) {
        //         waitingDialog.hide();
        //         if (x.status == 0) {
        //             alert('ups !! gagal menghubungi server, harap cek kembali koneksi internet anda');
        //         } else if (x.status == 404) {
        //             alert('ups !! Halaman yang diminta tidak dapat ditampilkan.');
        //         } else if (x.status == 500) {
        //             alert('ups !! Server sedang mengalami gangguan. harap coba lagi nanti');
        //         } else if (e == 'parsererror') {
        //             alert('Error.\nParsing JSON Request failed.');
        //         } else if (e == 'timeout'){
        //             alert('Request Time out. Harap coba lagi nanti');
        //         } else {
        //             alert('Unknow Error.\n' + x.responseText);
        //         }
        //     }
        // })
    }
</script>

<script type="text/javascript">
$(document).ready(function(){

	let selected = [];

	/* BASIC ;*/
	var responsiveHelper_dt_basic = undefined;
	var responsiveHelper_datatable_fixed_column = undefined;
	var responsiveHelper_datatable_col_reorder = undefined;
	var responsiveHelper_datatable_tabletools = undefined;

	var breakpointDefinition = {
		tablet : 1024,
		phone : 480
	};

	$('#dt_basic').dataTable({
		"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
		"t"+
		"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
		"autoWidth" : true,
		"preDrawCallback" : function() {
			// Initialize the responsive datatables helper once.
			if (!responsiveHelper_dt_basic) {
				responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic'), breakpointDefinition);
			}
		},
		"rowCallback" : function(nRow) {
			responsiveHelper_dt_basic.createExpandIcon(nRow);
		},
		"drawCallback" : function(oSettings) {
			responsiveHelper_dt_basic.respond();
		}
	});

	/* END BASIC */

	$('.check-me').change(function(evt){
		evt.preventDefault(); context = $(this);
		if(context.is(':checked'))
			selected.push(context.val());
		else
			selected.splice(_.findIndex(selected, function(o) { return o == context.val() }), 1);

		// console.log(selected);
	})

})
</script>

@endsection