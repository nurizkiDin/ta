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
        $user = DB::table('tbl_user')->where('username', $namaUser)->get();
        $dataUser = DB::table('data_variabel')->where('username', $namaUser)->get();
        $dataUji = DB::table('tbl_uji')->get();
        $hasil = DB::table('tbl_hasil')->where('username', $namaUser)->first();
        //tambah nilai tbl_hasil
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
            <a href="/edit_user">Edit User</a>
            <a href="/edit">Edit Data</a>
            <a href="/hasil" class="button-active">Hasil</a>
            <a href="/keluar" style="color: #f00;">Keluar</a>
        </aside>
        <section>
            <div>
                <div class="nameTag">
                    <?php
                        foreach ($user as $dt) {
                            echo "<h3>$dt->username</h3>
                            <p>$dt->nama</p>
                            <p>$dt->jenis_kelamin</p>
                            <p>$dt->usia</p>";
                        }
                    ?>
                </div>
            </div>
            <div class="tampilChart">
                <div id="chartMataKanan" style="width:100%; max-width:600px; height:500px;"></div>
                <div id="chartMataKiri" style="width:100%; max-width:600px; height:500px;"></div>
            </div>
            <div class="tampilChart">
                <div id="chart_div" style="margin: 20px;"></div>
            </div>
            <div class="hasilDiagnosis">
                <table>
                    <tr>
                        <td>Gangguan Mata Tua</td>
                        <td> : <?php echo $hasil->presbiopi?></td>
                    </tr>
                    <tr>
                        <td>Gangguan Mata Kanan</td>
                        <td>
                             : <?php echo $hasil->kekuatan_lensa_kanan?> Dioptri
                            <?php 
                            if ($hasil->kekuatan_lensa_kanan>0.4) {
                               echo " / Hipermetropi";
                            }
                            if ($hasil->kekuatan_lensa_kanan>=-0.4 && $hasil->kekuatan_lensa_kanan<=0.4) {
                               echo " / Normal";
                            }
                            if ($hasil->kekuatan_lensa_kanan<-0.4) {
                               echo " / Miopi";
                            }
                             ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Gangguan Mata Kiri</td>
                        <td>
                             : <?php echo $hasil->kekuatan_lensa_kiri?> Dioptri
                            <?php 
                            if ($hasil->kekuatan_lensa_kiri>0.4) {
                               echo " / Hipermetropi";
                            }
                            if ($hasil->kekuatan_lensa_kiri>=-0.4 && $hasil->kekuatan_lensa_kiri<=0.4) {
                               echo " / Normal";
                            }
                            if ($hasil->kekuatan_lensa_kiri<-0.4) {
                               echo " / Miopi";
                            }
                            ?>
                        </td>
                    </tr>
                </table>
            </div>
        </section>
    </main>
    <footer>&copy; Nurizki &ndash; 1744190043</footer>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
        google.charts.load('current',{packages:['corechart']});
        google.charts.setOnLoadCallback(drawChartMataKanan);
        google.charts.setOnLoadCallback(drawChartMataKiri);
        var dataKanan = [];
        var dataKiri = [];
        var passedArray = <?php echo json_encode($dataUser) ?>;

        for (i=0;i<passedArray.length;i++){
            dataKanan.push([passedArray[i]['jarak_objek_cm'], 
            (passedArray[i]['terlihat_jelas_cm_kanan']/passedArray[i]['jarak_objek_cm'])*100]);
        }
        for (i=0;i<passedArray.length;i++){
            dataKiri.push([passedArray[i]['jarak_objek_cm'], 
            (passedArray[i]['terlihat_jelas_cm_kiri']/passedArray[i]['jarak_objek_cm'])*100]);
        }

        function drawChartMataKanan() {
            // Set Data
            const data = new google.visualization.DataTable();
            data.addColumn('number');
            data.addColumn('number', 'Normal');
            data.addColumn('number', 'Miopi');
            data.addColumn('number', 'Hipermetropi');

            for (i=0;i<dataKanan.length;i++){
                if ((dataKanan[i][1])==100) {
                    data.addRow([dataKanan[i][0], (dataKanan[i][1]), null, null]);
                }
                if ((dataKanan[i][1])<100) {
                    data.addRow([dataKanan[i][0], null, (dataKanan[i][1]), null]);
                }
                if ((dataKanan[i][1])>100) {
                    data.addRow([dataKanan[i][0], null, null, (dataKanan[i][1])]);
                }
                
            }
            // Set Options
            const options = {
                title: 'Statistik Uji Coba Mata Kanan',
                hAxis: {title: 'Jarak Objek (cm)', minValue: 0, maxValue: 600},
                vAxis: {title: 'Objek Terlihat', minValue: 0, maxValue: 200},
                legend: {position: 'bottom'},
                colors: ['#0f0', '#f00', '#ff0']
            };
            // Draw
            const chart = new google.visualization.ScatterChart(document.getElementById('chartMataKanan'));
            chart.draw(data, options);
        }

        function drawChartMataKiri() {
            // Set Data
            const data = new google.visualization.DataTable();
            data.addColumn('number');
            data.addColumn('number', 'Normal');
            data.addColumn('number', 'Miopi');
            data.addColumn('number', 'Hipermetropi');

            for (i=0;i<dataKiri.length;i++){
                if ((dataKiri[i][1])==100) {
                    data.addRow([dataKiri[i][0], (dataKiri[i][1]), null, null]);
                }
                if ((dataKiri[i][1])<100) {
                    data.addRow([dataKiri[i][0], null, (dataKiri[i][1]), null]);
                }
                if ((dataKiri[i][1])>100) {
                    data.addRow([dataKiri[i][0], null, null, (dataKiri[i][1])]);
                }
                
            }
            // Set Options
            const options = {
                title: 'Statistik Uji Coba Mata Kiri',
                hAxis: {title: 'Jarak Objek (cm)', minValue: 0, maxValue: 600},
                vAxis: {title: 'Objek Terlihat', minValue: 0, maxValue: 200},
                legend: {position: 'bottom'},
                colors: ['#0f0', '#f00', '#ff0']
            };
            // Draw
            const chart = new google.visualization.ScatterChart(document.getElementById('chartMataKiri'));
            chart.draw(data, options);
        }
    </script>
    <script>
        let tampung = <?php echo json_encode($dataUji)?>;
        // let usiaUser = <?php //foreach ($user as $dt) {echo $dt->usia;}?>;
        // var userDiagnosis = <?php //echo json_encode($dataUser) ?>;

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
        console.log(userDiagnosis)
    </script>
    <script src="/js/pohonData.js"></script>
</body>
</html>
