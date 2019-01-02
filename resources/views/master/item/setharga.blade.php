@extends('main')

@section('title', 'Master Barang')

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

			<li>Home</li><li>Data Master</li><li>Tambah Data Barang</li>

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

					<i class="fa-fw fa fa-asterisk"></i>

					Data Master <span><i class="fa fa-angle-double-right"></i> Tambah Data Barang </span>

				</h1>

			</div>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-align-right">

				<div class="page-title">

					<a href="{{ url('/master/barang') }}" class="btn btn-default"><i class="fa fa-arrow-left"></i>&nbsp;Kembali</a>

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

				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

					<!-- Widget ID (each widget will need unique ID)-->
					<div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">

						<header>

							<h2><strong>Master Barang</strong></h2>				
							
						</header>

						<!-- widget div-->
						<div>
							
							<!-- widget content -->
							<div class="widget-body">
								
								<form id="data-form" class="form-horizontal" action="{{ route('barang.addoutletprice') }}" method="post">
									{{ csrf_field() }}

									<fieldset>

										<legend>
											Form Tambah Data Harga Barang
										</legend>

										<article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

											<div class="form-group">

												<label class="control-label text-left">Nama Barang</label>
												&nbsp; &colon; &nbsp;
												<strong><i>{{ $get_outlet[0]->i_nama }}</i></strong>

											</div>
										</article>

										<div class="row ">

											<article class="col-xs-12 col-sm-8 col-md-8 col-lg-8 table-responsive">

                                            <table class="table" id="tbl_setharga">

                                                <tbody>

                                                    @foreach($get_outlet as $outlet)

                                                    <tr>
                                                        <td>{{ $outlet->c_name }}</td>
                                                        <td class="input-group">
                                                            <input type="hidden" name="item_id[]" value="{{ Crypt::encrypt($outlet->op_item) }}">
                                                            <input type="hidden" name="outlet_id[]" value="{{ Crypt::encrypt($outlet->op_outlet) }}">
                                                            <input type="text" class="form-control harga-outlet" name="harga[]" value="{{ number_format($outlet->op_price,0,',','.') }}">
                                                        </td>
                                                    </tr>

                                                    @endforeach
                                                    
                                                </tbody>

                                            </table>

											</article>

										</div>

									</fieldset>

									<div class="form-actions">

										<div class="row">

											<div class="col-md-12">

												<button class="btn btn-default" type="reset" onclick="window.location = '{{url("/master/barang")}}'">
													<i class="fa fa-times"></i>
													&nbsp;Batal
												</button>
												<button class="btn btn-primary" type="submit">
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
	
	<script type="text/javascript">

		var baseUrl = '{{ url('/') }}';

		$(document).ready(function(){
			$(".harga-outlet").maskMoney({thousands:'.', precision: 0});
		})

        function overlay()
		{
			$('#overlay').fadeIn(200);
			$('#load-status-text').text('Sedang Memproses...');
		}

	</script>

@endsection