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
        $dataUji = DB::table('tbl_uji')->where('dokname')->get();
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
            <a href="/lab" class="button-active">Input Uji Variabel</a>
            <a href="/lab/edit">Edit Uji</a>
            <a href="/lab/hasil">Hasil Uji</a>
            <a href="/lab/keluarLab" class="button-lab">Keluar</a>
        </aside>
        <section>
            <div class="kriteriaLab">
                <h2>Kriteria Nilai Variabel Uji</h2>
                <h3>Usia</h3>
                <p>&raquo; Tua &ensp; &raquo; Dewasa &ensp; &raquo; Muda</p>
                <h3>Jenis Rabun</h3>
                <p>&raquo; Hipermetropi &ensp; &raquo; Miopi</p>
                <h3>Astigmatism</h3>
                <p>&raquo; Tidak Silinder &ensp; &raquo; Silinder</p>
                <h3>Tingkat Produksi Air Mata</h3>
                <p>&raquo; Normal &ensp; &raquo; Air Mata Berkurang</p>
                <h3>Jenis Lensa</h3>
                <p>&raquo; Tanpa Kontak Lensa &ensp; &raquo; Soft Lens &ensp; &raquo; Hard Lens</p>
                <br>
                <form action="/lab/data" method="post" enctype="multipart/form-data">
                    <input type="file" name="csvData">
                    <button type="submit" id="login-btn" style="padding: 5px;">SIMPAN</button>
                </form>
                <?php
                foreach($errors->all() as $error) {
                    echo "<p style=\"color: #f00;font-size: 0.8em;\">{$error}</p>";
                }
                if(session('success')) {
                    echo "<p style=\"color: #0f0;font-size: 1.5em;\">".session('success')."</p>";
                }
                ?>
            </div>
        </section>
    </main>
    <footer>&copy; Nurizki &ndash; 1744190043</footer>
</body>
</html>