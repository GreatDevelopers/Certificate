<html>
<body>
<?php
require_once('../library/odf.php');
require_once('database.php');

$odf = new odf("certify.odt");
 /* storing data from html form to php variables*/
$insName = $_POST["in"];
$aidedStatus = $_POST["as"];
$insTagline = $_POST["it"];
$affilliation = $_POST["a"];
$event = $_POST["e"];
$topic = $_POST["t"];
$sign1 = $_POST["s1"];
$sign2 = $_POST["s2"];
$sign3 = $_POST["s3"];
$des1 = $_POST["d1"];
$des2 = $_POST["d2"];
$des3 = $_POST["d3"];
$var = 0;


if($insName == NULL && $aidedStatus == NULL && $insTagline == NULL && 
                  $affilliation == NULL && $event == NULL && $topic == NULL && 
                  $sign1 == NULL && $des1 == NULL && 
                  $sign2 == NULL && $des2 == NULL && 
                  $sign3 == NULL && $des3 == NULL)
{
       $result = mysql_query("SELECT * FROM `table` ORDER BY id DESC LIMIT 1");
}
else
{
$check = mysql_query("SELECT * FROM `table`");

while($row = mysql_fetch_array($check))
{
                 if($insName == $row['Institution_Name'] && $aidedStatus == $row['Aided_Status'] && $insTagline == $row['Institute_Tagline'] && 
                  $affilliation == $row['Affilliation'] && $event == $row['Event'] && $topic == $row['Topic'] && 
                  $sign1 == $row['Sign1'] && $des1 == $row['Desg1'] && 
                  $sign2 == $row['Sign2'] && $des2 == $row['Desg2'] && 
                  $sign3 == $row['Sign3'] && $des3 == $row['Desg3'])
                           {
                                $var++;
                           }
}

//Inserting data into database after redundancy check. 
if($var == 0)
{
		
  mysql_query("INSERT into `table` VALUES                      ('','$insName','$aidedStatus','$insTagline','$affilliation','$event','$topic','$sign1','$des1','$sign2','$des2','$sign3','$des3')");
echo "Done";
}


//Selecting the user entered data from database 

$result = mysql_query("SELECT * FROM `table` WHERE Institution_Name = '$insName' && Aided_Status = '$aidedStatus' && Institute_Tagline = '$insTagline' && 
                  Affilliation = '$affilliation' && Event = '$event' && Topic = '$topic' && 
                  Sign1 = '$sign1' && Desg1 = '$des1' && 
                  Sign2 = '$sign2' && Desg2 = '$des2' && 
                  Sign3 = '$sign3' && Desg3 = '$des3'");
}
$res = mysql_fetch_array($result);

$odf -> setvars('College',$res['Institution_Name']);
$odf -> setvars('status',$res['Aided_Status']);
$odf -> setvars('tagline',$res['Institute_Tagline']);
$odf -> setvars('other',$res['Affilliation']);
$odf -> setvars('sub',$res['Event']);
$odf -> setvars('Event',$res['Topic']);
$odf -> setvars('sign1',$res['Sign1']);
$odf -> setvars('sign2',$res['Sign2']);
$odf -> setvars('sign3',$res['Sign3']);
$odf -> setvars('d1',$res['Desg1']);
$odf -> setvars('d2',$res['Desg2']);
$odf -> setvars('d3',$res['Desg3']);


$odf -> saveToDisk("new.odt");
?>
<form action="FormtoCert.php" method="post" enctype="multipart/form-data">

SAL:         <input type="text" name="sal"><br>
First Name:  <input type="text" name="fname"><br>
Middle Name: <input type="text" name="mname"><br>
Last Name:   <input type="text" name="lname"><br>
Institution: <input type="text" name="ins"><br>
City:        <input type="text" name="city"><br>
state:       <input type="text" name="state"><br>
photo:       <input type="file" name="file" id="file"><br>
<input type="submit" value ="GENERATE">
</form>
<form action="next.php">
<input type="submit" value="GENERATE ANOTHER CANDIDATE CERTIFICATE">
</form>


</body>
</html> 
