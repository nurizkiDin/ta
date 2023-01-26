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

        $namaDok = Session::get('nama_dokter');
        $dataUji = DB::table('tbl_uji')->where('dokname', $namaDok)->get();
        if (sizeof($dataUji)==null) {
            echo redirect('/lab');
        }
    ?>
    <header>
        <h1>Diagnosis Nilai Kerabunan Mata</h1>
        <nav>
            <ul type="none">
                <li><a href="/">Pengecekan</a></li>
                <li><a href="/lab" class="button-active">Lab Uji</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <aside>
            <a href="/lab">Input Uji Variabel</a>
            <a href="/lab/edit" class="button-active">Edit Uji</a>
            <a href="/lab/hasil">Hasil Uji</a>
            <a href="/lab/keluarLab" class="button-lab">Keluar</a>
        </aside>
        <section>
            <div class="divLab">
                <form action="/lab/edit/data" method="post">
                    <table cellspacing="0" cellpadding="0">
                        <tr style="background-color: rgb(20, 220, 145);">
                            <th>Usia</th>
                            <th>Jenis Rabun</th>
                            <th>Astigmatism</th>
                            <th>Tingkat Produksi Air Mata</th>
                            <th>Jenis Lensa</th>
                        </tr>
                        <?php
                        foreach($dataUji as $dt) {
                            echo "
                            <tr>
                                <td><input type=\"text\" name=\"usia[]\" value=\"{$dt->usia}\"></td>
                                <td><input type=\"text\" name=\"jenis_rabun[]\" value=\"{$dt->jenis_rabun}\"></td>
                                <td><input type=\"text\" name=\"astigmatism[]\" value=\"{$dt->astigmatism}\"></td>
                                <td><input type=\"text\" name=\"tingkat_prod_airMata[]\" value=\"{$dt->tingkat_prod_airMata}\"></td>
                                <td><input type=\"text\" name=\"jenis_lens[]\" value=\"{$dt->jenis_lens}\"></td>
                            </tr>
                            ";
                        }
                        ?>
                    </table>
                    <button type="submit" class="btn-smt">Simpan</button>
                </form>
                <?php
                foreach($errors->all() as $error) {
                    echo "<p style=\"color: #f00;font-size: 0.8em;\">{$error}</p>";
                }
                ?>
                <form action="/lab/edit/hapus" method="post">
                    <table cellpadding=0 cellspacing=0>
                        <tr>
                            <th style="border: none;padding:4px;">Hapus Data</th>
                        </tr>
                        <?php
                        foreach($dataUji as $dt) {
                            echo "
                            <tr>
                                <td>
                                    <input type=\"submit\" class=\"btn-hapusUji\" name=\"id_uji\" value=\"{$dt->id_uji}\">
                                </td>
                            </tr>
                            ";
                        }
                        ?>
                    </table>
                </form>
            </div>
        </section>
    </main>
    <footer>&copy; Nurizki &ndash; 1744190043</footer>
</body>
</html>