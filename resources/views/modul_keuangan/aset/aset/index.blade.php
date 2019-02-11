@extends('main')

@section('title', 'Data Aset')

@section(modulSetting()['extraStyles'])

	<link rel="stylesheet" type="text/css" href="{{ asset('modul_keuangan/js/vendors/bootstrap_datatable_v_1_10_18/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('modul_keuangan/js/vendors/toast/dist/jquery.toast.min.css') }}">
    
@endsection


@section('content')
    <div class="col-md-12" style="background: none;">
    	<div class="col-md-12">
    		<div class="row">
    			<div class="col-md-6 content-title">
    				Data Aset
    			</div>

    			<div class="col-md-6 text-right">
                    <a href="{{ route('aset.create') }}">
    				    <button class="btn btn-info btn-sm">Tambah / Edit Data Aset</button>
                    </a>
    			</div>
    		</div>	
    	</div>

    	<div class="col-md-12 table-content">
    		<table class="table table-bordered table-stripped" id="data-sample">
    			<thead>
    				<tr>
    					<th width="5%">No</th>
    					<th width="20%">Nama Aset</th>
    					<th width="20%">Golongan</th>
                        <th width="15%">Harga Beli</th>
                        <th width="15%">Nilai Sisa</th>
                        <th width="15%">Tanggal Habis</th>
                        <th width="15%">Status</th>
    				</tr>
    			</thead>

    			<tbody>

                    @foreach($data as $key => $group)
                        
                        <tr>
                            <td class="text-center">{{ ($key + 1) }}</td>
                            <td>{{ $group->at_nama }}</td>
                            <td class="text-center" style="cursor: alias; color: #0099CC;">
                                {{ $group->ga_nama }}
                            </td>
                            <td class="text-right" style="cursor: alias; color: #0099CC;">{{ number_format($group->at_harga_beli, 2) }}</td>
                            <td class="text-right" style="cursor: alias; color: #0099CC;">{{ number_format($group->at_nilai_sisa, 2) }}</td>
                            <td class="text-center" style="cursor: alias;">
                                {{ date('d/m/Y', strtotime($group->at_tanggal_habis)) }}
                            </td>

                            <?php
                                $status = "Habis";

                                if($group->at_status == 'SL')
                                    $status = "Terjual";
                                else if($group->at_status == "ST")
                                    $status = "Dalam Penyusutan"
                             ?>

                            <td class="text-center" style="font-weight: 600;">
                                {{ $status }}
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