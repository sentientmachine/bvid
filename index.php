<?php
    $dbhost = 'localhost';
    $dbuser = '';
    $dbpass = '';

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
      echo 'Could not select database, big problem';
      exit;
    }
   
    function get_left_bundle($link){ 

        $sql = "select title1, url1, img1 from bvid limit 1;";
        $res = mysqli_query($link, $sql);
    
        if (!$res){
          echo "DB Error, could not query the database\nMySQL Error:";
          echo mysqli_error();
          #exit();
        }
        #$url1 = '';
        while ($result = mysqli_fetch_assoc($res)){
            $title1 = $result["title1"];
            $url1 = $result["url1"];
            $img1 = $result["img1"];
        }
        $html_payload = "<h3>" . $title1 . "</h3>";
        $html_payload .= '<a href="' . $url1 . '">' . $url1 . '</a><br><br>';
        $html_payload .= '<img border=2 src="images/' . $img1  . '" width=600 /><br>';

        return $html_payload;
    }

    function get_url1($link){ 
        $sql = "select distinct url1 from bvid limit 1;";
        $res = mysqli_query($link, $sql);
    
        if (!$res){
          echo "DB Error, could not query the database\nMySQL Error:";
          echo mysqli_error();
          #exit();
        }
        #$url1 = '';
        while ($result = mysqli_fetch_assoc($res)){
            $url1 = $result["url1"];
        }
        return $url1;
    }


?>

<br><br><br>

<table border=0><tr><td>

<h1 align=center>Which youtube link is better?</h1>

<table border=1><tr><td>

<?php echo get_left_bundle($link); ?>

<br>
<br>

<div align=center><input type="submit" class="button" name="url1" value="This one" /></div><br>
</td><td>

<h3>The Living Universe - Documentary about Consciousness and Reality | Waking Cosmos</h3>
<a href="https://www.youtube.com/watch?v=HD4WthE414k">https://www.youtube.com/watch?v=HD4WthE414k</a><br><br>
<img border=2 src="images/universe_is_alive.jpg" width=500 /><br>
<br>
<div align=center><input type="submit" class="button" name="url1" value="This one" /></div><br>
</td></tr></table>

<br>
<br>

Submit a youtube url:<br>
<input size=100 type="text" name="submiturl" value=''>



</td></tr></table>

