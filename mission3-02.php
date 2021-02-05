<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission_3-02</title>
    </head>
    <body>
       <form action = "" method="post">
           お名前 : <input type="text" name="name"
           required = "required"
           placeholder="入力してください">
           <br>
           コメント：<input type="text" name="str"
           required = "required"
           placeholder = "入力してください">
           <br>
           <input type="submit" name="submit">
       </form>
       <?php
       if(!empty($_POST["name"]&&$_POST["str"])){
           $filename = "mission_3-2.txt";
           //新たな投稿番号設定（テキストファイルより）
           if(file_exists($filename)){
               $comments = file($filename, FILE_IGNORE_NEW_LINES);
           }
            $num=1;
            //1行ごとに改行してnumをカウント
            foreach($comments as $comment){
                $num++;
            }
            
           //フォームからPOST送信＆受け取り
           $date = date("Y/m/d H:i:s");
           $name = $_POST["name"];
           $str = $_POST["str"];
           $comments[$num] = $str;
           
           //テキスト保存
           $fp = fopen($filename, "a");
           $msg = $num."<>".$name."<>".
           $str."<>".$date;
           fwrite($fp,$msg . PHP_EOL);
           fclose($fp);
       }
       //ファイル読み込み&PHPで配列にする
       if(file_exists($filename)){
           $comments = file($filename, FILE_IGNORE_NEW_LINES);
       }
       //1行ごとに改行してブラウザに表示
       foreach($comments as $comment){
           $displays=explode("<>",$comment);
           foreach($displays as $display){
               echo $display . " ";
           }
           echo "<br>";
       }
       ?>
    </body>
</html>