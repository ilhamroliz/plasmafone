<?php

namespace App\Http\Controllers\master\gudang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\master\d_gudang as Gudang;

use DB;
use Session;

class gudang_controller extends Controller
{
    function kode_gudang()
    {
        $AWAL = 'GD';
        $bulanRomawi = array("", "I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");
        $noUrutAkhir = Gudang::count();
        if ($noUrutAkhir == 0) {
            $noUrutAkhir = 0;
        }
        $no = 1;
        $no_gudang = "";
        $no_urut = $noUrutAkhir + 1;
        $tgl = sprintf("%01s", abs(date('d')));
        if($noUrutAkhir) {
            $no_gudang = sprintf("%03s", abs($noUrutAkhir + 1)). '/' . $AWAL .'/'. $tgl . '/' . $bulanRomawi[date('n')] .'/' . date('Y');
        }
        else {
            $no_gudang = sprintf("%03s", $no). '/' . $AWAL .'/'. $tgl . '/' . $bulanRomawi[date('n')] .'/' . date('Y');
        }
        return $no_gudang;
    }

    public function gudang()
    {
        $gudangs = Gudang::get();
    	return view('master/gudang/index')->with(compact('gudangs'));
    }

    public function add_gudang(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $data = $request->all();
            $gudang = new Gudang();
            $gudang->g_kode = $data['kode_gudang'];
            $gudang->g_nama = $data['nama_gudang'];
            // $gudang->save();

            if ($gudang->save()) {
                // return redirect('master/gudang')->with('flash_message_success','Semua Data Gudang Yang Terakhir Anda Input Berhasil Tersimpan Di Database!');
                $kode_gudang = $this->kode_gudang();
                return  json_encode([
                    'status'    => 'berhasil',
                    'no_gudang' => $kode_gudang
                ]);
            }else{
                // return redirect('master/gudang')->with('flash_message_error','Semua Data Gudang Yang Terakhir Anda Input Gagal Tersimpan Di Database!');
                return  json_encode([
                    'status'    => 'gagal'
                ]);
            }
            
        }

        $kode_gudang = $this->kode_gudang();

        return view('master.gudang.add')->with(compact('kode_gudang'));
    }

    public function multiple_delete(Request $request){
        // return json_encode($request->data);
        Gudang::whereIn('g_id', $request->data)->delete();
        Session::flash('flash_message_success', 'Semua Data Yang Anda Pilih Berhasil Dihapus.');

        return  json_encode([
                    'status'    => 'berhasil'
                ]);
    }

    public function edit_multiple(Request $request){
        $data = Gudang::whereIn('g_id', $request->data_check)->get();
        return view('master.gudang.edit', compact('data'));
    }

    public function edit(Request $request){
        $data = Gudang::where('g_id', $request->id)->get();

        if(count($data) == 0){
            return view('errors.data_not_found');
        }
        return view('master.gudang.edit', compact('data'));
    }

    public function update(Request $request){
        // return json_encode($request->all());

        $data = Gudang::where('g_id', $request->id);

        if(!$data->first()){
            $response = [
                'status'    => 'tidak ada',
                'content'   => 'null'
            ];

            return json_encode($response);
        }else{
            $data->update([
                'g_nama'        => $request->nama_gudang
            ]);

            Session::flash('flash_message_success', 'Semua data yang telah Anda ubah berhasil tersimpan.');
            $response = [
                'status'    => 'berhasil',
                'content'   => null
            ];

            return json_encode($response);
        }
    }

    public function get_gudang($id){
        $data = Gudang::find($id);

        return json_encode($data);
    }
}
