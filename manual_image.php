<?php
session_start();
require_once('library/odf.php');
$base = $_SESSION["base"]; 				//Getting file name with filled Institute Details
$odf = new odf("odt/base/$base.odt");   		//Initializing the object with above file name
$id = uniqid();
$_SESSION['id'] = $id;					//To be used with filenames to differentiate simultaneous files being processed

//Using Session variables to fetch form data
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{

	$name = $_SESSION['sal'];
	$fname = $_SESSION['fname'];
	$mname = $_SESSION['mname'];
	$lname = $_SESSION['lname'];
	$ins = $_SESSION['ins'];
	$city = $_SESSION['city'];
	$state = $_SESSION['state'];
	$photo = $_SESSION['photo'];
	$id = $_SESSION['id'];
        
	$targ_w = $targ_h = 500;	//Dimensions of cropped image
	$jpeg_quality = 100;		//Quality of cropped image

	$src = "uploads/manual/src.jpg";

	//defining handles for creating the crooped image
	$img_r = imagecreatefromjpeg($src);		
	$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );
	
	//Generating the image using co-ordinates represented by the Crop Box
	imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'],
	$targ_w,$targ_h,$_POST['w'],$_POST['h']);
	
	//saving the jpeg image after cropping
	imagejpeg($dst_r,"uploads/manual/cropped/$photo",$jpeg_quality);


$article = $odf->setSegment('articles');	//Defining Segment articles( used in .odt file)
		 //image
                $pic = "uploads/manual/cropped/".$photo;
                
                if(!file_exists($pic))
                  {
                  $pic = "uploads/manual/image.gif";
                 }
		$article->setImage('pic',$pic,4);
		
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
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Live Image Selector</title>
  <h1><center>Crop Image</center></h1>      
  <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
  <script src="jcrop/jquery.min.js"></script>
  <script src="jcrop/jquery.Jcrop.js"></script>
  <link rel="stylesheet" href="jcrop/main.css" type="text/css" />
  <link rel="stylesheet" href="jcrop/demos.css" type="text/css" />
  <link rel="stylesheet" href="jcrop/jquery.Jcrop.css" type="text/css" />

<script type="text/javascript">

  $(function(){

    $('#cropbox').Jcrop({
      boxWidth: 700,
      boxHeight: 700,
      aspectRatio: 1,
      setSelect:   [50, 0, 400,400],
      minSize: [400,400],
      allowSelect: false,
      onSelect: updateCoords
    });

  });

  function updateCoords(c)
  {
    $('#x').val(c.x);
    $('#y').val(c.y);
    $('#w').val(c.w);
    $('#h').val(c.h);
  };

  function checkCoords()
  {
    if (parseInt($('#w').val())) return true;
    alert('Please select a crop region then press submit.');
    return false;
  };

</script>
<style type="text/css">
  #target {
    background-color: #ccc;
    width: 500px;
    height: 330px;
    font-size: 24px;
    display: block;
  }


</style>

</head>
<body background="html/bck.jpg">

<div class="container">
<div class="row">
<div class="span12">
<div class="jc-demo-box">



		<!-- This is the image we're attaching Jcrop to -->
		<img src="uploads/manual/src.jpg" id="cropbox" />

		<!-- This is the form that our event handler fills -->
		<form action="manual_image.php" method="post" onsubmit="return checkCoords();">
			<input type="hidden" id="x" name="x" />
			<input type="hidden" id="y" name="y" />
			<input type="hidden" id="w" name="w" />
			<input type="hidden" id="h" name="h" />
			<input type="submit" value="Save & Generate Certificate" class="btn btn-large btn-inverse" /><!--..........CHANGE...-->
		</form>

		<p>
			<b>Image Cropping Area.</b>Highlighted portion of the image will be selected.
		</p>


	</div>
	</div>
	</div>
	</div>
	</body>

</html>
