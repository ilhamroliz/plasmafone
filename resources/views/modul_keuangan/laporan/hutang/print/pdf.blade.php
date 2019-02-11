

<?php 
	$tanggal_1 = explode('/', $_GET['d1'])[0].' '.switchBulan(explode('/', $_GET['d1'])[1]).' '.explode('/', $_GET['d1'])[2];
	$type = ($_GET['type'] == "Hutang_Supplier") ? 'Supplier' : 'Karyawan';
?>					

{{-- Judul Kop --}}

	<table width="100%" border="0" style="border-bottom: 1px solid #333; margin-top: -20px;">
      <thead>
        <tr>
          <th style="text-align: left; font-size: 14pt; font-weight: 600; padding-top: 10px;" colspan="2">Laporan Hutang {{ $type }} ({{ $_GET['jenis'] }})</th>
        </tr>

        <tr>
          <th style="text-align: left; font-size: 12pt; font-weight: 500" colspan="2">{{ jurnal()->companyName }}</th>
        </tr>

        <tr>
          <th style="text-align: left; font-size: 8pt; font-weight: 500; padding-bottom: 10px;">(Angka Disajikan Dalam Rupiah, Kecuali Dinyatakan Lain)</th>

          <th style="font-size: 8pt; font-weight: normal; text-align: right;">
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
					<th rowspan="2" width="3%" style="text-align: center; color: white; background-color: #0099CC; border: 1px solid #ffffff; padding: 5px;">No</th>
					<th rowspan="2" width="22%" style="text-align: center; color: white; background-color: #0099CC; border: 1px solid #ffffff; padding: 5px;">Nama Kreditur</th>
					<th rowspan="2" width="12%" style="text-align: center; color: white; background-color: #0099CC; border: 1px solid #ffffff; padding: 5px;">Jumlah Hutang</th>
					<th rowspan="2" width="12%" style="text-align: center; color: white; background-color: #0099CC; border: 1px solid #ffffff; padding: 5px;">Belum Jatuh Tempo</th>
					<th colspan="4"style="text-align: center; color: white; background-color: #0099CC; border: 1px solid #ffffff; padding: 5px;">Sudah Jatuh Tempo</th>
				</tr>

				<tr>
					<th width="12%" style="text-align: center; color: white; background-color: #0099CC; border: 1px solid #ffffff; padding: 5px;">0 - 30 Hari</th>
					<th width="12%" style="text-align: center; color: white; background-color: #0099CC; border: 1px solid #ffffff; padding: 5px;">30 - 60 Hari</th>
					<th width="12%" style="text-align: center; color: white; background-color: #0099CC; border: 1px solid #ffffff; padding: 5px;">60 - 90 Hari</th>
					<th width="12%" style="text-align: center; color: white; background-color: #0099CC; border: 1px solid #ffffff; padding: 5px;">> 90 Hari</th>
				</tr>
			</thead>

			<tbody>

				<?php 
					$gtHutang = $gtBelumJatuhTempo = $gtFirst = $gtSecond = $gtThird = $gtFourth = 0;
				?>

				@foreach($data as $key => $data)

					<tr>
						<td style="text-align: center; border: 1px solid #ccc; padding: 5px;">{{ ($key+1) }}</td>
						<td style="border: 1px solid #ccc; padding: 5px;">{{ ($data['nama_supplier']) }}</td>
						<td style="text-align: right; font-weight: 600; border: 1px solid #ccc; padding: 5px;">{{ number_format($data['total_hutang'], 2) }}</td>
						<td style="text-align: right; font-weight: 600; border: 1px solid #ccc; color: #007E33; padding: 5px;">{{ number_format($data['belum_jatuh_tempo'], 2) }}</td>
						<td style="text-align: right; font-weight: 600; border: 1px solid #ccc; color: #CC0000; padding: 5px;">{{ number_format($data['first'], 2) }}</td>
						<td style="text-align: right; font-weight: 600; border: 1px solid #ccc; color: #CC0000; padding: 5px;">{{ number_format($data['second'], 2) }}</td>
						<td style="text-align: right; font-weight: 600; border: 1px solid #ccc; color: #CC0000; padding: 5px;">{{ number_format($data['third'], 2) }}</td>
						<td style="text-align: right; font-weight: 600; border: 1px solid #ccc; color: #CC0000; padding: 5px;">{{ number_format($data['fourth'], 2) }}</td>
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
					<th width="25%" colspan="2" style="text-align: center; background-color: #0099CC; color: #ffffff; border: 1px solid #ffffff; padding: 5px;">Total Seluruh Hutang</th>
					<th width="12%" style="text-align: right; background-color: #0099CC; color: #ffffff; border: 1px solid #ffffff; padding: 5px;">
						{{ number_format($gtHutang, 2) }}
					</th>
					<th width="12%" style="text-align: right; background-color: #0099CC; color: #ffffff; border: 1px solid #ffffff; padding: 5px;">
						{{ number_format($gtBelumJatuhTempo, 2) }}
					</th>
					<th width="12%" style="text-align: right; background-color: #0099CC; color: #ffffff; border: 1px solid #ffffff; padding: 5px;">
						{{ number_format($gtFirst, 2) }}
					</th>
					<th width="12%" style="text-align: right; background-color: #0099CC; color: #ffffff; border: 1px solid #ffffff; padding: 5px;">
						{{ number_format($gtSecond, 2) }}
					</th>
					<th width="12%" style="text-align: right; background-color: #0099CC; color: #ffffff; border: 1px solid #ffffff; padding: 5px;">
						{{ number_format($gtThird, 2) }}
					</th>
					<th width="12%" style="text-align: right; background-color: #0099CC; color: #ffffff; border: 1px solid #ffffff; padding: 5px;">
						{{ number_format($gtFourth, 2) }}
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
						<th class="sharpen" colspan="9" style="background-color: white; border: 0px; color: #00695c; font-size: 12pt; padding-bottom: 10px; text-align: center;">
							| {{ $parrent['nama_supplier'] }} |
						</th>
					</tr>
					<tr>
						<th width="2%" style="background-color: #0099CC; color: white; text-align: center; padding: 5px 3px">No</th>
						<th width="12%" style="background-color: #0099CC; color: white; text-align: center; padding: 5px 3px">Tanggal</th>
						<th width="12%" style="background-color: #0099CC; color: white; text-align: center; padding: 5px 3px">Tanggal Jatuh Tempo</th>
						<th width="14%" style="background-color: #0099CC; color: white; text-align: center; padding: 5px 3px">Nomor Referensi</th>
						<th width="12%" style="background-color: #0099CC; color: white; text-align: center; padding: 5px 3px">Belum Jatuh Tempo</th>
						<th width="12%" style="background-color: #0099CC; color: white; text-align: center; padding: 5px 3px">0 - 30 Hari</th>
						<th width="12%" style="background-color: #0099CC; color: white; text-align: center; padding: 5px 3px">30 - 60 Hari</th>
						<th width="12%" style="background-color: #0099CC; color: white; text-align: center; padding: 5px 3px">60 - 90 Hari</th>
						<th width="12%" style="background-color: #0099CC; color: white; text-align: center; padding: 5px 3px">> 90 Hari</th>
					</tr>
				</thead>

				<tbody>
					@foreach($parrent['detail'] as $index => $detail)
						<tr>
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
								{{ number_format($detail['belum_jatuh_tempo'], 2) }}
							</td>
							<td style="text-align: right; font-weight: 600; border: 1px solid #eee; padding: 5px 3px;">
								{{ number_format($detail['first'], 2) }}
							</td>
							<td style="text-align: right; font-weight: 600; border: 1px solid #eee; padding: 5px 3px;">
								{{ number_format($detail['second'], 2) }}
							</td>
							<td style="text-align: right; font-weight: 600; border: 1px solid #eee; padding: 5px 3px;">
								{{ number_format($detail['third'], 2) }}
							</td>
							<td style="text-align: right; font-weight: 600; border: 1px solid #eee; padding: 5px 3px;">
								{{ number_format($detail['fourth'], 2) }}
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
						<td colspan="4" style="font-weight: 600; text-align: center; background-color: #eee; border: 1px solid #ffffff; padding: 5px 3px;">
							Saldo {{ $parrent['nama_supplier'] }}
						</td>
						<td style="font-weight: 600; text-align: right; background-color: #eee; border: 1px solid #ffffff; color: #00695c; padding: 5px 3px;">
							{{ number_format($totBelumjatuhTempo, 2) }}
						</td>
						<td style="font-weight: 600; text-align: right; background-color: #eee; border: 1px solid #ffffff; color: #00695c; padding: 5px 3px;">
							{{ number_format($totFirst, 2) }}
						</td>
						<td style="font-weight: 600; text-align: right; background-color: #eee; border: 1px solid #ffffff; color: #00695c; padding: 5px 3px;">
							{{ number_format($totSecond, 2) }}
						</td>
						<td style="font-weight: 600; text-align: right; background-color: #eee; border: 1px solid #ffffff; color: #00695c; padding: 5px 3px;">
							{{ number_format($totThird, 2) }}
						</td>
						<td style="font-weight: 600; text-align: right; background-color: #eee; border: 1px solid #ffffff; color: #00695c; padding: 5px 3px;">
							{{ number_format($totFourth, 2) }}
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
					<th colspan="4" style="text-align: center; background-color: #0099CC; color: white; padding: 5px; border: 1px solid #ffffff;">Total Seluruh Kreditur</th>
					<th width="12%" style="text-align: right; background-color: #0099CC; color: white; padding: 5px; border: 1px solid #ffffff;">
						{{ number_format($gtBelumJatuhTempo, 2) }}
					</th>
					<th width="12%" style="text-align: right; background-color: #0099CC; color: white; padding: 5px; border: 1px solid #ffffff;">
						{{ number_format($gtFirst, 2) }}
					</th>
					<th width="12%" style="text-align: right; background-color: #0099CC; color: white; padding: 5px; border: 1px solid #ffffff;">
						{{ number_format($gtSecond, 2) }}
					</th>
					<th width="12%" style="text-align: right; background-color: #0099CC; color: white; padding: 5px; border: 1px solid #ffffff;">
						{{ number_format($gtThird, 2) }}
					</th>
					<th width="12%" style="text-align: right; background-color: #0099CC; color: white; padding: 5px; border: 1px solid #ffffff;">
						{{ number_format($gtFourth, 2) }}
					</th>
				</tr>
			</thead>
		</table>
	@endif