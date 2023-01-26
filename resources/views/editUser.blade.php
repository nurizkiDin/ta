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
            <a href="/">Input Data Variabel</a>
            <a href="/edit_user" class="button-active">Edit User</a>
            <a href="/edit">Edit Data</a>
            <a href="/hasil">Hasil</a>
            <a href="/keluar" style="color: #f00;">Keluar</a>
        </aside>
        <section>
            <div>
            <h3 class="nameTag"><?php echo $dataUser[0]->username;?></h3>;
                <div class="editUser">
                    <?php
                        foreach ($dataUser as $dt) {
                            echo "
                            <form action=\"/edit_user/edit\" method=\"post\">
                                <table cellspacing=0>
                                <tr>
                                    <td>Nama </td>
                                    <td>
                                        : <input type=\"text\" name=\"nama\" value=\"$dt->nama\">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Jenis Kelamin </td>
                                    <td>
                                        : <input type=\"text\" name=\"jenis_kelamin\" value=\"$dt->jenis_kelamin\">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Usia </td>
                                    <td>
                                        : <input type=\"text\" name=\"usia\" value=\"$dt->usia\">
                                    </td>
                                </table>  
                                <button type=\"submit\" class=\"btn-smt\">Simpan</button>
                            </form>";
                        }
                        foreach($errors->all() as $error) {
                            echo "<p style=\"color: #f00;font-size: 0.8em;\">{$error}</p>";
                        }
                    ?>
                </div>
            </div>
        </section>
    </main>
    <footer>&copy; Nurizki &ndash; 1744190043</footer>
</body>
</html>