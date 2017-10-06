<?php
session_start();
require_once('library/odf.php');
require_once('decide.php');
//$base = $_SESSION["base"]; 				//Getting file name with filled Institute Details
//$odf = new odf("odt/base/$base.odt");   		//Initializing the object with above file name
//$id = uniqid();
//$_SESSION['id'] = $id;					//To be used with filenames to differentiate simultaneous files being processed

/*
if ($_SERVER['REQUEST_METHOD'] == 'POST')  
{
// Assigning Form data to sesssion variables to be used in next step.

$_SESSION['sal'] = $_POST["sal"];
$_SESSION['fname'] = $_POST["fname"];
$_SESSION['mname'] = $_POST["mname"];
$_SESSION['lname'] = $_POST["lname"];
$_SESSION['ins'] = $_POST["ins"];
$_SESSION['city'] = $_POST["city"];
$_SESSION['state'] = $_POST["state"];

*/
//assigning image name to variable photo.

//$photo = "$id".strtok($_FILES["file"]["name"],".");	//using strtok() to store filename without extension
//$_SESSION['photo'] = $photo;				//Assigning Photo variable to session vatriable

/*************************************** Image Validation********************************************/

// Link to the other file if any of following condition fails
/*
$url = "<meta http-equiv='Refresh' content='3; URL=option.php?var=manual'>"; 


if($_FILES["file"]["name"] == Null)		//checks if no file is selected
	{
	  echo "<center><strong>No Image Selected!</strong></center>";
	  echo $url;
	  exit;
	}


if($_FILES["file"]["size"] > 400144) 		//Size validation Condition(should be less than 400kb)
	{
	  echo "<center><strong>Image Size Exceeded...</strong></center>";
	  echo $url;
	  exit;
	}

//moving the uploaded file to directory
move_uploaded_file($_FILES["file"]["tmp_name"],"uploads/manual/" .$photo);

$photo_path = "uploads/manual/$photo";		//storing path of uploaded photo in variable

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

}


else 
{
*/
//Using Session variables to fetch form data
	$name = $_SESSION['sal'];
	$fname = $_SESSION['fname'];
	$mname = $_SESSION['mname'];
	$lname = $_SESSION['lname'];
	$ins = $_SESSION['ins'];
	$city = $_SESSION['city'];
	$state = $_SESSION['state'];
	$photo = $_SESSION['photo'];
	$id = $_SESSION['id'];
  
/*      
	$targ_w = $targ_h = 500;	//Dimensions of cropped image
	$jpeg_quality = 100;		//Quality of cropped image

	$src = "uploads/manual/src.jpg";

	//defining handles for creating the crooped image
	$img_r = imagecreatefromjpeg($src);		
	$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );
	
	//Generating the image using co-ordinates represented by the Crop Box
	imagecopyresampled($dst_r,$img_r,0,0,$_GET['x'],$_GET['y'],
	$targ_w,$targ_h,$_GET['w'],$_GET['h']);
	
	//saving the jpeg image after cropping
	imagejpeg($dst_r,"uploads/manual/cropped/$photo",$jpeg_quality);
*/

$article = $odf->setSegment('articles');	//Defining Segment articles( used in .odt file)
	
		 //image
/*  
              $pic = "uploads/manual/cropped/".$photo;
                
                if(!file_exists($pic))
                  {
                  $pic = "uploads/manual/image.gif";
                 }
		$article->setImage('pic',$pic,4);
*/		
$article->pic(" ");
		//name
                 if($mname==NULL)
		         $article->nameArticle(" ".$name." ".$fname." ".$lname);
		else
                         $article->nameArticle(" ".$name." ".$fname." ".$mname." ".$lname); 
		
		//Institute/department
		if($city==NULL)
			$article->deptArticle($ins.", ".$state);
		else
			$article->deptArticle($ins.", ".$city);
	$article->merge();	

$odf->mergeSegment($article);

// We save the file 

# Final ODT file.
$source_file = "odt/cert/$id.odt";
//$odf -> saveToDisk("odt/cert/$id.odt"); //Saving the odt file to directory
$odf -> saveToDisk($source_file); //Saving the odt file to directory
//Convert the odt format to pdf

//$source_file = "odt/cert/$id.odt";
$output_file = "/pdf/$id.pdf";
$get_current_dir= getcwd();
//$command = 'sudo unoconv -f pdf --output /var/www/html/Certificate/CGS/pdf/'.$source_file;
$command = 'unoconv -o ' .$get_current_dir.'/pdf/'.$id.'.pdf -f pdf ' .$source_file;
#$command = '/usr/bin/unoconv -o '.$output_file.' -f pdf '.$source_file;
$result = shell_exec($command);
echo $result;

echo   '<html>
	<head>
	<link href="style/bootstrap.min.css" rel="stylesheet" media="screen">	
	<link href="style/style.css" rel="stylesheet" media="screen">
	</head>
	<body>
	<center>	
	<h1>Your Certificate has been Generated!</h1>
	<form action="odt/cert/'.$id.'.odt">
	<input class="btn btn-primary" type="submit" value="Download ODT">
	</form>
	<form action="pdf/'.$id.'.pdf">
	<input class="btn btn-primary" type="submit" value="View/Download PDF">
	</form>	
	<form action="option.php?var=manual" method = "GET">
	<input type=hidden name=var value=manual>
	<input class="btn btn-primary" type="submit" value="Generate Another Certificate">
	</form>
	<form action="index.html">
	<input class="btn btn-primary" type="submit" value="Goto First Page">
	</form>
	</center>
	</body>
	</html>';

exit;
//}
?>
