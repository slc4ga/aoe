<?
    session_start();

    if(!isset($_SESSION['user_id'])) {
        header("location: ../index.php");
    }

    
    if($_POST) {
        if($_POST['picUpload']) {
            $image = $_FILES['file']['name'];
            $uploadedfile = $_FILES['file']['tmp_name'];
            if ($image) {
                $filename = stripslashes($_FILES['file']['name']);
                $i = strrpos($filename,".");
                if (!$i) { $ext=""; }
                else {
                    $l = strlen($filename) - $i;
                    $ext = substr($filename,$i+1,$l);
                }
                $extension = $ext;
                $extension = strtolower($extension);
                if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif"))  {
                    echo ' Unknown Image extension ';
                    $errors=1;
                }
                else {
                    $size=filesize($_FILES['file']['tmp_name']);
                    $name = $_SESSION['user_id'] . ".jpg";
                    if($extension=="jpg" || $extension=="jpeg" || $extension=="JPG" || $extension=="JPEG") {
                        $uploadedfile = $_FILES['file']['tmp_name'];
                        $src = imagecreatefromjpeg($uploadedfile);
                    }
                    else if($extension=="png" || $extension=="PNG") {
                        $uploadedfile = $_FILES['file']['tmp_name'];
                        $src = imagecreatefrompng($uploadedfile);
                    }
                    else {
                        $src = imagecreatefromgif($uploadedfile);
                    }
                    list($width,$height)=getimagesize($uploadedfile);
                    $newwidth=190;
                    $newheight=240;
                    $tmp=imagecreatetruecolor($newwidth,$newheight);
                    imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
                    imagejpeg($tmp,"../img/$name",100);
                    imagedestroy($src);
                    imagedestroy($tmp);
                    move_uploaded_file($_FILES["file"]["tmp_name"],"../img/$name");
                    header("location:userHome.php?select=2");
                    //echo "stop";
                }
            } else {
                $response = "file";
            }
        }
    }
?>