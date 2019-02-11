(function($){

	let appended = '<div id="wait_me_overlay">'+
            		'<div class="content-loader">'+
                		'<div class="lds-dual-ring"></div><br>'+
                		'<span class="text">Sedang Memuat Halaman. Harap Tunggu...</span>'+
            		'</div>'+
        		'</div>';

	$("body").prepend(appended);

	$.fn.wait = function(action){
		if(action == 'show'){
			$('#wait_me_overlay').fadeIn(200);
		}

		if(action == 'close'){
			$('#wait_me_overlay').fadeOut('200')
		}
	}

	$(document).ready(function(){
		$("#wait_me_overlay").fadeOut();
	})

}(jQuery))