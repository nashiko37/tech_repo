<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission_2-04</title>
    </head>
    <body>
        
       <form action = "" method="post">
           <input type="text" name="str"
           value="コメント"
           required = "required"
           placeholder = "入力してください">
           <input type="submit" name="submit">
       </form>
       <?php
       if(!empty($_POST["str"])){
           //フォームからPOST送信＆受け取り
           $str = $_POST["str"];
           echo $str . "を受け付けしました。<br>";
           //テキスト保存
           $filename = "mission_2-4.txt";
           $fp = fopen($filename, "a");
           fwrite($fp,$str . PHP_EOL);
           fclose($fp);
           
           //ファイル読み込み&PHPで配列にする
           if(file_exists($filename)){
               $comments = file($filename, 
               FILE_IGNORE_NEW_LINES);
           }
           //1行ごとに改行してブラウザに表示
           foreach($comments as $comment){
               echo $comment . "<br>";
           }
           /*
           for($i=0; $i<3; $i++){
               echo $comments[$i]."<br>";
           }*/
           
           //条件分岐
           if($str == "完成！"){
               echo "おめでとう！<br>";
           }
       }
       ?>
    </body>
</html>