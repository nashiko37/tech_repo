<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission_4-8</title>
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
       
       
       //テーブル削除
       $sql = 'DROP TABLE tbtest';
       $stmt = $pdo->query($sql);
       
       //表示
       $sql = 'SELECT * FROM tbtest';
       $stmt = $pdo->query($sql);
       $results = $stmt->fetchAll();
       foreach ($results as $row){
           //$rowの中にはテーブルのカラム名が入る
           echo $row['id'].',';
           echo $row['name'].',';
           echo $row['comment'].'<br>';
           echo "<hr>";
       }
       ?>
    </body>
</html>