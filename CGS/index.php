<?php session_start(); ?>
<?php

require_once('../library/odf.php');
$sel = $_GET["cert"];    //Represents Selection
$odf = new odf("odt/design/$sel.odt");
if($_SERVER['REQUEST_METHOD'] == 'POST')
{ 
// storing data from html form to php variables
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

//Setting the tags in odt file to be replaced by user filled data
$odf -> setvars('College',$insName);
$odf -> setvars('status',$aidedStatus);
$odf -> setvars('tagline',$insTagline);
$odf -> setvars('other',$affilliation);
$odf -> setvars('event',$event);
$odf -> setvars('topic',$topic);
$odf -> setvars('sign1',$sign1);
$odf -> setvars('sign2',$sign2);
$odf -> setvars('sign3',$sign3);
$odf -> setvars('d1',$des1);
$odf -> setvars('d2',$des2);
$odf -> setvars('d3',$des3);

$base = uniqid("base");
$_SESSION["base"] = $base;

$odf -> saveToDisk("odt/base/$base.odt");	//saving to Directory to be used in further steps

echo '  
	<html>
	<head>
		<link href="style/bootstrap.min.css" rel="stylesheet" media="screen">	
		<link href="style/style.css" rel="stylesheet" media="screen">
	</head>

	<body>
	<center>
	<h2>Institute Details Saved Succesfully!</h2>
	<h3>Please Select Next Option</h3>
	<form action = "option.php?var=manual" method = "GET">
	<input type=hidden name=var value=manual>
	<input class = "btn btn-primary" type="submit" value = "Fill Candidate Details Manually">
	</form>
	<form action="option.php?var=csv" method ="GET">
	<input type=hidden name=var value=csv>
	<input class = "btn btn-primary" type="submit" value="Upload CSV file">
	</form>
	</center>
	<p><h4>Note:</h4>
	<li><strong>Manual:</strong> Generates Certificate for One Candidate by manually filling Candidate Details.</li>
	<li><strong>UPload CSV:</strong> This feature allow you to generate Batch certificates by simply taking csv file (for Candidate Details) & a compressed file containing images. 
      
	</body>';
	exit;
}

?>

<html>
	<head>		
		<title>Academic Certificate</title>
		<link href="style/bootstrap.min.css" rel="stylesheet" media="screen">	
		<link href="style/style.css" rel="stylesheet" media="screen">

<script>
function validateForm()
{
var check1=document.forms["new"]["in"].value;
if (check1==null || check1=="")
   {
        alert("Institute Name must be filled out");
	return false;
	}
	if (!check1.match(/^[A-Za-z]/))
	    {
		alert("Invalid Characters Entered in Institute Name");
		return false;
}
var check2=document.forms["new"]["as"].value;
if (check2==null || check2=="")
   {
        alert("Aided Status must be filled out");
	return false;
	}
	if (!check2.match(/^[A-Za-z]/))
	    {
		alert("Invalid Characters Entered in Aided Status");
		return false;
}
var check3 =document.forms["new"]["it"].value;
if (check3==null || check3=="")
   {
        alert("Institute Tagline must be filled out");
	return false;
	}
	if (!check3.match(/^[A-Za-z0-9]/))
	    {
		alert("Invalid Characters Entered in Institute Tagline");
		return false;
}
var check4=document.forms["new"]["a"].value;
if (check4==null || check4=="")
   {
        alert("Affiliation must be filled out");
	return false;
	}
	if (!check4.match(/^[A-Za-z0-9]/))
	    {
		alert("Invalid Characters Entered in Affiliation");
		return false;
}

var check5=document.forms["new"]["e"].value;
if (check5==null || check5=="")
   {
        alert("Event must be filled out");
	return false;
	}
	if (!check5.match(/^[A-Za-z0-9]/))
	    {
		alert("Invalid Characters Entered in Event");
		return false;
}var check6=document.forms["new"]["t"].value;
if (check6==null || check6=="")
   {
        alert("Topic must be filled out");
	return false;
	}
	if (!check6.match(/^[A-Za-z0-9]/))
	    {
		alert("Invalid Characters Entered in Topic");
		return false;
}

var check7=document.forms["new"]["s1"].value;
if (check7==null || check7=="")
   {
        alert("Signature(Left) must be filled out");
	return false;
	}
	if (!check7.match(/^[A-Za-z]/))
	    {
		alert("Invalid Characters Entered in Signature(Left)");
		return false;
}
var check8=document.forms["new"]["d1"].value;
if (check8==null || check8=="")
   {
        alert("Designation must be filled out");
	return false;
	}
	if (!check8.match(/^[A-Za-z]/))
	    {
		alert("Invalid Characters Entered in Designation");
		return false;
}
var check9=document.forms["new"]["s2"].value;
if (check9==null || check9=="")
   {
        alert("Signature(Middle) must be filled out");
	return false;
	}
	if (!check9.match(/^[A-Za-z]/))
	    {
		alert("Invalid Characters Entered in Signature(Middle)");
		return false;
}
var check10=document.forms["new"]["d2"].value;
if (check10==null || check10=="")
   {
        alert("Designation must be filled out");
	return false;
	}
	if (!check10.match(/^[A-Za-z]/))
	    {
		alert("Invalid Characters Entered in Designation");
		return false;
}
var check11=document.forms["new"]["s3"].value;
if (check11==null || check11=="")
   {
        alert("Signature(Right) must be filled out");
	return false;
	}
	if (!check11.match(/^[A-Za-z]/))
	    {
		alert("Invalid Characters Entered in Signature(Right)");
		return false;
}
var check12=document.forms["new"]["d3"].value;
if (check12==null || check12=="")
   {
        alert("Designation must be filled out");
	return false;
	}
	if (!check12.match(/^[A-Za-z]/))
	    {
		alert("Invalid Characters Entered in Designation");
		return false;
}	       
}
</script>

	</head>
	<body>
		<center>
    			<header><h1 style="font-family:verdana;">Institute Details</h1></header>
		<p class="bottom-one">		
			<center>
<p class="bottom-one">			
<table>
<form name=new id=myform method=POST onSubmit ="return validateForm();">
<tr> 
 <td>Institution Name:</td> 
 <td><input type=text name=in title="For e.g. Guru Nanak Dev Engineering College"></td>
</tr>

<tr> 
 <td>Aided Status:</td> 
 <td><input type=text name=as title="For e.g. Punjab Govt. Aided Status"></td>
</tr>

<tr> 
 <td>Institute Tagline:</td> 
 <td><input type=text name=it title="For e.g. An Autonomous College u/s 2(f) and 12(B) of UGC Act 1956"></td>
</tr>

<tr>
 <td>Affiliation:</td> 
 <td><input type=text name=a title="For e.g. AICTE Approved, NBA Accreditted, Affiliated to PTU, Jalandhar"></td>
</tr>

<tr>
 <td>Event:</td> 
 <td><input type=text name=e title="For e.g. Six Week Training"></td>
</tr>

<tr>
 <td>Topic:</td> 
 <td><input type=text name=t title="For e.g. Computing Technology"></td>
</tr>

<tr>
 <td>Signature(Left):</td> 
 <td><input type=text name=s1 title="For e.g. Dr M S Saini"></td>
</tr>

<tr>
 <td>Designation:</td> 
 <td><input type=text name=d1 title="For e.g. Director"></td>
</tr>

<tr>
 <td>Signature(Middle):</td> 
 <td><input type=text name=s2 ></td>
</tr>

<tr>
 <td>Designtion:</td> 
 <td><input type=text name=d2 ></td>
</tr>

<tr>
 <td>Signature(Right):</td> 
 <td><input type=text name=s3 ></td>
</tr>

<tr>
 <td>Desigantion:</td> 
 <td><input type=text name=d3 ></td>
</tr>
  
</table>
<input class="btn btn-primary" type=submit name=Submit value=Submit>
</center>
</p>
</form>
</br>
</body>
</html>

