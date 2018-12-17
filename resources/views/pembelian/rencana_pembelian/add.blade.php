@extends('main')

@section('title', 'Rencana Pembelian')

@section('extra_style')

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
            <li>Rencana Pembelian</li>
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
						 Rencana Pembelian
					</span>
                </h1>
            </div>
            @if(Access::checkAkses(45, 'insert') == true)
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-align-right">

                    <div class="page-title">

                        <a href="{{ url('pembelian/rencana-pembelian') }}" class="btn btn-success"><i class="fa fa-plus"></i>&nbsp;Kembali
                            Data</a>

                    </div>

                </div>
            @endif
        </div>

        <article class="col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">

            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-0" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false" data-widget-sortable="false" role="widget">
                
                <header role="heading">
                    <div class="jarviswidget-ctrls" role="menu">   <a href="javascript:void(0);" class="button-icon jarviswidget-toggle-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Collapse"><i class="fa fa-minus "></i></a> <a href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Fullscreen"><i class="fa fa-expand "></i></a>
                    </div>
                    <h2><strong>Tambah Rencana Pembelian</strong></h2>

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
                        <form id="checkout-form" class="form-inline" role="form">
                            <fieldset class="row">
                                {{-- <div class="form-group">
                                    <div class="col col-8">
                                        <label class="input">
                                            <input type="text" class="form-control" id="autoitem" name="item" placeholder="Masukkan Nama/Kode Barang">
                                        </label>
                                    </div>
                                    <div class="col col-2">
                                        <label class="input">
                                            <input type="text" name="kuantitas" placeholder="Qty">
                                        </label>
                                    </div>
                                    <div class="col col-2">
                                        <button class="btn btn-primary" href="javascript:void(0);">Primary</button>
                                    </div>
                                </div> --}}
                                <div class="form-group col-md-8">
                                    <label class="sr-only" for="namabarang">Nama Barang</label>
                                    <input type="text" class="form-control" id="namabarang" name="item" placeholder="Masukkan Nama/Kode Barang" style="width: 100%">
                                </div>
                                <div class="form-group col-md-2">
                                    <label class="sr-only" for="kuantitas">QTY</label>
                                    <input type="text" class="form-control" id="kuantitas" name="kuantitas" placeholder="QTY" style="width: 100%">
                                </div>
                            </fieldset>
                        </form>
                    </div>
                    <!-- end widget content -->
                    {{-- <div class="widget-body">
                        <p class="alert alert-info">
                            The icons below are the most basic ones, without any icons or additional css applied to it
                        </p>

                        <p>
                            Buttons come in 6 different default color sets
                            <code>
                                .btn .btn-*
                            </code>
                            <code>
                                .btn-default, .btn-primary, .btn-success... etc
                            </code>
                        </p>
                        <a href="javascript:void(0);" class="btn btn-default">Default</a>
                        <a href="javascript:void(0);" class="btn btn-primary">Primary</a>
                        <a href="javascript:void(0);" class="btn btn-success">Success</a>
                        <a href="javascript:void(0);" class="btn btn-info">Info</a>
                        <a href="javascript:void(0);" class="btn btn-warning">Warning</a>
                        <a href="javascript:void(0);" class="btn btn-danger">Danger</a>
                        <a href="javascript:void(0);" class="btn btn-default disabled">Disabled</a>
                        <a href="javascript:void(0);" class="btn btn-link">Link</a>
                        <button class="btn btn-primary" href="javascript:void(0);">Primary</button>

                    </div>
 --}}
                </div>
                <!-- end widget div -->

            </div>
            <!-- end widget -->

        </article>

    </div>
    <!-- END MAIN CONTENT -->

@endsection

@section('extra_script')

    <script type="text/javascript">
        $(document).ready(function () {

        })
    </script>

@endsection
