<!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)-->
		<script data-pace-options='{ "restartOnRequestAfter": true }' src="{{ asset('template_asset/js/plugin/pace/pace.min.js') }}"></script>

		{{-- <script type="text/javascript" src="{{ asset('js/app.js') }}"></script> --}}

		<!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
		{{-- <script src="{{ asset('template_asset/js/libs/jquery-2.1.1.min.js') }}'"></script> --}}

		<script src="{{ asset('template_asset/js/libs/jquery-2.1.1.min.js') }}"></script>

		<script src="{{ asset('template_asset/js/libs/jquery-ui-1.10.3.min.js') }}"></script>		

		<!-- IMPORTANT: APP CONFIG -->
		<script src="{{ asset('template_asset/js/app.config.js') }}"></script>

		<script src="{{ asset('template_asset/plugins/lodash/core.js') }}"></script>

		<!-- JS TOUCH : include this plugin for mobile drag / drop touch events-->
		<script src="{{ asset('template_asset/js/plugin/jquery-touch/jquery.ui.touch-punch.min.js') }}"></script> 

		<!-- BOOTSTRAP JS -->
		<script src="{{ asset('template_asset/js/bootstrap/bootstrap.min.js') }}"></script>

		<!-- CUSTOM NOTIFICATION -->
		<script src="{{ asset('template_asset/js/notification/SmartNotification.min.js') }}"></script>

		<!-- JARVIS WIDGETS -->
		<script src="{{ asset('template_asset/js/smartwidgets/jarvis.widget.min.js') }}"></script>

		<!-- EASY PIE CHARTS -->
		<script src="{{ asset('template_asset/js/plugin/easy-pie-chart/jquery.easy-pie-chart.min.js') }}"></script>

		<!-- SPARKLINES -->
		<script src="{{ asset('template_asset/js/plugin/sparkline/jquery.sparkline.min.js') }}"></script>

		<!-- JQUERY VALIDATE -->
		<script src="{{ asset('template_asset/js/plugin/jquery-validate/jquery.validate.min.js') }}"></script>

		<!-- JQUERY MASKED INPUT -->
		<script src="{{ asset('template_asset/js/plugin/masked-input/jquery.maskedinput.min.js') }}"></script>

		<!-- JQUERY SELECT2 INPUT -->
		<script src="{{ asset('template_asset/js/plugin/select2/select2.min.js') }}"></script>

		<!-- JQUERY UI + Bootstrap Slider -->
		<script src="{{ asset('template_asset/js/plugin/bootstrap-slider/bootstrap-slider.min.js') }}"></script>

		<!-- browser msie issue fix -->
		<script src="{{ asset('template_asset/js/plugin/msie-fix/jquery.mb.browser.min.js') }}"></script>

		<!-- FastClick: For mobile devices -->
		<script src="{{ asset('template_asset/js/plugin/fastclick/fastclick.min.js') }}"></script>

		<script src="{{ asset('template_asset/plugins/axios/dist/axios.min.js') }}"></script>
		<script src="{{ asset('template_asset/plugins/toast/dist/jquery.toast.min.js') }}"></script>
		<script src="{{ asset('template_asset/plugins/vue/vue.js') }}"></script>

		<!--[if IE 8]>

		<h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>

		<![endif]-->

		<!-- Demo purpose only -->
		<script src="{{ asset('template_asset/js/demo.min.js') }}"></script>

		<!-- MAIN APP JS FILE -->
		<script src="{{ asset('template_asset/js/app.min.js') }}"></script>

		<!-- SmartChat UI : plugin -->
		<script src="{{ asset('template_asset/js/smart-chat-ui/smart.chat.ui.min.js') }}"></script>
		<script src="{{ asset('template_asset/js/smart-chat-ui/smart.chat.manager.min.js') }}"></script>
		
		<!-- PAGE RELATED PLUGIN(S) -->

		<script>
			$(document).ready(function() {

				baseUrl = '{{ url('/') }}';
				// DO NOT REMOVE : GLOBAL FUNCTIONS!
				pageSetUp();

				$('[data-toggle="tooltip"]').tooltip()

			});

		</script>

		<!-- Your GOOGLE ANALYTICS CODE Below -->
		<script type="text/javascript">
			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', 'UA-XXXXXXXX-X']);
			_gaq.push(['_trackPageview']);

			(function() {
				var ga = document.createElement('script');
				ga.type = 'text/javascript';
				ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				var s = document.getElementsByTagName('script')[0];
				s.parentNode.insertBefore(ga, s);
			})();

		</script>