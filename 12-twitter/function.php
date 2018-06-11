<?php

    session_start();

    $link = mysqli_connect("localhost","wsomerse_twitter","4Zky+)8XQ!Kd","wsomerse_twitter");
    
    if(mysqli_connect_errno()){
        print_r(mysqli_connect_error());
        exit();
    }
    
    if($_GET['function'] == "logout"){
        session_unset();
    }
    
    // function time_since($since) {
    //     $chunks = array(
    //         array(60 * 60 * 24 * 365 , 'year'),
    //         array(60 * 60 * 24 * 30 , 'month'),
    //         array(60 * 60 * 24 * 7, 'week'),
    //         array(60 * 60 * 24 , 'day'),
    //         array(60 * 60 , 'hour'),
    //         array(60 , 'min'),
    //         array(1 , 'sec')
    //     );
    //     for ($i = 0, $j = count($chunks); $i < $j; $i++) {
    //         $seconds = $chunks[$i][0];
    //         $name = $chunks[$i][1];
    //         if (($count = floor($since / $seconds)) != 0) {
    //             break;
    //         }
    //     }
    //     $print = ($count == 1) ? '1 '.$name : "$count {$name}s";
    //     return $print;
    // }
    
    // function time_elapsed_string($datetime, $full = false) {
    //     $now = new DateTime;
    //     $ago = new DateTime($datetime);
    //     $diff = $now->diff($ago);
    
    //     $diff->w = floor($diff->d / 7);
    //     $diff->d -= $diff->w * 7;
    
    //     $string = array(
    //         'y' => 'year',
    //         'm' => 'month',
    //         'w' => 'week',
    //         'd' => 'day',
    //         'h' => 'hour',
    //         'i' => 'minute',
    //         's' => 'second',
    //     );
    //     foreach ($string as $k => &$v) {
    //         if ($diff->$k) {
    //             $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
    //         } else {
    //             unset($string[$k]);
    //         }
    //     }
    
    //     if (!$full) $string = array_slice($string, 0, 1);
    //     return $string ? implode(', ', $string) . ' ago' : 'just now';
    // }
    
    function time_elapsed_string($time_ago){
        $time_ago = strtotime($time_ago);
        $cur_time   = time() + 28800;
        $time_elapsed   = $cur_time - $time_ago;
        $seconds    = $time_elapsed ;
        $minutes    = round($time_elapsed / 60 );
        $hours      = round($time_elapsed / 3600);
        $days       = round($time_elapsed / 86400 );
        $weeks      = round($time_elapsed / 604800);
        $months     = round($time_elapsed / 2600640 );
        $years      = round($time_elapsed / 31207680 );
        // Seconds
        if($seconds <= 60 and  $minute< 1){
            return "just now";
        }
        //Minutes
        else  if($minutes <=60){
            if($minutes==1){
                return "one minute ago";
            }
            else{
                return "$minutes minutes ago";
            }
        }
        //Hours
        else if($hours <=24){
            if($hours==1){
                return "an hour ago";
            }else{
                return "$hours hrs ago";
            }
        }
        //Days
        else if($days <= 7){
            if($days==1){
                return "yesterday";
            }else{
                return "$days days ago";
            }
        }
        //Weeks
        else if($weeks <= 4.3){
            if($weeks==1){
                return "a week ago";
            }else{
                return "$weeks weeks ago";
            }
        }
        //Months
        else if($months <=12){
            if($months==1){
                return "a month ago";
            }else{
                return "$months months ago";
            }
        }
        //Years
        else{
            if($years==1){
                return "one year ago";
            }else{
                return "$years years ago";
            }
        }
    }
    
    function displayTweets($type){
        
        global $link;
        
        if($type == 'public'){
            $whereClause = "";
        }else if($type == 'isFollowing'){
            
            $query = "SELECT * FROM isFollowing WHERE follower = ". mysqli_real_escape_string($link, $_SESSION['id']);
            
            $whereClause = "";
        
            while($row = mysqli_fetch_assoc($result)){
                if($whereClause == ""){
                    $whereClause = "WHERE"; 
                } else {
                    $whereClause .= " OR";
                }
                $whereClause .= " userid =".$row['isFollowing'];
            }
        } else if($type == 'yourtweets'){
            
            $whereClause = "WHERE userid = ".mysqli_real_escape_string($link,$_SESSION['id']);
            
        }else if($type == 'search'){
            
            
            echo '<p>Showing search results for "'.mysqli_real_escape_string($link, $_GET['q']).'":</p>';
            
            
            $whereClause = "WHERE tweet LIKE '%". mysqli_real_escape_string($link, $_GET['q'])."%'";
            
        } else if(is_numeric($type)){
            $userQuery = "SELECT * FROM users WHERE id= ".mysqli_real_escape_string($link,$type)." LIMIT 1";
            $userQueryResult = mysqli_query($link,$userQuery);
            $user = mysqli_fetch_assoc($userQueryResult);
             
            echo "<h2>".mysqli_real_escape_string($link,$user['email'])."'s Tweets</h2>";
               
            $whereClause = "WHERE userid =".mysqli_real_escape_string($link,$type);
        }
        
        $query = "SELECT * FROM tweets ".$whereClause." ORDER BY `datetime` DESC LIMIT 10";
        
        $result = mysqli_query($link,$query);
        
        if(mysqli_num_rows($result) == 0){
            echo "There are no tweets to display";
        }else{
            while($row = mysqli_fetch_assoc($result)){
               
                $userQuery = "SELECT * FROM users WHERE id= ".mysqli_real_escape_string($link,$row['userid'])." LIMIT 1";
                $userQueryResult = mysqli_query($link,$userQuery);
                $user = mysqli_fetch_assoc($userQueryResult);
                
                echo "<div class='tweet'><p><a href='?page=publicprofiles&userid=".$user['id']."'>".$user['email']."</a> <span class='time'>".time_elapsed_string($row['datetime'])."</span>:</p>";

                // echo "<div class='tweet'><p><a href='?page=publicprofiles&userid=".$user['id']."'>".$user['email']."</a> <span class='time'>".time_since(time()-strtotime($row['datetime']))." ago</span>:</p>";
                
                echo "<p>".$row['tweet']."</p>";
                
                echo "<p><button type='button' class='btn btn-light toggleFollow' data-userId='".$row['userid']."'>";
                
                $isFollowingQuery = "SELECT * FROM isFollowing WHERE follower = ". mysqli_real_escape_string($link, $_SESSION['id'])." AND isFollowing = ". mysqli_real_escape_string($link, $row['userid'])." LIMIT 1";
        
                $isFollowingQueryResult = mysqli_query($link, $isFollowingQuery);
                
                if (mysqli_num_rows($isFollowingQueryResult) > 0) {//means it is following, so changing to be unfollowing
                    echo "Unfollow";
                } else {
                    echo "Follow";
                }
                
                echo"</button></p></div>";
            }
        }
    }
    
    function displaySearch() {
        
        echo '<form class="form-inline">
          <div class="form-group">
            <input type="hidden" name="page" value="search">
            <input type="text" name="q" class="form-control" id="search" placeholder="Search">
          </div>
          <button type="submit" class="btn btn-primary">Search Tweets</button>
        </form>';
                
        
    }
    
    function displayTweetBox() {
        
        if ($_SESSION['id'] > 0) {
            
            echo '<div id="tweetSuccess" class="alert alert-success">Your tweet was posted successfully.</div>
            <div id="tweetFail" class="alert alert-danger"></div>
            <div class="form">
                <div class="form-group">
                    <textarea class="form-control" id="tweetContent"></textarea>
                </div>
                <button id="postTweetButton" class="btn btn-primary">Post Tweet</button>
            </div>';
            
            
        }
        
        
    }
    
    function displayUsers(){
        
        global $link;
        
        $query = "SELECT * FROM users LIMIT 10";
        
        $result = mysqli_query($link,$query);
        
        while($row = mysqli_fetch_assoc($result)){
            echo "<p><a href='?page=publicprofiles&userid=".$row['id']."'>".$row['email']."</a></p>";
        }
        
        
    }
    
    
    

?>
