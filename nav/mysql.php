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
                $md5 = md5($this->randomPassword());
                $sql = "insert into users values('$un', '$md5');";
                $result = $this->mysqli->query($sql) or die('ERROR: User could not be 
                    added'); 
            
                //send email
                $un = 'slc4ga';
                $to = $un . '@virginia.edu';
                $subject = "New AOE - Pi Account!";
                $message = "
                <html>
                    <head>
                        <title>New AOE Pi Chapter Account</title>
                    </head>
                    <body>
                        <p>Welcome to the website of the Pi Chapter of Alpha Omega Epsilon. You've had an account made for you 
                            with the following credentials:</p>
                        <br>
                        <p>
                            Username: " . $un . "<br>
                            Password: " . $md5 . "<br>
                        </p>
                        <br>
                        <p>
                            Please navigate to <a href=\"http://alphaomegaepsilonatuva.com/\">http://alphaomegaepsilonatuva.com/</a> to
                            change your password and edit and view your profile as soon as possible.
                        </p>
                    </body>
                </html>";       
            
                // To send HTML mail, the Content-type header must be set
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $headers = "From: " . WEBMASTER_EMAIL;
            
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
            $_SESSION['user_id'] = $un;
            $sql = "SELECT * FROM users WHERE username = '$un' AND pw = '$md5'";
            $result = $this->mysqli->query($sql) or die("password");
            $num = $result->num_rows;
            if($num == 1) {
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
        
        $sql = "SELECT password FROM users WHERE email = '$un'";
        $result = $this->mysqli->query($sql) or die("username");
        $num = $result->num_rows;
        if ($num == 1) {
            $row = $result->fetch_array(MYSQLI_NUM);
            $pw = $this->randomPassword();
            $md5 = md5($pw);
            $sql = "update users set password='$md5'";
            $result = $this->mysqli->query($sql) or die("username");
            $sql = "SELECT email FROM users WHERE email = '$un'";
            $result = $this->mysqli->query($sql) or die("username");
            $row = $result->fetch_array(MYSQLI_NUM);
            $to = $row[0];
            $headers = 'From: ' . "\r\n" .
                        'Reply-To: ';
            $subject = "Password Retrieval";
            $message = "You have requested your password from the A.O.E Pi Chapter website. Your password has been reset, and your 
                    new login information is as follows: \n\nUsername: " . $un . "\nPassword: " . $pw;
            mail($to, $subject, $message, $headers);
            return "";
        }
        return "username";
    }
    
    function resetPass($old, $new) {
        $old = $this->quote_smart($old);
        $new = $this->quote_smart($new);
        
        $md5old = md5($old);
        $md5new = md5($new);
        $un = $_SESSION['userid'];
        $sql = "select * from users where password='$md5old' and username='$un'";
        $result = $this->mysqli->query($sql) or die("username");
        $num = $result->num_rows;
        if ($num == 1) {
            $sql = "update users set password='$md5new' where password='$md5old' and username='$un'";
            $result = $this->mysqli->query($sql) or die("username");
            return "success";
        }
        return "error";
    }
    
    function sendMessage($name, $email, $subject, $message) {
        //$to  = 'aoes-exec@virginia.edu';
        $to = 'slc4ga@virginia.edu';
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
    
    function deleteSister($un) {
        $sql = "delete from users where username='$un'";
        $result = $this->mysqli->query($sql) or die("delete sister");
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
        $sql = "select * from testimonials where approved=0";
        $result = $this->mysqli->query($sql) or die("all pending testimonials");
        return $result;
    }
    
    function getAllApprovedTestimonials() {
        $sql = "select * from testimonials where approved=1";
        $result = $this->mysqli->query($sql) or die("all approved testimonials");
        return $result;
    }
    
    function deleteTestimonial($id) {
        $sql = "delete from testimonials where id=$id";
        $result = $this->mysqli->query($sql) or die("delete testimonials");
    }
    
    function approve($id) {
        $sql = "update testimonials set approved=1 where id=$id";
        $result = $this->mysqli->query($sql) or die("approve testimonials"); 
    }
    
    function getPositions() {
        $sql = "SELECT DISTINCT posList.id,posList.name FROM posList left join leadership on 
                posList.id=leadership.position where posList.order=0";
        $result = $this->mysqli->query($sql) or die("positions"); 
        return $result;
    }
    
    function getExec() {
        $sql = "SELECT DISTINCT posList.id,posList.name FROM posList left join leadership on 
                posList.id=leadership.position where not posList.order=0 order by posList.order asc";
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
        
        $sql = "select username from profiles where first_name='$array[0]' and last_name='$array[1]'";
        $result = $this->mysqli->query($sql) or die("get username");  
        $row = $result->fetch_array(MYSQLI_NUM);

        $sql = "insert into leadership values('$row[0]', '$pos')";
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
            WHERE leadership.username = '$id'"; 
        $result = $this->mysqli->query($sql) or die("leadership lookup");  
        $row = $result->fetch_array(MYSQLI_NUM);
        return $row[0]; 
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
    
    function getFamilies() {
        $sql = "select distinct family from families";
        $result = $this->mysqli->query($sql) or die("family names");  
        return $result;    
    }
}

?>