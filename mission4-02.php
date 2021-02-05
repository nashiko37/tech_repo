<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission_4-2</title>
    </head>
    <body>
       <?php
       echo "接続開始<br>";
       //DB接続設定
       $dsn = 'mysql:dbname=DBNAME;host=localhost';
       $user = 'USERNAME';
       $password = 'PASSWORD';
       $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
       echo "接続終了<br>";
       
       $sql = "CREATE TABLE IF NOT EXISTS tbtest"
       ." ("
       . "id INT AUTO_INCREMENT PRIMARY KEY,"
       . "name char(32),"
       . "comment TEXT"
       .");";
       $stmt = $pdo->query($sql);
       ?>
    </body>
</html>