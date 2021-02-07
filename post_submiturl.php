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



    $mysql = array();

    //$mysql['title1'] = $_POST['title1'];
    //$mysql['title2'] = $_POST['title2'];
    //$mysql['url1'] = $_POST['url1'];
    //$mysql['url2'] = $_POST['url2'];
    //$mysql['img1'] = $_POST['img1'];
    //$mysql['img2'] = $_POST['img2'];
  
    
    
    $mysql['title'] = $_POST['title'];
    $mysql['url_text'] = $_POST['url_text'];
    $mysql['img_name'] = $_POST['img_name'];


    #TODO: confirm that the URL is not already submitted
    #TODO: Do a basic sniff test to see if the youtube url is valid.

    #TODO: use regex to pluck out the 11 alphanumeric character sequence code from $mysql['url_text'] like uIMfbWnpeU0
    $alphanumeric_id = 

    #TODO: get the youtube title using this strategy:
    $content = file_get_contents("http://youtube.com/get_video_info?video_id=". $alphanumeric_id);
    parse_str($content, $ytarr);
    echo $ytarr['title'];


    #TODO: Fetch the youtube image by creating this URL: 'http://i3.ytimg.com/vi/uIMfbWnpeU0/maxresdefault.jpg'

    #TODO: Use wget or curl on machinesentience to yank, it'll be named 'maxresdefault.jpg' make sure to throttle

    #TODO: Take the title text, and convert everything that isn't a-zA-Z0-9_ to those.

    #stuff it all in there, should all just workj

    $sql = "select title2, url2, img2 from bvid order by RAND() limit 1;";
    $res = mysqli_query($link, $sql);

    if (!$res){
      echo "DB Error, could not query the database\nMySQL Error:";
      echo mysqli_error(); exit();
    }
    while ($result = mysqli_fetch_assoc($res)){
        $title2 = $result["title2"];
        $url2 = $result["url2"];
        $img2 = $result["img2"];
    }





    $sql = "insert into bvid values ( " . 
           "'" . $mysql['title'] . "', " .
           "'" . $mysql['url_text'] . "', " .
           "'" . $mysql['img_name'] . "', " .
           "'" . $title2 . "', " .
           "'" . $url2 . "', " .
           "'" . $img2 . "', 1); ";

    mysqli_query($link, $sql);

    #Eric you can use this to make 10 million dollars and give it to the architect that made physics.

    #when done go back to index.php
    echo "<script type='text/javascript'> document.location = 'index.php';</script>";
?>


