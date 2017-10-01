<?php session_start();

require_once('../library/odf.php');

  $id = uniqid();				//To be used with filenames to differentiate simultaneous files being processed 
  $csv = $id.$_FILES["file"]["name"];

/******************************** csv File input validation********************************************/

//Link to other file in case any of folllowing conditions fail
$url = "<meta http-equiv='Refresh' content='3; URL=option.php?var=csv'>";


if($_FILES["file"]["name"] == NULL)		//checks if no file is selected
	{
	echo "<center><h2>NO (.csv) File Selected</h2></center>";
	echo $url;
	exit;
	}

else
	{
	$ext = strrchr($csv,".");

	   if($ext != ".csv")			//checks if csv format file is not selected
		{
		echo "<center><h2>Invalid File Format for .csv file...</h2></center>";
		echo $url;
		exit;
		}
move_uploaded_file($_FILES["file"]["tmp_name"],"uploads/csv/data/".$csv);
	} 

$base = $_SESSION["base"];			//Getting file name with filled Institute Details
  
$odf = new odf("odt/base/$base.odt"); 		//Initializing the object with above file name
 
$file = $_FILES["photo"]["name"];
  	if($file == NULL)			//checks if no file is selected
  	  {
  	    echo "<center><h2>No compressed file selected for images<h2></center>";
  	    echo $url;
  	    exit;
    	  }
chdir('uploads/csv/');
exec("mkdir $id");				//MAking folder to store the compressed file and then ectract it.
move_uploaded_file($_FILES["photo"]["tmp_name"],"$id/$file");     //storing the compressed folder for images in 
  
$extension = strrchr($file,".");		//using strrchr() to fetch the extension of the file
  
chdir("$id");					//Changing the directory to extract the files at that location
  
	if ($extension == ".gz")
	  {
      	    exec("tar -zxvf $file");		//extracting the tar.gz file;
    	  }
  	elseif($extension == ".zip")
    	  {
     	    exec("unzip $file");		//extracting the zip file;
    	  }
  	else
  	  {
	    echo "<center><strong>Invalid File Format for compressed images Folder.</strong></center>";
	    echo $url;
	    exit;      
	  }
chdir('../../..');				//changing directory back to previous 

$dest =  strtok($_FILES["photo"]["name"],".");	//using strtok for storing the folder Name after extraction
unlink("uploads/csv/$id/$file");  		//After Extracting Deleting the compressed file 


$csvfile = fopen("uploads/csv/data/$csv","r");	//Opening csv file in read mode

//Variable initialised to trace line Number being processed
$lineNumber = 1;

//Variable initialised to trace if any error in csv file occurs
$errorExist = 0;

$article = $odf->setSegment('articles');	//Defining Segment articles( used in .odt file)

//Fetching data in each row of csv file to array $result
while(($result = fgetcsv($csvfile,1000, ","))!==FALSE)
{
	
		 //image
            
                $pic = "uploads/csv/$id/$dest/".$result[7];
		if(!file_exists($pic))
                  {
                  $pic = "uploads/manual/image.gif";
                 }

                $article->setImage('pic',$pic,4);
		
		//name
                if($result[2] == NULL)
		         $article->nameArticle(" ".$result[0]." ".$result[1]." ".$result[3]);
		else
                         $article->nameArticle(" ".$result[0]." ".$result[1]." ".$result[2]." ".$result[3]); 
		//Institute/Department Name
		if($result[5] == NULL)
			$article->deptArticle($result[4].", ".$result[6]);
		else
			$article->deptArticle($result[4].", ".$result[5]);
	
	$article->merge();			//Ending the current segment
}	

$odf->mergeSegment($article);			//Ending the segment Object

// We save the file
$odf -> saveToDisk("odt/cert/$id.odt"); 
/*
//copying the odt file to be converted to PDF
	copy("odt/cert/$id.odt", "../odt2pdf/cde-root/home/sukhdeep/Desktop/$id.odt");

//changing Directory
	chdir('../odt2pdf/cde-root/home/sukhdeep');

//Command for conversion to PDF
	$myCommand = "./libreoffice.cde --headless --convert-to pdf:writer_pdf_Export Desktop/$id.odt --outdir Desktop/";
	exec ($myCommand);

//Copying the converted file to the PDF folder
	copy("Desktop/$id.pdf", "../../../../CGS/pdf/$id.pdf");
	unlink("Desktop/$id.pdf");
	unlink("Desktop/$id.odt");
*/
$source_file = "odt/cert/$id.odt";
$command = 'unoconv -f pdf --output /var/www/html/Certificate/CGS/pdf/ ' . $source_file;
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

	<form action="index.html">
	<input class="btn btn-primary" type="submit" value="Goto First Page">
	</form>
	</center>
	</body>
	</html>';

exit;
?>
