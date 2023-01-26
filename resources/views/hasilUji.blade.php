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
        $dataUji = DB::table('tbl_uji')->get();
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
            <a href="/lab/edit">Edit Uji</a>
            <a href="/lab/hasil" class="button-active">Hasil Uji</a>
            <a href="/lab/keluarLab" class="button-lab">Keluar</a>
        </aside>
        <section>
        <section>
            <div id="chart_div" style="margin: 20px;"></div>
        </section>
    </main>
    <footer>&copy; Nurizki &ndash; 1744190043</footer>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
        let tampung = <?php echo json_encode($dataUji)?>;
        var arr = [];
        for (let i=0;i<tampung.length;i++) {
            arr[i] = [
                tampung[i]['usia'],
                tampung[i]['jenis_rabun'],
                tampung[i]['astigmatism'],
                tampung[i]['tingkat_prod_airMata'],
                tampung[i]['jenis_lens'],
            ]
        }
    </script>
    <script src="/js/pohonData.js"></script>
</body>
</html>