@extends('main')

@section('title', 'Master Akun')

@section(modulSetting()['extraStyles'])

	<link rel="stylesheet" type="text/css" href="{{ asset('modul_keuangan/js/vendors/bootstrap_datatable_v_1_10_18/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('modul_keuangan/js/vendors/toast/dist/jquery.toast.min.css') }}">
    
@endsection

@section('ribbon')
    <!-- RIBBON -->
    <div id="ribbon">

        <span class="ribbon-button-alignment">

            <span id="refresh" class="btn btn-ribbon" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Refresh Halaman? Semua Perubahan Yang Belum Tersimpan Akan Hilang.." data-html="true" onclick="location.reload()">

                <i class="fa fa-refresh"></i>

            </span>

        </span>

        <!-- breadcrumb -->
        <ol class="breadcrumb">

            <li>Home</li><li>Manajemen Keuangan</li><li>Master Akun Keuangan</li><li>Master COA</li>

        </ol>
        <!-- end breadcrumb -->

    </div>
    <!-- END RIBBON -->
@endsection

@section('main_content')
    <!-- MAIN CONTENT -->
    <div id="content">

        <div class="row">

            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

                <h1 class="page-title txt-color-blueDark">

                    <i class="fa fa-lg fa-fw fa-money"></i>

                    Manajemen Keuangan  <span><i class="fa fa-angle-double-right"></i> Master Akun Keuangan </span> <span><i class="fa fa-angle-double-right"></i> Master COA </span>

                </h1>

            </div>

            @if(Access::checkAkses(45, 'insert') == true)
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-align-right">

                <div class="page-title">

                    <a href="{{ Route('akun.create') }}" class="btn btn-success"><i class="fa fa-plus"></i>&nbsp;Tambah / Edit Data</a>

                </div>

            </div>
            @endif

        </div>

        <!-- widget grid -->
        <section id="widget-grid" class="">

            <!-- row -->

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="table_content">
                    
                    <div class="jarviswidget" id="wid-id-11" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
                        <!-- widget div-->
                        <div>
                            <!-- widget content -->
                            <div class="widget-body no-padding">
                                <!-- widget body text-->
                                <div class="tab-content padding-10">
                                    <div class="tab-pane fade in active" id="hr1">
                                        <table class="table table-bordered table-stripped" id="data-sample">
                                            <thead>
                                                <tr>
                                                    <th width="5%">No</th>
                                                    <th width="12%">Kode Akun</th>
                                                    <th width="25%">Nama Akun</th>
                                                    <th width="15%">Kelompok</th>
                                                    <th width="8%">D/K</th>
                                                    <th width="15%">Saldo Opening</th>
                                                    <th width="15%">Tanggal Buat</th>
                                                    <th width="10">Aksi</th>
                                                </tr>
                                            </thead>

                                            <tbody>

                                                @foreach($data as $key => $akun)
                                                    <?php 
                                                        $bg     = '#eee';
                                                        $color  = '#aaa';

                                                        if($akun->ak_isactive == '1'){
                                                            $bg     = 'none';
                                                            $color  = 'none';
                                                        }
                                                    ?>

                                                    <tr style="background: {{ $bg  }}; color: {{  $color }};">
                                                        <td class="text-center">{{ ($key+1) }}</td>
                                                        <td>{{ $akun->ak_id }}</td>
                                                        <td>{{ $akun->ak_nama }}</td>
                                                        <td>{{ $akun->kelompok }}</td>

                                                        <?php 
                                                            if($akun->ak_posisi == 'D')
                                                                $posisi = 'DEBET';
                                                            else
                                                                $posisi = 'KREDIT';
                                                        ?>

                                                        <td class="text-center">{{ $posisi }}</td>
                                                        <td class="text-right">{{ number_format($akun->ak_opening, 2) }}</td>
                                                        <td class="text-center">{{ date('d/m/Y', strtotime($akun->created_at)) }}</td>
                                                        <td class="text-center">
                                                            {{-- <button class="btn btn-secondary btn-sm" title="Edit Data Group">
                                                                <i class="fa fa-edit"></i>
                                                            </button> --}}

                                                            @if($akun->ak_status == 'locked')
                                                                <button class="btn btn-default btn-sm" title="Akun Sedang Dikunci" style="cursor: no-drop;">
                                                                    <i class="fa fa-lock"></i>
                                                                </button>
                                                            @elseif($akun->ak_isactive == '1')
                                                                <button class="btn btn-success btn-sm aktifkanData" title="Nonaktifkan" data-id="{{ $akun->ak_id }}">
                                                                    <i class="fa fa-check-square-o"></i>
                                                                </button>
                                                            @else
                                                                <button class="btn btn-danger btn-sm aktifkanData" title="Aktifkan" data-id="{{ $akun->ak_id }}">
                                                                    <i class="fa fa-square-o"></i>
                                                                </button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                                <!-- end widget body text-->
                            </div>
                            <!-- end widget content -->
                        </div>
                        <!-- end widget div -->
                    </div>
                </div>
            </div>

            <!-- end row -->

        </section>
        <!-- end widget grid -->

    </div>
    <!-- END MAIN CONTENT -->
@endsection


@section(modulSetting()['extraScripts'])
	
	<script src="{{ asset('modul_keuangan/js/options.js') }}"></script>
    <script src="{{ asset('modul_keuangan/js/vendors/toast/dist/jquery.toast.min.js') }}"></script>
	<script src="{{ asset('modul_keuangan/js/vendors/bootstrap_datatable_v_1_10_18/datatables.min.js') }}"></script>
    <script src="{{ asset('modul_keuangan/js/vendors/axios_0_18_0/axios.min.js') }}"></script>

	<script type="text/javascript">

		$(document).ready(function() {
		    $('#data-sample').DataTable({
                "bLengthChange": false,
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

            $('.aktifkanData').click(function(e){
                e.preventDefault();
                e.stopImmediatePropagation();

                var context = $(this);
                var cfrm = confirm('Apakah Anda Yakin ?');

                if(cfrm){
                    $('.aktifkanData').attr('disabled', 'disabled');

                    axios.post('{{ route('akun.delete') }}', { ak_id: context.data('id'), _token: '{{ csrf_token() }}' })
                            .then((response) => {
                                console.log(response.data);
                                
                                if(response.data.status == 'berhasil'){
                                    $.toast({
                                        text: response.data.message,
                                        showHideTransition: 'slide',
                                        position: 'top-right',
                                        icon: 'success',
                                        hideAfter: 5000
                                    });

                                    if(response.data.active == '0'){
                                        context.removeClass('btn-success');
                                        context.addClass('btn-danger');
                                        context.html('<i class="fa fa-square-o"></i>');
                                        context.closest('tr').css({
                                            'background': '#eee',
                                            'color'     : '#aaa'
                                        });
                                        context.attr('title', 'Aktifkan');
                                    }else{
                                        context.removeClass('btn-danger');
                                        context.addClass('btn-success');
                                        context.html('<i class="fa fa-check-square-o"></i>');
                                        context.closest('tr').css({
                                            'background': 'none',
                                            'color'     : '#6f6f6f'
                                        });
                                        context.attr('title', 'Nonaktifkan');
                                    }

                                }else{
                                    $.toast({
                                        text: response.data.message,
                                        showHideTransition: 'slide',
                                        position: 'top-right',
                                        icon: 'error',
                                        hideAfter: false
                                    });
                                }

                            })
                            .catch((err) => {
                                alert('Ups. Sistem Mengalami kesalahan. Message: '+err);
                            })
                            .then(() => {
                                $('.aktifkanData').removeAttr('disabled');
                            })
                }
            })
		});

    </script>

@endsection