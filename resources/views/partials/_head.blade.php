<meta charset="utf-8">
<!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->
<meta name="csrf-token" content="{{ csrf_token() }}">
<title> Plasmafone | @yield('title') </title>
<meta name="description" content="">
<meta name="author" content="">
	
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

<!-- Basic Styles -->
<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('template_asset/css/bootstrap.min.css') }}">
<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('template_asset/plugins/font-awesome_4_7/css/font-awesome.min.css') }}">

<!-- SmartAdmin Styles : Caution! DO NOT change the order -->
<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('template_asset/css/smartadmin-production-plugins.min.css') }}">
<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('template_asset/css/smartadmin-production.min.css') }}">
<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('template_asset/css/smartadmin-skins.min.css') }}">

<!-- Checkbox style -->
<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('template_asset/css/bootstrap/awesome-bootstrap-checkbox.css') }}">
<!-- Datepicker -->
<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('template_asset/js/plugin/datapicker/datepicker3.css') }}">
{{-- <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('template_asset/css/bootstrap4.css') }}"> --}}
<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('template_asset/css/bootstrap/awesome-bootstrap-checkbox.css') }}">

<!-- SmartAdmin RTL Support  -->
<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('template_asset/css/smartadmin-rtl.min.css') }}">

<!-- Toast  -->
<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('template_asset/plugins/toast/dist/jquery.toast.min.css') }}">

<!-- Choosen  -->
<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('template_asset/css/chosen.css') }}">

<!-- Demo purpose only: goes with demo.js, you can delete this css when designing your own WebApp -->
<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('template_asset/css/demo.min.css') }}">

<!-- We recommend you use "your_style.css" to override SmartAdmin
     specific styles this will also ensure you retrain your customization with each SmartAdmin update.-->
<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('template_asset/css/your_style.css') }}"> 

<!-- FAVICONS -->
<link rel="shortcut icon" href="{{ asset('template_asset/img/favicon/logo_small.png') }}" type="image/x-icon">
<link rel="icon" href="{{ asset('template_asset/img/logo_small.png') }}" type="image/x-icon">

<!-- GOOGLE FONT -->
<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">

<!-- Specifying a Webpage Icon for Web Clip 
	 Ref: https://developer.apple.com/library/ios/documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html -->
<link rel="apple-touch-icon" href="{{ asset('template_asset/img/splash/sptouch-icon-iphone.png') }}">
<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('template_asset/img/splash/touch-icon-ipad.png') }}">
<link rel="apple-touch-icon" sizes="120x120" href="{{ asset('template_asset/img/splash/touch-icon-iphone-retina.png') }}">
<link rel="apple-touch-icon" sizes="152x152" href="{{ asset('template_asset/img/splash/touch-icon-ipad-retina.png') }}">

<!-- iOS web-app metas : hides Safari UI Components and Changes Status Bar Appearance -->
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">

<!-- Startup image for web apps -->
<link rel="apple-touch-startup-image" href="{{ asset('template_asset/img/splash/ipad-landscape.png') }}" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
<link rel="apple-touch-startup-image" href="{{ asset('template_asset/img/splash/ipad-portrait.png') }}" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
<link rel="apple-touch-startup-image" href="{{ asset('template_asset/img/splash/iphone.png') }}" media="screen and (max-device-width: 320px)">

<style type="text/css">
	.dataTables_length {
		float: right;
	}
	.dt-toolbar-footer > :last-child, .dt-toolbar > :last-child {
		padding-right: 0 !important;
	}
	.col-sm-1.col-xs-12.hidden-xs {
	    padding: 0px;
	}
	.ui-autocomplete {
        max-height: 200px;
        overflow-y: auto;
        /* prevent horizontal scrollbar */
        overflow-x: hidden;
        /* add padding to account for vertical scrollbar */
        padding-right: 20px;
    } 
	/* .modal-backdrop{
		position: relative;
	} */
</style>
