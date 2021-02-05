<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission_4-7</title>
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
       
       $id = 1; //変更する投稿番号
       $name = "小嶋元太";
       $comment = "うな重食べたい"; 
       $sql = 'UPDATE tbtest SET name=:name,comment=:comment WHERE id=:id';
       $stmt = $pdo->prepare($sql);
       $stmt->bindParam(':name', $name, PDO::PARAM_STR);
       $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
       $stmt->bindParam(':id', $id, PDO::PARAM_INT);
       $stmt->execute();
       
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