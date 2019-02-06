<!-- New Frontend -->
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Plasmafone</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	@include('frontend.partials._htmlheader')
</head>
<body class="animsition">

	<!-- Header -->
	@include('frontend.partials._header')

    <!-- breadcrumb -->
    @yield('breadcrumb')

	<!-- Content -->
	@yield('content')

	@include('frontend.partials._footer')

	<!-- Back to top -->
	<div class="btn-back-to-top" id="myBtn">
		<span class="symbol-btn-back-to-top">
			<i class="zmdi zmdi-chevron-up"></i>
		</span>
	</div>


	@include('frontend.partials._script')

</body>
</html>