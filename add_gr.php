<?php 
Session_start();
?>
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/style.css" type="text/css" rel="stylesheet"/>	
<?php
include_once("database_connection.php");
if (isset($_SESSION['lg']) AND $_SESSION['lg']=="In"){
	if (isset($_POST['name']) AND $_POST['name']!=""){

		
		$name = mysqli_real_escape_string($dbc, $_POST['name']);
		$type = mysqli_real_escape_string($dbc, $_POST['type']);
		$elements = mysqli_real_escape_string($dbc, $_POST['elements']);

		if (isset($_POST['steps'])){
			$steps = mysqli_real_escape_string($dbc, $_POST['steps']);
		}else{
			$steps="";
		}

		if(!mysqli_query($dbc,"INSERT INTO groups  (name, type, steps, elements) VALUES('$name', '$type', '$steps', '$elements')")){
			echo "<div id='error' align='center'>Une erreur s&#39;est produite 0x1<br></div>", mysqli_error($dbc);
			die;
		}else{
			echo '<SCRIPT LANGUAGE="JavaScript">
			window.top.location.reload();
			</SCRIPT>';
		}
		

	}else{

		?>
		<script>
		function htmlEntities(str) {
     		   return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/é/g, '&eacute;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
		}	
		function display(a) {
			if(a == "Elements"){
				document.getElementById("elementsEtapes1").disabled = true;
				document.getElementById("elementsEtapes2").disabled = true;
			   	document.getElementById("Etapes").style.display = "none";
			   	document.getElementById("Elements").style.display = "table-row";
			   	document.getElementById("elementsElements").disabled = false;
				}else{
				document.getElementById("elementsElements").disabled = true;
		    	document.getElementById("Elements").style.display = "none";
		    	document.getElementById("Etapes").style.display = "table-row";
		    	document.getElementById("elementsEtapes1").disabled = false;
		    	document.getElementById("elementsEtapes2").disabled = false;
		  		}
		  	}

		<?php
		echo'function isInArray(array, search){
    	return array.indexOf(search) >= 0;}
		var names=[];';

		$query2="select name from groups";
		$result2 = mysqli_query($dbc,$query2);
		if($result2){
		    if(mysqli_affected_rows($dbc)!=0){  	
		    	$i=0;
		    	while($row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC)){
		    		$variable=stripslashes($row2['name']);
		    		echo 'names['.$i.']="'. mysqli_real_escape_string($dbc,$variable) .'";';
					$i++;
		    	}
		   	}
		} ?>

		function validateform(){
			var s=htmlEntities(document.groups.name.value);
  			if(isInArray(names, s)){
  				alert("Une famille portant le meme nom existe deja");
			}else{
			document.groups.submit();
	  		}
		}
		



		</script></head><body>

		<?php
		echo"<div align='left'><a href='settings.php'><img src='img/setting.png' width='60'></a></div><form name='groups' method='post'>
		<table id='add_gr' align='center'>
			<tr align='center'>
				<td class='table_title'>Nom</td>
		
			</tr>
			<tr align='center'>
				<td ><input id='name' name='name' autocomplete='off'></td>
		
			</tr>
			<tr align='center'>
				<td class='table_title'>Type</td>
		
			</tr>
			<tr align='center' id='groups_type'>
				<td>Elements <input type='radio' name='type' value='elements' checked onclick='display(\"Elements\",\"Etapes\")' style='margin-right:40px;'>
				Etapes <input type='radio' name='type' value='steps' onclick='display(\"Etapes\",\"Elements\")'></td>
		
			</tr>

			<tr >
				<td >
					<table id='Etapes'  style='display:none;'>

						<tr align='center'>
							<td class='table_title'>Etapes:</td>
							<td class='table_title' >Elements:</td>
							
						</tr>
						<tr >
							<td><textarea name='steps'  id='elementsEtapes1'></textarea></td>
							<td colspan='2'><textarea name='elements' id='elementsEtapes2'></textarea></td>
						
						
						</tr>

						<tr  align='center'>
							<td class='exemple' align='center'>M:choix multiples. U: choix uniques<br>Ex: Taille:U,Viandes:M,Supplements:M</td>
							<td class='exemple' align='center'>Ex: XL:500,L:400/Poulet:0,viande:0/Kiri:50</td>
						
						</tr>
					</table>
				</td>
			</tr>
			<tr >
				<td >
					<table id='Elements' align='center'>

						<tr align='center'>
							<td colspan='2' class='table_title' >Elements:</td><td></td>
						</tr>
						<tr >
							<td colspan='2'><textarea name='elements' id='elementsElements' ></textarea></td>
						</tr>
						<tr>
							<td colspan='2' class='exemple' align='center'>Ex: Pepsi:100,Ifri:60</td>
						</tr>
		
					</table>
				</td>
			</tr>
			<tr align='center'>
				<td ><img width='50' src='img/save.png' onclick='validateform()'></td>
			</tr>

		</table></form>";
	}
}else{
echo '<SCRIPT LANGUAGE="JavaScript">
document.location.href="settings.php";
</SCRIPT>';
	}
	?>
</body></html>