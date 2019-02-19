<!--===============================================================================================-->
<!-- FAVICONS -->
	<link rel="shortcut icon" href="{{ asset('template_asset/img/favicon/logo_small.png') }}" type="image/x-icon">
	<link rel="icon" href="{{ asset('template_asset/img/logo_small.png') }}" type="image/x-icon">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('template_asset/frontend/bootstrap-4.0/css/bootstrap.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('template_asset/frontend/fonts/font-awesome-4.7.0/css/font-awesome.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('template_asset/frontend/fonts/iconic/css/material-design-iconic-font.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('template_asset/frontend/fonts/linearicons-v1.0.0/icon-font.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('template_asset/frontend/vendor/animate/animate.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('template_asset/frontend/vendor/css-hamburgers/hamburgers.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('template_asset/frontend/vendor/animsition/css/animsition.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('template_asset/frontend/vendor/select2/select2.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('template_asset/frontend/vendor/daterangepicker/daterangepicker.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('template_asset/frontend/vendor/slick/slick.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('template_asset/frontend/vendor/MagnificPopup/magnific-popup.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('template_asset/frontend/vendor/perfect-scrollbar/perfect-scrollbar.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('template_asset/frontend/css/util.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('template_asset/frontend/css/main.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('template_asset/frontend/css/animate.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('template_asset/frontend/css/jquery-ui.css')}}">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('template_asset/css/smartadmin-production-plugins.min.css') }}">
<!-- <link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}"> -->
<style type="text/css">
	p {
	    font-family: 'Poppins-Medium', sans-serif;
	    font-size: 1.1em;
	    font-weight: 300;
	    line-height: 1.7em;
	    color: #999;
	}

	a, a:hover, a:focus {
	    color: #7386D5;
	    text-decoration: none;
	    transition: all 0.3s;
	}

	#sidebar {
	    /* don't forget to add all the previously mentioned styles here too */
	    /*background: #7386D5;*/
	    color: #fff;
	    transition: all 0.3s;
	}

	#sidebar .sidebar-header {
	    font-family: 'Poppins-Medium', sans-serif;
	    padding: 10px;
	    padding-left: 0px;
	    color: #333;
	}

	#sidebar ul.components {
	    padding: 10px;
	    border-top: 3px solid #7386D5;
	    border-bottom: 3px solid #7386D5;
	    border-left: 1px solid #9e9e9e;
	    border-right: 0.1px solid #9e9e9e;
	    font-size: 12px;
	}

	#sidebar ul p {
	    color: #fff;
	    padding: 10px;
	}

	#sidebar ul li a {
	    /*padding: 10px;*/
	    /*font-size: 1.1em;*/
	    color: #333;
	    display: block;
	}
	#sidebar ul li a:hover {
	    color: #7386D5;
	    background: #fff;
	}

	#sidebar ul li.active > a, a[aria-expanded="true"] {
	    color: #333;
	    /*background: #6d7fcc;*/
	}
	ul ul a {
	    font-size: 0.9em !important;
	    padding-left: 30px !important;
	    color: #000;
	    /*background: #6d7fcc;*/
	}
	.logo{
		height: 40% !important;
	}
	.wrapper {
	    display: flex;
	    align-items: stretch;
	}

	#sidebar {
	    min-width: 220px;
	    max-width: 220px;
	}

	#content {
		margin-left: 20px;
	}

	#sidebar.active {
	    margin-left: -270px;
	}
	a[data-toggle="collapse"] {
	    position: relative;
	}

	.dropdown-toggle::after {
	    display: block;
	    position: absolute;
	    top: 50%;
	    right: 20px;
	    transform: translateY(-50%);
	}

	#sidebarCollapse {
		display: none;
	}

	@media (max-width: 768px) {
	    #sidebar {
	        margin-left: -360px;
	    }
	    #sidebar.active {
	        margin-left: 0;
	    }
	    #sidebarCollapse {
	        display: block;
	    }

	    #content {
		    margin-left: 138px;
		}

	    .block2-pic {
	    	height: 335px !important;
	    }
	}
</style>