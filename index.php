<?php
    $dbhost = 'localhost'; $dbuser = ''; $dbpass = '';
    $lines_array = file("/home1/machines/pw");
    foreach($lines_array as $line) { $dbpass = trim($line); }
    $lines_array = file("/home1/machines/un");
    foreach($lines_array as $line) { $dbuser = trim($line); }

    $conn = mysqli_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql');
    $dbname = 'machines_organizedthought';
    if (!$link = mysqli_connect($dbhost, $dbuser, $dbpass)) {
      echo 'Could not connect to mysql';
      exit;
    }
    if (!mysqli_select_db($link, $dbname)) {
      echo 'Could not select database, big problem'; exit;
    }
   
    function get_bundle($link){ 

        $sql = "select title1, url1, img1, title2, url2, img2 from bvid order by RAND() limit 1;";
        $res = mysqli_query($link, $sql);
    
        if (!$res){
          echo "DB Error, could not query the database\nMySQL Error:";
          echo mysqli_error(); exit();
        }
        while ($result = mysqli_fetch_assoc($res)){
            $title1 = $result["title1"];
            $url1 = $result["url1"];
            $img1 = $result["img1"];
            $title2 = $result["title2"];
            $url2 = $result["url2"];
            $img2 = $result["img2"];
        }

        $html_payload = '<table border=1><tr><td>';
        $html_payload .= "<h3>" . $title1 . "</h3>";
        $html_payload .= '<a href="' . $url1 . '">' . $url1 . '</a><br><br>';
        $html_payload .= '<img border=2 src="images/' . $img1  . '" width=600 /><br>';

        $html_payload .= '<form name="increment_form" action="post_increment.php" method="post">';
        $html_payload .= '    <input size=10 type="hidden" name="url_text1" value="' . $url1 . '">';
        $html_payload .= '    <input size=10 type="hidden" name="url_text2" value="' . $url2 . '">';
        $html_payload .= '    <input type="submit" class="button" name="url1" value="This one"/>';
        $html_payload .= '</form>';

        $html_payload .= '<br>';

        $html_payload .= '</td><td>';

        $html_payload .= "<h3>" . $title2 . "</h3>";
        $html_payload .= '<a href="' . $url2 . '">' . $url2 . '</a><br><br>';
        $html_payload .= '<img border=2 src="images/' . $img2  . '" width=600 /><br>';
        $html_payload .= '<div align=center><input type="submit" class="button" name="url1" value="This one"/></div><br>';
        $html_payload .= '<br>';
        $html_payload .= '</td></tr></table>';
        return $html_payload;
    }

    function increment_youtube_url($link){

        $sql = "update bvid set votes = votes+1 where 1=1";
        echo $sql;

        #mysqli_query($link, $sql);
    }
    //function increment_youtube_url($link, $url1, $url2){
    //    $sql = "update bvid set votes = votes+1 " .
    //         "where url1 = '" . $url1 . "' and url2 = '" . $url2 . "';";
    //    mysqli_query($link, $sql);
    //}


?>

<br><br><br>

<table border=0><tr><td>

<h1 align=center>Which youtube link is better?</h1>

<?php echo get_bundle($link); ?>

<br>
<br>

Submit a youtube url:<br>
<br>

<form name="increment_form" action="post_increment.php" method="post">
    <input size=100 type="text" name="url_text" value='https://www.youtube.com/watch?v=HD4WthE414k'>
    <input type="submit" class="button" name="submiturl" value="increment"/>
</form>


</td></tr></table>

