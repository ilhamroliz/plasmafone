
<div class="form-group col-md-12" style="border-bottom: 1px solid #c90d18; padding-bottom: 15px;">
	<label class="row text-left col-md-7 control-label" style="text-align: left;"><h4 style="font-weight:bold">Total Tagihan:</h4></label>
	<div class="input-group col-md-5 row text-right">
    	<h4><div style="float: left;">Rp. </div><div class="row text-right" style="float: right; font-weight:bold;"> {{ number_format($total, 0, '', '.').',00' }}</div></h4>
    	<input type="hidden" class="totalnet" name="total" value="Rp. {{ number_format($total, 0, '', '.').',00' }}">
    </div>
</div>

{{-- ===================================================================================================== --}}
<form id="formDetailPembayaran">
<div class="form-group col-md-12" style="float: right;">
	<label for="bayar" class="row text-left col-md-6 control-label" style="text-align: left; font-weight:bold;"><h4 style="font-weight:bold">Cash:</h4></label>
	<div class="input-group col-md-5" style="float:right; margin-right:20px;">
		<input type="text" value="" name="bayar" class="bayar row text-right form-control" style="text-align: right; float: right;" onkeyup="hitung()">
    </div>
</div>

<div class="form-group col-md-12" style="float: right;">
	<label for="bca" class="row text-left col-md-6 control-label" style="text-align: left; font-weight:bold;"><h4 style="font-weight:bold">BRI:</h4></label>
	<div class="input-group col-md-5" style="float:right; margin-right:20px;">
		<input type="text" value="" name="bri" class="bca row text-right form-control" style="text-align: right; float: right;" onkeyup="hitung()">
    </div>
</div>
<div class="form-group col-md-12" style="float: right; border-bottom: 1px solid #c90d18; padding-bottom: 15px;">
	<label for="permata" class="row text-left col-md-6 control-label" style="text-align: left; font-weight:bold;"><h4 style="font-weight:bold">BNI:</h4></label>
	<div class="input-group col-md-5" style="float:right; margin-right:20px;">
		<input type="text" value="" name="bni" class="permata row text-right form-control" style="text-align: right; float: right;" onkeyup="hitung()">
    </div>
</div>

<div class="form-group col-md-12" style="float: right;">
	<label class="row text-left col-md-7 control-label" style="text-align: left;"><h4 style="font-weight:bold">Total Pembayaran:</h4></label>
	<div class="input-group col-md-5 row text-right">
		<h4><div style="float: left;">Rp. </div><div class="row text-right TotalPembayaran" style="float: right; font-weight:bold;">0,00</div></h4>
		<input type="hidden" name="total_pembayaran" id="total_pembayaran">
    </div>
</div>

<div class="form-group col-md-12" style="float: right;">
	<label class="row text-left col-md-7 control-label" style="text-align: left;"><h4 style="font-weight:bold">Kembali:</h4></label>
	<div class="input-group col-md-5 row text-right">
		<h4><div style="float: left;">Rp. </div><div class="row text-right kembali" style="float: right; font-weight:bold;">0,00</div></h4>
		<input type="hidden" name="kembali" id="kembali">
    </div>
</div>
</form>

<div class="form-group col-md-12" id="buttonCetak" style="display: none;">
    <div style="float: right;">
        <button id="simpan" type="button" onclick="simpanPenjualan()" class="btn-simpan btn btn-success btn-flat" style="min-height: 0;"><span class="glyphicon glyphicon-print"></span> Cetak</button>
    </div>
</div>

<div class="form-group">
	<label class="row text-left col-md-6 control-label" style="text-align: left;"><h4></h4></label>
	<div class="input-group col-md-6 row text-right">
    	
    </div>
</div>
<script type="text/javascript">

	var totalTagihan = {{ $total }};

	/*$('.maskmoney').inputmask("numeric", {
	    radixPoint: ",",
	    groupSeparator: ".",
	    digits: 2,
	    autoGroup: true,
	    prefix: 'Rp. ', Space after $, this will not truncate the first character.
	    rightAlign: false,
	    oncleared: function () { self.Value(''); }
	});*/

	$('.bca').maskMoney({
        prefix: 'Rp. ',
        thousands: '.',
        decimal: ',',
        affixesStay: true
    });

    $('.permata').maskMoney({
        prefix: 'Rp. ',
        thousands: '.',
        decimal: ',',
        affixesStay: true
    });

    $('.bayar').maskMoney({
        prefix: 'Rp. ',
        thousands: '.',
        decimal: ',',
        affixesStay: true
    });

	function hitung(){
		var bayartemp = $('.bayar').val();
		var bcatemp = $('.bca').val();
		var permatatemp = $('.permata').val();

		var bayar = konversiAngka(bayartemp);
		if (isNaN(bayar)) {
			bayar = 0;
		}
		var bca = konversiAngka(bcatemp);
		if (isNaN(bca)) {
			bca = 0;
		}
		var permata = konversiAngka(permatatemp);
		if (isNaN(permata)) {
			permata = 0;
		}

		var totaltemp = bayar + bca + permata;
		var total = konversiRupiahV2(totaltemp);
		$('.TotalPembayaran').text(total);
		$('#total_pembayaran').val(totaltemp);

		var tagihantemp = $('.totalnet').val();
		var tagihan = konversiAngka(tagihantemp);

		var kembalitemp = totaltemp - tagihan;
		if (isNaN(kembalitemp)) {
			kembalitemp = 0;
		}
		var kembali = konversiRupiahV2(kembalitemp);
		$('.kembali').text(kembali);
		$('#kembali').val(kembalitemp);

		if (totalTagihan <= totaltemp) {
			$('#buttonCetak').css('display', 'block');
		} else {
			$('#buttonCetak').css('display', 'none');
		}
	}

	function konversiRupiah(angka) {
        var rupiah = '';        
        var angkarev = angka.toString().split('').reverse().join('');
        for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
        var hasil = 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
    	hasil = hasil+',00';
        return hasil;
    
    }

    function konversiRupiahV2(angka) {
        var rupiah = '';        
        var angkarev = angka.toString().split('').reverse().join('');
        for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
        var hasil = rupiah.split('',rupiah.length-1).reverse().join('');
    	hasil = hasil+',00';
        return hasil;
    
    }

    function konversiAngka(rupiah)
    {
    	return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);
    }

</script>