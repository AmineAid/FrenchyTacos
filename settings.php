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
	echo '<a href="settings.php?logout=Yes"><img src="img/padunlocked.png" width="30"></a>';
	
	include_once("database_connection.php");
	echo '<br><div align="center"><h2><a href="add_gr.php" style="color:green;">Ajouter une famille</a></h2></div><br>';
	echo'
	<table >
		<tr>
			<td>
				<table id="groups_table">';
					$query1="select * from groups order by name";
					$result1 = mysqli_query($dbc,$query1);
					if($result1 AND mysqli_affected_rows($dbc)!=0){
						$i=1;
						echo '<tr>';
						while($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)){
							$groupid=mysqli_real_escape_string($dbc,$row1['id']);
							$name=mysqli_real_escape_string($dbc,$row1['name']);
							$name = str_replace( array( '\'', '"'), '&#8217;', $name);
							$name = stripcslashes($name);
							$type=mysqli_real_escape_string($dbc,$row1['type']);
							$elements=mysqli_real_escape_string($dbc,$row1['elements']);
							$elements = str_replace( array( '\'', '"'), '&#8217;', $elements);
							$elements = stripcslashes($elements);
							$steps=mysqli_real_escape_string($dbc,$row1['steps']);
							$steps = str_replace( array( '\'', '"'), '&#8217;', $steps);
							$steps = stripcslashes($steps);
							if($i%3 != 0){
								echo "<td><a href='edit_gr.php?groupid=$groupid'><div class='group_name'>$name</div></a></td>";
							}else{
								echo "<td><a href='edit_gr.php?groupid=$groupid'><div class='group_name'>$name</div></a></td></tr><tr>";
							}

							$i++;
						}
						for ($j=$i; $j%3 == 0;$j++) {
							echo '<td></td>';
						}
						echo '</tr>';
					}
					echo"
				</table>
			</td>
			<td  align='right' style='width:500px;'>
				<table style='font-size:35px; ' align='right'>
					<tr >
						<td background:;><a href='defaults.php' ><div class='group_name' style='background:green'>R&eacute;glage</div></a><br><br></td>
					</tr>
					<tr>
						<td><a href='log.php' ><div class='group_name' style='background:green'>LOG</div></a></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>";
	
}else{

	include_once("database_connection.php");
	$query3="select * from defaults WHERE name='password'";
	$result3 = mysqli_query($dbc,$query3);
	$row3 = mysqli_fetch_array($result3,MYSQLI_ASSOC);
	$password=$row3['value'];
	if (isset($_POST['password']) AND $_POST['password']== $password ){
		$_SESSION['lg'] = "In";
		echo'<script type="text/javascript">window.location.reload();</script>';
	}else{

		?>
		<html><head>
		<link href="css/style.css" type="text/css" rel="stylesheet"/>
		</head>
		<body>
		<div align="center"><form method='post'>
		<input  style="	width:300px;height: 50px;font-size: 30px;" type="password" name="password" placeholder="Mot de passe"> <br><br>	
		<input type="submit" value="Valider" style="font-size: 30px;">
		</form></div>
		</body></html>
		<?php
	}
}
	?>
