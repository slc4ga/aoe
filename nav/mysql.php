<?php

require_once 'constants.php';

date_default_timezone_set('America/New_York');

class Mysql {
     
    private $mysqli;
    private $conn;
     
     // basically constructor
     function __construct() {
        $this->mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME) OR DIE ("Unable to 
            connect to database! Please try again later.");
        if (mysqli_connect_errno()) {
            printf("Can't connect to MySQL Server. Error code: %s\n", mysqli_connect_error());
            return null;
        }
    }
    
    // for escaping sql injections
    function quote_smart($value) {
       if (get_magic_quotes_gpc()) {
           $value = stripslashes($value);
       }
    
       if (!is_numeric($value)) {
           $value = $this->mysqli->real_escape_string($value);
       }
       return $value;
    }
    
    function addUser($un) {
        $un = $this->quote_smart($un);
        
        // check if username already exists
        $checkUN = "select * from users where username='$un'";
        $result = $this->mysqli->query($checkUN) or die('ERROR: could not validate 
            username');
        $num = $result->num_rows;
        if($num == 0) {
                $md5 = $this->randomPassword();
                $newmd5 = md5($md5);
                $sql = "insert into users values('$un', '$newmd5');";
                $result = $this->mysqli->query($sql) or die('ERROR: User could not be 
                    added'); 
            
                //send email
                $to = $un . '@virginia.edu';
                $subject = "New AOE - Pi Account!";
                $message = "Welcome to the website of the Pi Chapter of Alpha Omega Epsilon. You've had an account made for you with the following credentials:\n
                 Username: " . $un . "
                 Password: " . $md5 . "\n\nPlease navigate to http://alphaomegaepsilonatuva.com/ to change your password and edit and view your profile as soon as possible. \n\nQuestions? Email our webmaster at " . WEBMASTER_EMAIL . " with specific details and she'll get back to you as soon as possible!";       
            
                // To send HTML mail, the Content-type header must be set
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $headers = "From: info@alphaomegaepsilonatuva.com";
            
                mail($to, $subject, $message, $headers);
            
                if($result === TRUE) {
                    return "";
                } else {
                    return $result;
                }
        }
        return 'userexists';
    }
    
    function login($un, $pw) {
        $un = $this->quote_smart($un);
        $pw = $this->quote_smart($pw);
        $md5 = md5($pw);
        $sql = "SELECT * FROM users WHERE username = '$un'";
        $result = $this->mysqli->query($sql) or die("username");
        $num = $result->num_rows;
        if ($num == 1) {
            setcookie("aoeuserID", $un, time()+3600);
            session_start();
            $sql = "SELECT * FROM users WHERE username = '$un' AND pw = '$md5'";
            $result = $this->mysqli->query($sql) or die("password");
            $num = $result->num_rows;
            if($num == 1) {
                $_SESSION['user_id'] = $un;
                header("location: ../users/userHome.php");
                return "";
            }
            else return "password";
        }
        return "username";
    }
    
    function randomPassword() {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 12; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
    
    function getPass($un) {
        // escape sql injections
        $un = $this->quote_smart($un, $db_handle);
        
        $sql = "SELECT pw FROM users WHERE username = '$un'";
        $result = $this->mysqli->query($sql) or die("username");
        $num = $result->num_rows;
        if ($num == 1) {
            $row = $result->fetch_array(MYSQLI_NUM);
            $pw = $this->randomPassword();
            $md5 = md5($pw);
            $sql = "update users set pw='$md5' where username='$un'";
            $result = $this->mysqli->query($sql) or die("username");

            $to = $un . "@virginia.edu";
            $headers = 'From: ' . "\r\n" .
                        'Reply-To: ';
            $subject = "Password Retrieval";
            $message = "You have requested your password from the A.O.E Pi Chapter website. Your password has been reset, and your new login information is as follows: \n\nUsername: " . $un . "\nPassword: " . $pw;
            mail($to, $subject, $message, $headers);
            return "";
        }
        return "username";
    }
    
    function resetPass($old, $new) {
        $old = $this->quote_smart($old);
        $new = $this->quote_smart($new);
        session_start();
        
        $md5old = md5($old);
        $md5new = md5($new);
        $un = $_SESSION["user_id"];
        $sql = "select * from users where pw='$md5old' and username='$un'";
        $result = $this->mysqli->query($sql);
        $num = $result->num_rows;
        //echo $num;
        if ($num == 1) {
            $sql = "update users set pw='$md5new' where pw='$md5old' and username='$un'";
            $result = $this->mysqli->query($sql) or die("password");
            $_SESSION['resetPass'] = "success";
            return "success";
        } else {
             $_SESSION['resetPass'] = "old";
             return "old";
        }
    }
    
    function sendMessage($name, $email, $subject, $message) {
        $to  = 'aoes-execs@virginia.edu';
        $headers = "From: info@alphaomegaepsilonatuva.com";
        $headers .= "Reply-to: " . $name . " <" . $email . ">";
        
        $site = "A.O.E. Pi";
        $subject = $site . " - " . $subject;
        
        mail($to, $subject, $message, $headers);
        header("location: contactSuccess.php");
    }
    
    function getClassMembers($class) {
        if(strpos($class,'Alumnae') !== false) {
            $class = 'Alumnae';
        }
        $sql = "select username,first_name,last_name,year,major from profiles where pc like '$class%' order by last_name asc";
        $result = $this->mysqli->query($sql) or die("pledge class members");
        return $result;
    }
    
    function getAllSisters() {
        $sql = "select username,first_name,last_name from profiles order by first_name asc";
        $result = $this->mysqli->query($sql) or die("pledge class members");
        return $result;
    }
    
    function getAllActiveSisters() {
        $sql = "select username,first_name,last_name from profiles where not pc like '%Alumnae%' order by first_name asc";
        $result = $this->mysqli->query($sql) or die("pledge class members");
        return $result;
    }
    
    function addPledgeClass($letter, $info) {
        // split info on new line
        $array = explode("\n", $info);
        for($i = 0; $i < count($array); ++$i) {
            $individual = explode(",", $array[$i]);
            $un = $this->quote_smart($individual[0]);
            $fname = $this->quote_smart($individual[1]);
            $lname = $this->quote_smart($individual[2]);
            
            $this->addUser($un);
            
            $sql = "insert into profiles values ('$un', '$fname', '$lname', '$letter', null, null, null, null, null, null, null, 
                    null, null, null);";
            $result = $this->mysqli->query($sql) or die("adding pledge class profiles");
        }
    }
    
    function getClassCount() {
        $sql = "SELECT pc, COUNT( * ) FROM profiles where not pc like 'Alumnae%' GROUP BY pc";
        $result = $this->mysqli->query($sql) or die("pledge class counts");
        return $result;
    }
    
    function convertSister($un) {
        $class = $this->getPledgeClass($un);
        $newClass = "Alumnae (" . $class . ")";
        $sql = "update profiles set pc='$newClass' where username='$un'";
        $result = $this->mysqli->query($sql) or die("convert sister");
        return $result;
    }
    
    function addSister($name, $id, $pc) {
            $un = $this->quote_smart($id);
            $names = explode(" ", $name);
            $fname = $this->quote_smart($names[0]);
            $lname = $this->quote_smart($names[1]);
            
            $this->addUser($un);
            
            $sql = "insert into profiles values ('$un', '$fname', '$lname', '$pc', null, null, null, null, null, null, null, 
                    null, null, null);";
            $result = $this->mysqli->query($sql) or die("adding pledge class profiles");   
    }
    
    function convertClass($class) {
        $class = $this->quote_smart($class);
        $newClass = "Alumnae (" . $class . ")";
        $sql = "update profiles set pc='$newClass' where pc='$class'";
        $result = $this->mysqli->query($sql) or die("converting class");   
    }
    
    function getFullName($un) {
        $sql = "select first_name,last_name from profiles where username='$un'";
        $result = $this->mysqli->query($sql) or die("get first name");  
        $row = $result->fetch_array(MYSQLI_NUM);
        return $row[0] . " " . $row[1];
    }
    
    function getPos($un) {
        $sql = "select position from leadership where username='$un' order by position desc";
        $result = $this->mysqli->query($sql) or die("get position");  
        $row = $result->fetch_array(MYSQLI_NUM);
        return $row[0];
    }
    
    function checkWebmaster($un) {
        $sql = "select * from leadership where username='$un' and position='W'";
        $result = $this->mysqli->query($sql) or die("check webmaster");  
        $row = $result->fetch_array(MYSQLI_NUM);
        if($result->num_rows == 1) {
            return true;
        }
        return false;
    }
    
    function checkExec($un) {
        $sql = "select * from leadership inner join posList on leadership.position=posList.ID where username='$un' and (`order`>0 or position='W')";
        $result = $this->mysqli->query($sql) or die("check exec");  
        return $result->num_rows;
    }
    
    function addTestimonial($message) {
        $message = $this->quote_smart($message);
        $sql = "insert into testimonials values (null,'" . $_SESSION['user_id'] . "','$message',0)";
        $result = $this->mysqli->query($sql) or die("adding testimonial");  
        return $sql;
    }

    function addFeedback($message) {
        $message = $this->quote_smart($message);
        $sql = "insert into feedback values (null,'$message','" . date('Y-m-d', time()) . "', 0)";
        $result = $this->mysqli->query($sql) or die("adding feedback");  
    }
    
    function getTestimonialNums() {
        $sql = "select count(*) from testimonials where approved=0";
        $result = $this->mysqli->query($sql) or die("pending count");  
        $row = $result->fetch_array(MYSQLI_NUM);
        return $row[0];
    }
    
    function getApprovedTestimonialNums() {
        $sql = "select count(*) from testimonials where approved=1";
        $result = $this->mysqli->query($sql) or die("approved count");  
        $row = $result->fetch_array(MYSQLI_NUM);
        return $row[0];
    }
    
    function getAllPendingTestimonials() {
        $sql = "select * from testimonials where approved=0 order by username asc";
        $result = $this->mysqli->query($sql) or die("all pending testimonials");
        return $result;
    }
    
    function getAllApprovedTestimonials() {
        $sql = "select * from testimonials where approved=1 order by username asc";
        $result = $this->mysqli->query($sql) or die("all approved testimonials");
        return $result;
    }

    function getAllUnacknowledgedFeedback() {
        $sql = "select * from feedback where ack=0 order by date asc";
        $result = $this->mysqli->query($sql) or die("getAllUnacknowledgedFeedback ");
        return $result;
    }
        
    function getTestimonial($id) {
        $sql = "select message from testimonials where id=$id";
        $result = $this->mysqli->query($sql) or die("get testimonial");
        $row = $result->fetch_array(MYSQLI_NUM);
        return $row[0];
    }
    
    function deleteTestimonial($id) {
        $sql = "delete from testimonials where id=$id";
        $result = $this->mysqli->query($sql) or die("delete testimonials");
    }

    function acknowledgeFeedback($req) {
        $sql = "update feedback set ack=1 where id=$req";
        $result = $this->mysqli->query($sql) or die("ack feedback");
    }
    
    function approve($id) {
        $sql = "update testimonials set approved=1 where id=$id";
        $result = $this->mysqli->query($sql) or die("approve testimonials"); 
    }
    
    function editTestimonial($id, $text) {
        $sql = "update testimonials set message='$text' where id=$id";
        //echo $sql;
        $result = $this->mysqli->query($sql) or die("edit testimonials"); 
    }
    
    function getPositions() {
        $sql = "SELECT DISTINCT posList.id,posList.name FROM posList left join leadership on 
                posList.id=leadership.position where posList.order=0 or posList.order=-1 order by posList.name asc";
        $result = $this->mysqli->query($sql) or die("positions"); 
        return $result;
    }
    
    function getExec() {
        $sql = "SELECT DISTINCT posList.id,posList.name FROM posList left join leadership on 
                posList.id=leadership.position where posList.order > 0 order by posList.order asc";
        $result = $this->mysqli->query($sql) or die("exec"); 
        return $result;
    }
    
    function search() {
        $sql = "select first_name,last_name from profiles where first_name like '%$q%' 
            or last_name like '%$q%' order by first_name asc LIMIT 5";
        $result = $this->mysqli->query($sql) or die("search"); 
        return $result;
    }
    
    function getAllLeaders($pos) {
        $sql = "select username from leadership where position='$pos' and start_date >= DATE_SUB(NOW(),INTERVAL 1 YEAR) and current=1";
        $result = $this->mysqli->query($sql) or die("leaders"); 
        return $result;
    }
    
    function addLeader($pos, $name) {
        $array = explode(" ", $name);
        $sql = "select username from profiles where first_name='$array[0]' and last_name='$array[1]'";
        $result = $this->mysqli->query($sql) or die("get username");  
        $row = $result->fetch_array(MYSQLI_NUM);

        $sql = "insert into leadership values('$row[0]', '$pos', '" . date('Y-m-d', time()) . "',1)";
        $result = $this->mysqli->query($sql) or die("insert pos"); 
        
    }
    
    function getPositionId() {
        $alphabet = "ABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $id = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 2; $i++) {
            $n = rand(0, $alphaLength);
            $id[] = $alphabet[$n];
        }
        return implode($id); //turn the array into a string      
    }
    
    function checkUniqueId($id) {
        $sql = "select * from posList where id='$id'";
        $result = $this->mysqli->query($sql) or die("check unique id"); 
        return $result->num_rows;  
    }
    
    function addLeaderPosition($name, $order) {
        $id = $this->getPositionId();
        //echo "ID: " . $id . "<br>";
        while($this->checkUniqueId($id) == 1) {
            $id = $this->getPositionId();
//            echo "ID: " . $id . "<br>";
        }
        
        $sql = "insert into posList values('$id', '$name', $order)";
        $result = $this->mysqli->query($sql) or die("insert leadership pos"); 
        return $result;        
    }

    function deleteLeaderPosition($name) {
        $sql = "update posList set `order`=-2 where id='$name'";
        $result = $this->mysqli->query($sql) or die("delete leadership pos"); 
        return $result;        
    }
    
    function deleteLeader($pos, $name) {
        $array = explode(" ", $name);
        
        $sql = "select username from profiles where first_name='$array[0]' and last_name='$array[1]'";
        $result = $this->mysqli->query($sql) or die("get username");  
        $row = $result->fetch_array(MYSQLI_NUM);

        $sql = "update leadership set current=0 where username='$row[0]' and position='$pos'";
        $result = $this->mysqli->query($sql) or die("delete pos");  
    }
    
    function getInfo($un) {
        $sql = "select * from profiles where username='$un'";
        $result = $this->mysqli->query($sql) or die("user info"); 
        return $result;
    }
    
    function getClassNums($class) {
        if(strpos($class,'Alumnae') !== false) {
            $class = 'Alumnae';
        }
        $sql = "select count(*) from profiles where pc like '" . $class . "%'";
        $result = $this->mysqli->query($sql) or die("pc nums");  
        $row = $result->fetch_array(MYSQLI_NUM);
        return $row[0];
    }
    
    function getPledgeClass($id) {
        $sql = "select pc from profiles where username='$id'";
        $result = $this->mysqli->query($sql) or die("pc lookup");  
        $row = $result->fetch_array(MYSQLI_NUM);
        return $row[0]; 
    }
    
    function getLeadership($id) {
        $sql = "SELECT posList.name FROM leadership LEFT JOIN posList ON posList.id = leadership.position 
            WHERE leadership.username = '$id' order by posList.order desc";
        $result = $this->mysqli->query($sql) or die("leadership lookup");  
        return $result; 
    }
    
    function updateProfile($year, $hometown, $country, $major, $major2, $minor, $minor2, $activities, $bio) {
        $activities = $this->quote_smart($activities);
        $bio = $this->quote_smart($bio);
        $id = $_SESSION['user_id'];
        $sql = "update profiles set year=$year, hometown='$hometown', state='$country', major='$major', major2='$major2', 
            minor='$minor', minor2='$minor2', activities='$activities', bio='$bio' where username='$id'";
        $result = $this->mysqli->query($sql) or die("leadership lookup");  
        return true;
    }

    function searchSisters($term) {
        $sql = "SELECT * FROM profiles where lower(username) like lower('%$term%') or lower(first_name) like lower('%$term%') or lower(last_name) like lower('%$term%') or lower(pc) like lower('%$term%') or lower(year) like lower('%$term%') or lower(hometown) like lower('%$term%') or lower(state) like lower('%$term%') or lower(major) like lower('%$term%') or lower(major2) like lower('%$term%') or lower(minor) like lower('%$term%') or lower(minor2) like lower('%$term%') or lower(activities) like lower('%$term%') or lower(bio) like lower('%$term%')"; 
        //echo $sql;
        $result = $this->mysqli->query($sql) or die("sister search");  
        return $result;
    }

    function searchPledgeClass($term) {
        $sql = "SELECT DISTINCT pc FROM profiles where lower(pc) like lower('%$term%')"; 
        $result = $this->mysqli->query($sql) or die("pc search");  
        return $result;
    }

    function getURL($pc) {
        if($pc == 'Kappa') 
             return "sisters.php?select=1";
        else if($pc == 'Lambda') 
             return "sisters.php?select=2";
        else if($pc == 'Mu') 
             return "sisters.php?select=3";
        else if($pc == 'Nu') 
             return "sisters.php?select=5";
        else
             return "sisters.php?select=4";
    }

    function searchExecPositions($term) {
        $sql = "SELECT DISTINCT posList.order, posList.name, posList.id FROM profiles LEFT JOIN leadership LEFT JOIN posList ON posList.id = leadership.position ON profiles.username = leadership.username WHERE lower(posList.name) like lower('%$term%') and not posList.order=0 order by posList.order asc"; 
        $result = $this->mysqli->query($sql) or die("pos search");  
        return $result;
    }

    function searchChairPositions($term) {
        $sql = "SELECT DISTINCT posList.order, posList.name, posList.id FROM profiles LEFT JOIN leadership LEFT JOIN posList ON posList.id = leadership.position ON profiles.username = leadership.username WHERE lower(posList.name) like lower('%$term%') and posList.order=0 order by posList.order asc"; 
        $result = $this->mysqli->query($sql) or die("pos search");  
        return $result;
    }
    
    function getPointsCategories() {
        $sql = "select * from pointsCategories order by  category asc, `order` desc"; 
        $result = $this->mysqli->query($sql) or die("get categories");  
        return $result;
    }
    
    function addEvent($name, $date, $points, $category) {
        $sql = "insert into events values(null, '$name', $category, '$date', $points, 1)"; 
        $result = $this->mysqli->query($sql) or die("add event");  
        return $result;
    }
    
    function addBabyEvent($name, $date, $category) {
        $sql = "insert into events values(null, '$name', $category, '$date', null, 0)"; 
        $result = $this->mysqli->query($sql) or die("add baby event");  
        return $result;
    }
    
    function getEventsInCategory($category) {
        $sql = "select * from events where category=$category and approved=1"; 
        $result = $this->mysqli->query($sql) or die("get events in category");  
        return $result;
    }
    
    function getUnapprovedEventsInCategory($category) {
        $sql = "select * from events where category=$category and approved=0"; 
        $result = $this->mysqli->query($sql) or die("get unapproved events in category");  
        return $result;
    }
    
    function deleteEvent($id) {
        $sql = "delete from events where id=$id";
        $result = $this->mysqli->query($sql) or die("delete event");  
        return $result;
    }
    
    function addEventCategory($category, $order) {
        $sql = "insert into pointsCategories values(null, '$category', $order)"; 
        $result = $this->mysqli->query($sql) or die("add category");  
        return $result;
    }
    
    function getChapters() {
        $sql = "select distinct date, pass from events inner join chapterPass on events.id=chapterPass.eventId where category=9 order by date asc"; 
        $result = $this->mysqli->query($sql) or die("get chapters");  
        return $result;
    }
    
    function generateChapterPassword() {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 6; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string  
    }
    
    function setChapterPass($pw) {
        $sql = "select id from events order by id desc limit 1";
        $result = $this->mysqli->query($sql) or die("get chapter id for pass");  
        $lateIdArray = $result->fetch_array(MYSQLI_NUM);
        $lateId = $lateIdArray[0];
        
        $sql = "insert into chapterPass values($lateId, '$pw')";
        $result = $this->mysqli->query($sql) or die("set late chapter pass"); 
        
        $id = $lateId - 1;
        $sql = "insert into chapterPass values($id, '$pw')";
        $result = $this->mysqli->query($sql) or die("set chapter pass"); 
        return $result;
    }
    
    function getPointsInMonth() {
        return $this->getPointsInSpecifiedMonth(time());
    }
    
    function getPointsInSpecifiedMonth($month) {
        $minDate = date('Y-m-d', time());
        if(date('Y-m-t', $month) < $minDate) {
            $minDate = date('Y-m-t', $month);
        }
        $sql = "select points from events join pointsCategories on events.category=pointsCategories.num where date > '" . date('Y-m-1', $month) . "' and date < '". $minDate . "' and not events.category=10 and not events.category=11 and not events.category=9 and `order`=0";
        $result = $this->mysqli->query($sql) or die("get points in month");  
        $points = 0;
        while($row = mysqli_fetch_array($result)) {
            $points += $row[0];
        }
        
        // add chapter points
        $sql = "select distinct date from events where category=9 and date > '" . date('Y-m-1', $month) . "' and date < '" 
            . date('Y-m-t', $month) . "'";
        $result = $this->mysqli->query($sql) or die("get chapter points in month");  
        $points += $result->num_rows * CHAPTER_POINTS;
        return $points;   
    }
    
    function checkCategoryIsMandatory($cat) {
        $sql = "select * from pointsCategories where num=$cat and `order`=0";
        $result = $this->mysqli->query($sql) or die("check category order"); 
        return $result->num_rows;
    }
    
    function getPointsInCategory($cat) {
        if($this->checkCategoryIsMandatory($cat) == 0) {
            return 0;
        }
        if($cat == 9) {
            $sql = "select distinct date from events where category=$cat and date <= '" . date('Y-m-d', time()) . "'";
            $result = $this->mysqli->query($sql) or die("get points in category for user");  
            $points = 0;
            $num_chaps = $result->num_rows;
            $points = CHAPTER_POINTS * $num_chaps;
            return $points;
        } else {
            $sql = "select points from events where category=$cat and date <= '" . date('Y-m-d', time()) . "'";
            $result = $this->mysqli->query($sql) or die("get points in category");  
            $points = 0;
            while($row = mysqli_fetch_array($result)) {
                $points += $row[0];
            }
            return $points;
        }
    }
    
    function getPointsInMonthForUser($un) {
        return $this->getPointsInSpecifiedMonthForUser(time(), $un);
    }
    
    function getPointsInSpecifiedMonthForUser($date, $un) {
        $sql = "select points from events inner join points on events.id = points.eventId where date > '" . date('Y-m-1', $date) . "' and date < '". date('Y-m-t', $date) . "' and points.username = '" . $un . "' and points.approved=1 and not category=10 and not category=11";
        $result = $this->mysqli->query($sql) or die("get points in month for user");  
        $points = 0;
        while($row = mysqli_fetch_array($result)) {
            $points += $row[0];
        }
        
        return $points;
    }
    
    function getPointsInCategoryForUser($cat) {
        $un = $_SESSION['user_id'];
        if($cat == 10) {
            $sql = "select * from leadership inner join posList on leadership.`position`=posList.`id` where username='$un' and `order`=0";
            $result = $this->mysqli->query($sql) or die("get points in category for user - chair"); 
            return $result->num_rows * CHAIR_POINTS;
        } else if($cat == 11) {
            $sql = "select * from leadership inner join posList on leadership.`position`=posList.`id` where username='$un' and `order`=-1";
            $result = $this->mysqli->query($sql) or die("get points in category for user - committee"); 
            return $result->num_rows * COMMITTEE_POINTS;
        } else if($cat == 16) {
            $sql = "select points from events inner join points on events.id = points.eventId where category=$cat and points.username = '$un' and points.approved=1";
            $result = $this->mysqli->query($sql) or die("get points in semester bonus category");  
            $points = 0;
            while($row = mysqli_fetch_array($result)) {
                $points += $row[0];
            }
            return $points;
        }
        
        if($cat == 9) {
            $sql = "select distinct date, points from events inner join points on events.id = points.eventId where category=$cat and date <= '" . date('Y-m-d', time()) . "' and points.username = '$un' and points.approved=1";
            $result = $this->mysqli->query($sql) or die("get points in category for user");  
            $points = 0;
            while($row = mysqli_fetch_array($result)) {
                $points += $row[1];
            }
            return $points;
        } else {
            $sql = "select points from events inner join points on events.id = points.eventId where category=$cat and date <= '" . date('Y-m-d', time()) . "' and points.username = '$un' and points.approved=1";
            $result = $this->mysqli->query($sql) or die("get points in category for user");  
            $points = 0;
            while($row = mysqli_fetch_array($result)) {
                $points += $row[0];
            }
            return $points;
        }
    }
    
    function submitAttendance($un, $eventId) { 
        $sql = "insert into points values ($eventId, '$un', 0)";
        $result = $this->mysqli->query($sql) or die("submit attendance");  
        return $result;
    }

    function submitApprovedAttendance($un, $eventId) { 
        $sql = "insert into points values ($eventId, '$un', 1)";
        $result = $this->mysqli->query($sql) or die("submit approved attendance");  
        return $result;
    }
    
    function attendChapter($username, $date, $pw, $ontime){ 
        if($ontime == 0) {
            $name = "Late Chapter";
            $html = '<div class="alert alert-warning" role="alert">
                        You were a little late, but your attendance was recorded!
                    </div>';
        } else {
            $name = "Chapter";
            $html = '<div class="alert alert-success" role="alert">
                        Thanks for being on time - your attendance was recorded!
                    </div>';
        }
        $sql = "select id from events where category=9 and date='" . date('Y-m-d', strtotime($date)) . "' and event='$name'";
        $result = $this->mysqli->query($sql) or die("find current chapter id");  
        $idArray = mysqli_fetch_array($result);
        $id = $idArray[0];
        
        // check password
        $sql = "select pass from chapterPass where eventId=$id";
        $result = $this->mysqli->query($sql) or die("find current chapter password");  
        $passArray = mysqli_fetch_array($result);
        $pass = $passArray[0];

        if($pass == $pw) {
            $sql = "insert into points values($id, '$username', 1)";
            $result = $this->mysqli->query($sql) or die("add chapter attendance");  
        } else {
            $html = '<div class="alert alert-danger" role="alert">
                        That password wasn\'t right..try again!
                    </div>';
            $today = date('Y-m-d', time());
            $today_formatted = date('n/j/Y', time());
            if(time() > strtotime("7:50 PM") && time() < strtotime("8:15 PM")) { //on time
                if($this->checkChapterAttendance($_SESSION['user_id'], date('Y-m-d', time())) == 0) {
                    $html .= "<div class='row'>
                        <div class='col-md-4 col-md-offset-4'>";
                    $html .= "<button style='width: 100%' class='btn btn-lg btn-success' onclick=\"ontimeChapter('"
                        . $_SESSION['user_id'] . "','" . $today . "')\">Check In <br>
                        ($today_formatted)</button>";
                    $html .= "  </div>
                      </div>";
                } else {
                    $html .= "<div class='row'>
                            <div class='col-md-6 col-md-offset-3'>
                                <h5>Thanks, you've already checked in today!</h5>
                            </div>
                        </div>";    
                }
            } else if(time() < strtotime("8:20 PM")) { // late
                    if($this->checkChapterAttendance($_SESSION['user_id'], date('Y-m-d', time())) == 0) {
                        $html .= "<div class='row'>
                                <div class='col-md-4 col-md-offset-4'>";
                        $html .= "<button style='width: 100%' class='btn btn-lg btn-warning'
                                onclick=\"lateChapter('" . $_SESSION['user_id'] . "','" . $today . "')\">
                                    Check In <br> ($today_formatted)</button>";
                        $html .= "  </div>
                            </div>";
                    } else {
                        $html .= "<div class='row'>
                                <div class='col-md-6 col-md-offset-3'>
                                    <h5>Thanks, you've already checked in today!</h5>
                                </div>
                            </div>";    
                    }
            } else if(time() < strtotime("9:15 PM")) { // too late
                if($this->checkChapterAttendance($_SESSION['user_id'], date('Y-m-d', time())) == 0) {
                    $html .= "<div class='row'>
                        <div class='col-md-12'>";
                    $html .= "<div class='alert alert-danger' role='alert'>
                            <strong>Oh snap!</strong> You were too late to chapter to check in. 
                            Try to be on time next time!
                        </div>";
                    $html .= "</div>
                        </div>";
                }
            }
        }
        return $html;
    }
    
    function checkAttendance($un, $eventId) {
        $sql = "select * from points where username = '$un' and eventId = $eventId";
        $result = $this->mysqli->query($sql) or die("check attendance");  
        return $result->num_rows;    
    }
    
    function checkAttendanceApproval($un, $eventId) {
        $sql = "select * from points where username = '$un' and eventId = $eventId and approved=1";
        $result = $this->mysqli->query($sql) or die("check attendance approval");  
        return $result->num_rows;    
    }
    
    function checkChapterAttendance($un, $date) {
        $sql = "select * from points inner join events on points.eventId=events.id where username = '$un' and date = '$date' and category=9";
        $result = $this->mysqli->query($sql) or die("check chapter attendance");  
        return $result->num_rows;    
    }
    
    function checkChapterPoints($un, $date) {
        $sql = "select points from points inner join events on points.eventId=events.id where username = '$un' and date = '$date' and category=9";
        $result = $this->mysqli->query($sql) or die("check chapter points");  
        return $result;    
    }
    
    function getChairPositionPoints($un) {
        $sql = "select * from leadership inner join posList on leadership.`position`=posList.`id` where username='$un' and `order`=0 order by start_date desc";
        $result = $this->mysqli->query($sql) or die("get chair position points");  
        return $result;     
    }
    
    function getCommitteePositionPoints($un) {
        $sql = "select * from leadership inner join posList on leadership.`position`=posList.`id` where username='$un' and `order`=-1 order by start_date desc";
        $result = $this->mysqli->query($sql) or die("get chair position points");  
        return $result;     
    }
    
    function chapterExemption($username, $eventId) {
        $sql = "insert into points values($eventId, '$username', 1)";
        $result = $this->mysqli->query($sql) or die("chapter attendance exemption");  
        return $result->num_rows;  
    }
    
    function getDateRange() {
        $sql = "select min(date), max(date) from events";
        $result = $this->mysqli->query($sql) or die("get date range");  
        return $result;  
    }
    
    function getSemesterStart() {
        $sql = "select min(date) from events";
        $result = $this->mysqli->query($sql) or die("get semester start");  
        return $result;  
    }
    
    function getSisterQuota($month) {
        $sisters = $this->getAllActiveSisters();
        $monthlyPoints = $this->getPointsInSpecifiedMonth($month);
        $passingSisters;
        while($sisterInfo = mysqli_fetch_array($sisters)) {
            $sisterPoints = $this->getPointsInSpecifiedMonthForUser($month, $sisterInfo[0]);
            if($sisterPoints > POINTS_QUOTA * $monthlyPoints) {
                $passingSisters[] = $sisterInfo[0];
            } else {
                $missingSisters[] = $sisterInfo[0];
            }
        }
        $sisterList[] = $passingSisters;
        $sisterList[] = $missingSisters;
        return $sisterList;
    }
    
    function makeListDownload($filename, $month, $datadump){            
        
        header('Content-Description: File Transfer');
        header("Content-Type: application/force-download");
        header('Content-disposition: attachment; filename="' . $filename . '"');
        header('Content-Length: '.strlen($datadump));
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header("Connection: close");
        header('Expires: 0');
        header('Pragma: public');
        
        echo $datadump;
    
        return true;

    }
    
    function getSemesterEvents($date) {
        // date = year-1 or year-8
        $end = strtotime("+4 month", $date);
        $sql = "select * from events where date > '" . date('Y-m-1', $date) . "' and date < '" . date('Y-m-t', $end) 
            . "' and not category=9 and approved=1 order by date asc";
        $result = $this->mysqli->query($sql) or die("get semester events");  
        return $result; 
    }
    
    function getEventAttendance($eventId) {
        $sql = "select * from points where eventId=$eventId and approved=0";
        $result = $this->mysqli->query($sql) or die("get submitted event attendance");  
        return $result; 
    }
    
    function approveAttendance($eventId, $un) {
        $sql = "update points set approved=1 where eventId=$eventId and username='$un'";
        $result = $this->mysqli->query($sql) or die("approve event attendance");  
        return $result; 
    }
    
    function approveBabyEvent($eventId, $points) {
        $sql = "update events set approved=1, points=$points where id=$eventId";
        $result = $this->mysqli->query($sql) or die("approve baby attendance");  
        return $result; 
    }
    
    function getTotalPointsOverall() {
        $sql = "select points from events where not category=9";
        $result = $this->mysqli->query($sql) or die("get total non chapter points");  
        $points = 0;
        while($event = mysqli_fetch_array($result)) {
            $points += $event[0];
        }
        
        // add chapter points
        $sql = "select points from events where category=9 and points=" . CHAPTER_POINTS;
        $result = $this->mysqli->query($sql) or die("get total chapter points");
        $points += $result->num_rows * CHAPTER_POINTS;
        
        return $points;
    }
    
    function getTotalPointsForUser() {
        $sql = "select profiles.username, sum(points) from profiles left join points on profiles.username=points.username left join events on events.id=points.eventId where not profiles.pc like '%Alumnae%' and points.approved=1 group by profiles.username order by profiles.first_name asc";
        $result = $this->mysqli->query($sql) or die("get total points for all users");  
        return $result;
    }

    function getTotalPointsForOneUser($un) {
        $sql = "select sum(points) from points left join events on events.id=points.eventId where username='$un' and points.approved=1";
        $result = $this->mysqli->query($sql) or die("get total points for one user");  
        $pointsArray = mysqli_fetch_array($result);
        $points = $pointsArray[0];

        $commiteeRows = $this->getCommitteePositionPoints($un);
        $commiteePoints = $commiteeRows->num_rows * COMMITTEE_POINTS;

        $chairRows = $this->getChairPositionPoints($un);
        $chairPoints = $chairRows->num_rows * CHAIR_POINTS;

        $totalPoints = $points + $commiteePoints + $chairPoints;
        return $totalPoints;
    }
    
    function addBabyEventForm($cat) {
        $sql = "select category from pointsCategories where num=$cat";
        $result = $this->mysqli->query($sql) or die("add baby event form");  
        $nameArray = mysqli_fetch_array($result);
        $name = $nameArray[0];
        
        echo '
        <div class="row"><div class="col-md-8 col-md-offset-2">
        <form action="addBabyEvent.php" method="post" accept-charset="UTF-8">
            <div class="row">
                <div class="col-md-6">
                    <input id="cat" type="hidden" name="cat" value="' . $cat . '"/>
                    <input class="form-control" id="name" style="margin-bottom: 15px;" type="text" name="name"  
                        size="50" placeholder="Event Name"/>
                </div>
                <div class="col-md-6">
                    <input class="form-control" id="date" style="margin-bottom: 15px;" type="date" name="date"  
                        size="50" placeholder="Event date"/>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <input class="btn btn-primary" style="width: 100%;" 
                           type="submit" value="Submit Event for Approval" />
                </div>
            </div>
            <br>
        </form></div></div>';
    }

    function checkLeadershipExpiration() {
        $sql = "update leadership set current=0 where start_date <= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)";
        $result = $this->mysqli->query($sql) or die("check leadership expiration"); 
    }
    
    function calculateSemesterBonus($date) {
        $this->checkLeadershipExpiration();

        $end = strtotime("+4 month", $date);
        $date_formatted = date( 'Y-m-t', $end);

        $sql = "insert into events values (null, 'Professional Bonus', 16, '$date_formatted', 3, 1)";
        $result = $this->mysqli->query($sql) or die("add professional bonus");  

        $sql = "insert into events values (null, 'Sisterhood Bonus', 16, '$date_formatted', 3, 1)";
        $result = $this->mysqli->query($sql) or die("add sisterhood bonus");  

        $sql = "insert into events values (null, 'Fundraising Bonus', 16, '$date_formatted', 3, 1)";
        $result = $this->mysqli->query($sql) or die("add Fundraising bonus");  

        $sql = "insert into events values (null, 'Chapter Bonus', 16, '$date_formatted', 3, 1)";
        $result = $this->mysqli->query($sql) or die("add chapter bonus");  

        $sql = "select id from events order by id desc limit 1";
        $result = $this->mysqli->query($sql) or die("select last event id");  
        $idArray = mysqli_fetch_array($result);
        $id = $idArray[0];

        $sisters = $this->getAllActiveSisters();
        while($sisterInfo = mysqli_fetch_array($sisters)) {
            if($this->getAllSemesterPointsByCategory ($date, $sisterInfo[0], 9) > 30) {
                $this->submitApprovedAttendance($sisterInfo[0], $id);
            }

            if($this->getAllSemesterPointsByCategory ($date, $sisterInfo[0], 1) > 10) {
                $this->submitApprovedAttendance($sisterInfo[0], ($id-3));
            }

            if($this->getAllSemesterPointsByCategory ($date, $sisterInfo[0], 2) > 10) {
                $this->submitApprovedAttendance($sisterInfo[0], ($id-2));
            }

            if($this->getAllSemesterPointsByCategory ($date, $sisterInfo[0], 3) > 10) {
                $this->submitApprovedAttendance($sisterInfo[0], ($id-1));
            }  
        }
        
    }
    
    function getAllSemesterPointsByCategory ($date, $un, $cat) {
        // date = year-1 or year-8
        $end = strtotime("+5 month", $date);
        $sql = "select SUM(`points`) from events inner join points on events.id=points.eventId where date > '" . date('Y-m-1', $date) . 
            "' and date < '" . date('Y-m-1', $end) . "' and points.approved=1 and points.username='$un' and events.category=$cat";
        $result = $this->mysqli->query($sql) or die("get semester points for user by category"); 
        $resultArray = mysqli_fetch_array($result); 
        return $resultArray[0]; 
    }

    function deactivateSister($un) {
        $sql = "delete from users where username='$un'";
        $result = $this->mysqli->query($sql) or die("deactivate/delete");  
        return $result;
    }
    
    function checkChapterMade($today) {
        $sql = "select * from events where date='$today' and category=9";
        $result = $this->mysqli->query($sql) or die("check chapter event made");  
        return $result->num_rows;
    }
}

?>