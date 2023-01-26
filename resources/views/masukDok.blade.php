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
                <li><a href="/">Pengecekan</a></li>
                <li><a href="/lab" class="button-active">Lab Uji</a></li>
            </ul>
        </nav>
    </header>
    <div id="login">
        <form id="formLogin" action="/masukLab/dok" method="post">
            <input type="text" id="namaUser" name="dokname" placeholder="Admin" style="height: 40px;">
            <input type="password" id="sandiUser" name="password" placeholder="Password" style="height: 40px;">
            <button type="submit" id="login-btn">Masuk</button>
        </form>    
        <?php
        foreach($errors->all() as $error) {
            echo "<p style=\"color: #f00;font-size: 0.8em;\">{$error}</p>";
        }
        ?>
    </div>
    <main>
        <section>
            <div id="chart_div" class="divLab"></div>
        </section>
    </main>
    <footer>&copy; Nurizki &ndash; 1744190043</footer>
</body>
</html>