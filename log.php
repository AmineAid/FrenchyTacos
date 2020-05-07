<?php 
Session_start();
?>
<html><head>
<title>Frenchy Tacos</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/style.css" type="text/css" rel="stylesheet"/>	

<?php
if (isset($_SESSION['lg']) AND isset($_GET['logout'])){
	
	session_unset ();  
	session_destroy();
	setcookie("lg", 5, time()-3600);
	echo'<script type="text/javascript">window.top.location.reload();</script>';

}elseif(isset($_SESSION['lg'])){



	echo '<a href="settings.php"><img src="img/setting.png" width="60"></a>';
	
	include_once("database_connection.php");


	$fromtime = strtotime('today midnight');
	$result = mysqli_query($dbc,'SELECT SUM(price) AS totalprice FROM tickets WHERE time > '.$fromtime.''); 
	$row = mysqli_fetch_assoc($result); 
	$sum = $row['totalprice'];
		echo " <div align='center' style='font-size:100px;'><b>".$sum." DA</b></div>
	<div align='center'>Depuis le ".date('d-m-Y H:i', $fromtime)."</div><br>";



	$fromtime = strtotime('yesterday midnight');
	$result = mysqli_query($dbc,'SELECT SUM(price) AS totalprice FROM tickets WHERE time > '.$fromtime.''); 
	$row = mysqli_fetch_assoc($result); 
	$sum = $row['totalprice'];
		echo " <div align='center' style='font-size:100px;'><b>".$sum." DA</b></div>
	<div align='center'>Depuis le ".date('d-m-Y H:i', $fromtime)."</div><br>";
	




	$fromtime = strtotime('last month midnight');
	$result = mysqli_query($dbc,'SELECT SUM(price) AS totalprice FROM tickets WHERE time > '.$fromtime.''); 
	$row = mysqli_fetch_assoc($result); 
	$sum = $row['totalprice'];
		echo " <div align='center' style='font-size:100px;'><b>".$sum." DA</b></div>
	<div align='center'>Depuis le ".date('d-m-Y H:i', $fromtime)."</div>";

	}
