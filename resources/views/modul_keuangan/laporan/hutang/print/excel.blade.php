

<?php 
	$tanggal_1 = explode('/', $_GET['d1'])[0].' '.switchBulan(explode('/', $_GET['d1'])[1]).' '.explode('/', $_GET['d1'])[2];
	$type = ($_GET['type'] == "Hutang_Supplier") ? 'Supplier' : 'Karyawan';
?>					

{{-- Judul Kop --}}

	<table width="100%" border="0" style="border-bottom: 1px solid #333; margin-top: -20px;">
      <thead>
        <tr>
        	<th>&nbsp;</th>
          	<th style="text-align: left; font-size: 14pt; font-weight: 600; padding-top: 10px;" colspan="5">
          		Laporan Hutang {{ $type }} ({{ $_GET['jenis'] }})
          	</th>
        </tr>

        <tr>
        	<th>&nbsp;</th>
            <th style="text-align: left; font-size: 12pt; font-weight: 500" colspan="5">{{ jurnal()->companyName }}</th>
        </tr>

        <tr>
        	<th>&nbsp;</th>
	        <th style="text-align: left; font-size: 8pt; font-weight: 500; padding-bottom: 10px;" colspan="5">
	        	(Angka Disajikan Dalam Rupiah, Kecuali Dinyatakan Lain)
	        </th>

	        <th style="font-size: 8pt; font-weight: normal; text-align: right;" colspan="3">
	          	<b>Per Tanggal {{ $tanggal_1 }}</b>
	        </th>
        </tr>
      </thead>
    </table>

{{-- End Judul Kop --}}

<div style="padding-top: 20px;">

	@if($_GET['jenis'] == 'rekap')
		<table class="table" width="100%" style="font-size: 9pt; border-collapse: collapse;">

			<thead>
				<tr>
					<th rowspan="2">&nbsp;</th>
					<th rowspan="2" width="3%" style="text-align: center; color: #ffffff; background-color: #0099CC; padding: 5px;">No</th>
					<th rowspan="2" width="22%" style="text-align: center; color: #ffffff; background-color: #0099CC; padding: 5px;">Nama Kreditur</th>
					<th rowspan="2" width="12%" style="text-align: center; color: #ffffff; background-color: #0099CC; padding: 5px;">Jumlah Hutang</th>
					<th rowspan="2" width="12%" style="text-align: center; color: #ffffff; background-color: #0099CC; padding: 5px;">Belum Jatuh Tempo</th>
					<th colspan="4" width="45%" style="text-align: center; color: #ffffff; background-color: #0099CC; padding: 5px;">Sudah Jatuh Tempo</th>
				</tr>

				<tr>
					<th style="text-align: center; color: #ffffff; background-color: #0099CC; padding: 5px;">0 - 30 Hari</th>
					<th style="text-align: center; color: #ffffff; background-color: #0099CC; padding: 5px;">30 - 60 Hari</th>
					<th style="text-align: center; color: #ffffff; background-color: #0099CC; padding: 5px;">60 - 90 Hari</th>
					<th style="text-align: center; color: #ffffff; background-color: #0099CC; padding: 5px;">> 90 Hari</th>
				</tr>
			</thead>

			<tbody>
				<?php 
					$gtHutang = $gtBelumJatuhTempo = $gtFirst = $gtSecond = $gtThird = $gtFourth = 0;
				?>

				@foreach($data as $key => $data)

					<tr>
						<td>&nbsp;</td>
						<td style="text-align: center; border: 1px solid #ccc; padding: 5px;">{{ ($key+1) }}</td>
						<td style="border: 1px solid #ccc; padding: 5px;">{{ ($data['nama_supplier']) }}</td>
						<td style="text-align: right; font-weight: 600; border: 1px solid #ccc; padding: 5px;">{{ $data['total_hutang'] }}</td>
						<td style="text-align: right; font-weight: 600; border: 1px solid #ccc; color: #007E33; padding: 5px;">{{ $data['belum_jatuh_tempo'] }}</td>
						<td style="text-align: right; font-weight: 600; border: 1px solid #ccc; color: #CC0000; padding: 5px;">{{ $data['first'] }}</td>
						<td style="text-align: right; font-weight: 600; border: 1px solid #ccc; color: #CC0000; padding: 5px;">{{ $data['second'] }}</td>
						<td style="text-align: right; font-weight: 600; border: 1px solid #ccc; color: #CC0000; padding: 5px;">{{ $data['third'] }}</td>
						<td style="text-align: right; font-weight: 600; border: 1px solid #ccc; color: #CC0000; padding: 5px;">{{ $data['fourth'] }}</td>
					</tr>

					<?php
						$gtHutang += $data['total_hutang'];
						$gtBelumJatuhTempo += $data['belum_jatuh_tempo'];
						$gtFirst += $data['first'];
						$gtSecond += $data['second'];
						$gtThird += $data['third'];
						$gtFourth += $data['fourth'];
					?>
				@endforeach
				
			</tbody>

		</table>

		<table class="table" width="100%" style="font-size: 9pt; border-collapse: collapse; margin-top: 30px;">
			<thead>
				<tr>
					<th></th>
					<th colspan="2" style="text-align: center; background-color: #0099CC; color: #ffffff; border: 1px solid #ffffff; padding: 5px;">Total Seluruh Hutang</th>
					<th width="14%" style="text-align: right; background-color: #0099CC; color: #ffffff; border: 1px solid #ffffff; padding: 5px;">
						{{ $gtHutang }}
					</th>
					<th width="12%" style="text-align: right; background-color: #0099CC; color: #ffffff; border: 1px solid #ffffff; padding: 5px;">
						{{ $gtBelumJatuhTempo }}
					</th>
					<th width="12%" style="text-align: right; background-color: #0099CC; color: #ffffff; border: 1px solid #ffffff; padding: 5px;">
						{{ $gtFirst }}
					</th>
					<th width="12%" style="text-align: right; background-color: #0099CC; color: #ffffff; border: 1px solid #ffffff; padding: 5px;">
						{{ $gtSecond }}
					</th>
					<th width="12%" style="text-align: right; background-color: #0099CC; color: #ffffff; border: 1px solid #ffffff; padding: 5px;">
						{{ $gtThird }}
					</th>
					<th width="12%" style="text-align: right; background-color: #0099CC; color: #ffffff; border: 1px solid #ffffff; padding: 5px;">
						{{ $gtFourth }}
					</th>
				</tr>
			</thead>
		</table>
	@else
		<?php 
			$gtBelumJatuhTempo = $gtFirst = $gtSecond = $gtThird = $gtFourth = 0;
		?>

		@foreach($data as $key => $parrent)
			<?php 
				$margin = ($key != 0) ? '30px;' : '';
				$totBelumjatuhTempo = $totFirst = $totSecond = $totThird = $totFourth = 0; 
			?>

			<table width="100%" style="font-size: 9pt; border-collapse: collapse;">
				<thead>
					<tr>
						<th></th>
						<th class="sharpen" colspan="9" style="background-color: #ffffff; border: 0px; color: #00695c; font-size: 12pt; padding-bottom: 10px; text-align: center;">
							| {{ $parrent['nama_supplier'] }} |
						</th>
					</tr>
					<tr>
						<th></th>
						<th width="2%" style="background-color: #0099CC; color: #ffffff; text-align: center; padding: 5px 3px">No</th>
						<th width="12%" style="background-color: #0099CC; color: #ffffff; text-align: center; padding: 5px 3px">Tanggal</th>
						<th width="12%" style="background-color: #0099CC; color: #ffffff; text-align: center; padding: 5px 3px">Tanggal Jatuh Tempo</th>
						<th width="14%" style="background-color: #0099CC; color: #ffffff; text-align: center; padding: 5px 3px">Nomor Referensi</th>
						<th width="12%" style="background-color: #0099CC; color: #ffffff; text-align: center; padding: 5px 3px">Belum Jatuh Tempo</th>
						<th width="12%" style="background-color: #0099CC; color: #ffffff; text-align: center; padding: 5px 3px">0 - 30 Hari</th>
						<th width="12%" style="background-color: #0099CC; color: #ffffff; text-align: center; padding: 5px 3px">30 - 60 Hari</th>
						<th width="12%" style="background-color: #0099CC; color: #ffffff; text-align: center; padding: 5px 3px">60 - 90 Hari</th>
						<th width="12%" style="background-color: #0099CC; color: #ffffff; text-align: center; padding: 5px 3px">> 90 Hari</th>
					</tr>
				</thead>

				<tbody>
					@foreach($parrent['detail'] as $index => $detail)
						<tr>
							<td></td>
							<td style="text-align: center; border: 1px solid #eee; padding: 5px 3px;">{{ $index+1 }}</td>
							<td style="text-align: center; border: 1px solid #eee; padding: 5px 3px;">
								{{ date('d/m/Y', strtotime($detail['tanggal'])) }}
							</td>
							<td style="text-align: center; border: 1px solid #eee; padding: 5px 3px;">
								{{ date('d/m/Y', strtotime($detail['jatuh_tempo'])) }}
							</td>
							<td style="text-align: center; border: 1px solid #eee; padding: 5px 3px;">
								{{ $detail['nomor_referensi'] }}
							</td>
							<td style="text-align: right; font-weight: 600; border: 1px solid #eee; padding: 5px 3px;">
								{{ $detail['belum_jatuh_tempo'] }}
							</td>
							<td style="text-align: right; font-weight: 600; border: 1px solid #eee; padding: 5px 3px;">
								{{ $detail['first'] }}
							</td>
							<td style="text-align: right; font-weight: 600; border: 1px solid #eee; padding: 5px 3px;">
								{{ $detail['second'] }}
							</td>
							<td style="text-align: right; font-weight: 600; border: 1px solid #eee; padding: 5px 3px;">
								{{ $detail['third'] }}
							</td>
							<td style="text-align: right; font-weight: 600; border: 1px solid #eee; padding: 5px 3px;">
								{{ $detail['fourth'] }}
							</td>
						</tr>

						<?php 
							$totBelumjatuhTempo += $detail['belum_jatuh_tempo'];
							$totFirst += $detail['first'];
							$totSecond += $detail['second'];
							$totThird += $detail['third'];
							$totFourth += $detail['fourth'];
						?>
					@endforeach
				</tbody>

				<tfoot>
					<tr>
						<td></td>
						<td colspan="4" style="font-weight: 600; text-align: center; background-color: #eee; border: 1px solid #ffffff; padding: 5px 3px;">
							Saldo {{ $parrent['nama_supplier'] }}
						</td>
						<td style="font-weight: 600; text-align: right; background-color: #eee; border: 1px solid #ffffff; color: #00695c; padding: 5px 3px;">
							{{ $totBelumjatuhTempo }}
						</td>
						<td style="font-weight: 600; text-align: right; background-color: #eee; border: 1px solid #ffffff; color: #00695c; padding: 5px 3px;">
							{{ $totFirst }}
						</td>
						<td style="font-weight: 600; text-align: right; background-color: #eee; border: 1px solid #ffffff; color: #00695c; padding: 5px 3px;">
							{{ $totSecond }}
						</td>
						<td style="font-weight: 600; text-align: right; background-color: #eee; border: 1px solid #ffffff; color: #00695c; padding: 5px 3px;">
							{{ $totThird }}
						</td>
						<td style="font-weight: 600; text-align: right; background-color: #eee; border: 1px solid #ffffff; color: #00695c; padding: 5px 3px;">
							{{ $totFourth }}
						</td>
					</tr>
				</tfoot>
			</table>

			<?php
				$gtBelumJatuhTempo += $totBelumjatuhTempo;
				$gtFirst += $totFirst;
				$gtSecond += $totSecond;
				$gtThird += $totThird;
				$gtFourth += $totFourth;
			?>

			<table width="100%">
				<tr>
					<td>&nbsp;</td>
				</tr>
			</table>
		@endforeach

		<table width="100%" style="border-collapse: collapse; font-size: 9pt;">
			<thead>
				<tr>
					<th></th>
					<th colspan="4" style="text-align: center; background-color: #0099CC; color: #ffffff; padding: 5px; border: 1px solid #ffffff;">Total Seluruh Kreditur</th>
					<th width="12%" style="text-align: right; background-color: #0099CC; color: #ffffff; padding: 5px; border: 1px solid #ffffff;">
						{{ $gtBelumJatuhTempo }}
					</th>
					<th width="12%" style="text-align: right; background-color: #0099CC; color: #ffffff; padding: 5px; border: 1px solid #ffffff;">
						{{ $gtFirst }}
					</th>
					<th width="12%" style="text-align: right; background-color: #0099CC; color: #ffffff; padding: 5px; border: 1px solid #ffffff;">
						{{ $gtSecond }}
					</th>
					<th width="12%" style="text-align: right; background-color: #0099CC; color: #ffffff; padding: 5px; border: 1px solid #ffffff;">
						{{ $gtThird }}
					</th>
					<th width="12%" style="text-align: right; background-color: #0099CC; color: #ffffff; padding: 5px; border: 1px solid #ffffff;">
						{{ $gtFourth }}
					</th>
				</tr>
			</thead>
		</table>
	@endif