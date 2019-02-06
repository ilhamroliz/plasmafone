@extends('main')

@section('title', 'Return Penjualan')

@section('extra_style')
    <style type="text/css">

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
            <li>Home</li><li>Layanan Perbaikan</li><li>Perbaikan Barang</li>
        </ol>
        <!-- end breadcrumb -->
    </div>
    <!-- END RIBBON -->
@endsection


@section('main_content')

    <!-- MAIN CONTENT -->
    <div id="content">

        <div class="row">

            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <h1 class="page-title txt-color-blueDark">
                    <i class="fa-fw fa fa-wrench"></i>
                    Layanan Perbaikan <span><i class="fa fa-angle-double-right"></i> Perbaikan Barang </span>
                </h1>
            </div>

        </div>

        <section id="widget-grid" class="">

            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="jarviswidget" id="wid-id-0"
                         data-widget-colorbutton="false"
                         data-widget-editbutton="false"
                         data-widget-togglebutton="false"
                         data-widget-deletebutton="false"
                         data-widget-fullscreenbutton="false"
                         data-widget-custombutton="false"
                         data-widget-sortable="false">
                        <header role="heading"><div class="jarviswidget-ctrls" role="menu"><a href="javascript:void(0);" class="button-icon jarviswidget-toggle-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Collapse"><i class="fa fa-minus "></i></a> <a href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Fullscreen"><i class="fa fa-expand "></i></a> </div>
                            <h2><strong>Tambah Retun Penjualan</strong></h2>
                        </header>
                        <div role="content">
                            <div class="widget-body">
                                <form class="form-horizontal" id="form_return">
                                    <fieldset>
                                        <div class="row">
                                            <article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label text-left">Nama Member</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group input-group-md">
                                                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                            <div class="icon-addon addon-md">
                                                                <input class="form-control" id="cari-member" placeholder="Masukkan Nama Member" type="text"  style="text-transform: uppercase">
                                                                <label for="cari-member" class="glyphicon glyphicon-search" rel="tooltip" title="Nama Member"></label>
                                                                <input type="hidden" name="idmember" id="idmember">
                                                            </div>
                                                            <span class="input-group-btn">
										                        <button class="btn btn-primary" type="button" id="search_member"><i class="fa fa-search"></i> Cari</button>
										                    </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-3 control-label text-left">Kode Spesifik</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group input-group-md">
                                                            <span class="input-group-addon"><i class="glyphicon glyphicon-barcode"></i></span>
                                                            <div class="icon-addon addon-md">
                                                                <input class="form-control" id="kode" placeholder="Masukkan Kode Spesifik" type="text"  style="text-transform: uppercase">
                                                                <label for="kode" class="glyphicon glyphicon-search" rel="tooltip" title="Kode Spesifik"></label>
                                                            </div>
                                                            <span class="input-group-btn">
										                        <button class="btn btn-primary" type="button" id="search_code"><i class="fa fa-search"></i> Cari</button>
										                    </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-3 control-label text-left">Nota</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group input-group-md">
                                                            <span class="input-group-addon"><i class="glyphicon glyphicon-book"></i></span>
                                                            <div class="icon-addon addon-md">
                                                                <input class="form-control" id="nota" placeholder="Masukkan Nota Penjualan" type="text"  style="text-transform: uppercase">
                                                                <label for="nota" class="glyphicon glyphicon-search" rel="tooltip" title="Nota Penjualan"></label>
                                                            </div>
                                                            <span class="input-group-btn">
										                        <button class="btn btn-primary" type="button" id="search_nota"><i class="fa fa-search"></i> Cari</button>
										                    </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-3 control-label text-left">Tanggal</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group input-daterange" id="date-range">
                                                            <input type="text" class="form-control" id="tgl_awal" name="tgl_awal"  placeholder="Tanggal Awal" data-dateformat="dd/mm/yy">
                                                            <span class="input-group-addon bg-custom text-white b-0">to</span>
                                                            <input type="text" class="form-control" id="tgl_akhir" name="tgl_akhir"  placeholder="Tanggal Akhir" data-dateformat="dd/mm/yy">
                                                            <span class="input-group-btn">
										                        <button class="btn btn-primary" type="button" id="search_nota"><i class="fa fa-search"></i> Cari</button>
										                    </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </section>

        <section id="widget-grid" class="">

            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="jarviswidget" id="wid-id-0"
                         data-widget-colorbutton="false"
                         data-widget-editbutton="false"
                         data-widget-togglebutton="false"
                         data-widget-deletebutton="false"
                         data-widget-fullscreenbutton="false"
                         data-widget-custombutton="false"
                         data-widget-sortable="false">
                        <header role="heading"><div class="jarviswidget-ctrls" role="menu"><a href="javascript:void(0);" class="button-icon jarviswidget-toggle-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Collapse"><i class="fa fa-minus "></i></a> <a href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Fullscreen"><i class="fa fa-expand "></i></a> </div>
                            <h2><strong>Daftar Nota Penjualan</strong></h2>
                        </header>
                        <div role="content">
                            <div class="widget-body no-padding">
                                <table id="dt_active" class="table table-striped table-bordered table-hover" width="100%">

                                    <thead>

                                    <tr>

                                        <th><i class="fa fa-fw fa-calendar txt-color-blue"></i>&nbsp;Tanggal</th>

                                        <th><i class="fa fa-fw fa-building txt-color-blue "></i>&nbsp;Nota</th>

                                        <th class="text-center" width="15%"><i class="fa fa-fw fa-wrench txt-color-blue"></i>&nbsp;Aksi</th>

                                    </tr>

                                    </thead>

                                    <tbody>

                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </section>
    </div>
    <!-- END MAIN CONTENT -->
@endsection

@section('extra_script')
    <script type="text/javascript">
        var aktif;
        $(document).ready(function () {
            aktif = $('#dt_active').dataTable();

            $( "#date-range" ).datepicker({
                language: "id",
                format: 'dd/mm/yyyy',
                prevText: '<i class="fa fa-chevron-left"></i>',
                nextText: '<i class="fa fa-chevron-right"></i>',
                autoclose: true,
                todayHighlight: true
            });
        })
    </script>
@endsection
