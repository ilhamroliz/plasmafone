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
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h1 class="page-title txt-color-blueDark">
                    <i class="fa-fw fa fa-cog"></i> 
                    Pengelolaan Pengguna<span>>
                    Tambah User</span></h1>
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
                <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                    <!-- Widget ID (each widget will need unique ID)-->
                    <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
                        <header>
                            <h2><strong>Tambah User</strong></h2>				  
                        </header>

                        <!-- widget div-->
                        <div>
                            
                            <!-- widget content -->
                            <div class="weight-body ibox-content">
                                <form id="form-tambah" class="smart-form" action="{{ url('/pengaturan/akses-pengguna/simpan-tambah') }}" method="post">
                                    {{ csrf_field() }}
                                    <fieldset>
                                        <legend>
                                            Form Tambah User
                                        </legend>

                                        <div class="row form-group">
                                            <section class="col col-6">
                                                <label class="input"> <i class="icon-prepend fa fa-user"></i>
                                                    <input type="text" name="name" placeholder="Nama">
                                                </label>
                                            </section>
                                            <section class="col col-6">
                                                <label class="input"> <i class="icon-prepend fa fa-user"></i>
                                                    <input type="text" name="uname" placeholder="Username">
                                                </label>
                                            </section>
                                        </div>

                                        <div class="row form-group">
                                            <section class="col col-6">
                                                <label class="input"> <i class="icon-prepend fa fa-key"></i>
                                                    <input type="text" name="pass" placeholder="Password">
                                                </label>
                                            </section>
                                            <section class="col col-6">
                                                <label class="input"> <i class="icon-prepend fa fa-key"></i>
                                                    <input type="text" name="passconf" placeholder="Konfirmasi Password">
                                                </label>
                                            </section>
                                        </div>

                                        <div class="form-group row">
                                        <!-- <div class="col col-6"> -->
                                            <section class="col col-2">
                                                <label class="select">
                                                    <select name="day">
                                                        <option value="0" selected="" disabled="">Tanggal</option>
                                                        <option value="1">1</option>
                                                        <option value="1">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                        <option value="9">9</option>
                                                        <option value="10">10</option>
                                                        <option value="11">11</option>
                                                        <option value="12">12</option>
                                                        <option value="13">13</option>
                                                        <option value="14">14</option>
                                                        <option value="15">15</option>
                                                        <option value="16">16</option>
                                                        <option value="17">17</option>
                                                        <option value="18">18</option>
                                                        <option value="19">19</option>
                                                        <option value="20">20</option>
                                                        <option value="21">21</option>
                                                        <option value="22">22</option>
                                                        <option value="23">23</option>
                                                        <option value="24">24</option>
                                                        <option value="25">25</option>
                                                        <option value="26">26</option>
                                                        <option value="27">27</option>
                                                        <option value="28">28</option>
                                                        <option value="29">29</option>
                                                        <option value="30">30</option>
                                                        <option value="31">31</option>
                                                    </select> <i></i> 
                                                </label>
                                            </section>
                                            <section class="col col-2">
                                                <label class="select">
                                                    <select name="month">
                                                        <option value="0" selected="" disabled="">Bulan</option>
                                                        <option value="1">January</option>
                                                        <option value="1">February</option>
                                                        <option value="3">March</option>
                                                        <option value="4">April</option>
                                                        <option value="5">May</option>
                                                        <option value="6">June</option>
                                                        <option value="7">July</option>
                                                        <option value="8">August</option>
                                                        <option value="9">September</option>
                                                        <option value="10">October</option>
                                                        <option value="11">November</option>
                                                        <option value="12">December</option>
                                                    </select> <i></i> 
                                                </label>
                                            </section>
                                            <section class="col col-2">
                                                <label class="select">
                                                    <select name="month">
                                                        <option value="0" selected="" disabled="">Bulan</option>
                                                        <option value="1960">1960</option>
                                                        <option value="1961">1961</option>
                                                        <option value="3">March</option>
                                                        <option value="4">April</option>
                                                        <option value="5">May</option>
                                                        <option value="6">June</option>
                                                        <option value="7">July</option>
                                                        <option value="8">August</option>
                                                        <option value="9">September</option>
                                                        <option value="10">October</option>
                                                        <option value="11">November</option>
                                                        <option value="12">December</option>
                                                    </select> <i></i> 
                                                </label>
                                            </section>
                                        </div>
                                        
                                    </fieldset>
                                    <footer>
                                        <div class="col-md-12">
                                            <button class="pull-right btn btn-primary btn-outlinebtn-flat simpan" type="submit" style="margin-left: 5px;">
                                                <i class="fa fa-floppy-o"></i> Simpan
                                            </button>
                                            <a href="{{url('/pengaturan/akses-pengguna')}}" class="btn btn-default btn-flat pull-right">Kembali</a>
                                        </div>
                                    </footer>

                                </form>
                            </div>
                            <!-- end widget content -->
                            
                        </div>
                        <!-- end widget div -->
                        
                    </div>
                    <!-- end widget -->

                </article>
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