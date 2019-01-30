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

		<!-- JQUERY Mask Money -->
		<script src="{{ asset('template_asset/js/plugin/mask-money/jquery.maskMoney.js') }}"></script>

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
		<script src="{{ asset('template_asset/js/app.config.js') }}"></script>

		<!-- SmartChat UI : plugin -->
		<script src="{{ asset('template_asset/js/smart-chat-ui/smart.chat.ui.min.js') }}"></script>
		<script src="{{ asset('template_asset/js/smart-chat-ui/smart.chat.manager.min.js') }}"></script>
        <!-- Month Picker -->
        <script src="{{ asset('template_asset/js/MonthPicker.js') }}"></script>
		<!-- Datatables -->
		<script src="{{ asset('template_asset/js/plugin/datatables/jquery.dataTables.min.js') }}"></script>
		<script src="{{ asset('template_asset/js/plugin/datatables/dataTables.colVis.min.js') }}"></script>
		<script src="{{ asset('template_asset/js/plugin/datatables/dataTables.tableTools.min.js') }}"></script>
		<script src="{{ asset('template_asset/js/plugin/datatables/dataTables.bootstrap.min.js') }}"></script>
		<script src="{{ asset('template_asset/js/plugin/datatable-responsive/datatables.responsive.min.js') }}"></script>
        <!-- Datepicker -->
        <script src="{{ asset('template_asset/js/plugin/datapicker/bootstrap-datepicker.js') }}"></script>
		<!-- <script src="{{ asset('template_asset/jquery/jquery.autocomplete.min.js') }}"></script> -->
		<script>
		var responsiveHelper_dt_basic = undefined;
		var responsiveHelper_datatable_fixed_column = undefined;
		var responsiveHelper_datatable_col_reorder = undefined;
		var responsiveHelper_datatable_tabletools = undefined;

		var breakpointDefinition = {
			tablet : 1024,
			phone : 480
		};
			$(document).ready(function() {

				baseUrl = '{{ url('/') }}';
				// DO NOT REMOVE : GLOBAL FUNCTIONS!
				pageSetUp();

				$('[data-toggle="tooltip"]').tooltip();

				var access = '{{ Access::checkAkses(13, "read") }}';

				if(access == true){
					warn_notif();

					setInterval( function() {

						warn_notif();

					}, 600000);
				}
				
			});

			function warn_notif(){
				
				axios.post(baseUrl+'/inventory/min-stock/cek-warn').then((response) => {

					if(response.data.data.length == 0){
						$('#warn-notif').html('<div class="alert alert-transparent text-center"><h4>Semua Qty Stock Barang Melebihi Minimum Stock</h4>'+
							'<i class="fa fa-lock fa-4x fa-border"></i></div>');
					}else if(response.data.data.length == 1){
						$('#warn-notif').html('<ul class="notification-body">'+
								'<li>'+'<span class="unread">'+'<a onclick="detil('+response.data.data[0].s_id+')" class="msg">'+'<img src="" alt="" class="air air-top-left margin-top-5" width="40" height="40" />'+'<span class="from">'+response.data.data[0].i_kelompok+'<i class="icon-paperclip"></i></span><span class="subject">'+response.data.data[0].i_nama+'</span>'+'<span class="msg-body">Item ini kurang <b>'+ (response.data.data[0].s_min - response.data.data[0].s_qty) +'</b> Unit dari Stock Minimum</span>'+'</a>'+'</span>'+'</li>'+
								'<li><span><a href="{{ url('/inventory/min-stock') }}"><span class="subject text-align-right no-padding">Lihat Selengkapnya</span></a></span></li>'+
								'</ul>');
					}else if(response.data.data.length == 2){
						$('#warn-notif').html('<ul class="notification-body">'+
								'<li>'+'<span class="unread">'+'<a onclick="detil('+response.data.data[0].s_id+')" class="msg">'+'<img src="" alt="" class="air air-top-left margin-top-5" width="40" height="40" />'+'<span class="from">'+response.data.data[0].i_kelompok+'<i class="icon-paperclip"></i></span><span class="subject">'+response.data.data[0].i_nama+'</span>'+'<span class="msg-body">Item ini kurang <b>'+ (response.data.data[0].s_min - response.data.data[0].s_qty) +'</b> Unit dari Stock Minimum</span>'+'</a>'+'</span>'+'</li>'+
								'<li>'+'<span class="unread">'+'<a onclick="detil('+response.data.data[1].s_id+')" class="msg">'+'<img src="" alt="" class="air air-top-left margin-top-5" width="40" height="40" />'+'<span class="from">'+response.data.data[1].i_kelompok+'<i class="icon-paperclip"></i></span><span class="subject">'+response.data.data[1].i_nama+'</span>'+'<span class="msg-body">Item ini kurang <b>'+ (response.data.data[1].s_min - response.data.data[1].s_qty) +'</b> Unit dari Stock Minimum</span>'+'</a>'+'</span>'+'</li>'+
								'<li><span><a href="{{ url('/inventory/min-stock') }}"><span class="subject text-align-right no-padding">Lihat Selengkapnya</span></a></span></li>'+
								'</ul>');
					}else if(response.data.data.length == 3){
						$('#warn-notif').html('<ul class="notification-body">'+
								'<li>'+'<span class="unread">'+'<a onclick="detil('+response.data.data[0].s_id+')" class="msg">'+'<img src="" alt="" class="air air-top-left margin-top-5" width="40" height="40" />'+'<span class="from">'+response.data.data[0].i_kelompok+'<i class="icon-paperclip"></i></span><span class="subject">'+response.data.data[0].i_nama+'</span>'+'<span class="msg-body">Item ini kurang <b>'+ (response.data.data[0].s_min - response.data.data[0].s_qty) +'</b> Unit dari Stock Minimum</span>'+'</a>'+'</span>'+'</li>'+
								'<li>'+'<span class="unread">'+'<a onclick="detil('+response.data.data[1].s_id+')" class="msg">'+'<img src="" alt="" class="air air-top-left margin-top-5" width="40" height="40" />'+'<span class="from">'+response.data.data[1].i_kelompok+'<i class="icon-paperclip"></i></span><span class="subject">'+response.data.data[1].i_nama+'</span>'+'<span class="msg-body">Item ini kurang <b>'+ (response.data.data[1].s_min - response.data.data[1].s_qty) +'</b> Unit dari Stock Minimum</span>'+'</a>'+'</span>'+'</li>'+
								'<li>'+'<span class="unread">'+'<a onclick="detil('+response.data.data[2].s_id+')" class="msg">'+'<img src="" alt="" class="air air-top-left margin-top-5" width="40" height="40" />'+'<span class="from">'+response.data.data[2].i_kelompok+'<i class="icon-paperclip"></i></span><span class="subject">'+response.data.data[2].i_nama+'</span>'+'<span class="msg-body">Item ini kurang <b>'+ (response.data.data[2].s_min - response.data.data[2].s_qty) +'</b> Unit dari Stock Minimum</span>'+'</a>'+'</span>'+'</li>'+
								'<li><span><a href="{{ url('/inventory/min-stock') }}"><span class="subject text-align-right no-padding">Lihat Selengkapnya</span></a></span></li>'+
								'</ul>');
					}else if(response.data.data.length > 3){
						$('#warn-notif').html('<ul class="notification-body">'+
								'<li>'+'<span class="unread">'+'<a onclick="detil('+response.data.data[0].s_id+')" class="msg">'+'<img src="" alt="" class="air air-top-left margin-top-5" width="40" height="40" />'+'<span class="from">'+response.data.data[0].i_kelompok+'<i class="icon-paperclip"></i></span><span class="subject">'+response.data.data[0].i_nama+'</span>'+'<span class="msg-body">Item ini kurang <b>'+ (response.data.data[0].s_min - response.data.data[0].s_qty) +'</b> Unit dari Stock Minimum</span>'+'</a>'+'</span>'+'</li>'+
								'<li>'+'<span class="unread">'+'<a onclick="detil('+response.data.data[1].s_id+')" class="msg">'+'<img src="" alt="" class="air air-top-left margin-top-5" width="40" height="40" />'+'<span class="from">'+response.data.data[1].i_kelompok+'<i class="icon-paperclip"></i></span><span class="subject">'+response.data.data[1].i_nama+'</span>'+'<span class="msg-body">Item ini kurang <b>'+ (response.data.data[1].s_min - response.data.data[1].s_qty) +'</b> Unit dari Stock Minimum</span>'+'</a>'+'</span>'+'</li>'+
								'<li>'+'<span class="unread">'+'<a onclick="detil('+response.data.data[2].s_id+')" class="msg">'+'<img src="" alt="" class="air air-top-left margin-top-5" width="40" height="40" />'+'<span class="from">'+response.data.data[2].i_kelompok+'<i class="icon-paperclip"></i></span><span class="subject">'+response.data.data[2].i_nama+'</span>'+'<span class="msg-body">Item ini kurang <b>'+ (response.data.data[2].s_min - response.data.data[2].s_qty) +'</b> Unit dari Stock Minimum</span>'+'</a>'+'</span>'+'</li>'+
								'<li>'+'<span class="unread">'+'<a onclick="detil('+response.data.data[3].s_id+')" class="msg">'+'<img src="" alt="" class="air air-top-left margin-top-5" width="40" height="40" />'+'<span class="from">'+response.data.data[3].i_kelompok+'<i class="icon-paperclip"></i></span><span class="subject">'+response.data.data[3].i_nama+'</span>'+'<span class="msg-body">Item ini kurang <b>'+ (response.data.data[3].s_min - response.data.data[3].s_qty) +'</b> Unit dari Stock Minimum</span>'+'</a>'+'</span>'+'</li>'+
								'<li><span><a href="{{ url('/inventory/min-stock') }}"><span class="subject text-align-right no-padding">Lihat Selengkapnya</span></a></span></li>'+
								'</ul>');
					}

					$('#date-notif').html(response.data.time);
					$('#countBadge').html(response.data.count);

				});

			}

			function detil(id){

				axios.post(baseUrl+'/inventory/min-stock/detail?id='+id).then((response) => {

					$('#dnItem').html(response.data.data.i_nama);
					$('#dnPosisi').html(response.data.data.c_name);
					$('#dnPemilik').html(response.data.comp.c_name);
					$('#dnMinStock').html(response.data.data.s_min);
					$('#dnQty').html(response.data.data.s_qty);

				});
				$('#detilDNModal').modal('show');

			}
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

			var dataTableLanguage = {
	           	"emptyTable": "Tidak ada data",
	           	"sInfo": "Menampilkan _START_ - _END_ Dari _TOTAL_ Data",
	           	"sSearch": 'Pencarian &nbsp',
	           	"sLengthMenu": "Menampilkan &nbsp; _MENU_ &nbsp; Data",
	           	"infoEmpty": "",
	           	"paginate": {
	               "previous": "Sebelumnya",
	               "next": "Selanjutnya",
	            },
	            "processing":"<img src='{{ asset('template_asset/images/loader.gif') }}' width='30px'>"
	        }

	        function overlay()
			{
				$('#overlay').fadeIn(200);
				$('#load-status-text').text('Sedang Memproses...');
			}

			function out()
			{
				$('#overlay').fadeOut(200);
			}

            function convertToRupiah(angka) {
                var rupiah = '';
                var angkarev = angka.toString().split('').reverse().join('');
                for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
                var hasil = 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
                return hasil;

            }

            function toRupiah(angka) {
                var rupiah = '';
                var angkarev = angka.toString().split('').reverse().join('');
                for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
                var hasil = rupiah.split('',rupiah.length-1).reverse().join('');
                return hasil;

            }

            function convertToAngka(rupiah)
            {
                return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);
            }

		</script>
