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
		<li>Home</li><li>Pengaturan</li><li>Log Kegiatan Pengguna</li>
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
					<h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-cog"></i> Pengelolaan Pengguna <span>> Log Kegiatan Pengguna</span></h1>
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

						<header>
							<h2><strong>Log Kegiatan Pengguna</strong></h2>
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

								<div class="row form-group">
									<div class="col-lg-12 col-md-12 col-sm-12">
										<div class="col-md-4">

											<div>
												<div class="input-group input-daterange" id="date-range">
													<input type="text" class="form-control" id="tgl_awal" name="tgl_awal"  placeholder="Tanggal Awal" data-dateformat="dd/mm/yy">
													<span class="input-group-addon bg-custom text-white b-0">to</span>
													<input type="text" class="form-control" id="tgl_akhir" name="tgl_akhir"  placeholder="Tanggal Akhir" data-dateformat="dd/mm/yy">
												</div>
											</div>

										</div>
										<div class="col-md-7">
											<div class="form-group">
												<input type="hidden" name="searchhidden" id="searchhidden">
												<input type="text" id="search" class="form-control" name="search" placeholder="Cari Berdasarkan Nama User" style="width: 80%; float: left">

												<button type="button" class="btn btn-primary btn-sm icon-btn ml-2" onclick="search()" style="width: 10%; margin-left: 5%">
													<i class="fa fa-search"></i>
												</button>
											</div>
										</div>

										<div class="col-md-1 no-padding no-margin hapuslog">
										</div>
									</div>
								</div>

								{!! csrf_field() !!}
								<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
									<thead>
										<tr>
                                            <th class="text-center" style="width: 20%">Nama</th>
											<th class="text-center" style="width: 25%">Outlet</th>
											<th class="text-center" style="width: 40%">Aktivitas</th>
											<th class="text-center" style="width: 15%">Waktu Akses</th>
										</tr>
									</thead>
									<tbody id="showdata">

									</tbody>
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

	</div>
<!-- END MAIN CONTENT -->
@endsection

@section('extra_script')

<!-- PAGE RELATED PLUGIN(S) -->

<script type="text/javascript">
	var table;
	$(document).ready(function(){
		$( "#search" ).autocomplete({
			source: baseUrl+'/pengaturan/log-kegiatan/cariLog',
			minLength: 2,
			select: function(event, data) {
				getData(data.item);
			}
		});

		table = $('#dt_basic').DataTable({
			language: dataTableLanguage,
			"order": []
		});

		$( "#date-range" ).datepicker({
			language: "id",
			format: 'dd/mm/yyyy',
			prevText: '<i class="fa fa-chevron-left"></i>',
			nextText: '<i class="fa fa-chevron-right"></i>',
			autoclose: true,
			todayHighlight: true
		});

	});

	function getData(data){
		$('#searchhidden').val(data.id);
	}

	function search(){

		$('#showdata').html('<tr class="odd"><td valign="top" colspan="6" class="dataTables_empty">Tidak ada data</td></tr>');
		var tgl_awal = $('#tgl_awal').val();
		var tgl_akhir = $('#tgl_akhir').val();
		var nama = $('#searchhidden').val();

		$('#overlay').fadeIn(200);
		$('#load-status-text').text('Sedang Mencari Data ...');
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.ajax({
			url: '{{ url('/pengaturan/log-kegiatan/findLog') }}',
			type: 'get',
			data: {tgl_awal:tgl_awal, tgl_akhir:tgl_akhir, nama:nama},
			success: function(response){
				$('#searchhidden').val('');
				table.clear();
				for (var i = 0; i < response.length; i++) {
					table.row.add([
						response[i].m_name,
						response[i].c_name,
						response[i].la_activity,
						response[i].la_date
					]).draw( false );
				}
			}
		});
		$('#overlay').fadeOut(200);
		$('.hapuslog').html('<button class="btn btn-danger animated" style="width: 100%" onclick="hapus()"><i class="">Hapus</i></button>');
	}

	function hapus(){
		var tgl_awal = $('#tgl_awal').val();
		var tgl_akhir = $('#tgl_akhir').val();
		var nama = $('#searchhidden').val();

		$.SmartMessageBox({
			title : "Pesan!",
			content : 'Apakah Anda yakin akan manghapus data Log tanggal '+tgl_awal+' - '+tgl_akhir+' ?',
			buttons : '[Batal][Ya]'
		}, function(ButtonPressed) {
			if (ButtonPressed === "Ya") {
				$('#overlay').fadeIn(200);
				$('#load-status-text').text('Sedang Menghapus Data ...');
				$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});
				$.ajax({
					url: '{{ url('/pengaturan/log-kegiatan/hapus') }}',
					type: 'get',
					data: {tgl_awal:tgl_awal, tgl_akhir:tgl_akhir, nama:nama},
					success: function(response){
						if(response.status == 'hlSukses'){
							$('#overlay').fadeOut(200);
							$.smallBox({
								title : "Berhasil",
								content : 'Data Log Berhasil Dihapus ...!',
								color : "#739E73",
								timeout: 4000,
								icon : "fa fa-check bounce animated"
							});
							location.reload();
						}else if(response.status == 'empty'){
							$('#overlay').fadeOut(200);
							$.smallBox({
								title : "Gagal",
								content : "Maaf, Data Log Tidak Ada ",
								color : "#A90329",
								timeout: 4000,
								icon : "fa fa-times bounce animated"
							});
						}else{
							$('#overlay').fadeOut(200);
							$.smallBox({
								title : "Gagal",
								content : "Maaf, Data Log Gagal Dihapus ",
								color : "#A90329",
								timeout: 4000,
								icon : "fa fa-times bounce animated"
							});
						}
					}
				});
				$('#overlay').fadeOut(200);
			}
		});
	}
</script>
@endsection
