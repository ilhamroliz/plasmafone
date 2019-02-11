@extends('main')

@section('title', 'Tambah Data Transaksi Kas')

@section(modulSetting()['extraStyles'])

	<link rel="stylesheet" type="text/css" href="{{ asset('modul_keuangan/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('modul_keuangan/js/vendors/wait_me_v_1_1/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('modul_keuangan/js/vendors/toast/dist/jquery.toast.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('modul_keuangan/js/vendors/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('modul_keuangan/js/vendors/datepicker/dist/datepicker.min.css') }}">

@endsection


@section('content')
    <div class="col-md-12" style="background: none;" id="vue-component">
    	<div class="col-md-12">
    		<div class="row">
    			<div class="col-md-6 content-title">
    				Master Data Transaksi keuangan &nbsp;<i class="fa fa-question-circle" style="cursor: help;"></i>
    			</div>

    			<div class="col-md-6 text-right form-status">
    				<span v-if="stat == 'standby'" v-cloak>
                        <i class="fa fa-exclamation"></i> &nbsp; Pastikan Data Terisi Dengan Benar            
                    </span>

                    <div class="loader" v-if="stat == 'loading'" v-cloak>
                       <div class="loading"></div> &nbsp; <span>@{{ statMessage }}</span>
                    </div>
    			</div>
    		</div>	
    	</div>

    	<div class="col-md-12 table-content">
            <form id="data-form" v-cloak>
                <input type="hidden" readonly name="_token" value="{{ csrf_token() }}">
                <input type="hidden" readonly name="tr_id" v-model="singleData.tr_id">
                <div class="row">
                    <div class="col-md-6" style="background: none;">

                        <div class="row mt-form">
                            <div class="col-md-3">
                                <label class="modul-keuangan">Nomor Transaksi</label>
                            </div>

                            <div class="col-md-5">
                                <input type="text" name="tr_nomor" class="form-control modul-keuangan" placeholder="Di Isi Oleh Sistem" readonly v-model="singleData.tr_nomor">
                            </div>

                            <div class="col-md-1 form-info-icon link" @click="search" v-if="!onUpdate">
                                <i class="fa fa-search" title="Cari Group Berdasarkan Nomor dan Type Group"></i>
                            </div>

                            <div class="col-md-1 form-info-icon link" @click="formReset" v-if="onUpdate">
                                <i class="fa fa-times" title="Bersihkan Pencarian" style="color: #CC0000;"></i>
                            </div>
                        </div>

                        <div class="row mt-form">
                            <div class="col-md-3">
                                <label class="modul-keuangan">Type Transaksi Kas</label>
                            </div>

                            <div class="col-md-5">
                                <vue-select :name="'tr_type'" :id="'tr_type'" :options="typeTransaksi" :disabled="onUpdate" @input="typeChange"></vue-select>
                            </div>

                            <div class="col-md-1 form-info-icon" title="Parameter Type Group Digunakan Untuk Pencarian Data">
                                <i class="fa fa-info-circle"></i>
                            </div>
                        </div>

                        <div class="row mt-form" style="border-top: 1px solid #eee; padding-top: 20px;">
                            <div class="col-md-3">
                                <label class="modul-keuangan">Ket. Transaksi *</label>
                            </div>

                            <div class="col-md-6">
                                <input type="text" name="tr_nama" class="form-control modul-keuangan" :placeholder="singleData.placholderNama" v-model="singleData.tr_nama" title="Tidak Boleh Kosong">
                            </div>
                        </div>

                        <div class="row mt-form" v-if="locked">
                            <div class="col-md-3">
                                <label class="modul-keuangan"></label>
                            </div>

                            <div class="col-md-7">
                                <div class="modul-keuangan-alert primary" role="alert">
                                  <i class="fa fa-info-circle"></i> &nbsp;&nbsp;Group Akun Dikunci. Tidak Bisa Dinonaktifkan
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6" style="background: none; padding: 0px; padding-right: 10px;">
                        <div class="col-md-12" style="padding: 0px; min-height: 260px; background: #f7f7f7;">
                            <table class="table table-stripped table-bordered table-mini">
                                <thead>
                                    <tr>
                                        <th width="8%">*</th>
                                        <th width="60%">Akun</th>
                                        <th width="32%">Posisi</th>
                                    </tr>
                                </thead>

                                <tbody id="wrap">
                                    <tr>
                                        <td class="text-center" style="padding:8px;">
                                            <i class="fa fa-lock" style="color: #3F729B;"></i>
                                        </td>

                                        <td style="padding: 8px;">
                                            <vue-select :name="'akun[]'" :id="'akunFirst'" :options="akunFirst" :style="'width:100%;'"></vue-select>
                                        </td>

                                        <td class="debet" style="padding: 8px 8px 0px 8px;">
                                            <vue-select :name="'dk[]'" :id="'dkFirst'" :options="dkFirst" :style="'width:100%;'"></vue-select>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center" style="padding:8px;">
                                            <i class="fa fa-lock" style="color: #3F729B;"></i>    
                                        </td>

                                        <td style="padding: 8px;">
                                            <vue-select :name="'akun[]'" :id="'akunSecond'" :options="akunLawan" :style="'width:100%;'"></vue-select>
                                        </td>

                                        <td class="debet" style="padding: 8px 8px 0px 8px;">
                                           <vue-select :name="'dk[]'" :id="'dkSecond'" :options="dk" :style="'width:100%;'"></vue-select>
                                        </td>
                                    </tr>

                                    <tr v-for="n in akunCount" id="cekWrap">
                                        <td class="text-center" style="padding: 8px;">
                                            <i class="fa fa-times" :id="'deleteAkun'+n" style="color: #ff4444; cursor: pointer;" @click="deleteAkun"></i>
                                        </td>

                                        <td style="padding: 8px;">
                                            <vue-select :name="'akun[]'" :id="'akun_'+n" :options="akunLawan"></vue-select>
                                        </td>

                                        <td class="debet" style="padding: 13px 8px 0px 8px;">
                                            <vue-select :name="'dk[]'" :id="'dk_'+n" :options="dk" :style="'width:100%;'"></vue-select>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-12" style="padding: 0px; margin-top: -10px">

                            <table class="table table-stripped table-bordered table-mini">
                                <tr>
                                    <td width="8%" class="text-center" style="padding: 10px 5px 0px 5px;">
                                        <i class="fa fa-plus" style="color: #00C851; cursor: pointer;" @click="addAkun" title="Tambahkan Akun"></i>    
                                    </td>

                                    <td colspan="2" class="text-center" style="padding: 10px 5px 10px 5px; font-style: italic;">
                                        Pastikan Terdapat Minimal 1 Akun Debet dan 1 Akun Debet Pada Detail Transaksi    
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row content-button">
                    <div class="col-md-6">
                        <a href="{{ route('transaksi.index') }}" title="Kembali Ke Halaman Master Transaksi">
                            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-arrow-left" :disabled="btnDisabled"></i></button>
                        </a>
                    </div>

                    <div class="col-md-6 text-right">
                        <button type="button" class="btn btn-info btn-sm" @click="updateData" :disabled="btnDisabled" v-if="onUpdate"><i class="fa fa-floppy-o"></i> &nbsp;Simpan Perubahan</button>
                        
                        <button type="button" class="btn btn-danger btn-sm" @click="deleteData" :disabled="btnDisabled" v-if="onUpdate"><i class="fa fa-times"></i> &nbsp;Hapus</button>

                        <button type="button" class="btn btn-primary btn-sm" @click="saveData" :disabled="btnDisabled" v-if="!onUpdate"><i class="fa fa-floppy-o"></i> &nbsp;Simpan</button>
                    </div>
                </div>
            </form>
    	</div>

        <div class="ez-popup" id="data-popup">
            <div class="layout" style="width: 50%">
                <div class="top-popup" style="background: none;">
                    <span class="title">
                        Data Transaksi Yang Sudah Masuk
                    </span>

                    <span class="close"><i class="fa fa-times" style="font-size: 12pt; color: #CC0000"></i></span>
                </div>
                
                <div class="content-popup">
                    <vue-datatable :data_resource="list_data_table" :columns="data_table_columns" :selectable="true" :ajax_on_loading="onAjaxLoading" :index_column="'mt_id'" @selected="dataSelected"></vue-datatable>
                </div>
            </div>
        </div>

    </div>
@endsection


@section(modulSetting()['extraScripts'])
	
	<script src="{{ asset('modul_keuangan/js/options.js') }}"></script>

    <script src="{{ asset('modul_keuangan/js/vendors/vue_2_x/vue_2_x.js') }}"></script>
    <script src="{{ asset('modul_keuangan/js/vendors/vue_2_x/components/datatable.component.js') }}"></script>
    <script src="{{ asset('modul_keuangan/js/vendors/vue_2_x/components/select.component.js') }}"></script>
    <script src="{{ asset('modul_keuangan/js/vendors/vue_2_x/components/inputmask.component.js') }}"></script>
    <script src="{{ asset('modul_keuangan/js/vendors/vue_2_x/components/datepicker.component.js') }}"></script>

    <script src="{{ asset('modul_keuangan/js/vendors/wait_me_v_1_1/wait.js') }}"></script>
    <script src="{{ asset('modul_keuangan/js/vendors/toast/dist/jquery.toast.min.js') }}"></script>
    <script src="{{ asset('modul_keuangan/js/vendors/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('modul_keuangan/js/vendors/validator/bootstrapValidator.min.js') }}"></script>
    <script src="{{ asset('modul_keuangan/js/vendors/axios_0_18_0/axios.min.js') }}"></script>
    <script src="{{ asset('modul_keuangan/js/vendors/inputmask/inputmask.jquery.js') }}"></script>
    <script src="{{ asset('modul_keuangan/js/vendors/datepicker/dist/datepicker.min.js') }}"></script>

	<script type="text/javascript">

        function register_validator(){
            $('#data-form').bootstrapValidator({
                feedbackIcons : {
                  valid : 'glyphicon glyphicon-ok',
                  invalid : 'glyphicon glyphicon-remove',
                  validating : 'glyphicon glyphicon-refresh'
                },
                fields : {
                  tr_nama : {
                    validators : {
                      notEmpty : {
                        message : 'Nama Transaksi Tidak Boleh Kosong',
                      }
                    }
                  },

                  tr_tanggal : {
                    validators : {
                      notEmpty : {
                        message : 'Tanggal Transaksi Tidak Boleh Kosong',
                      }
                    }
                  },

                  akun_kas : {
                    validators : {
                      notEmpty : {
                        message : 'Akun Kas Harus Dipilih',
                      }
                    }
                  },

                }
            });
        }

		var app = new Vue({
            el: '#vue-component',
            data: {
                stat: 'standby',
                statMessage: '',
                btnDisabled: false,
                onAjaxLoading: false,
                onUpdate: false,
                locked: false,
                type: 'KM',
                akunCount: 0,

                data_table_columns : [],

                typeTransaksi : [
                    {
                        id: 'KM',
                        text: 'KM - Transaksi Kas Masuk'
                    },

                    {
                        id: 'KK',
                        text: 'KK - Transaksi Kas Keluar'
                    },

                    {
                        id: 'BM',
                        text: 'BM - Transaksi Bank Masuk'
                    },

                    {
                        id: 'BK',
                        text: 'BK - Transaksi Bank Keluar'
                    },

                    {
                        id: 'MD',
                        text: 'MD - Memorial Debet'
                    },

                    {
                        id: 'MK',
                        text: 'MK - Memorial Kredit'
                    }
                ],

                dk : [
                    {
                        id: 'D',
                        text: 'Debet'
                    },

                    {
                        id: 'K',
                        text: 'Kredit'
                    },
                ],

                list_data_table : [],
                akun: [],
                akunFirst: [],
                akunLawan: [],
                dkFirst: [],

                kelompokKas: '',
                kelompokBank: '',

                singleData: {
                    tr_nama: '',
                    tr_id: '',
                    tr_nomor: '',
                    placholderNama: 'contoh: Setoran Modal Investor',
                }
            },

            created: function(){
                console.log('Initializing Vue');
            },

            mounted: function(){
                console.log('Vue Ready');
                $('#tr_tanggal').val('{{ date('d/m/Y') }}');
                register_validator();

                var that = this;

                this.data_table_columns = [
                    {name: 'Nama Transaksi', context: 'mt_nama', width: '60%', childStyle: 'text-align: center'},
                    {name: 'Type Transaksi', context: 'mt_type', width: '40%', childStyle: 'text-align: center', override(e){
                        switch(e){
                            case 'KM':
                                return 'Kas Masuk';
                                break;

                            case 'KK':
                                return 'Kas Keluar';
                                break;

                            case 'BM':
                                return 'Bank Masuk';
                                break;

                            case 'BK':
                                return 'Bank Keluar';
                                break;

                            case 'MD':
                                return 'Memorial Debet';
                                break;

                            case 'MK':
                                return 'Memorial Kredit';
                                break;
                        }
                    }},
                ];

                axios.get('{{route('transaksi.form_resource')}}')
                          .then((response) => {

                                this.kelompokKas  = response.data.kelompok_kas.hp_hierarki;
                                this.kelompokBank = response.data.kelompok_bank.hp_hierarki;

                                if(response.data.akun.length > 0){
                                    this.akun = response.data.akun
                                    this.generateAkun();
                                } 

                                // console.log(this.kelompokKas);

                          })
                          .catch((e) => {
                            alert('error '+e);
                          })
            },

            computed: {
                // ---
            },

            watch: {
                // ---
            },

            methods: {
                saveData: function(evt){
                    evt.preventDefault();
                    evt.stopImmediatePropagation();
                    if($('#data-form').data('bootstrapValidator').validate().isValid()){

                        this.stat = 'loading';
                        this.statMessage = 'Sedang Menyimpan Data ..'
                        this.btnDisabled = true;

                        axios.post('{{ route('transaksi.store') }}', $('#data-form').serialize())
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

                                        this.formReset();
                                    }else{
                                        $.toast({
                                            text: response.data.message,
                                            showHideTransition: 'slide',
                                            position: 'top-right',
                                            icon: 'error',
                                            hideAfter: false
                                        });

                                        this.stat = 'standby';
                                    }

                                })
                                .catch((err) => {
                                    alert('Ups. Sistem Mengalami kesalahan. Message: '+err);
                                })
                                .then(() => {
                                    this.btnDisabled = false;
                                })
                    }
                },

                updateData: function(evt){
                    evt.preventDefault();
                    evt.stopImmediatePropagation();

                    if($('#data-form').data('bootstrapValidator').validate().isValid()){

                        this.stat = 'loading';
                        this.statMessage = 'Sedang Memperbarui Data ..'
                        this.btnDisabled = true;

                        axios.post('{{ route('transaksi.update') }}', $('#data-form').serialize())
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

                                        this.formReset();
                                    }else{
                                        $.toast({
                                            text: response.data.message,
                                            showHideTransition: 'slide',
                                            position: 'top-right',
                                            icon: 'error',
                                            hideAfter: false
                                        });

                                        this.stat = 'standby';
                                    }

                                })
                                .catch((err) => {
                                    alert('Ups. Sistem Mengalami kesalahan. Message: '+err);
                                })
                                .then(() => {
                                    this.btnDisabled = false;
                                })
                    }
                },

                deleteData: function(evt){
                    evt.preventDefault();
                    evt.stopImmediatePropagation();

                    if(this.locked){
                        $.toast({
                            text: "Group Ini Sedang Dikunci (Digunakan Oleh Sistem). Tidak Bisa Dinonaktifkan",
                            showHideTransition: 'slide',
                            position: 'top-right',
                            icon: 'info',
                            hideAfter: false
                        });
                    }else{
                        var cfrm = confirm('Apakah Anda Yakin ?');

                        if(cfrm){
                            this.stat = 'loading';
                            this.statMessage = 'Sedang Menghapus Transaksi ..'
                            this.btnDisabled = true;

                            axios.post('{{ route('transaksi.delete') }}', { tr_id: this.singleData.tr_id, _token: '{{ csrf_token() }}' })
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

                                            this.formReset();
                                        }else{
                                            $.toast({
                                                text: response.data.message,
                                                showHideTransition: 'slide',
                                                position: 'top-right',
                                                icon: 'error',
                                                hideAfter: false
                                            });

                                            this.stat = 'standby';
                                        }

                                    })
                                    .catch((err) => {
                                        alert('Ups. Sistem Mengalami kesalahan. Message: '+err);
                                    })
                                    .then(() => {
                                        this.btnDisabled = false;
                                    })
                        }
                    }

                },

                typeChange: function(e){
                    this.type = e;
                    this.generateAkun();
                },

                addAkun: function(e){
                    e.preventDefault();
                    e.stopImmediatePropagation();

                    this.akunCount++;
                },

                deleteAkun: function(e){
                    e.preventDefault();
                    e.stopImmediatePropagation();

                    conteks = $('#'+e.srcElement.id);
                    conteks.closest('tr').remove();
                },

                search: function(e){
                    e.preventDefault();
                    this.list_data_table = [];
                    this.onAjaxLoading = true;

                    axios.get('{{ Route('transaksi.datatable') }}?type='+$('#tr_type').val())
                            .then((response) => {
                                // console.log(response.data);
                                if(response.data.length){
                                    this.list_data_table = response.data;
                                }
                            })
                            .then(() => {
                                this.onAjaxLoading = false;
                            })
                            .catch((err) => {
                                alert('Ups. Sistem Mengalami kesalahan. Message: '+err);
                            })

                    $('#data-popup').ezPopup('show');
                },

                dataSelected: function(e){
                    var that = this; loopCount = 1;
                    this.stat = 'loading';
                    this.statMessage = 'Sedang Menyiapkan Data ..'
                    this.btnDisabled = true;

                    var idx = this.list_data_table.findIndex(a => a.mt_id === e);

                    this.singleData.tr_id = this.list_data_table[idx].mt_id;
                    this.singleData.tr_nomor = this.list_data_table[idx].mt_id;
                    this.singleData.tr_nama = this.list_data_table[idx].mt_nama;
                    this.akunCount = parseInt(this.list_data_table[idx].detail.length - 2);

                    $('#tr_type').val(this.list_data_table[idx].mt_type).trigger('change.select2');

                    this.onUpdate = true;
                    this.type = $('#tr_type').val();

                    setTimeout(function(){
                        $.each(that.list_data_table[idx].detail, function(i, n){
                            if(i == 0){
                                $('#akunFirst').val(n.mtdt_akun).trigger('change.select2');
                                $('#dkFirst').val(n.mtdt_posisi).trigger('change.select2');
                            }else if(i == 1){
                                $('#akunSecond').val(n.mtdt_akun).trigger('change.select2');
                                $('#dkSecond').val(n.mtdt_posisi).trigger('change.select2');
                            }else{
                                $('#akun_'+loopCount).val(n.mtdt_akun).trigger('change.select2');
                                $('#dk_'+loopCount).val(n.mtdt_posisi).trigger('change.select2');
                                loopCount++;
                            }
                        })
                        that.stat = 'standby';
                        that.btnDisabled = false;
                    }, 0)

                    $('#data-popup').ezPopup('close');

                },

                generateAkun: function(e){
                    var status = this.type;
                    var that = this;

                    switch(status.substring(0, 1)){
                        case "K":
                            this.akunFirst = $.grep(that.akun, function(e){ return e.kelompok == that.kelompokKas});
                            this.akunLawan = $.grep(that.akun, function(e){ return e.kelompok != that.kelompokKas && e.kelompok != that.kelompokBank});
                            break;

                        case "B":
                            this.akunFirst = $.grep(that.akun, function(e){ return e.kelompok == that.kelompokBank});
                            this.akunLawan = $.grep(that.akun, function(e){ return e.kelompok != that.kelompokBank && e.kelompok != that.kelompokKas});
                            break;

                        case "M":
                            this.akunFirst = $.grep(that.akun, function(e){ return e.kelompok != that.kelompokBank && e.kelompok != that.kelompokKas});
                            this.akunLawan = $.grep(that.akun, function(e){ return e.kelompok != that.kelompokBank && e.kelompok != that.kelompokKas});
                            break;

                        default:
                            alert('Type Transaksi Tidak Diketahui');
                            return false;
                            break;

                    }

                    if(status == 'KM' || status == 'BM' || status == 'MD'){
                        this.dkFirst = [{id: this.dk[0].id , text: this.dk[0].text}];
                    }else{
                        this.dkFirst = [{id: this.dk[1].id , text: this.dk[1].text}];
                    }

                    return true;;
                },

                humanizePrice: function(alpha){
                  var bilangan = alpha.toString();
                  var commas = '00';


                  if(bilangan.split('.').length > 1){
                    commas = bilangan.split('.')[1];
                    bilangan = bilangan.split('.')[0];
                  }
                  
                  var number_string = bilangan.toString(),
                    sisa  = number_string.length % 3,
                    rupiah  = number_string.substr(0, sisa),
                    ribuan  = number_string.substr(sisa).match(/\d{3}/g);
                      
                  if (ribuan) {
                    separator = sisa ? ',' : '';
                    rupiah += separator + ribuan.join(',');
                  }

                  // Cetak hasil
                  return rupiah+'.'+commas; // Hasil: 23.456.789
                },

                formReset: function(){
                    
                    this.singleData.tr_nama = '';
                    this.singleData.tr_nomor = '';

                    if(this.akunFirst.length >= 0){
                        $('#akunFirst').val(this.akunFirst[0]['id']).trigger('change.select2');
                    }

                    if(this.akunLawan.length >= 0){
                        $('#akunSecond').val(this.akunLawan[0]['id']).trigger('change.select2');
                    }

                    this.akunCount = 0;
                    this.stat = 'standby';
                    this.onUpdate = false;
                    $('#data-form').data('bootstrapValidator').resetForm();
                }
            }
        })

    </script>

@endsection