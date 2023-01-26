<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class Dokter extends Controller
{
    function masukLab() {
        return view('masukDok');
    }

    function labDok() {
        $namaDok = Session::get('nama_dokter');
        if (!$namaDok) {
            return redirect('/masukLab');
        }
        return view('dataUjiDok');
    }

    function editLab() {
        $namaDok = Session::get('nama_dokter');
        if (!$namaDok) {
            return redirect('/masukLab');
        }
        return view('editUji');
    }

    function hasilLab() {
        $namaDok = Session::get('nama_dokter');
        if (!$namaDok) {
            return redirect('/masukLab');
        }
        return view('hasilUji');
    }

    function keluar() {
        Session::forget('nama_dokter');
        return redirect('/masukLab');
    }

    function keLab(Request $req) {
        $this->validate($req, [
            'dokname' => 'required',
            'password' => 'required'
        ],[
            'dokname.required' => 'Admin id tidak boleh kosong',
            'password.required' => 'Password tidak boleh kosong'
        ]);
        $dok = DB::table('tbl_dokter')->where('dokname', $req->dokname)->first();
        if (!$dok) {
            return redirect('/masukLab')->withErrors('Gagal login, cek admin id dan password');
        } else {
            if ($dok->password == $req->password) {
                Session::put('nama_dokter', $dok->dokname);
                return redirect('/lab');
            } else {
                return redirect('/masukLab')->withErrors('Gagal login, cek admin id dan password');
            }
        }
    }

    function dataUji(Request $req) {
        $this->validate($req, [
            'csvData' => 'required|mimes:csv,txt|max:2048'
        ],[
            'csvData.required' => 'Data Belum dipilih',
            'csvData.mimes' => 'Ekstensi Data Harus Berupa .csv atau .txt',
            'csvData.max' => 'Data Maksimal 2MB'
        ]);
        $namaDok = Session::get('nama_dokter');

        $dataUji = $req->file('csvData');
        $namaData = time()."_".$dataUji->getClientOriginalName();
        $dirData = $dataUji->move(public_path('/data_uji'), $namaData);
        $publikData = public_path('data_uji\\'.$namaData);
        $dt = str_replace('\\','\\\\',$publikData);
        if ($dirData) {
            DB::statement("LOAD DATA INFILE '{$dt}'
            INTO TABLE tbl_uji FIELDS TERMINATED BY ';'
            ENCLOSED BY '\"' LINES TERMINATED BY '\\r\\n' IGNORE 1 LINES
            (usia, jenis_rabun, astigmatism, tingkat_prod_airMata, jenis_lens)
            SET dokname = '{$namaDok}'");
        }

        return redirect()->back()->with('success', 'Berhasil!');
    }

    function editUji(Request $req) {
        $err1 = false;
        $err2 = false;
        $err3 = false;
        $err4 = false;
        $err5 = false;
        $ujiVar = DB::table('tbl_uji')->where('dokname', Session::get('nama_dokter'))->get();
        foreach($req->usia as $dt) {
            if ($dt!='Tua' && $dt!='Dewasa' && $dt!='Muda'){
                $err1 = true;
            }
        }
        foreach($req->jenis_rabun as $dt) {
            if ($dt=='Miopi' && $dt=='Hipermetropi'){
                $err2 = true;
            }
        }
        foreach($req->astigmatism as $dt) {
            if ($dt=='Silinder' && $dt=='Tidak Silinder'){
                $err3 = true;
            }
        }
        foreach($req->tingkat_prod_airMata as $dt) {
            if ($dt=='Normal' && $dt=='Air Mata Berkurang'){
                $err4 = true;
            }
        }
        foreach($req->jenis_lens as $dt) {
            if ($dt=='Tanpa Kontak Lensa' && $dt=='Hard Lens' && $dt=='Soft Lens'){
                $err5 = true;
            }
        }
        if ($err1==false && $err2==false && $err3==false && $err4==false && $err5==false){
                for($i=0;$i<sizeof($req->usia);$i++) {
                    DB::insert('update tbl_uji set usia = ?, jenis_rabun = ?, astigmatism = ?, 
                    tingkat_prod_airMata = ?, jenis_lens = ? 
                    where id_uji = ?', [
                        $req->usia[$i],
                        $req->jenis_rabun[$i],
                        $req->astigmatism[$i],
                        $req->tingkat_prod_airMata[$i],
                        $req->jenis_lens[$i],
                        $ujiVar[$i]->id_uji
                    ]);
            }
            return redirect('/lab');
        } else {
            return redirect('/lab')->withInput()->withErrors('Input harus sesuai dengan kriteria variabel uji');
        }
    }
    function hapusUji(Request $req) {
        DB::statement("DELETE FROM tbl_uji WHERE id_uji = $req->id_uji");
        return redirect('/lab/edit');
    }
}