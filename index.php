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
    function pluck_youtube_id($url){
        $video_id = pluck_youtube_id_strat1($url);
        if ($video_id == ""){
            $video_id = pluck_youtube_id_strat2($url);
        }
        return $video_id;
    }

    function convert_youtube_url_to_embed($url){
        #https://www.youtube.com/embed/YQn2MyHcNBM

        $video_id = pluck_youtube_id($url);
        $newurl = 'https://www.youtube.com/embed/' . $video_id;
        return $newurl;
    }
    function embed_payload_from_url($url){

        $embedurl = convert_youtube_url_to_embed($url);
        $payload = '<iframe width="470" height="370" src="' . $embedurl . '" ' .
                   'frameborder="0" allow="accelerometer; autoplay; clipboard-write; ' .
                   'encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe><br>';

        return $payload;
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

        $html_payload = '<table border=1><tr><td><table border=0 style="max-width:98%;"><tr><td>';

        $html_payload .= "<h3>" . $title1 . "</h3>";
        $html_payload .= '<a href="' . $url1 . '">' . $url1 . '</a><br><br>';
        $html_payload .= '</td><td>';
        $html_payload .= "<h3>" . $title2 . "</h3>";
        $html_payload .= '<a href="' . $url2 . '">' . $url2 . '</a><br><br>';

        $html_payload .= '</td></tr><tr><td>';

        $html_payload .= embed_payload_from_url($url1);
        $html_payload .= '<div align=center><form name="increment_form1" action="post_increment.php" method="post">';
        $html_payload .= '    <input size=10 type="hidden" name="title1" value="' . $title1 . '">';
        $html_payload .= '    <input size=10 type="hidden" name="title2" value="' . $title2 . '">';
        $html_payload .= '    <input size=10 type="hidden" name="url1" value="' . $url1 . '">';
        $html_payload .= '    <input size=10 type="hidden" name="url2" value="' . $url2 . '">';
        $html_payload .= '    <input size=10 type="hidden" name="img1" value="' . $img1 . '">';
        $html_payload .= '    <input size=10 type="hidden" name="img2" value="' . $img2 . '">';
        $html_payload .= '    <input type="submit" class="button" name="submiturl1" value="This one"/>';
        $html_payload .= '</form></div>';
        $html_payload .= '<br>';
        
        $html_payload .= '</td><td>';


        $html_payload .= embed_payload_from_url($url2);

        $html_payload .= '<div align=center><form name="increment_form2" action="post_increment.php" method="post">';
        $html_payload .= '    <input size=10 type="hidden" name="title1" value="' . $title2 . '">';
        $html_payload .= '    <input size=10 type="hidden" name="title2" value="' . $title1 . '">';
        $html_payload .= '    <input size=10 type="hidden" name="url1" value="' . $url2 . '">';
        $html_payload .= '    <input size=10 type="hidden" name="url2" value="' . $url1 . '">';
        $html_payload .= '    <input size=10 type="hidden" name="img1" value="' . $img2 . '">';
        $html_payload .= '    <input size=10 type="hidden" name="img2" value="' . $img1 . '">';
        $html_payload .= '    <input type="submit" class="button" name="submiturl2" value="This one"/>';
        $html_payload .= '</form></div>';


        $html_payload .= '<br>';
        $html_payload .= '</td></tr></table></td></tr></table>';
        return $html_payload;
    }
?>

<br><br><br>

<table border=0><tr><td>

<h1 align=center>Which youtube link is better?</h1>

<?php echo get_bundle($link); ?>

<br>
<br>
<br>
<br>
<br>

<h1>What is this?</h1>
Choosing which video and blurb summary you like more here trains a machine learning algorithm that generates youtube links and summaries that the user would most like right now given available information.<br><br>

As I load in additional data points about the video (its length, category, user age, author, creation date, language, frame color samples, etc ) and keeping user preferences lists at first broken out by cookie (public ip), then later by username/password, I can do super-cool data science and machine learning and doge-coin powered Face-Book for cats, to bring you more of what you're seeing right now: The very best videos of the 90 petabytes available to you to watch on youtube.  The videos with content you'll like so much, that you'll say: "It's a crime that my parents or school hasn't shown me these videos before!"<br><br>

I use the genetic algorithm, vanilla neural nets, standard n-dimension linear regressions, decision trees, cross pollinating user content against whats trending now, and separating out what it is that makes you like a video, to find more of that.  <br>
<br>
You'll wonder: "How does this totally rando website know how to bring me youtube videos I really enjoy better than youtube front page does?  Well, In a narrow way: I know what your brain is after better than you know yourself, I can run probabilities correlations on 50 million individuals, 1-in-1000 of which are almost exactly like you.  Also controlling for the fact that the standard kind of person isn't able to pilot his own life as good as a machine would.  Yatta Yatta, All your base are belong to us leeroy jenkins, make your time.  Chaos isn't a pit. Nintendo Sixtyfour.
<br>
<br>
<br>

Submit a youtube url and it will be taken under advisement, and voted upon:<br>

<form name="submit_url_form" action="post_submiturl.php" method="post">
    <input size=100 type="text" name="url_text" value=''><br>
    <input type="submit" class="button" name="submiturl" value="SubmitUrl"/>
</form>

</td></tr></table>

