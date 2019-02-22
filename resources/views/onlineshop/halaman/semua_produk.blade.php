@extends('main_frontend')

@section('breadcrumb')
	<div class="container">
		<div class="bread-crumb flex-w p-l-0 p-r-15 p-t-30 p-lr-0-lg">
			<a href="{{route('frontend')}}" class="stext-109 cl8 hov-cl1 trans-04">
				Home
				<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
			</a>

			<span class="stext-109 cl4">
				Produk
			</span>
		</div>
	</div>
@endsection

@section('content')
	<div class="bg0 m-t-10 p-b-140">
		<div class="container">
				<div class="row">
					<div class="col-md-4 col-md-offset-8">
					<button type="button" id="sidebarCollapse" class="btn btn-sm btn-primary mb-2">
                        <i class="fa fa-align-left"></i>
                        <span> Kategori</span>
                    </button>
					</div>
				</div>
			<div class="wrapper">
				<nav id="sidebar">
					<form id="formFilter">
					<div class="sidebar-header">
			            <h5>Kategori</h5>
			        </div>
			        <ul class="main-menu-m list-unstyled components" style="background-color: #fff;">
			            <li class="mb-2">
			            	<h6 data-toggle="collapse" aria-expanded="false" class="mtext-104 cl2">Handphone</h6>
					        <ul class="sub-menu-m py-0 pl-3" style="display: block;">
					        	@foreach($i_merk_hp as $merk)
								<li>
									<div class="custom-control custom-checkbox filter">
									  <input type="checkbox" name="merk[]" class="custom-control-input merkClass" id="merk-{{$merk->i_merk}}" value="{{$merk->i_merk}}">
									  <label class="custom-control-label text-dark" for="merk-{{$merk->i_merk}}" style="line-height: 25px;">{{mb_convert_case($merk->i_merk, MB_CASE_TITLE, "UTF-8")}}</label>
									</div>
								</li>
								@endforeach
					        </ul>
			                <span class="arrow-main-menu-m p-0" style="color: #333;">
			                    <i class="fa fa-angle-down" aria-hidden="true" style="line-height: 25px;"></i>
			                </span>
					    </li>
			            <li>
			            	<h6 data-toggle="collapse" aria-expanded="false" class="mtext-104 cl2">Aksesoris</h6>
					        <ul class="sub-menu-m py-0 pl-3" style="display: block;">
					        	@foreach($i_merk_acces as $merk)
								<li>
									<div class="custom-control custom-checkbox filter">
									  <input type="checkbox" name="merk[]" class="custom-control-input merkClass" id="merk-{{$merk->i_merk}}" value="{{$merk->i_merk}}">
									  <label class="custom-control-label text-dark" for="merk-{{$merk->i_merk}}" style="line-height: 25px;">{{mb_convert_case($merk->i_merk, MB_CASE_TITLE, "UTF-8")}}</label>
									</div>
								</li>
								@endforeach
					        </ul>
			                <span class="arrow-main-menu-m p-0" style="color: #333;">
			                    <i class="fa fa-angle-down" aria-hidden="true" style="line-height: 25px;"></i>
			                </span>
					    </li>
					</ul>
					<div class="sidebar-header">
			            <h5>Harga</h5>
			        </div>
			        <ul class="list-unstyled components">
			            <li>
			            	<a href="#">Min - Harga</a>
					        <ul>
								<li>
									<input type="number" min="0" value="0.00" data-decimals="2" step="100.0">
								</li>
					        </ul>
					    </li>
			            <li>
			            	<a href="#">Max - Harga</a>
					        <ul>
								<li>
									<input type="number" min="0" value="0.00" data-decimals="2" step="100.0">
								</li>
					        </ul>
					    </li>
					</ul>
					<div class="sidebar-header"></div>
			        <ul class="list-unstyled">
			            <li>
					        <ul>
								<li>
									<button type="button" class="btn btn-sm btn-primary btn-block focus stext-105 bor1" onclick="getFilter()">Aktifkan Filter</button>
								</li>
					        </ul>
					    </li>
					</ul>
					</form>
				</nav>
				<div id="content">
					<div class="row results">
						@foreach($products as $product)
						<div class="col-sm-6 col-md-4 col-lg-3 p-b-35 merk merk-{{$product->i_merk}}">
                    	<!-- Block2 -->
                    		<div class="block2">
								<div class="block2-pic hov-img0" style="height: 260px; display: flex; align-items: center; box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;">
		                        	@if($product->i_img != null || $product->i_img != "")
			                        	<a href="{{url('onlineshop/product-detail')}}/{{encrypt($product->i_id)}}">
			                            	<img src="{{asset('img/items/'.$product->i_img)}}" alt="IMG-PRODUCT" class="img-fluid">
			                        	</a>
		                        	@else
			                        	<a href="{{url('onlineshop/product-detail')}}/{{encrypt($product->i_id)}}">
			                            	<img src="{{asset('template_asset/frontend/images/product-mark.jpg')}}" alt="IMG-PRODUCT" class="img-fluid">
			                        	</a>
		                        	@endif
									<a href="{{url('onlineshop/product-detail')}}/{{encrypt($product->i_id)}}" class="btn btn-outline-primary block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn3 p-lr-15 trans-04">
										Lihat Detail
									</a>
								</div>

								<div class="block2-txt flex-w flex-t p-t-14">
									<div class="block2-txt-child1 flex-col-l ">
										<a href="{{url('onlineshop/product-detail')}}/{{encrypt($product->i_id)}}" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
											{{mb_convert_case($product->i_nama, MB_CASE_TITLE, "UTF-8")}}
										</a>

										<span class="stext-105 cl3">
											Rp. {{number_format($product->i_price,0,",",".")}}
										</span>
									</div>

									<div class="block2-txt-child2 flex-r p-t-3">
										<a href="" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
											<img class="icon-heart1 dis-block trans-04" src="{{asset('template_asset/frontend/images/icons/icon-heart-01.png')}}" alt="ICON">
											<img class="icon-heart2 dis-block trans-04 ab-t-l" src="{{asset('template_asset/frontend/images/icons/icon-heart-02.png')}}" alt="ICON">
										</a>
									</div>
								</div>
							</div>
						</div>
						@endforeach
					</div>
					<nav>
					    <ul class="pagination justify-content-center">
                            @if (isset($custom))
                                {{$products->appends(['data' => $custom])->links("vendor/pagination/bootstrap-4")}}
                            @else
                                {{$products->links("vendor/pagination/bootstrap-4")}}
                            @endif
					    </ul>
					</nav>
				</div>
			</div>
		</div>
	</div>

@endsection

@section('extra-script')

	<script type="text/javascript">
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });

            $("input[type='number']").inputSpinner();
        });

        function getFilter()
        {
        	// var inputs =  document.getElementsByClassName( 'merkClass' );

        	var inputs = $('div.filter').find('input:checked');
            names  = [].map.call(inputs, function( input) {
            	return input.value;
            });

        	window.location = "{{ url('onlineshop/products/searching') }}?data=" + JSON.stringify(names);
        }

    </script>

@endsection
