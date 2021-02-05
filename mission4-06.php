<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission_4-6</title>
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
       
       //全てのデータを表示
       /*
       $sql = 'SELECT * FROM tbtest';
       $stmt = $pdo->query($sql);
       $results = $stmt->fetchAll();
       foreach ($results as $row){
           //$rowの中にはテーブルのカラム名が入る
           echo $row['id'].',';
           echo $row['name'].',';
           echo $row['comment'].'<br>';
           echo "<hr>";
       }*/
       $id = 1;
       $sql = 'SELECT * FROM tbtest WHERE id=:id';
       $stmt = $pdo->prepare($sql);
       $stmt->bindParam(':id', $id, PDO::PARAM_INT);
       $stmt->execute();
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