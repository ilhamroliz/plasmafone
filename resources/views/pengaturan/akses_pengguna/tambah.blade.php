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
                    Tambah Data User</span></h1>
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
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">

                    <!-- Widget ID (each widget will need unique ID)-->
                    <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
                        <header>
                            <h2><strong>Tambah Data User</strong></h2>				  
                        </header>

                        <!-- widget div-->
                        <div>
                            
                            <!-- widget content -->
                            <div class="weight-body">
                                <form id="form-tambah" class="form-horizontal" action="{{ url('/pengaturan/akses-pengguna/simpan-tambah') }}" method="post">
                                    {{ csrf_field() }}
                                    <fieldset>
                                        <legend>
                                            Form Tambah User
                                        </legend>

                                        <div class="row">
                                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 sortable-grid ui-sortable">
                                                
                                                <div class="form-group">
                                                    <label class="col-xs-4 col-lg-4 control-label text-left">Nama User</label>
                                                    <div class="col-xs-8 col-lg-8 inputGroupContainer">
                                                        <input type="text" class="form-control" name="namaUser" id="namaUser" placeholder="Nama User" style="text-transform: uppercase">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-xs-4 col-lg-4 control-label text-left">Username</label>
                                                    <div class="col-xs-8 col-lg-8 inputGroupContainer">
                                                        <input type="text" class="form-control" name="username" id="username" placeholder="USERNAME">
                                                    </div>                                                
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-xs-4 col-lg-4 control-label text-left">Password</label>
                                                    <div class="col-xs-8 col-lg-8 inputGroupContainer">
                                                        <input type="text" class="form-control" name="pass" id="pass" placeholder="PASSWORD">
                                                    </div>                                                
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-xs-4 col-lg-4 control-label text-left">Konfirmasi Password</label>
                                                    <div class="col-xs-8 col-lg-8 inputGroupContainer">
                                                        <input type="text" class="form-control" name="passConf" id="passConf" placeholder="KONFIRMASI PASSWORD">
                                                    </div>                                                
                                                </div>
                                               
                                            </div>

                                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 sortable-grid ui-sortable">

                                                <div class="form-group">
                                                    <label class="col-xs-4 col-lg-4 control-label text-left">Jabatan</label>
                                                    <div class="col-xs-8 col-lg-8 inputGroupContainer">
                                                        <input type="text" class="form-control" name="jabatan" id="jabatan" placeholder="JABATAN USER">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-xs-4 col-lg-4 control-label text-left">Alamat User</label>
                                                    <div class="col-xs-8 col-lg-8 inputGroupContainer textarea">
                                                        <textarea name="alamatUser" id="alamatUser" class="custom-scroll" rows="3"></textarea>
                                                    </div>                                                
                                                </div>

                                            </div>
                                            
                                        </div>
                                        
                                    </fieldset>
                                    
                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button class="btn btn-primary" type="submit" style="margin-left: 5px;">
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