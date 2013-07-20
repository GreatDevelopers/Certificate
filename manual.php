<?php session_start(); ?>
<?php

require_once('../library/odf.php');

$odf = new odf("new.odt");
if ($_SERVER['REQUEST_METHOD'] == 'POST')  //My condition;
{
// Assigning Form data to variables.
$name = $_POST["sal"];
$firstName = $_POST["fname"];
$middleName = $_POST["mname"];
$lastName = $_POST["lname"];
$institute = $_POST["ins"];
$city = $_POST["city"];
$state = $_POST["state"];

$_SESSION['name'] = $name;
$_SESSION['fname'] = $firstName;
$_SESSION['mname'] = $middleName;
$_SESSION['lname'] = $lastName;
$_SESSION['ins'] = $institute;
$_SESSION['city'] = $city;
$_SESSION['state'] = $state;



//assigning image name to variable photo.
$photo = $_FILES["file"]["name"]; 
$_SESSION['photo'] = $photo;

/*************************************** Image Validation********************************************/
$url = "<meta http-equiv='Refresh' content='1; URL=option.php?var=manual'>";
if (($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/jpg")
|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "image/x-png")
|| ($_FILES["file"]["type"] == "image/png"))
{
if($_FILES["file"]["size"] > 400144)//...............................................................................................Change
{
echo "<center><h1>Image Size Exceeded...</h1></center>";
sleep (2);
echo $url;
exit;
}
}
else
{
echo "<center><h1>No OR Invalid Image File...</h1></center>";
sleep (2);
echo $url;
exit;
}

//Moving uploaded file to uploads directory on server.
move_uploaded_file($_FILES["file"]["tmp_name"],"uploads/" . $_FILES["file"]["name"]);
copy("uploads/".$_FILES["file"]["name"],"uploads/src.jpg");
}


else //Else Condition	`			

{

	$name = $_SESSION['name'];
	$fname = $_SESSION['fname'];
	$mname = $_SESSION['mname'];
	$lname = $_SESSION['lname'];
	$ins = $_SESSION['ins'];
	$city = $_SESSION['city'];
	$state = $_SESSION['state'];
	$photo = $_SESSION['photo'];

        $targ_w = $targ_h = 500;
	$jpeg_quality = 100;

	$src = "uploads/$photo";
	$img_r = imagecreatefromjpeg($src);
	$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

	imagecopyresampled($dst_r,$img_r,0,0,$_GET['x'],$_GET['y'],
	$targ_w,$targ_h,$_GET['w'],$_GET['h']);

	imagejpeg($dst_r,"uploads/cropped/$photo",$jpeg_quality);


//$article = $odf->setSegment('articles');
	
		 //image
            
                $pic = "uploads/cropped/".$photo;
                
                if(!file_exists($pic))
                  {
                  $pic = "uploads/image.gif";
                 }
	
		$odf->setImage('pic',$pic,4);
		//name
                if($mname == NULL)
		         $odf->setVars('nameArticle'," ".$name." ".$fname." ".$lname);
		else
                         $odf->setVars('nameArticle'," ".$name." ".$fname." ".$mname." ".$lname); 
		//department
		if($city == NULL)
			$odf->setVars('deptArticle',$ins.", ".$state);
		else
			$odf->setVars('deptArticle',$ins.", ".$city);


	
//	$article->merge();	

//$odf->mergeSegment($article);

// We save the file

$odf -> saveToDisk("cert.odt");

//copying the file to be converted
copy("cert.odt", "../../Convert/cde-root/home/sukhdeep/Desktop/certificate.odt");

//changing Directory
chdir('../../Convert/cde-root/home/sukhdeep');

//Command for conversion to PDF
$myCommand = "./libreoffice.cde --headless -convert-to pdf Desktop/certificate.odt -outdir Desktop/";
exec ($myCommand);


copy("Desktop/".str_replace(".odt", ".pdf", "certificate.odt"), "../../../../Demo/test.wdout.db/pdf/".str_replace(".odt", ".pdf", "certificate.odt"));



echo   '<html>
	<body background="html/bck.jpg">
	<h1>Your Certificate has been Generated!</h1>
	<center><p>
	<form action="cert.odt">
	<input type="submit" value="Download ODT">
	</form>
	<form action="pdf/certificate.pdf">
	<input type="submit" value="View/Download PDF">
	</form></p>	
	<form action="option.php?var=manual" method = "GET">
	<input type=hidden name=var value=manual>
	<input type="submit" value="Generate Another Certificate">
	</form>
	<form action="index.html">
	<input type="submit" value="Goto First Page">
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
  <h1><center>Crop Image</center></h1>      <!--...........................................................CHANGE...............-->
  <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
  <script src="jcrop/jquery.min.js"></script>
  <script src="jcrop/jquery.Jcrop.js"></script>
  <link rel="stylesheet" href="jcrop/main.css" type="text/css" />
  <link rel="stylesheet" href="jcrop/demos.css" type="text/css" />
  <link rel="stylesheet" href="jcrop/jquery.Jcrop.css" type="text/css" />

<script type="text/javascript">

  $(function(){               //.......................................................................................inFunctionChange

    $('#cropbox').Jcrop({
      boxWidth: 882,
      boxHeight: 1000,
      aspectRatio: 1,
      setSelect:   [50, 0, 400,400],
      minSize: [400,400],
      maxSize: [1200,1200],
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
		<img src="uploads/src.jpg" id="cropbox" />

		<!-- This is the form that our event handler fills -->
		<form action="manual.php" method="get" onsubmit="return checkCoords();">
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
