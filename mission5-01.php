<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission_5-1</title>
    </head>
    <body>
       <?php
       //関数 
       //DB接続設定
       function connectDB(){
           //echo "接続開始<br>";
           $dsn = 'mysql:dbname=DBNAME;host=localhost';
           $user = 'USERNAME';
           $password = 'PASSWORD';
           $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
           //echo "接続終了<br>";
           return $pdo;
       }
       //テーブルを作成
       function createTB($pdo,$tbtest){
           $sql = "CREATE TABLE IF NOT EXISTS ". $tbtest
           ." ("
           . "id INT AUTO_INCREMENT PRIMARY KEY,"
           . "name char(32),"
           . "comment TEXT"
           .");";
           $stmt = $pdo->query($sql);
            //return $stmt;
       }
       //テーブルの一覧を表示
       function showTBList($pdo){
          $sql ='SHOW TABLES';
          $result = $pdo -> query($sql);
          foreach ($result as $row){
              echo $row[0];
              echo '<br>';
          }
          echo "<hr>"; 
        }
        //テーブルの構成詳細
        function showTBCon($pdo,$tbtest){
            $sql ='SHOW CREATE TABLE ' . $tbtest;
            $result = $pdo -> query($sql);
            foreach ($result as $row){
                echo $row[1];
            }
            echo "<hr>";
        }
        //テーブル削除
        function deleteTB($pdo,$tbtest){
            $sql = 'DROP TABLE ' . $tbtest;
            echo $sql . "<br>";
            $stmt = $pdo->query($sql);
        }
        //データ入力
        function insert($pdo,$tbtest,$name,$comment){
            $sql = $pdo -> prepare("INSERT INTO " . $tbtest . " (name, comment) VALUES (:name, :comment)");
            $sql -> bindParam(':name', $name, PDO::PARAM_STR);
            $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
            $sql -> execute();
        }
        //データ編集
        function edit($pdo,$tbtest,$num,$name,$comment){
            $id = $num; //変更する投稿番号
            $sql = 'UPDATE '. $tbtest . ' SET name=:name,comment=:comment WHERE id=:id';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        }
        //削除
        function del($pdo,$tbtest,$num){
            $id = $num;
            $sql = 'delete from ' . $tbtest . ' where id=:id';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        }
        //編集の取り出し
        function select($pdo,$tbtest,$editNum){
            $id = $editNum;
            $sql = 'SELECT * FROM tbtest WHERE id=:id ';
            $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
            $stmt->bindParam(':id', $id, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定してから、
            $stmt->execute();                             // ←SQLを実行する。
            $results = $stmt->fetchAll(); 
            foreach ($results as $row){
                //$rowの中にはテーブルのカラム名が入る
                $editWords = array($row['id'], $row['name'],$row['comment']);
            }
            return $editWords;
        }
        //表示
        function show($pdo,$tbtest){
            $sql = 'SELECT * FROM '. $tbtest;
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            echo "<br>*******投稿一覧********************<br>";
            foreach ($results as $row){
                //$rowの中にはテーブルのカラム名が入る
                echo $row['id'].',';
                echo $row['name'].',';
                echo $row['comment'].'<br>';
                echo "<hr>";
            }
        }
        //*********************************************
        //PW
        function checkPW($truePW, $inputPW){
            if($truePW == $inputPW){
                return true;
            }else{
                return false;
            }
        }
        ?>
        <?php
        $tbtest = 'tbtest';
        $truePW = "*****";
        $pdo = connectDB();
        createTB($pdo,$tbtest);
        //showTBList($pdo,$tbtest);
        
        //*****************************
        
        if(!empty($_POST["editNum"]) && checkPW($truePW, $_POST["editPW"])){
           $editNum = $_POST["editNum"];
           $editWords = select($pdo,$tbtest,$editNum);
           $editName = $editWords[1];
           $editComment = $editWords[2];
        }else{
           $editNum=-1;
        }
        ?>
        <form action = "" method="post">
            【投稿フォーム】<br>
            お名前 : <input type="text" name="name"
            value = "<?php if($editNum!=-1){echo $editName;} ?>";
            placeholder="名前"><br>
            コメント：<input type="text" name="comment"
            value = "<?php if($editNum!=-1){echo $editComment;} ?>";
            placeholder = "コメント"><br>
            パスワード：<input type="password" name="postPW"
            placeholder = "パスワード"><br>
            <input type="hidden" name="hiddenNum"
            value = "<?php echo $editNum ?>">
            <input type="submit" name="submit">
            <br><br>
            【削除フォーム】<br>
            削除番号：<input type="number" name="delNum"
            placeholder = "削除番号"><br>
            パスワード：<input type="password" name="delPW"
            placeholder = "パスワード"><br>
            <input type="submit" name="削除"><br>
            
            <br>
            【編集フォーム】<br>
            編集番号：<input type="number" name="editNum"
            placeholder = "編集番号"><br>
            パスワード：<input type="password" name="editPW"
            placeholder = "パスワード"><br>
            <input type="submit" name="編集"><br>
        </form>
        <?php
        if(!empty($_POST["delNum"]) && checkPW($truePW, $_POST["delPW"])){
           $delNum=$_POST["delNum"];
           del($pdo,$tbtest,$delNum);
       }
       
       if(!empty($_POST["name"]&&$_POST["comment"]) && checkPW($truePW, $_POST["postPW"])){
           //フォームからPOST送信＆受け取り
           $date = date("Y/m/d H:i:s");
           $name = $_POST["name"];
           $comment = $_POST["comment"];
           $hiddenNum = $_POST["hiddenNum"];
           $text = $name."<>".$comment."<>".$date;
           
           if($hiddenNum==-1){
               insert($pdo,$tbtest,$name,$comment);
           }else{
               edit($pdo,$tbtest,$hiddenNum,$name,$comment);
           }
           
       }
        //showTBCon($pdo,$tbtest);
        show($pdo,$tbtest);
        //deleteTB($pdo,$tbtest);
        //showTBList($pdo,$tbtest);
       ?>
    </body>
</html>