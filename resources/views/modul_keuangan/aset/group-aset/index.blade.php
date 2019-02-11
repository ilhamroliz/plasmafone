@extends('main')

@section('title', 'Group Aset')

@section(modulSetting()['extraStyles'])

	<link rel="stylesheet" type="text/css" href="{{ asset('modul_keuangan/js/vendors/bootstrap_datatable_v_1_10_18/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('modul_keuangan/js/vendors/toast/dist/jquery.toast.min.css') }}">
    
@endsection


@section('content')
    <div class="col-md-12" style="background: none;">
    	<div class="col-md-12">
    		<div class="row">
    			<div class="col-md-6 content-title">
    				Data Group Aset
    			</div>

    			<div class="col-md-6 text-right">
                    <a href="{{ route('group.aset.create') }}">
    				    <button class="btn btn-info btn-sm">Tambah / Edit Data Group Aset</button>
                    </a>
    			</div>
    		</div>	
    	</div>

    	<div class="col-md-12 table-content">
    		<table class="table table-bordered table-stripped" id="data-sample">
    			<thead>
    				<tr>
    					<th width="5%">No</th>
    					<th width="20%">Nama Group</th>
    					<th width="20%">Golongan</th>
                        <th width="15%">Akun Harta</th>
                        <th width="15%">Akun Akumulasi</th>
                        <th width="15%">Akun Beban</th>
    					<th>Aksi</th>
    				</tr>
    			</thead>

    			<tbody>

                    @foreach($data as $key => $group)

                        <?php

                            switch($group->ga_golongan){
                                case "1":
                                    $golongan = "Non Bangunan - Kelompok 1";
                                    break;

                                case "2":
                                    $golongan = "Non Bangunan - Kelompok 2";
                                    break;

                                case "3":
                                    $golongan = "Non Bangunan - Kelompok 3";
                                    break;

                                case "4":
                                    $golongan = "Non Bangunan - Kelompok 4";
                                    break;

                                case "5":
                                    $golongan = "Bangunan - Permanen";
                                    break;

                                case "6":
                                    $golongan = "Bangunan - Non Permanen";
                                    break;
                            }

                        ?>
                        
                        <tr>
                            <td class="text-center">{{ ($key + 1) }}</td>
                            <td>{{ $group->ga_nama }}</td>
                            <td class="text-center" style="cursor: alias; color: #0099CC;" title="Masa Manfaat : {{ $group->ga_masa_manfaat }} Tahun | Persentase Saldo Menurun : {{ $group->ga_saldo_menurun }} % | Persentase Garis Lurus : {{ $group->ga_garis_lurus }} %">
                                {{ $golongan }}
                            </td>
                            <td class="text-center" style="cursor: alias; color: #0099CC;" title="{{ $group->nama_akun_harta }}">{{ $group->ga_akun_harta }}</td>
                            <td class="text-center" style="cursor: alias; color: #0099CC;" title="{{ $group->nama_akun_akumulasi }}">{{ $group->ga_akun_akumulasi }}</td>
                            <td class="text-center" style="cursor: alias; color: #0099CC;" title="{{ $group->nama_akun_beban }}">{{ $group->ga_akun_beban }}</td>
                            <td class="text-center">
                                <button class="btn btn-success btn-sm deleteGroup" title="hapus group" data-id="{{ $group->ga_id }}">
                                    <i class="fa fa-eraser"></i>
                                </button>
                            </td>
                        </tr>
                        
                    @endforeach
    				
    			</tbody>
    		</table>
    	</div>
    </div>
@endsection


@section(modulSetting()['extraScripts'])
	
	<script src="{{ asset('modul_keuangan/js/options.js') }}"></script>
    <script src="{{ asset('modul_keuangan/js/vendors/toast/dist/jquery.toast.min.js') }}"></script>
	<script src="{{ asset('modul_keuangan/js/vendors/bootstrap_datatable_v_1_10_18/datatables.min.js') }}"></script>
    <script src="{{ asset('modul_keuangan/js/vendors/axios_0_18_0/axios.min.js') }}"></script>

	<script type="text/javascript">

		$(document).ready(function() {
		    $('#data-sample').DataTable({
		    	"language": {
		            "lengthMenu": "Tampilkan _MENU_ Data Per Halaman",
		            "zeroRecords": "Tidak Bisa Menemukan Apapun . :(",
		            "info": "Menampilkan Halaman _PAGE_ dari _PAGES_",
		            "infoEmpty": "Tidak Ada Data Apapun",
		            "infoFiltered": "(Difilter Dari _MAX_ total records)",
		            "oPaginate": {
				        "sFirst":    "Pertama",
				        "sPrevious": "Sebelumnya",
				        "sNext":     "Selanjutnya",
				        "sLast":     "Terakhir"
				    }
		        }
		    });

            $('.deleteGroup').click(function(e){
                e.preventDefault();
                e.stopImmediatePropagation();
                conteks = $(this);

                var crfm = confirm('Apakah Anda Yakin ? ');

                if(crfm){
                    conteks.closest('tr').css({
                        'background': '#eee',
                        'color'     : '#aaa'
                    });

                    axios.post('{{ route('group.aset.delete') }}', { ga_id: conteks.data('id'), _token: '{{ csrf_token() }}' })
                                .then((response) => {
                                    // console.log(response.data);
                                    
                                    if(response.data.status == 'berhasil'){
                                        $.toast({
                                            text: response.data.message,
                                            showHideTransition: 'slide',
                                            position: 'top-right',
                                            icon: 'success',
                                            hideAfter: 5000
                                        });

                                        conteks.closest('tr').remove();
                                    }else{
                                        $.toast({
                                            text: response.data.message,
                                            showHideTransition: 'slide',
                                            position: 'top-right',
                                            icon: 'error',
                                            hideAfter: false
                                        });

                                        conteks.closest('tr').css({
                                            'background': 'none',
                                            'color'     : '#6f6f6f'
                                        });
                                    }

                                })
                                .catch((err) => {
                                    alert('Ups. Sistem Mengalami kesalahan. Message: '+err);
                                    conteks.closest('tr').css({
                                        'background': 'none',
                                        'color'     : '#6f6f6f'
                                    });
                                })
                }
            })
		});

    </script>

@endsection