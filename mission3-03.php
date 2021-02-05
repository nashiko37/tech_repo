<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission_3-03</title>
    </head>
    <body>
       <form action = "" method="post">
           お名前 : <input type="text" name="name"
           placeholder="名前">
           <br>
           コメント：<input type="text" name="comment"
           placeholder = "コメント">
           <input type="submit" name="submit">
           <br><br>
           削除番号：<input type="number" name="delNum"
           placeholder = "削除番号">
           <input type="submit" name="削除">
       </form>
       <?php
       //h()定義
       function h($str){
           return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
       }
       
       //投稿番号
       function countNum($filename0){
           if(file_exists($filename0)){
               $num = count(file($filename0))+1;
           }else{
               $num=1;
           }
           return $num;
       }
       //ファイル読み込み&PHPで配列にする
       function readLines($filename){
           if(file_exists($filename)){
               $lines = file($filename, FILE_IGNORE_NEW_LINES);
               return $lines;
           }
       }
       //ファイルの上書き
       function rewrite($fp, $lines, $delNum){
           foreach($lines as $line){
               $words=explode("<>",$line);
               if($words[0]!=$delNum){
                   fwrite($fp, $line.PHP_EOL);
               }
           }
       }
       //追加
       function addText($fp0,$fp,$num,$name,$comment,$date){
           $text = $num."<>".$name."<>".$comment."<>".$date;
           fwrite($fp0,$text.PHP_EOL);
           fwrite($fp,$text . PHP_EOL);
           
       }
       //ファイル生成
       function makeFile($filename0,$filename,$num,$name,$comment,$date){
           $lines=readLines($filename);
           $fp0 =fopen($filename0,"a");
           $fp = fopen($filename, "w");
           rewrite($fp,$lines,-1);
           addText($fp0,$fp,$num, $name, $comment, $date);
           fclose($fp);
       }
       //削除
       function deleteFile($filename, $delNum){
           $lines=readLines($filename);
           $fp = fopen($filename, "w");
           rewrite($fp,$lines,$delNum);
           fclose($fp);
       }
       
       //ファイルの中身をブラウザに表示
       function display($filename){
           $lines=readLines($filename);
           foreach($lines as $line){
               $words=explode("<>",$line);
               foreach($words as $word){
                   echo $word . " ";
               }
               echo "<br>";
           }
       }
       //*******************************
       $filename0 = "mission_3-3-1.txt";
       $filename = "mission_3-3.txt";
       $num=countNum($filename0);
       //削除
       if(!empty($_POST["delNum"])){
           $delNum=h($_POST["delNum"]);
           deleteFile($filename,$delNum);
       }
       //投稿
       if(!empty($_POST["name"]&&$_POST["comment"])){
           //フォームからPOST送信＆受け取り
           $date = date("Y/m/d H:i:s");
           $name = h($_POST["name"]);
           $comment = h($_POST["comment"]);
           makeFile($filename0,$filename,$num,$name,$comment,$date);
       }
       display($filename);
       ?>
    </body>
</html>