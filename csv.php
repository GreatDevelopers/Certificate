<html>
<body>

<?php

require_once('../library/odf.php');

$csv = $_FILES["file"]["name"];
/******************************** csv File input validation********************************************/

$url = "<meta http-equiv='Refresh' content='1; URL=option.php?var=csv'>";
if($csv == NULL)
{
echo "<center><h2>NO (.csv) File Selected</h2></center>";
echo $url;
exit;
}
else
{
$csvtoken = strtok($csv,".");
  while ($csvtoken != false)
    {
      $ext = $csvtoken;
      $csvtoken = strtok(".");
    }
if($ext != "csv")
{
echo "<center><h2>Invalid File Format for .csv file...</h2></center>";
echo $url;
exit;
}
move_uploaded_file($_FILES["file"]["tmp_name"],$_FILES["file"]["name"]);
} 

  
  $odf = new odf("new.odt");


  $file = $_FILES["photo"]["name"];
  if($file == NULL)
  {
  echo "<center><h2>No compressed file selected for images<h2></center>";
  echo $url;
  exit;
  }

  move_uploaded_file($_FILES["photo"]["tmp_name"],$_FILES["photo"]["name"]);
  $token = strtok($file,".");
  while ($token != false)
    {
      $new = $token;
      $token = strtok(".");
    }

  if ($new == "gz")
    {
      //echo "tar.gz file";
      exec("tar -zxvf $file");
    }
  elseif($new == "zip")
    {
     //echo "zip file";
     exec("unzip $file");
    }
  else
    {
     echo "<center><strong>Invalid File Format for compressed images Folder.</strong></center>";
     echo $url;
     exit;      
}

$dest =  strtok($file,".");
unlink("$file");


$csvfile = fopen("$csv","r");

$article = $odf->setSegment('articles');
while($result = fgetcsv($csvfile))
{
	
		 //image
            
                $pic = "$dest/".$result[7];
		if(!file_exists($pic))
                  {
                  $pic = "uploads/image.gif";
                 }

                $article->setImage('pic',$pic,4);
		
		//name
                if($result[2] == NULL)
		         $article->nameArticle(" ".$result[0]." ".$result[1]." ".$result[3]);
		else
                         $article->nameArticle(" ".$result[0]." ".$result[2]." ".$result[2]." ".$result[3]); 
		//department
		if($result[5] == NULL)
			$article->deptArticle($result[4].", ".$result[6]);
		else
			$article->deptArticle($result[4].", ".$result[5]);
	
	$article->merge();			
}	

$odf->mergeSegment($article);


// We save the file
$odf -> saveToDisk("cert.odt"); 

//copying the file to be converted
copy("cert.odt", "../../Convert/cde-root/home/sukhdeep/Desktop/certificate.odt");

//changing Directory
chdir('../../Convert/cde-root/home/sukhdeep');

//Command for conversion to PDF
$myCommand = "./libreoffice.cde --headless -convert-to pdf Desktop/certificate.odt -outdir Desktop/";
exec ($myCommand);

//Copying the converted file to the PDF folder
copy("Desktop/".str_replace(".odt", ".pdf", "certificate.odt"), "../../../../Demo/test.wdout.db/pdf/".str_replace(".odt", ".pdf", "certificate.odt"));

echo   '<h1>Your Certificate has been Generated!<h/1>
	<body background="html/bck.jpg">
	<center>
	<form action="cert.odt">
	<input type="submit" value="Download ODT">
	</form>

	<form action="pdf/certificate.pdf">
	<input type="submit" value="View/Download PDF">
	</form>

	<form action="index.html">
	<input type="submit" value="Goto First Page">
	</form>
	</center>
	</body>';

exit;

?>


</body>
</html> 
