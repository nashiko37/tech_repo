<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission_4-5</title>
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
       
       $sql = $pdo -> prepare("INSERT INTO tbtest (name, comment) VALUES (:name, :comment)");
       $sql -> bindParam(':name', $name, PDO::PARAM_STR);
       $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
       $name = '（服部平次）';
       $comment = '（なんやて）'; 
       $sql -> execute();
       ?>
    </body>
</html>