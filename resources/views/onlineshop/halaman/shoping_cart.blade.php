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

			<span class="stext-109 cl4">
				Troli Belanjaan
			</span>
		</div>
	</div>
@endsection

@section('content')

	<!-- Shoping Cart -->
	<form class="bg0 p-t-20 p-b-85">
		<div class="container">
			<div class="row">
				<div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
					<div class="m-l-0 m-r--38 m-lr-0-xl">
						<div class="wrap-table-shopping-cart">
							<table class="table-shopping-cart">
								<tr class="table_head">
									<th class="column-1">Product</th>
									<th class="column-2"></th>
									<th class="column-3">Price</th>
									<th class="column-4">Quantity</th>
									<th class="column-5">Total</th>
								</tr>
								@if (count($carts) > 0)
								@foreach($carts as $cart)
								<tr class="table_row">
									<td class="column-1">
										<div class="how-itemcart1">
											<img src="{{asset('img/items/'.$cart->i_img)}}" alt="IMG">
										</div>
									</td>
									<td class="column-2">{{$cart->i_nama}}</td>

									<td class="column-3">Rp. {{number_format($cart->i_price,0,",",".")}}</td>
									<input type="hidden" class="harga" id="harga-{{ $cart->cd_item }}" value="{{ $cart->i_price }}">
									<td class="column-4">
										<div class="wrap-num-product flex-w m-l-auto m-r-0">
											<div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
												<i class="fs-16 zmdi zmdi-minus"></i>
											</div>

											<input class="mtext-104 cl3 txt-center num-product cd_qty" type="number" id="qty-{{ $cart->cd_item }}" name="cd_qty[]" value="{{$cart->cd_qty}}" onkeyup="setHarga('{{ $cart->cd_item }}')">

											<div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
												<i class="fs-16 zmdi zmdi-plus"></i>
											</div>
										</div>
									</td>

									<td class="column-5" id="p_tot-{{ $cart->cd_item }}">Rp. {{number_format(( $cart->i_price * $cart->cd_qty),0,",",".")}}</td>
								</tr>
								@endforeach
								@else
								<tr class="table_row">
									<td colspan="5" class="txt-center"><h1 class="cl2">No Data Result!</h1></td>
								</tr>
								@endif
							</table>
						</div>

						<div class="flex-w flex-sb-m bor15 p-t-18 p-b-15 p-lr-40 p-lr-15-sm">
							<div class="flex-w flex-m m-r-20 m-tb-5">
								<input class="stext-104 cl2 plh4 size-117 bor11 p-lr-20 m-r-10 m-tb-5" type="text" name="coupon" placeholder="Coupon Code">

								<div class="btn btn-outline-primary flex-c-m stext-101 cl2 size-118 bor11 hov-btn3 p-lr-15 trans-04 pointer m-tb-5">
									Apply coupon
								</div>
							</div>

							<div class="btn btn-outline-primary flex-c-m stext-101 cl2 size-119 bor11 hov-btn3 p-lr-15 trans-04 pointer m-tb-10">
								Update Cart
							</div>
						</div>
					</div>
				</div>

				<div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
					<div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-0 m-lr-0-xl p-lr-15-sm">
						<h4 class="mtext-109 cl2 p-b-30">
							Cart Totals
						</h4>

						<div class="flex-w flex-t bor12 p-b-13 m-b-20">
							<div class="size-208">
								<span class="stext-110 cl2">
									Subtotal:
								</span>
							</div>

							<div class="size-209">
								<span class="mtext-110 cl2">

								</span>
							</div>
						</div>

						<button class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
							Proceed to Checkout
						</button>
					</div>
				</div>
			</div>
		</div>
	</form>
@endsection

@section('extra-script')
<script>
	$(document).ready(function(){
		var inputs = document.getElementsByClassName( 'cd_qty' ),
            arqty  = [].map.call(inputs, function( input ) {
                return input.value;
            });

        for (var i = 0; i < arqty.length; i++){

        }

	})

	function setHarga(id){
		var qty = $('#qty-'+id).val();
		var harga = $('#harga-'+id).val();
		var total = parseInt(qty) * parseInt(harga);
		$('#p_tot-'+id).html(total);
	}
</script>
@endsection