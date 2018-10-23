<?php
session_start();
$error="";
$hashedpassword="";
if(array_key_exists("logout",$_GET)){
	 session_destroy();
	unset($_SESSION);
	setcookie("id","",time()-60*60*24*365);
	setcookie('email', '', time() - 60*60*24*365);
  setcookie('Password', '', time() - 60*60*24*365);
  setcookie('emailID', '', time() - 60*60*24*365);
	$_COOKIE["id"]="";
}
else if(array_key_exists("id",$_SESSION) OR array_key_exists("id",$_COOKIE)){
	header("Location:");
}
if(array_key_exists("submit",$_POST)){
   $link=mysqli_connect("localhost","root","","register");
   if(mysqli_connect_error()){
	   echo "connection unsucessful";
   }
   if($_POST['email']==''){
	   
	  echo '<script language="javascript">';
echo 'alert("Username is Required")';
 echo '</script>';

   }
   if($_POST['password']==''){
	   echo '<script language="javascript">';
	   echo 'alert("Password is Required")';

 echo '</script>';
   }
   else if($_POST['emailID']==''){
	   	   echo '<script language="javascript">';
	   echo 'alert("Email ID is Required")';
   }

else{
	if($_POST['signup']=='1'){
	$query="SELECT id FROM user WHERE email='".mysqli_real_escape_string($link,$_POST['email'])."' LIMIT 1";
	$result=mysqli_query($link,$query);
	if(mysqli_num_rows($result)>0){
		  echo '<script language="javascript">';
echo 'alert("Email ID is Taken")';
 echo '</script>';

	}
	else{
	$hash = md5($_POST['password'], PASSWORD_DEFAULT);
	$em=$_POST['email'];
	$emID=$_POST['emailID'];
		$query="INSERT INTO user (email,password,emailID) VALUES ('$em','$hash','$emID')";
if(mysqli_query($link,$query)){
	
	
	 

	mysqli_query($link,$query);
	$_SESSION['id']=mysqli_insert_id($link);
		setcookie("id",mysqli_insert_id($link),time()+60*60*24*365);
	}
	header("Location:books.php");
}
	}
	

	else{
		$hash = md5($_POST['password'], PASSWORD_DEFAULT);
		$query="SELECT * FROM user WHERE email='".mysqli_real_escape_string($link,$_POST['email'])."'";
		$result=mysqli_query($link,$query);
		$row=mysqli_fetch_array($result);
		if(isset($row)){
			
             $_SESSION['id']=$row['id'];
	
			setcookie("id",$row['id'],time()+60*60*24*365);
				
		header("Location:session.php");
				
			}
			else{
				$error="unsucessful";
		}}
	}
}







?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
  <title>Make it easy</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">

  <!-- Favicons -->
  <link href="img/83087_5073552_883174_image.jpg" rel="icon">
  <link href="img/83087_5073552_883174_image.jpg" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Poppins:300,400,500,700" rel="stylesheet">

  <!-- Bootstrap CSS File -->
  <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Libraries CSS Files -->
  <link href="lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="lib/animate/animate.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- Main Stylesheet File -->
  <link href="books.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<style>
#signupform{
	width:30%;
	margin-left:auto;
	margin-right:auto;
}
#loginform{
	width:30%;
	margin-left:auto;
	margin-right:auto;
}
	

#middle{
	
		margin-left:auto;
	margin-right:auto;
}
#sup{
	margin-left:190px;
	
}
.checkbox{
	display:none;
}
.showloginform{
	margin-left:auto;
	margin-right:auto;
}
@media (max-width: 768px) {
	
	.form-control{
		width:90%;
	margin-left:auto;
	margin-right:auto;
}
.logo{
	width:50px;
}
#signupform{
	width:100%;
	margin-left:auto;
	margin-right:auto;
}
#loginform{
	width:100%;
	margin-left:auto;
	margin-right:auto;
}
.checkbox{
display:none;
}
#sup{
	margin-left:140px;
	margin-right:auto;
	font-size:20px;
}
#books{
	padding-left:0px;
}
#log{
	margin-left:0px;
	font-size:20px;
}
}
	</style>
  </head>
<body>
<nav>
<ul class="soc">
<li><a href='http://localhost/New%20folder/index.php'><i class="fa fa-home fa-3x"></i></a></li>

</nav>

<section id="books">
<div id="error"><?php echo '<script language="javascript">';
echo 'alert $error';
 echo '</script>'; ?></div>

<form method="post" id="signupform">
<div class="form-group" style="margin-top:250px">
  <input type="email" class="form-control" name="email" placeholder="Username">
  <input type="password" class="form-control" name="password" placeholder="password">
  <input type="email" class="form-control" name="emailID" placeholder="Email">
  <div class="checkbox"><label>
 </br>
  <input type="hidden" class="form-control" name="signup" value="1">
    <input type="checkbox"  name="stayloggedin"value=1>Staylogged in</label></div>
	</br>
	<div id="middle">
  <input type="submit" class="btn btn-primary" style="text-align:center" name="submit" value="signup" id="sup">
  <p><b><a class="showloginform" id="log" >Log in</a></b></p></div>
</div></form>
<form method="post"  id="loginform">
<div class="form-group" style="margin-top:250px">
  <input type="email" class="form-control" name="email" placeholder="Username">
  <input type="password" class="form-control" name="password" placeholder="password">
  <input type="email" class="form-control" name="emailID" placeholder="Email">
  <div class="checkbox"><label>
 </br>
  <input type="hidden" class="form-control" name="signup" value="0">
    <input type="checkbox"  name="stayloggedin"value=1>Staylogged in</label></div></br>
  <input type="submit" class="btn btn-primary" style="text-align:center" name="submit" value="log in" id="sup">
   <p><b><a class="showloginform" id="log" >Sign Up</a></b></p>
</div></form>

</div>
</section>

</body>


<script type="text/javascript">
$(".showloginform").click(function(){
$("#signupform").toggle();
$("#loginform").toggle();
});
</script>
</html>

