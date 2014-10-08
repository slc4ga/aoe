<?php

require_once 'constants.php';

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
        $sql = "select username,first_name,last_name from profiles where not pc='Alumnae' order by first_name asc";
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
        $sql = "select `order` from leadership inner join posList on leadership.position=posList.ID where username='$un'";
        $result = $this->mysqli->query($sql) or die("check webmaster");  
        $row = $result->fetch_array(MYSQLI_NUM);
        if($row[0] == 1) {
            return true;
        }
        return false;
    }
    
    function addTestimonial($message) {
        $message = $this->quote_smart($message);
        $sql = "insert into testimonials values (null,'" . $_SESSION['user_id'] . "','$message',0)";
        $result = $this->mysqli->query($sql) or die("adding testimonial");  
        return $sql;
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
                posList.id=leadership.position where posList.order=0 or posList.order=-1";
        $result = $this->mysqli->query($sql) or die("positions"); 
        return $result;
    }
    
    function getExec() {
        $sql = "SELECT DISTINCT posList.id,posList.name FROM posList left join leadership on 
                posList.id=leadership.position where not posList.order=0 and not posList.order=-1 order by posList.order asc";
        $result = $this->mysqli->query($sql) or die("exec"); 
        return $result;
    }
    
    function search() {
        $sql = "select first_name,last_name from profiles where first_name like '%$q%' 
            or last_name like '%$q%' order by first_name asc LIMIT 5";
        $result = $this->mysqli->query($sql) or die("exec"); 
        return $result;
    }
    
    function getAllLeaders($pos) {
        $sql = "select username from leadership where position='$pos'";
        $result = $this->mysqli->query($sql) or die("leaders"); 
        return $result;
    }
    
    function addLeader($pos, $name) {
        $array = explode(" ", $name);
        echo $array[0] . " " . $array[1];
        $sql = "select username from profiles where first_name='$array[0]' and last_name='$array[1]'";
        echo $sql;
        $result = $this->mysqli->query($sql) or die("get username");  
        $row = $result->fetch_array(MYSQLI_NUM);

        $sql = "insert into leadership values('$row[0]', '$pos')";
        echo $sql;
        $result = $this->mysqli->query($sql) or die("insert pos");  
    }
    
    function deleteLeader($pos, $name) {
        $array = explode(" ", $name);
        
        $sql = "select username from profiles where first_name='$array[0]' and last_name='$array[1]'";
        $result = $this->mysqli->query($sql) or die("get username");  
        $row = $result->fetch_array(MYSQLI_NUM);

        $sql = "delete from leadership where username='$row[0]' and position='$pos'";
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
        //echo $sql;
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
        $sql = "select * from pointsCategories order by num asc"; 
        $result = $this->mysqli->query($sql) or die("get categories");  
        return $result;
    }
    
    function addEvent($name, $date, $points, $category) {
        $sql = "insert into events values(null, '$name', $category, '$date', $points)"; 
        $result = $this->mysqli->query($sql) or die("add event");  
        return $result;
    }
    
    function getEventsInCategory($category) {
        $sql = "select * from events where category=$category"; 
        $result = $this->mysqli->query($sql) or die("get events in category");  
        return $result;
    }
    
    function deleteEvent($id) {
        $sql = "delete from events where id=$id";
        $result = $this->mysqli->query($sql) or die("delete event");  
        return $result;
    }
    
    function addEventCategory($category) {
        $sql = "insert into pointsCategories values(null, '$category')"; 
        $result = $this->mysqli->query($sql) or die("add category");  
        return $result;
    }

}

?>