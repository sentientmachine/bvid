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

    function contains_any_whitespace($str){
        if (strpos($str, ' ')  !== false) { return 1; }
        if (strpos($str, "\t") !== false) { return 1; }
        return 0;
    }
    function contains_illegal_sequences($str){
        if (strpos($str, "\"")  !== false) { return 1; }
        if (strpos($str, "'")   !== false) { return 1; }
        return 0;
    }
    function startswith($string_n, $firstpart){
        $sz = strlen($firstpart);
        if (substr( $string_n, 0, $sz) === $firstpart){
            return 1;
        }
        return 0;
    }

    function startswith_valid_hostnames($str){
        if (startswith($str, "https://www.youtube.com/") == 1) { return 1; }

        #or like
        #https://youtu.be/rStL7niR7gs?t=2
        if (startswith($str, "https://youtu.be/") == 1) { return 1; }

        return 0;
    }

    function is_valid_youtube_url($url){ 
        #the video id must be 11 characters wide.
        $video_id = pluck_youtube_id($url);

        #leading and trailing whitespace means NO.  url's can't have spaces
        if (contains_any_whitespace($url)){ return 0; }
        if (contains_illegal_sequences($url)){ return 0; }
        if (!startswith_valid_hostnames($url)){ return 0; }

        if (strlen($video_id) == 11){
            return 1;
        }

        return 0;
    }

    function pluck_youtube_id($url){
        $video_id = pluck_youtube_id_strat1($url);
        if ($video_id == ""){
            $video_id = pluck_youtube_id_strat2($url);
        }
        return $video_id;
    }

    function pluck_youtube_id_strat1($url){
        $matches = array();
        $matched = preg_match('/v=[a-zA-Z0-9_-]+/i', $url, $matches);
        if ($matched == 0){
            return "";
        }
        $haystack = $matches[0];
        $needle = "v=";
        $pos = strpos($haystack, $needle);
        $replace = '';
        if ($pos !== false) {
            $newstring = substr_replace($haystack, $replace, $pos, strlen($needle));
        }
        return $newstring;
    }
    function pluck_youtube_id_strat2($url){

        #url might look like this:
        #https://youtu.be/rStL7niR7gs?t=2
        $matches = array();

        $matched = preg_match('/https:\/\/youtu\.be\/[a-zA-Z0-9_-]+/i', $url, $matches);
        if ($matched == 0){
            return "";
        }
        $haystack = $matches[0];
        $needle = "https://youtu.be/";
        $pos = strpos($haystack, $needle);
        $replace = '';
        if ($pos !== false) {
            $newstring = substr_replace($haystack, $replace, $pos, strlen($needle));
        }
        return $newstring;
    }
    function pluck_youtube_timeindex($url){
        $matches = array();
        $matched = preg_match('/t=[0-9]+/i', $url, $matches);
        if ($matched == 0){
            return "";
        }
        $haystack = $matches[0];
        $needle = "t=";
        $pos = strpos($haystack, $needle);
        $replace = '';
        if ($pos !== false) {
            $newstring = substr_replace($haystack, $replace, $pos, strlen($needle));
        }
        return $newstring;
    }

    function format_youtube_url($url){
        #strategy: pluck out the video id and the start-time stamp
        #then plop that down onto literally:
        #https://www.youtube.com/watch?v=asdf

        if (!is_valid_youtube_url($url)){
            return "";
        }
        $video_id = pluck_youtube_id($url);
        $start_timeindex = pluck_youtube_timeindex($url);
        $fixed = "https://www.youtube.com/watch?v=" . $video_id;
        if (strlen($start_timeindex) > 0){
            $fixed = $fixed . "?t=" . $start_timeindex;
        }
        return $fixed;
    }

    $mysql = array();
    #$mysql['title'] = $_POST['title'];
    $mysql['url_text'] = $_POST['url_text'];
    #smysql['img_name'] = $_POST['img_name'];

    #TODO: confirm that the URL is not already submitted

    #TODO: Do a basic sniff test to see if the youtube url is valid.

    #TODO: The youtube title will be filled in via lazy loading later by python script defiant side
    #on a cronjob


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

    $url1 = trim($mysql['url_text']);
    if (is_valid_youtube_url($url1) && is_valid_youtube_url($url2)){
        $url1 = format_youtube_url($url1);
        $url2 = format_youtube_url($url2);
        $sql = "insert into bvid values ( " . 
               "'', " .
               "'" . $url1 . "', " .
               "'', " .
               "'', " .
               "'" . $url2 . "', " .
               "'', 1); ";

        mysqli_query($link, $sql);
    }
    #Eric you can use this to make 10 million dollars and give it to the architect that made physics.

    #when done go back to index.php
    echo "<script type='text/javascript'> document.location = 'index.php';</script>";
?>


