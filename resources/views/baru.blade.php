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
    <header>
        <h1>Diagnosis Nilai Kerabunan Mata</h1>
        <nav>
            <ul type="none">
                <li><a href="/" class="button-active">Pengecekan</a></li>
                <li><a href="/lab">Lab Uji</a></li>
            </ul>
        </nav>
    </header>
    <div id="login">
        <a href="/masuk">Masuk</a>
        <a href="/daftar">User Baru</a>
        <form id="formLogin" action="/daftar/baru" method="post">
            <input type="text" id="namaUser" name="username" placeholder="Username">
            <input type="text" name="nama" placeholder="nama">
            <select name="jenis_kelamin" style="text-align: center;">
                <optgroup label="Jenis Kelamin">
                    <option value="Pria">Pria</option>
                    <option value="Wanita">Wanita</option>
                    <option value="" selected>&ndash;&ndash;</option>
                </optgroup>
            </select>
            <input type="number" min="1" name="usia" placeholder="Usia">
            <input type="password" id="sandiUser" name="password" placeholder="Password">
            <button type="submit" id="login-btn">Daftar</button>
        </form>
        <?php
        foreach($errors->all() as $error) {
            echo "<p style=\"color: #f00;font-size: 0.8em;\">{$error}</p>";
        }
        ?>
    </div>
    <main>
        <aside style="filter: blur(5px);">
            <a href="#" class="button-active" style="pointer-events: none;">Input Data Variabel</a>
            <a href="#" style="pointer-events: none;">Edit Data</a>
            <a href="#" style="pointer-events: none;">Hasil</a>
            <a href="#" style="pointer-events: none;color: #f00;">Keluar</a>
        </aside>
    </main>
    <footer>&copy; Nurizki &ndash; 1744190043</footer>
</body>
</html>