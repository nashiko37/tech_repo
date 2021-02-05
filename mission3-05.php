<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission_3-05</title>
    </head>
    <body>
        <?php
        //関数
        //PW
        function checkPW($truePW, $inputPW){
            if($truePW == $inputPW){
                return true;
            }else{
                echo "パスワードが違います。<br>";
                return false;
            }
        }
        //投稿番号
       function countNum($log){
           if(file_exists($log)){
               $num = count(file($log))+1;
           }else{
               $num=1;
           }
           return $num;
       }
       
       //ファイルの上書き
       function overWrite($fp, $lines, $delNum){
           foreach($lines as $line){
               $words=explode("<>",$line);
               if($words[0]!=$delNum){
                   fwrite($fp, $line.PHP_EOL);
               }
           }
       }
      
       //投稿
       function postComment($log,$filename,$text){
           $num=countNum($log);
           $text = $num . "<>" . $text;
           $lines=file($filename, FILE_IGNORE_NEW_LINES);
           $lp =fopen($log,"a");
           $fp = fopen($filename, "w");
           overWrite($fp,$lines,-1);
           //addText($lp,$fp,$num,$text);
           fwrite($lp,$text.PHP_EOL);
           fwrite($fp,$text.PHP_EOL);
           fclose($lp);
           fclose($fp);
       }
       //削除
       function deleteComment($filename, $delNum){
           $lines=file($filename, FILE_IGNORE_NEW_LINES);
           $fp = fopen($filename, "w");
           overWrite($fp,$lines,$delNum);
           fclose($fp);
       }
       //編集する行の取り出し
       function selectComment($log,$filename, $editNum){
           $lines = file($log, FILE_IGNORE_NEW_LINES);
           $editWords=explode("<>",$lines[$editNum-1]);
           return $editWords;
       }
       //編集
       function editComment($log,$filename,$editNum,$text){
           $text = $editNum."<>".$text;
           $lines0 = file($log, FILE_IGNORE_NEW_LINES);
           $lines = file($filename, FILE_IGNORE_NEW_LINES);
           $fp0 = fopen($log, "w");
           $fp = fopen($filename,"w");
           
           foreach($lines0 as $line0){
               $words = explode("<>",$line0);
               if($words[0]!=$editNum){
                   fwrite($fp0, $line0.PHP_EOL);
               }else{
                   fwrite($fp0, $text."(編集)".PHP_EOL);
               }
           }
           fclose($fp0);
           
           foreach($lines as $line){
               $words = explode("<>",$line);
               if($words[0]!=$editNum){
                   fwrite($fp, $line.PHP_EOL);
               }else{
                   fwrite($fp, $text.PHP_EOL);
               }
           }
           fclose($fp);
       }
       
       //ファイルの中身をブラウザに表示
       function display($filename){
           $lines=file($filename, FILE_IGNORE_NEW_LINES);
           foreach($lines as $line){
               $words=explode("<>",$line);
               foreach($words as $word){
                   echo $word . " ";
               }
               echo "<br>";
           }
       }
        
        ?>
        <?php
        $log = "mission_3-5_log.txt";
        $filename = "mission_3-5.txt";
        $truePW = "12345";
        if(!empty($_POST["editNum"]) && checkPW($truePW, $_POST["editPW"])){
           $editNum = $_POST["editNum"];
           $editWords=selectComment($log,$filename, $editNum);
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
            *****************************************
        </form>
       <?php
       
       //*******************************
       //削除
       if(!empty($_POST["delNum"]) && checkPW($truePW, $_POST["delPW"])){
           $delNum=$_POST["delNum"];
           deleteComment($filename,$delNum);
       }
       
       if(!empty($_POST["name"]&&$_POST["comment"]) && checkPW($truePW, $_POST["postPW"])){
           //フォームからPOST送信＆受け取り
           $date = date("Y/m/d H:i:s");
           $name = $_POST["name"];
           $comment = $_POST["comment"];
           //$password = 
           $hiddenNum = $_POST["hiddenNum"];
           $text = $name."<>".$comment."<>".$date;
           
           if($hiddenNum==-1){
               postComment($log,$filename,$text);
           }else{
               editComment($log,$filename,$hiddenNum,$text); 
           }
           
       }
       display($filename);

       ?>
    </body>
</html>