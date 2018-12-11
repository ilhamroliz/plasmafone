@extends('main')

@section('title', 'Akses Pengguna')

@section('extra_style')
<style>
	#passLama + .glyphicon {
       cursor: pointer;
       pointer-events: all;
    }
	#passBaru + .glyphicon {
       cursor: pointer;
       pointer-events: all;
    }
	#passconf + .glyphicon {
       cursor: pointer;
       pointer-events: all;
    }
</style>
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
		<li>Home</li><li>Pengaturan</li><li>Akses Pengguna</li>
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

			@if(Session::has('flash_message_success'))
				<div class="col-md-12">
					<div class="alert alert-success alert-block">
						<a class="close" data-dismiss="alert" href="#">×</a>
						<h4 class="alert-heading">&nbsp;<i class="fa fa-thumbs-up"></i> &nbsp;Pemberitahuan Berhasil</h4>
						{{ Session::get('flash_message_success') }} 
					</div>
				</div>
			@elseif(Session::has('flash_message_error'))
				<div class="col-md-12">
					<div class="alert alert-danger alert-block">
						<a class="close" data-dismiss="alert" href="#">×</a>
						<h4 class="alert-heading">&nbsp;<i class="fa fa-frown-o"></i> &nbsp;Pemberitahuan Gagal</h4>
						{{ Session::get('flash_message_error') }}
					</div>
				</div>
			@endif

			<?php $mt = '20px'; ?>

			<!-- row -->
			<div class="row">

				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-cog"></i> Pengelolaan Pengguna <span>> User</span></h1>
				</div>

				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-align-right">
					<div class="page-title">
						@if($dis == 'denied')
						<button class="btn btn-success" onclick=tambah() disabled><i class="fa fa-plus"></i>&nbsp;Tambah Data</button>
						@else
						<button class="btn btn-success" onclick=tambah()><i class="fa fa-plus"></i>&nbsp;Tambah Data</button>
						@endif
					</div>
				</div>
				
				<!-- NEW WIDGET START -->
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<!-- Widget ID (each widget will need unique ID)-->
					<div class="jarviswidget" id="wid-id-0" 
						data-widget-colorbutton="false" 
						data-widget-deletebutton="false" 
						data-widget-editbutton="false"
						data-widget-custombutton="false"
						data-widget-sortable="false">
						<!-- widget options:
							usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">
							
							data-widget-colorbutton="false"	
							data-widget-editbutton="false"
							data-widget-togglebutton="false"
							data-widget-deletebutton="false"
							data-widget-fullscreenbutton="false"
							data-widget-custombutton="false"
							data-widget-collapsed="true" 
							data-widget-sortable="false"
							
						-->
						<header>
							<h2><strong>Pengelolaan Pengguna</strong></h2>											
						</header>

						<!-- widget div-->
						<div>
							
							<!-- widget edit box -->
							<div class="jarviswidget-editbox">
								<!-- This area used as dropdown edit box -->
								<input class="form-control" type="text">
								<span class="note"><i class="fa fa-check text-success"></i> Change title to update and save instantly!</span>
								
							</div>
							<!-- end widget edit box -->
							
							<!-- widget content -->
							<div class="widget-body">
								{!! csrf_field() !!}
								<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
									<thead>			                
										<tr>
											<th class="text-center">Nama User</th>
											<th class="text-center">Username</th>
											<th class="text-center">Jabatan</th>
											<th class="text-center">Aksi</th>
										</tr>
									</thead>
								</table>
							</div>
							<!-- end widget content -->
							
						</div>
						<!-- end widget div -->
						
					</div>
					<!-- end widget -->
				</article>

			</div>
			<!-- end row -->
		</section>
		<!-- end widget grid -->

		<!-- Modal -->
		<div class="modal fade" id="modalPass" tabindex="-1" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4>Form Ganti Password</h4>
						<!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							&times;
						</button>
						<h4 class="modal-title">
							<img src="img/logo.png" width="150" alt="SmartAdmin">
						</h4> -->
					</div>
					<div class="modal-body no-padding">

						<form id="pass-form" class="smart-form">
							<input type="hidden" name="id" id="id">

							<fieldset>
								<section>
									<div class="row">
										<label class="label col col-4">Password Lama</label>
										<div class="col col-8 has-feedback">
											<label class="input">
												<input type="password" name="passLama" id="passLama">
												<i class="glyphicon glyphicon-eye-open form-control-feedback"></i>
											</label>
										</div>
									</div>
								</section>

								<section>
									<div class="row">
										<label class="label col col-4">Password Baru</label>
										<div class="col col-8 has-feedback">
											<label class="input">
												<input type="password" name="passBaru" id="passBaru">
												<i class="glyphicon glyphicon-eye-open form-control-feedback"></i>
											</label>
										</div>
									</div>
								</section>

								<section>
									<div class="row">
										<label class="label col col-4">Konfirmasi Password Baru</label>
										<div class="col col-8 has-feedback">
											<label class="input">
												<input type="password" name="passconf" id="passconf">
												<i class="glyphicon glyphicon-eye-open form-control-feedback"></i>
											</label>
										</div>
									</div>
								</section>

							</fieldset>
							
							<footer>
								<button type="button" class="btn btn-primary" onclick="simpan_pass()"><i class="fa fa-floppy-o"></i>
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
		</div><!-- /.modal -->

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
  	var user;
	$(document).ready(function(){
		setTimeout(function () {
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			user = $('#dt_basic').DataTable({
				"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
				"t"+
				"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
				"autoWidth" : true,
				"language" : dataTableLanguage,
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
				},

				processing: true,
				searching: true,
				serverSide: true,
				"ajax": {
					"url": "{{ url('/pengaturan/akses-pengguna/dataUser') }}",
					"type": "post",
				},
				columns: [
					{data: 'm_name', name: 'm_name'},
					{data: 'm_username', name: 'm_username'},
					{data: 'nama', name: 'nama'},
					{data: 'aksi', name: 'aksi'}
				],
				responsive: false,
				//"language": dataTableLanguage,
			});
		}, 500);
	});

	//// Untuk memasukkan Encrypted Id dari controller ke modal
	$(document).ready(function () {
		$('body').on('click', '#passM',function(){
		document.getElementById("id").value = $(this).attr('data-id');
		// console.log($(this).attr('data-id'));
		});
	});

	//// Untuk set visibility Password
	$('#passLama + .glyphicon').on('click', function() {
		$(this).toggleClass('glyphicon-eye-close').toggleClass('glyphicon-eye-open'); // toggle our classes for the eye icon
		//$('#password').password('toggle'); // activate the hideShowPassword plugin
		if (document.getElementById('passLama').type == 'text') {
			document.getElementById('passLama').type = 'password';
		} else {
			document.getElementById('passLama').type = 'text';
		}
    });
	$('#passBaru + .glyphicon').on('click', function() {
		$(this).toggleClass('glyphicon-eye-close').toggleClass('glyphicon-eye-open'); // toggle our classes for the eye icon
		//$('#password').password('toggle'); // activate the hideShowPassword plugin
		if (document.getElementById('passBaru').type == 'text') {
			document.getElementById('passBaru').type = 'password';
		} else {
			document.getElementById('passBaru').type = 'text';
		}
    });
	$('#passconf + .glyphicon').on('click', function() {
		$(this).toggleClass('glyphicon-eye-close').toggleClass('glyphicon-eye-open'); // toggle our classes for the eye icon
		//$('#password').password('toggle'); // activate the hideShowPassword plugin
		if (document.getElementById('passconf').type == 'text') {
			document.getElementById('passconf').type = 'password';
		} else {
			document.getElementById('passconf').type = 'text';
		}
    });

	function akses(id){
		location.href = ('{{ url('/pengaturan/akses-pengguna/edit') }}/' + id);
	}

	function edit(id){
		location.href = ('{{ url('/pengaturan/kelola-pengguna/edit') }}/' + id);
	}

	function pass(id){
		location.href = ('{{ url('/pengaturan/kelola-pengguna/pass') }}/' + id);
	}

	function trigger(id){
		// location.href = ('{{ url('/pengaturan/kelola-pengguna/hapus') }}/' + id);
		
		$.SmartMessageBox({
			title : "PERHATIAN !",
			content : "Apakah Anda yakin ingin mengubah status Aktivasi User ?",
			buttons : '[No][Yes]'
		}, function(ButtonPressed) {
			if (ButtonPressed === "Yes") {
				$.smallBox({
					title : "Pemberitahuan",
					content : "<i class='fa fa-clock-o'></i> <i>Perubahan Status Aktivasi Disetujui</i>",
					color : "#659265",
					iconSmall : "fa fa-check fa-2x fadeInRight animated",
					timeout : 3000
				});
				location.href = ('{{ url('/pengaturan/kelola-pengguna/hapus') }}/' + id);
				// location.href = ('{{ url('/pengaturan/kelola-pengguna/hapus') }}/' + id);
			}
			if (ButtonPressed === "No") {
				$.smallBox({
					title : "Pemberitahuan",
					content : "<i class='fa fa-clock-o'></i> <i>Perubahan Status Aktivasi Dibatalkan</i>",
					color : "#C46A69",
					iconSmall : "fa fa-times fa-2x fadeInRight animated",
					timeout : 3000
				});
			}
		});
		e.preventDefault();
	}

	function tambah(){
		location.href = ('{{ url('/pengaturan/kelola-pengguna/tambah') }}');
	}
//   function cekAksesTambah() {
// 	$.ajax({
// 		url: '{{ url('/pengaturan/kelola-pengguna/tambah') }}',
// 		success: function(response){
// 			if(response.status == 'gagal') {
// 				// alert('Data Gagal Di Update');	
// 				// waitingDialog.hide();
// 				// $('#overlay').fadeOut(200);
// 				$.smallBox({
// 					title : "PERHATIAN !",
// 					content : "Anda tidak memiliki akses untuk menambahkan Data Pengguna",
// 					color : "#C46A69",
// 					iconSmall : "fa fa-times animated",
// 					timeout : 3000
// 				});
// 				// location.reload();
// 			}else{
// 				location.href = ('{{ url('/pengaturan/kelola-pengguna/tambah') }}');
// 			}
// 		}
// 	})
//   }

function simpan_pass(){
    // --- AXIOS USE ----//
    // $('#overlay').fadeIn(200);
    // $('#load-status-text').text('Penyimpanan Database Sedang di Proses');
    // // let btn = $('#submit-akses');
    // // btn.attr('disabled', 'disabled');
    // // btn.html('<i class="fa fa-floppy-o"></i> &nbsp;Proses...');

    // axios.post(baseUrl+'/pengaturan/kelola-pengguna/simpanPass', $('#form-pass').serialize())
    //     .then((response) => {
    //         if(response.data.status == 'sukses'){
    //             $('#overlay').fadeOut(200);
    //             // location.reload();
    //             $.smallBox({
    //                 title : "SUKSES",
    //                 content : "Password User Berhasil Diperbarui",
    //                 color : "#739E73",
    //                 iconSmall : "fa fa-check animated",
    //                 timeout : 3000
    //             });
    //             // location.reload();
    //         }else if(response.data.status == 'gagalPassL'){
    //             $('#overlay').fadeOut(200);
    //             $.smallBox({
    //                 title : "GAGAL",
    //                 content : "Password Lama Salah",
    //                 color : "#C46A69",
    //                 iconSmall : "fa fa-times animated",
    //                 timeout : 3000
    //             });
    //             // location.reload();
    //         }else if(response.data.status == 'gagalPassB'){
    //             $('#overlay').fadeOut(200);
    //             $.smallBox({
    //                 title : "GAGAL",
    //                 content : "Password Baru Tidak Sesuai",
    //                 color : "#C46A69",
    //                 iconSmall : "fa fa-times animated",
    //                 timeout : 3000
    //             });
    //             // location.reload();
    //         }else if(response.data.status == 'gagal'){
    //             $('#overlay').fadeOut(200);
    //             $.smallBox({
    //                 title : "GAGAL",
    //                 content : "Password User Gagal Diperbarui",
    //                 color : "#C46A69",
    //                 iconSmall : "fa fa-times animated",
    //                 timeout : 3000
    //             });
    //             // location.reload();
    //         }
    // })

    $('#overlay').fadeIn(200);
    $('#load-status-text').text('Silahkan Memproses Penyimpanan Data');
    // waitingDialog.show();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '{{ url('/pengaturan/kelola-pengguna/simpanPass') }}',
        type: 'get',
        data: $('#pass-form').serialize(),
        success: function(response){
            if (response.status == 'sukses') {
                // waitingDialog.hide();
                $('#overlay').fadeOut(200);
                $.smallBox({
                    title : "SUKSES",
                    content : "Data Akses Berhasil Diperbarui",
                    color : "#739E73",
                    iconSmall : "fa fa-check animated",
                    timeout : 5000
                });
                location.reload();
            }
            else if(response.status == 'gagal') {
                // alert('Data Gagal Di Update');	
                // waitingDialog.hide();
                $('#overlay').fadeOut(200);
                $.smallBox({
                    title : "GAGAL",
                    content : "Data Akses Gagal Diperbarui",
                    color : "#C46A69",
                    iconSmall : "fa fa-times animated",
                    timeout : 5000
                });
                // location.reload();
            }
            else if(response.status == 'gagalPassL') {
                // alert('Data Gagal Di Update');	
                // waitingDialog.hide();
                $('#overlay').fadeOut(200);
                $.smallBox({
                    title : "GAGAL",
                    content : "Password Lama Tidak Sesuai",
                    color : "#C46A69",
                    iconSmall : "fa fa-times animated",
                    timeout : 5000
                });
                // location.reload();
            }
            else if(response.status == 'gagalPassB') {
                // alert('Data Gagal Di Update');	
                // waitingDialog.hide();
                $('#overlay').fadeOut(200);
                $.smallBox({
                    title : "GAGAL",
                    content : "Password Baru Tidak Sesuai",
                    color : "#C46A69",
                    iconSmall : "fa fa-times animated",
                    timeout : 5000
                });
                // location.reload();
            }
        }
    })
}
</script>

@endsection