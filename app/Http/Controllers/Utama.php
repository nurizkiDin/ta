<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\user;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Utama extends Controller {
    public function masuk(){
        return view('masuk');
    }

    public function daftar(){
        return view('baru');
    }

    public function inputData(){
        $namaUser = Session::get('nama_user');
        if (!$namaUser) {
            return redirect('/masuk');
        }
        return view('inputData');
    }
    
    public function edit(){
        $namaUser = Session::get('nama_user');
        if (!$namaUser) {
            return redirect('/masuk');
        }
        return view('editUser');
    }

    public function userBaru(Request $req) {
        $this->validate($req, [
            'username' => 'required|unique:App\user,username',
            'usia' => 'required',
            'password' => 'required'
        ],[
            'username.unique' => 'Username sudah ada, silahkan coba yang lain',
            'username.required' => 'Username tidak boleh kosong',
            'password.required' => 'Password tidak boleh kosong',
            'usia.required' => 'Usia tidak boleh kosong'
        ]);
        DB::table('tbl_user')->insert([
            'username' => $req->username,
            'nama' => $req->nama,
            'jenis_kelamin' => $req->jenis_kelamin,
            'usia' => $req->usia,
            'password' => $req->password
        ]);
        return redirect('/masuk');
    }

    public function editUser(Request $req) {
        $this->validate($req, [
            'usia' => 'required',
        ],[
            'usia.required' => 'Usia tidak boleh kosong'
        ]);
        $namaUser = Session::get('nama_user');

        DB::table('tbl_user')->where('username', $namaUser)->update([
            'nama' => $req->nama,
            'jenis_kelamin' => $req->jenis_kelamin,
            'usia' => $req->usia
        ]);
        return redirect('/edit_user');
    }

    public function keUser(Request $req) {
        $this->validate($req, [
            'username' => 'required',
            'password' => 'required'
        ],[
            'username.required' => 'Username tidak boleh kosong',
            'password.required' => 'Password tidak boleh kosong'
        ]);
        $user = DB::table('tbl_user')->where('username', $req->username)->first();
        if (!$user) {
            return redirect('/masuk')->withErrors('Gagal login, cek username dan password');
        } else {
            if ($user->password == $req->password) {
                Session::put('nama_user', $user->username);
                return redirect('/');
            } else {
                return redirect('/masuk')->withErrors('Gagal login, cek username dan password');
            }
        }
    }

    public function keluar() {
        Session::forget('nama_user');
        return redirect('/masuk');
    }
}