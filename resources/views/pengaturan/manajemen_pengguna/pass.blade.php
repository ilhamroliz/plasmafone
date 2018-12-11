@extends('main')

@section('title', 'Tambah User')

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
        <li>Home</li><li>Pengaturan</li><li>Tambah Pengguna</li>
    </ol>
    <!-- end breadcrumb -->

    </div>
    <!-- END RIBBON -->
@endsection

@section('main_content')
    <!-- MAIN CONTENT -->
	<div id="content">

        <div class="row hidden-mobile">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <h1 class="page-title txt-color-blueDark">
                    <i class="fa-fw fa fa-cog"></i> 
                    Pengelolaan Pengguna<span>>
                    Ganti Password User</span></h1>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-align-right">
				<div class="page-title">
					<a href="{{ url('/pengaturan/akses-pengguna') }}" class="btn btn-default"><i class="fa fa-arrow-left"></i>&nbsp;Kembali</a>
				</div>
			</div>

        </div>

        <!-- widget grid -->
        <section id="widget-grid" class="" style="margin-bottom: 20px; min-height: 500px;">

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

            <!-- row -->
            <div class="row">

                <!-- NEW WIDGET START -->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">

                    <!-- Widget ID (each widget will need unique ID)-->
                    <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
                        <header>
                            <h2><strong>Ganti Password User</strong></h2>				  
                        </header>

                        <!-- widget div-->
                        <div>
                            
                            <!-- widget content -->
                            <div class="weight-body">
                                <form id="form-pass" class="form-horizontal">
                                    <input type="hidden" name="id" value="{{ $id }}">
                                    {{ csrf_field() }}
                                    <fieldset>
                                        <legend>
                                            Form Ganti Password
                                        </legend>

                                        <div class="row">
                                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 sortable-grid ui-sortable">
                                                
                                                <div class="form-group">
                                                    <label class="col-xs-4 col-lg-4 control-label text-left">Password Lama</label>
                                                    <div class="col-xs-8 col-lg-8 inputGroupContainer">
                                                        <input type="password" class="form-control" name="passLama" id="passLama" placeholder="PASSWORD LAMA">
                                                    </div>                                                
                                                </div>

                                            </div>

                                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 sortable-grid ui-sortable">

                                                <div class="form-group">
                                                    <label class="col-xs-4 col-lg-4 control-label text-left">Password Baru</label>
                                                    <div class="col-xs-8 col-lg-8 inputGroupContainer">
                                                        <input type="password" class="form-control" name="passBaru" id="passBaru" placeholder="PASSWORD BARU">
                                                    </div>                                                
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-xs-4 col-lg-4 control-label text-left">Konfirmasi </label>
                                                    <div class="col-xs-8 col-lg-8 inputGroupContainer">
                                                        <input type="password" class="form-control" name="passconf" id="passconf" placeholder="KONFIRMASI PASSWORD BARU">
                                                    </div>                                                
                                                </div>

                                            </div>
                                            
                                        </div>
                                        
                                    </fieldset>
                                    
                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button class="btn btn-primary" id="submit-tambah" type="submit" style="margin-left: 5px;">
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

                </div>
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
<script src="{{ asset('template_asset/js/notification/SmartNotification.min.js') }}"></script>
<script src="{{ asset('template_asset/js/app.config.js') }}"></script>
<script src="{{ asset('template_asset/js/waitingfor.js') }}"></script>
<script src="{{ asset('template_asset/js/dobpicker.js') }}"></script>
<script type="text/javascript">
    // --- AXIOS USE ----//
		$('#overlay').fadeIn(200);
		$('#load-status-text').text('Penyimpanan Database Sedang di Proses');
		// let btn = $('#submit-akses');
		// btn.attr('disabled', 'disabled');
		// btn.html('<i class="fa fa-floppy-o"></i> &nbsp;Proses...');

		axios.post(baseUrl+'/pengaturan/akses-pengguna/simpanPass', $('#form-pass').serialize())
			.then((response) => {
				if(response.data.status == 'sukses'){
					$('#overlay').fadeOut(200);
					// location.reload();
					$.smallBox({
						title : "SUKSES",
						content : "Password User Berhasil Diperbarui",
						color : "#739E73",
						iconSmall : "fa fa-check animated",
						timeout : 3000
					});
					// location.reload();
				}else if(response.data.status == 'gagalPassL'){
					$('#overlay').fadeOut(200);
					$.smallBox({
						title : "GAGAL",
						content : "Password Lama Salah",
						color : "#C46A69",
						iconSmall : "fa fa-times animated",
						timeout : 3000
					});
					// location.reload();
				}else if(response.data.status == 'gagalPassB'){
					$('#overlay').fadeOut(200);
					$.smallBox({
						title : "GAGAL",
						content : "Password Baru Tidak Sesuai",
						color : "#C46A69",
						iconSmall : "fa fa-times animated",
						timeout : 3000
					});
					// location.reload();
                }else if(response.data.status == 'gagal'){
					$('#overlay').fadeOut(200);
					$.smallBox({
						title : "GAGAL",
						content : "Password User Gagal Diperbarui",
						color : "#C46A69",
						iconSmall : "fa fa-times animated",
						timeout : 3000
					});
					// location.reload();
                }
		})
</script>

@endsection