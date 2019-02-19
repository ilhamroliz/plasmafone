<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="csrf_token" content="{{ csrf_token() }}">
	<title>Plasmafone</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	@include('onlineshop.partials._htmlheader')
</head>
<body class="animsition">

	<!-- Header -->
	@include('onlineshop.partials._header')

    <!-- breadcrumb -->
    @yield('breadcrumb')

	<!-- Content -->
	@yield('content')

	@include('onlineshop.partials._footer')

	<!-- Back to top -->
	<div class="btn-back-to-top" id="myBtn">
		<span class="symbol-btn-back-to-top">
			<i class="zmdi zmdi-chevron-up"></i>
		</span>
	</div>


	@include('onlineshop.partials._script')

</body>
</html>