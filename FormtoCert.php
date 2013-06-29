<?php

require_once('../library/odf.php');
require_once('dbase.php');

$odf = new odf("Blue.odt");

// Assigning Form data to variables.
$var =0;
$name = $_POST["sal"];
$firstName = $_POST["fname"];
$middleName = $_POST["mname"];
$lastName = $_POST["lname"];
$institute = $_POST["ins"];
$city = $_POST["city"];
$state = $_POST["state"];

//assigning image name to variable photo.
$photo = $_FILES["file"]["name"];

//Moving uploaded file to uploads directory on server.
move_uploaded_file($_FILES["file"]["tmp_name"],"uploads/" . $_FILES["file"]["name"]);


//Condition check for redundancy of data to be added to database. 
$check = mysql_query("SELECT * FROM data");

while($row = mysql_fetch_array($check))
{
                 if($name == $row['sal'] && $firstName == $row['1st_name'] && $middleName == $row['middle_name'] && 
                  $lastName == $row['last_name'] && $institute == $row['institute'] && $city == $row['city'] && 
                  $state == $row['state'] && $photo == $row['photo'])
                           {
                                $var++;
                           }
}

//Inserting data into database after redundancy check. 
if($var == 0)
{
                  mysql_query("INSERT into data VALUES('$name','$firstName','$middleName','$lastName','$institute','$city','$state','$photo')");
}

//Selecting the user entered data from database and replacing with the tags in odt document. 

$result = mysql_query("SELECT * FROM data WHERE sal = '$name' AND 1st_name = '$firstName' AND middle_name = '$middleName'
 AND last_name = '$lastName' AND institute = '$institute' AND city = '$city' AND state = '$state' AND photo = '$photo'");

$article = $odf->setSegment('articles');
while($row = mysql_fetch_array($result))
{
	
		 //image
            
                $pic = "uploads/" . $row['photo'];
                $article->setImage('pic',$pic,4,4);
		
		//name
                if($row['middle_name']==NULL)
		         $article->nameArticle(" ".$row['sal']." ".$row['1st_name']." ".$row['last_name']);
		else
                         $article->nameArticle(" ".$row['sal']." ".$row['1st_name']." ".$row['middle_name']." ".$row['last_name']); 
		//department
		$article->deptArticle($row['institute'].", ".$row['city']);
	
	$article->merge();			
}	

$odf->mergeSegment($article);

// We export the file
$odf->exportAsAttachedFile();
 
?>
