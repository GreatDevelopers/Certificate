
<html>
	<head>		
		<title>Candidate Details</title>
		<h1><center> Candidate Details Form</center></h1>
		<link href="style/bootstrap.min.css" rel="stylesheet" media="screen">	
		<link href="style/style.css" rel="stylesheet" media="screen">
<script>
function validateForm()
{
var check1=document.forms["new"]["fname"].value;
if (check1==null || check1=="")
   {
        alert("First Name must be filled out");
	return false;
   }
	if (!check1.match(/^[A-Za-z]/))	    
   {
		alert("Invalid Characters Entered in First Name");
		return false;
   }
var check2=document.forms["new"]["mname"].value;

if (check2.match(/^[0-9]/))
    {
		alert("Invalid Characters Entered in Middle Name");
		return false;
    } 
var check3 =document.forms["new"]["lname"].value;
if (check3==null || check3=="")
   {
        alert("Last Name must be filled out");
	return false;
	}
	if (!check3.match(/^[A-Za-z]/))
	    {
		alert("Invalid Characters Entered in Last Name");
		return false;
}
var check4=document.forms["new"]["ins"].value;
if (check4==null || check4=="")
   {
        alert("Institute must be filled out");
	return false;
	}
	if (!check4.match(/^[A-Za-z]/))
	    {
		alert("Invalid Characters Entered in Institute");
		return false;
}
var check5=document.forms["new"]["city"].value;
if (check5.match(/^[0-9]/))
    {
		alert("Invalid Characters Entered in City");
		return false;
    } 
var check6=document.forms["new"]["state"].value;
if (check6==null || check6=="")
   {
        alert("State must be filled out");
	return false;
	}
	if (!check6.match(/^[A-Za-z]/))
	    {
		alert("Invalid Characters Entered in State");
		return false;
}


}
</script>


<?php
if($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET["var"] == "manual")		//On Selecting Manual Entry

{
echo '
<body>
<center><h2>(Manual Entry)</h2><table>
<p class ="bottom-one">
<form name=new action="manual.php" method="post" enctype="multipart/form-data" onSubmit="return validateForm();">
<tr>
<tr><td>Name Initial:</td>
		    <td><select class="span1" name ="sal">
  			<option value="Mr.">Mr.</option>
  			<option value="Ms.">Ms.</option>
  			<option value="Mrs.">Mrs.</option>
			</select></td></tr>
<tr><td>First Name:</td> 
 <td><input type="text" name="fname"></td></tr>
<tr><td>Middle Name:</td> 
 <td><input type="text" name="mname"></td></tr>
<tr><td>Last Name:</td> 
 <td><input type="text" name="lname"></td></tr>
<tr><td>Institution:</td> 
 <td><input type="text" name="ins"></td></tr>
<tr><td>City:</td> 
 <td><input type="text" name="city"></td></tr>
<tr><td>State:</td> 
 <td><input type="text" name="state"></td></tr>
<tr><td>Photo:</td> 
 <td><input type="file" name="file" id="file"></td></tr>
</table>
(Size must be less than <strong>400 kb</strong>)</br>
<input class="btn btn-primary" type="submit" value ="GENERATE">
</form>
</center>
</p>
</body>';
exit;
}

elseif($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET["var"] == "csv")		//on selecting upload csv file
{
echo '  <body >
	<center><h2>(CSV File Input)</h2>
	<h4>Data format in (.csv) file</h4>
	<p> <li> Initials,Firstname,Middlename,lastname,institute,city,state,photo</li>
	<li>Data for each field must be enclosed in double quotes(").</li>
	<li>comma(,) must be used as separator.</li>
	<li>Photos folder must be in <strong>(.zip)</strong> or <strong>(.tar.gz)</strong> format.</li><br>
	<strong>Note:</strong><br>
	<li>Sample file containing csv and .tar.gz files can be Downloaded <a href="sample.zip">HERE</a></li>
	</p></center><br><br>
	<form action=csv.php method = "POST" action="csv.php" enctype="multipart/form-data">
	<strong>Select your (.csv) file: </strong><input type="file" name="file">
	<p><strong>Select your (.tar.gz) or (.zip) file:</strong><input type="file" name="photo"><br>
	<input class="btn btn-primary" type="submit" value="Submit"></p>
	</form>
	</body>
';
exit;
}
else
{
echo "<center><strong>Something Wrong Occured!</strong></center>";
echo "<meta http-equiv='Refresh' Content='2; URL:index.html'>";
exit;
}

?>
