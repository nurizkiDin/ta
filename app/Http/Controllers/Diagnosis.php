<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Diagnosis extends Controller
{
    public function dataVariabel(Request $req) {
        $err1 = false;
        $err2 = false;
        $err3 = false;
        $user = DB::table('tbl_user')->where('username', Session::get('nama_user'))->first();
        $presbiopi = 'Normal';
        $kanan = 0;
        $kiri = 0;
        $pembagi = 1;

        if($user->usia>=50) {
            $presbiopi = 'Presbiopi';
        }

        foreach($req->jarak_objek as $dt) {
            if (is_numeric($dt)==false){
                $err1 = true;
            }
        }
        foreach($req->terlihat_jelas_cm_kanan as $dt) {
            if (is_numeric($dt)==false){
                $err2 = true;
            }
        }
        foreach($req->terlihat_jelas_cm_kiri as $dt) {
            if (is_numeric($dt)==false){
                $err3 = true;
            }
        }

        if ($err1==false && $err2==false && $err3==false){
            for($i=0;$i<sizeof($req->jarak_objek);$i++){
                DB::insert('replace into data_variabel (id_data, username, jarak_objek_cm, 
                terlihat_jelas_cm_kanan, terlihat_jelas_cm_kiri) values (?, ?, ?, ?, ?)', [
                    "{$i}{$user->username}",
                    $user->username,
                    $req->jarak_objek[$i],
                    $req->terlihat_jelas_cm_kanan[$i],
                    $req->terlihat_jelas_cm_kiri[$i],
                ]);
                $kanan+=$req->terlihat_jelas_cm_kanan[$i]*
                ($req->terlihat_jelas_cm_kanan[sizeof($req->jarak_objek)-1]/$req->terlihat_jelas_cm_kanan[$i]);
                $kiri+=$req->terlihat_jelas_cm_kiri[$i]*
                ($req->terlihat_jelas_cm_kiri[sizeof($req->jarak_objek)-1]/$req->terlihat_jelas_cm_kiri[$i]);
            }
            $pembagi = sizeof($req->jarak_objek);
            DB::insert('replace into tbl_hasil (username, presbiopi, kekuatan_lensa_kiri,
            kekuatan_lensa_kanan) values (?, ?, ?, ?)', [
                $user->username,
                $presbiopi,
                (100/600)-100/($kiri/$pembagi),
                (100/600)-100/($kanan/$pembagi)
            ]);
            return redirect('/');
        } else {
            return redirect('/')->withErrors('Input harus berupa angka dan tidak kosong');
        }
    }

    public function edit(){
        $namaUser = Session::get('nama_user');
        if (!$namaUser) {
            return redirect('/masuk');
        }
        return view('editData');
    }

    public function editData(Request $req) {
        $err1 = false;
        $err2 = false;
        $err3 = false;
        $user = DB::table('tbl_user')->where('username', Session::get('nama_user'))->first();
        $presbiopi = 'Normal';
        $kanan = 0;
        $kiri = 0;
        $pembagi = 1;

        if($user->usia>=50) {
            $presbiopi = 'Presbiopi';
        }
        if($user->usia<50 && $user->usia>40) {
            $presbiopi = 'Semi Presbiopi';
        }
        foreach($req->jarak_objek as $dt) {
            if (is_numeric($dt)==false){
                $err1 = true;
            }
        }
        foreach($req->terlihat_jelas_cm_kanan as $dt) {
            if (is_numeric($dt)==false){
                $err2 = true;
            }
        }
        foreach($req->terlihat_jelas_cm_kiri as $dt) {
            if (is_numeric($dt)==false){
                $err3 = true;
            }
        }

        if ($err1==false && $err2==false && $err3==false){
            for($i=0;$i<sizeof($req->jarak_objek);$i++){
                DB::insert('replace into data_variabel (id_data, username, jarak_objek_cm, 
                terlihat_jelas_cm_kanan, terlihat_jelas_cm_kiri) values (?, ?, ?, ?, ?)', [
                    "{$i}{$user->username}",
                    $user->username,
                    $req->jarak_objek[$i],
                    $req->terlihat_jelas_cm_kanan[$i],
                    $req->terlihat_jelas_cm_kiri[$i],
                ]);
                $kanan+=$req->terlihat_jelas_cm_kanan[$i]*
                ($req->terlihat_jelas_cm_kanan[sizeof($req->jarak_objek)-1]/$req->terlihat_jelas_cm_kanan[$i]);
                $kiri+=$req->terlihat_jelas_cm_kiri[$i]*
                ($req->terlihat_jelas_cm_kiri[sizeof($req->jarak_objek)-1]/$req->terlihat_jelas_cm_kiri[$i]);
            }
            
            $pembagi = sizeof($req->jarak_objek);
            DB::insert('replace into tbl_hasil (username, presbiopi, kekuatan_lensa_kiri,
            kekuatan_lensa_kanan) values (?, ?, ?, ?)', [
                $user->username,
                $presbiopi,
                (100/600)-100/($kiri/$pembagi),
                (100/600)-100/($kanan/$pembagi)
            ]);
            return redirect('/edit');
        } else {
            return redirect('/edit')->withErrors('Input harus berupa angka dan tidak kosong');
        }
    }

    public function hasil(){
        $namaUser = Session::get('nama_user');
        if (!$namaUser) {
            return redirect('/masuk');
        }
        return view('hasil');
    }
}
