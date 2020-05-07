<?php 
Session_start();
?>
<html><head>
<title>Frenchy Tacos</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/style.css" type="text/css" rel="stylesheet"/>	
</head>

<?php
if(isset($_SESSION['lg'])){

		include_once("database_connection.php");
	$query3="select * from defaults WHERE name='password'";
		$result3 = mysqli_query($dbc,$query3);
		$row3 = mysqli_fetch_array($result3,MYSQLI_ASSOC);
		$oldpassword=$row3['value'];



	if(isset($_POST['password0']) AND $_POST['password0'] == $oldpassword){
		if($_POST['password'] == $_POST['password1'] AND $_POST['password'] != ""){
			$password = mysqli_real_escape_string($dbc, $_POST['password']);
		}else{
			$password = $oldpassword;
		}
			$maxnumber = mysqli_real_escape_string($dbc, $_POST['maxnumber']);
	if(!mysqli_query($dbc,"UPDATE defaults  SET value='$password' WHERE name='password'") OR !mysqli_query($dbc,"UPDATE defaults  SET value='$maxnumber' WHERE name='maxnumber'") ){
				echo "<div id='error' align='center'>Une erreur s&#39;est produite 0x9<br></div>", mysqli_error($dbc);
				die;
			}else{
				echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="settings.php";</SCRIPT>';
			}
	
}else{

	include_once("database_connection.php");

	$query3="select * from defaults WHERE name='maxnumber'";
	$result3 = mysqli_query($dbc,$query3);
	$row3 = mysqli_fetch_array($result3,MYSQLI_ASSOC);
	$maxnumber=$row3['value'];

	echo '<br><br><br><br><br><br><div align="center">
	<form method="POST">
		<input  style="	width:300px;height: 30px;font-size: 30px;" type="password" name="password0" placeholder="Ancien Mot de passe"><br><br>
		<input  style="	width:300px;height: 30px;font-size: 30px;" type="password" name="password" placeholder="Nouveau Mot de passe"><br><br>
		<input  style="	width:300px;height: 30px;font-size: 30px;" type="password" name="password1" placeholder="Confirmation"><br><br>
		Numero De Commande Maximum<br>
		<input  style="	width:300px;height: 30px;font-size: 30px;" name="maxnumber" value="'.$maxnumber.'" autocomplete="off"><br><br>
		<input type="image" src="img/validate.png"></form></div>';
	
}
}
	?>
