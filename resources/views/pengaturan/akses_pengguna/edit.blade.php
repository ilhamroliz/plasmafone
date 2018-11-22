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
					<div class="col-md-12">
						<h1>AKSES PENGGUNA</h1>
					</div>
					<div class="col-md-6">
						<div class="profile-image col-md-4">
							<img source="https://upload.wikimedia.org/wikipedia/commons/thumb/7/7e/Circle-icons-profile.svg/768px-Circle-icons-profile.svg.png" alt="profile">
						</div>
						<div class="profile-info col-md-8">
							<div class="">
								<div>
									<h2 class="no-margins">
										@foreach($user as $key => $data)
										{{ $data->m_name }}
									</h2>
									<h4>
									@if($data->m_level == 0)
									{{ "Admin"}}
									@endif
									</h4>
									<small>
										@if($data->m_address == null)
										{{ "Surabaya" }}
										@elseif($data->m_address != null)
										{{ $data->m_address }}
										@endif

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
									{{ $data->m_comp }}
									
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
						<form class="row form-akses" style="padding-right: 18px; padding-left: 18px;" action="{{ action('PengaturanController@simpan') }}">
							<input type="hidden" name="id" value="eyJpdiI6Ikhpc2pKTHg4Q1BIZk83NW00dTJ2ckE9PSIsInZhbHVlIjoiSUcxT3BXSjRaOW5YODQraG5hWWRXUHNoMWJiQzlpRnB1NFhjOERoOU55RT0iLCJtYWMiOiJiZGI2YTYyYzM0ODM3ODBlYWFjZTRmYTQ5MzMzZWJmNzVmNzUyYzEzMzIyMjU1NjFhMTRiMzcwNzY0ZTJmNGZjIn0=">
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
							<button style="float: right;" class="btn btn-primary" onclick="simpan()" type="button">Simpan
							</button>
							<a style="float: right; margin-right: 10px;" type="button" class="btn btn-white" href="http://localhost/plasmaphone/pengaturan/akses-pengguna">Kembali</a>
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
        waitingDialog.show();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '{{ url('pengaturan/akses-pengguna/simpan') }}',
            type: 'post',
            data: $('.form-akses').serialize(),
            success: function(response){
                if (response.status == 'sukses') {
                    waitingDialog.hide();
                    location.reload();
                }
            }, error:function(x, e) {
                waitingDialog.hide();
                if (x.status == 0) {
                    alert('ups !! gagal menghubungi server, harap cek kembali koneksi internet anda');
                } else if (x.status == 404) {
                    alert('ups !! Halaman yang diminta tidak dapat ditampilkan.');
                } else if (x.status == 500) {
                    alert('ups !! Server sedang mengalami gangguan. harap coba lagi nanti');
                } else if (e == 'parsererror') {
                    alert('Error.\nParsing JSON Request failed.');
                } else if (e == 'timeout'){
                    alert('Request Time out. Harap coba lagi nanti');
                } else {
                    alert('Unknow Error.\n' + x.responseText);
                }
            }
        })
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

	// Hapus Click

	$("#multiple_delete").click(function(evt){
		evt.preventDefault();

		if(selected.length == 0){
			alert('Tidak Ada Data Yang Anda Pilih')
		}
		else{
			let ask = confirm(selected.length+' Data Akan Dihapus Apakah Anda Yakin . ?');
			if(ask){
				$('#overlay').fadeIn(300);
				axios.post(baseUrl+'/master/suplier/suplier/multiple-delete', {
					data 	: selected,
					_token 	: '{{ csrf_token() }}'
				})
				.then((response) => {
					if(response.data.status == 'berhasil'){
						location.reload();
					}
				}).catch((error) => {
					console.log(error);
				})
			}
		}

	})

	// Edit Click

	$("#multiple_edit").click(function(evt){
		evt.preventDefault();

		if(selected.length == 0){
			alert('Tidak Ada Data Yang Anda Pilih')
		}else{
			$("#table-form").submit();
		}
	})

	// edit 1 click

	$(".edit").click(function(evt){
		evt.preventDefault(); 
		context = $(this);

		window.location = baseUrl+'/pembelian/rencana-pembelian/rencana-pembelian/edit?id='+context.data('id');
	})

	$('.status').on('change', function(e){
		var value = $(this).val();
		var no = $(this).attr('rel');
		var rdt_req = $(this).attr('rel1');
		// window.location = baseUrl+'/pembelian/rencana-pembelian/request-order-status?status='+value+'&&rdt_no='+no;
		$('#overlay').fadeIn(300);
		axios.post(baseUrl+'/pembelian/rencana-pembelian/request-order-status', {
			status 	: value,
			rdt_no 	: no,
			rdt_request : rdt_req,
			_token 	: '{{ csrf_token() }}'
		})
		.then((response) => {
			if(response.data.status == 'rencana pembelian'){
				$.toast({
					text: 'Status untuk Request Detail "'+no+'" berhasil diubah ke "Rencana Pembelian".',
					showHideTransition: 'fade',
					icon: 'success'
				});
				location.reload();
			} else if (response.data.status == 'ditunda') {
				$.toast({
					text: 'Status untuk Request Detail "'+no+'" berhasil diubah ke "Ditunda".',
					showHideTransition: 'fade',
					icon: 'success'
				});
				location.reload();
			} else if (response.data.status == 'dibatalkan') {
				$.toast({
					text: 'Status untuk Request Detail "'+no+'" berhasil diubah ke "Dibatalkan".',
					showHideTransition: 'fade',
					icon: 'success'
				});
				location.reload();
			} else if (response.data.status == 'pending') {
				$.toast({
					text: 'Status untuk Request Detail "'+no+'" berhasil diubah ke "Pending".',
					showHideTransition: 'fade',
					icon: 'success'
				});
				location.reload();
			}
		}).catch((error) => {
			console.log(error);
		})
	});

})
</script>

@endsection