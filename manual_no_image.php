<?php
session_start();
require_once('library/odf.php');
require_once('decide.php');

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
  

$article = $odf->setSegment('articles');	//Defining Segment articles( used in .odt file)
	
		 //image

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
?>
