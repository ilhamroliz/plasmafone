@extends('main')

@section('title', 'Tambah User')

@section('extra_style')
<style>
    #pass + .glyphicon {
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
                            <h2><strong>Tambah Data User</strong></h2>				  
                        </header>

                        <!-- widget div-->
                        <div>
                            
                            <!-- widget content -->
                            <div class="weight-body">
                                <form id="form-tambah" class="form-horizontal" action="{{ url('/pengaturan/kelola-pengguna/simpan') }}" method="post" enctype="multipart/form-data">
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
                                                        <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama User" style="text-transform: uppercase" required>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-xs-4 col-lg-4 control-label text-left">Outlet</label>
                                                    <div class="col-xs-8 col-lg-8 inputGroupContainer">
                                                        <select name="outlet" class="form-control outlet" id="outlet" required>
                                                            <option value="" selected disabled>-- PILIH OUTLET</option>
                                                            @foreach($getOutlet as $data)
                                                            <option value="{{ $data->c_id }}">{{ $data->c_name }}</option>
                                                            @endforeach
                                                        </select>                                                    
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-xs-4 col-lg-4 control-label text-left">Username</label>
                                                    <div class="col-xs-8 col-lg-8 inputGroupContainer">
                                                        <input type="text" class="form-control" name="username" id="username" placeholder="USERNAME" required>
                                                    </div>                                                
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-xs-4 col-lg-4 control-label text-left">Password</label>
                                                    <div class="col-xs-8 col-lg-8 inputGroupContainer">
                                                        <input type="password" class="form-control" name="pass" id="pass" placeholder="PASSWORD" required>
                                                        <i class="glyphicon glyphicon-eye-open form-control-feedback"></i>
                                                    </div>                                                
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-xs-4 col-lg-4 control-label text-left">Konfirmasi Password</label>
                                                    <div class="col-xs-8 col-lg-8 inputGroupContainer">
                                                        <input type="password" class="form-control" name="passconf" id="passconf" placeholder="KONFIRMASI PASSWORD" required>
                                                        <i class="glyphicon glyphicon-eye-open form-control-feedback"></i>
                                                    </div>                                                
                                                </div>
                                               
                                            </div>

                                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 sortable-grid ui-sortable">

                                                <div class="form-group">
                                                    <label class="col-xs-4 col-lg-4 control-label text-left">Level Pengguna</label>
                                                    <div class="col-xs-8 col-lg-8 inputGroupContainer">
                                                        <select name="jabatan" class="form-control jabatan" id="jabatan" required>
                                                            <option value="" selected disabled>-- PILIH LEVEL</option>
                                                            @foreach($getLevel as $data)
                                                            @if($data->l_id != 1)
                                                            <option value="{{ $data->l_id }}">{{ $data->l_name }}</option>
                                                            @endif
                                                            @endforeach
                                                        </select>                                                       
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-xs-4 col-lg-4 control-label text-left">Tanggal Lahir</label>
                                                    <div class="col-xs-8 col-lg-8">
                                                        <select id="dobday" class="form-control col-sm-2" style="width: 30%;" name="tanggal"></select>
                                                        <select id="dobmonth" class="form-control col-sm-4" style="width: 30%; margin-left: 10px" name="bulan"></select>
                                                        <select id="dobyear" class="form-control col-sm-3" style="width: 30%; margin-left: 10px" name="tahun"></select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-xs-4 col-lg-4 control-label text-left">Alamat User</label>
                                                    <div class="col-xs-8 col-lg-8 textarea">
                                                        <textarea name="alamat" id="alamat" class="custom-scroll form-control" rows="3" style="width: 100%" required></textarea>
                                                    </div>                                                
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-xs-4 col-lg-4 control-label text-left">Gambar</label>
                                                    <div class="col-xs-8 col-lg-8">
                                                        <div class="upload-btn-wrapper">
                                                            <!-- <label class="btn btn-default" for="upload-file-selector">
                                                                <input id="upload-file-selector" name="imageUpload" class="uploadGambar" type="file" >
                                                                <i class="fa fa-file-picture-o margin-correction"></i>&nbsp;Upload Gambar
                                                            </label> -->

                                                            <button class="btn btn-default"><i class="fa fa-file-picture-o"></i>&nbsp;Upload Gambar</button>
                                                            <input type="file" name="imageUpload" id="imageUpload" class="uploadGambar" />
                                                            <label> &nbsp Maksimal 2 MB</label>
														</div>
                                                    </div>                                                
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-xs-4 col-lg-4 control-label"></label>
                                                    <div class="col-xs-8 col-lg-8">
                                                        <div class="col-sm-12 image-holder" style="padding:0px;">
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
<script src="{{ asset('template_asset/js/plugin/bootstrapvalidator/bootstrapValidator.min.js') }}"></script>

<script src="{{ asset('template_asset/js/notification/SmartNotification.min.js') }}"></script>
<script src="{{ asset('template_asset/js/app.config.js') }}"></script>
<script src="{{ asset('template_asset/js/waitingfor.js') }}"></script>
<script src="{{ asset('template_asset/js/dobpicker.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $.dobPicker({
        // Selectopr IDs
        daySelector: '#dobday',
        monthSelector: '#dobmonth',
        yearSelector: '#dobyear',

        // Default option values
        dayDefault: 'Tanggal',
        monthDefault: 'Bulan',
        yearDefault: 'Tahun',

        // Minimum age
        minimumAge: 10,

        // Maximum age
        maximumAge: 80
        });

    });

    $('#passconf').blur(function(){
        if($('#passconf').val() != $('#pass').val()){
            $.smallBox({
                title : "PERHATIAN",
                content : "Password tidak sesuai",
                color : "#C46A69",
                iconSmall : "fa fa-times animated",
                timeout : 3000
            });
        }
    })

    $('#username').blur(function(){
        var username = $('#username').val();
        axios.post(baseUrl+'/pengaturan/kelola-pengguna/cekuser', {username:username}).then((response) => {
            if(response.data.status == 'ada'){
                $.smallBox({
                title : "PERHATIAN",
                content : "Username sudah digunakan",
                color : "#C46A69",
                iconSmall : "fa fa-times animated",
                timeout : 3000
            });
            }
        })
    })

    $(".uploadGambar").on('change', function () {
        $('.save').attr('disabled', false);
        if (typeof (FileReader) != "undefined") {
            var image_holder = $(".image-holder");
            image_holder.empty();
            var reader = new FileReader();
            reader.onload = function (e) {
                image_holder.html('<img src="{{ asset('template_asset/img/loading1.gif') }}" class="img-responsive" width="60px">');
                $('.save').attr('disabled', true);
                setTimeout(function(){
                    image_holder.empty();
                    $("<img />", {
                        "src": e.target.result,
                        "class": "thumb-image img-responsive",
                        "height": "80px",
                    }).appendTo(image_holder);
                    $('.save').attr('disabled', false);
                }, 2000)
            }
            image_holder.show();
            reader.readAsDataURL($(this)[0].files[0]);
        } else {
            alert("This browser does not support FileReader.");
        }
    });

    //// Untuk set visibility Password
	$('#pass + .glyphicon').on('click', function() {
		$(this).toggleClass('glyphicon-eye-close').toggleClass('glyphicon-eye-open'); // toggle our classes for the eye icon
		//$('#password').password('toggle'); // activate the hideShowPassword plugin
		if (document.getElementById('pass').type == 'text') {
			document.getElementById('pass').type = 'password';
		} else {
			document.getElementById('pass').type = 'text';
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



</script>
@endsection