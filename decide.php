<?php
session_start();
require_once('library/odf.php');
$base = $_SESSION["base"]; 				//Getting file name with filled Institute Details
$odf = new odf("odt/base/$base.odt");   		//Initializing the object with above file name
$id = uniqid();
$_SESSION['id'] = $id;					//To be used with filenames to differentiate simultaneous files being processed
//echo $_SERVER['REQUEST_METHOD'];
if ($_SERVER['REQUEST_METHOD'] == 'POST')  
{
// Assigning Form data to sesssion variables to be used in next step.
//echo $_POST["mname"];

$_SESSION['sal'] = $_POST["sal"];
$_SESSION['fname'] = $_POST["fname"];
$_SESSION['mname'] = $_POST["mname"];
$_SESSION['lname'] = $_POST["lname"];
$_SESSION['ins'] = $_POST["ins"];
$_SESSION['city'] = $_POST["city"];
$_SESSION['state'] = $_POST["state"];
//echo $_SESSION['lname'];
//assigning image name to variable photo.
$photo = "$id".strtok($_FILES["file"]["name"],".");	//using strtok() to store filename without extension
$_SESSION['photo'] = $photo;				//Assigning Photo variable to session vatriable

/*************************************** Image Validation********************************************/

// Link to the other file if any of following condition fails
$url = "<meta http-equiv='Refresh' content='3; URL=option.php?var=manual'>"; 

if($_FILES["file"]["size"] > 400144)            //Size validation Condition(should be less than 400kb)
        {
          echo "<center><strong>Image Size Exceeded...</strong></center>";
          echo $url;
          exit;
        }



if($_FILES["file"]["name"] == Null)		//checks if no file is selected
	{
header( "Location: manual_no_image.php" );die;
	}

else{
//echo $_POST["mname"];
move_uploaded_file($_FILES["file"]["tmp_name"],"uploads/manual/" .$photo);

$photo_path = "uploads/manual/$photo";          //storing path of uploaded photo in variable

//Checking the type of uploaded Image file

if ($_FILES["file"]["type"] == "image/gif")
        $origin = imagecreatefromgif($photo_path);

elseif($_FILES["file"]["type"] == "image/jpeg")
        $origin = imagecreatefromjpeg($photo_path);

elseif($_FILES["file"]["type"] == "image/jpg")
        $origin = imagecreatefromjpeg($photo_path);

elseif($_FILES["file"]["type"] == "image/png")
        $origin = imagecreatefrompng($photo_path);

//In case of any other format of uploaded file
else
        {
          echo "<center><strong>Invalid Image File...</strong></center>";
          echo $url;
          exit;
        }

$originWidth = imagesx($origin);   //Width of original uploaded image
$originHeight = imagesy($origin);  //Height of original uploaded image

//creating another image to which the original image is copied
$destination = imageCreateTrueColor( $originWidth, $originHeight );

//Copying the original uploaded image to new created one
imagecopyresampled($destination,$origin,0,0,0,0,$originWidth,$originHeight,$originWidth,$originHeight);

//Finally saving the image as jpeg in directory to be used by cropping tool
imagejpeg($destination,"uploads/manual/src.jpg",100);




header( "Location: manual_image.php" );
}
}
?>
