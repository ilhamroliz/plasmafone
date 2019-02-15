<!--===============================================================================================-->
<script type="text/javascript" src="{{asset('template_asset/frontend/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
<script type="text/javascript" src="{{asset('template_asset/frontend/js/jquery-ui.js')}}"></script>
<!--===============================================================================================-->
<script type="text/javascript" src="{{asset('template_asset/frontend/vendor/animsition/js/animsition.min.js')}}"></script>
<!--===============================================================================================-->
<script type="text/javascript" src="{{asset('template_asset/frontend/vendor/bootstrap/js/popper.js')}}"></script>
<script type="text/javascript" src="{{asset('template_asset/frontend/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<!--===============================================================================================-->
<script type="text/javascript" src="{{asset('template_asset/frontend/vendor/select2/select2.min.js')}}"></script>
<script type="text/javascript">
$(".js-select2").each(function(){
	$(this).select2({
		minimumResultsForSearch: 20,
		dropdownParent: $(this).next('.dropDownSelect2')
	});
})
</script>
<!--===============================================================================================-->
<script type="text/javascript" src="{{asset('template_asset/frontend/vendor/daterangepicker/moment.min.js')}}"></script>
<script type="text/javascript" src="{{asset('template_asset/frontend/vendor/daterangepicker/daterangepicker.js')}}"></script>
<!--===============================================================================================-->
<script type="text/javascript" src="{{asset('template_asset/frontend/vendor/slick/slick.min.js')}}"></script>
<script type="text/javascript" src="{{asset('template_asset/frontend/js/slick-custom.js')}}"></script>
<!--===============================================================================================-->
<script type="text/javascript" src="{{asset('template_asset/frontend/vendor/parallax100/parallax100.js')}}"></script>
<script type="text/javascript">
    $('.parallax100').parallax100();
</script>
<!--===============================================================================================-->
<script type="text/javascript" src="{{asset('template_asset/frontend/vendor/MagnificPopup/jquery.magnific-popup.min.js')}}"></script>
<script type="text/javascript">
$('.gallery-lb').each(function() { // the containers for all your galleries
	$(this).magnificPopup({
        delegate: 'a', // the selector for gallery item
        type: 'image',
        gallery: {
        enabled:true
        },
        mainClass: 'mfp-fade'
    });
});
</script>
<!--===============================================================================================-->
<script type="text/javascript" src="{{asset('template_asset/frontend/vendor/isotope/isotope.pkgd.min.js')}}"></script>
<!--===============================================================================================-->
<script type="text/javascript" src="{{asset('template_asset/frontend/vendor/sweetalert/sweetalert.min.js')}}"></script>
<script type="text/javascript">
$('.js-addwish-b2').on('click', function(e){
	e.preventDefault();
});

$('.js-addwish-b2').each(function(){
	var nameProduct = $(this).parent().parent().find('.js-name-b2').html();
	$(this).on('click', function(){
		swal(nameProduct, "is added to wishlist !", "success");

		$(this).addClass('js-addedwish-b2');
		$(this).off('click');
	});
});

$('.js-addwish-detail').each(function(){
	var nameProduct = $(this).parent().parent().parent().find('.js-name-detail').html();

	$(this).on('click', function(){
		swal(nameProduct, "is added to wishlist !", "success");

		$(this).addClass('js-addedwish-detail');
	$(this).off('click');
	});
});

</script>
<!--===============================================================================================-->
<script type="text/javascript" src="{{asset('template_asset/frontend/vendor/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script type="text/javascript">
$('.js-pscroll').each(function(){
	$(this).css('position','relative');
	$(this).css('overflow','hidden');
	var ps = new PerfectScrollbar(this, {
		wheelSpeed: 1,
		scrollingThreshold: 1000,
		wheelPropagation: false,
	});

	$(window).on('resize', function(){
		ps.update();
	});
});
</script>
<!--===============================================================================================-->
<script type="text/javascript" src="{{asset('template_asset/frontend/js/main.js')}}"></script>
<script type="text/javascript" src="{{asset('template_asset/frontend/js/bootstrap-input-spinner.js')}}"></script>
<script type="text/javascript">
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
		}
	});
</script>
<!-- CUSTOM NOTIFICATION =========================================================================-->
<script src="{{asset('template_asset/js/notification/SmartNotification.min.js')}}"></script>
<script type="text/javascript">
	// function viewCart(token)
	// {
	// 	var data = 'id=' + id + '&nama=' + nama;
	// 	axios.get(baseUrl+'', data).then((response) => {



	// 	})
	// }
</script>
@yield('extra-script')