@extends('main_frontend')

@section('breadcrumb')
	<div class="container">
		<div class="bread-crumb flex-w p-l-0 p-r-15 p-t-30 p-lr-0-lg">
			<a href="{{route('frontend')}}" class="stext-109 cl8 hov-cl1 trans-04">
				Home
				<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
			</a>

			<a href="{{route('product_all')}}" class="stext-109 cl8 hov-cl1 trans-04">
				Produk
				<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
			</a>

			<a href="{{route('product_all')}}" class="stext-109 cl8 hov-cl1 trans-04">
				Handphone
				<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
			</a>

			<span class="stext-109 cl4">
				{{$products->i_merk}}
			</span>
		</div>
	</div>
@endsection

@section('content')
	<div class="bg0 m-t-23 p-b-140">
		<div class="container">
			<div class="row isotope-grid">
				@foreach($products as $product)
				<div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item">
					<!-- Block2 -->
					<div class="block2">
						<div class="block2-pic hov-img0" style="height: 300px; display: flex; align-items: center; box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;">
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
									{{$product->i_nama}}
								</a>

								<span class="stext-105 cl3">
									{{$product->i_price}}
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
			         {{$products->links()}}
			    </ul>
			</nav>

		</div>
	</div>
@endsection