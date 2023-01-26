<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diagnosis Mata</title>
    <link rel="stylesheet" href="/style/style.css">
</head>
<body>
    <?php
        use Illuminate\Support\Facades\Session;
        use Illuminate\Support\Facades\DB;
        $namaUser = Session::get('nama_user');
        $dataUser = DB::table('tbl_user')->where('username', $namaUser)->get();
    ?>
    <header>
        <h1>Diagnosis Nilai Kerabunan Mata</h1>
        <nav>
            <ul type="none">
                <li><a href="/" class="button-active">Pengecekan</a></li>
                <li><a href="/lab">Lab Uji</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <aside>
            <a href="/" class="button-active">Input Data Variabel</a>
            <a href="/edit_user">Edit User</a>
            <a href="/edit">Edit Data</a>
            <a href="/hasil">Hasil</a>
            <a href="/keluar" style="color: #f00;">Keluar</a>
        </aside>
        <section>
            <div>
                <div class="nameTag">
                    <?php
                        foreach ($dataUser as $dt) {
                            echo "<h3>$dt->username</h3>
                            <p>Nama : $dt->nama</p>
                            <p>Jenis Kelamin : $dt->jenis_kelamin</p>
                            <p>Usia : $dt->usia</p>";
                        }
                    ?>
                </div>
            </div>
            <div class="divInput">
                <form action="/data" method="post">
                    <table>
                        <tr>
                            <td>Jarak Objek (cm)</td>
                            <td>Terlihat Jelas [Kanan] (cm)</td>
                            <td>Terlihat Jelas [Kiri] (cm)</td>
                        </tr>
                        <tr>
                            <td><input type="text" name="jarak_objek[]" value="25" disabled></td>
                            <td><input type="text" name="terlihat_jelas_cm_kanan[]"></td>
                            <td><input type="text" name="terlihat_jelas_cm_kiri[]"></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="jarak_objek[]" value="50"  disabled></td>
                            <td><input type="text" name="terlihat_jelas_cm_kanan[]"></td>
                            <td><input type="text" name="terlihat_jelas_cm_kiri[]"></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="jarak_objek[]" value="100"  disabled></td>
                            <td><input type="text" name="terlihat_jelas_cm_kanan[]"></td>
                            <td><input type="text" name="terlihat_jelas_cm_kiri[]"></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="jarak_objek[]" value="200"  disabled></td>
                            <td><input type="text" name="terlihat_jelas_cm_kanan[]"></td>
                            <td><input type="text" name="terlihat_jelas_cm_kiri[]"></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="jarak_objek[]" value="300"  disabled></td>
                            <td><input type="text" name="terlihat_jelas_cm_kanan[]"></td>
                            <td><input type="text" name="terlihat_jelas_cm_kiri[]"></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="jarak_objek[]" value="400"  disabled></td>
                            <td><input type="text" name="terlihat_jelas_cm_kanan[]"></td>
                            <td><input type="text" name="terlihat_jelas_cm_kiri[]"></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="jarak_objek[]" value="500"  disabled></td>
                            <td><input type="text" name="terlihat_jelas_cm_kanan[]"></td>
                            <td><input type="text" name="terlihat_jelas_cm_kiri[]"></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="jarak_objek[]" value="600"  disabled></td>
                            <td><input type="text" name="terlihat_jelas_cm_kanan[]"></td>
                            <td><input type="text" name="terlihat_jelas_cm_kiri[]"></td>
                        </tr>
                    </table>
                    <button type="submit" class="btn-smt">Simpan</button>
                </form>
                <?php
                foreach($errors->all() as $error) {
                    echo "<p style=\"color: #f00;font-size: 0.8em;\">{$error}</p>";
                }
                ?>
            </div>
        </section>
    </main>
    <footer>&copy; Nurizki &ndash; 1744190043</footer>
</body>
</html>