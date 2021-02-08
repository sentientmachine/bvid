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

        $html_payload .= '<div align=center><form name="increment_form1" action="post_increment.php" method="post">';
        $html_payload .= '    <input size=10 type="hidden" name="title1" value="' . $title1 . '">';
        $html_payload .= '    <input size=10 type="hidden" name="title2" value="' . $title2 . '">';
        $html_payload .= '    <input size=10 type="hidden" name="url1" value="' . $url1 . '">';
        $html_payload .= '    <input size=10 type="hidden" name="url2" value="' . $url2 . '">';
        $html_payload .= '    <input size=10 type="hidden" name="img1" value="' . $img1 . '">';
        $html_payload .= '    <input size=10 type="hidden" name="img2" value="' . $img2 . '">';
        $html_payload .= '    <input type="submit" class="button" name="url1" value="This one"/>';
        $html_payload .= '</form></div>';
        $html_payload .= '<br>';

        $html_payload .= '</td><td>';

        $html_payload .= "<h3>" . $title2 . "</h3>";
        $html_payload .= '<a href="' . $url2 . '">' . $url2 . '</a><br><br>';
        $html_payload .= '<img border=2 src="images/' . $img2  . '" width=600 /><br>';

        $html_payload .= '<div align=center><form name="increment_form2" action="post_increment.php" method="post">';
        $html_payload .= '    <input size=10 type="hidden" name="title1" value="' . $title1 . '">';
        $html_payload .= '    <input size=10 type="hidden" name="title2" value="' . $title2 . '">';
        $html_payload .= '    <input size=10 type="hidden" name="url1" value="' . $url2 . '">';
        $html_payload .= '    <input size=10 type="hidden" name="url2" value="' . $url1 . '">';
        $html_payload .= '    <input size=10 type="hidden" name="img1" value="' . $img1 . '">';
        $html_payload .= '    <input size=10 type="hidden" name="img2" value="' . $img2 . '">';
        $html_payload .= '    <input type="submit" class="button" name="url2" value="This one"/>';
        $html_payload .= '</form></div>';


        $html_payload .= '<br>';
        $html_payload .= '</td></tr></table>';
        return $html_payload;
    }
?>

<br><br><br>

<table border=0><tr><td>

<h1 align=center>Which youtube link is better?</h1>

<?php echo get_bundle($link); ?>

<br>
<br>

Submit a youtube url:<br>

<form name="submit_url_form" action="post_submiturl.php" method="post">
    <input size=100 type="text" name="title" value=''><br>
    <input size=100 type="text" name="url_text" value=''><br>
    <input size=100 type="text" name="img_name" value=''><br>
    <input type="submit" class="button" name="submiturl" value="SubmitUrl"/>
</form>

</td></tr></table>

