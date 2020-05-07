<?php 
Session_start();
?>
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/style.css" type="text/css" rel="stylesheet"/>	
</head>
<body>
<a href="settings.php"><img src="img/setting.png" width="60"></a>
	
<?php
include_once("database_connection.php");
if (isset($_SESSION['lg']) AND $_SESSION['lg']=="In" AND isset($_GET['groupid'])){
	$groupid=mysqli_real_escape_string($dbc, $_GET['groupid']);
	$query5="select * from groups WHERE id=$groupid";
	$result5 = mysqli_query($dbc,$query5);
	if($result5 AND mysqli_affected_rows($dbc)!=0){
		while($row5 = mysqli_fetch_array($result5,MYSQLI_ASSOC)){

			$name=mysqli_real_escape_string($dbc,$row5['name']);
			$type=mysqli_real_escape_string($dbc,$row5['type']);
			$elements=mysqli_real_escape_string($dbc,$row5['elements']);
			$elements = str_replace( array( '\'', '"'), '&#8217;', $elements);
			$elements = stripcslashes($elements);
			$steps=mysqli_real_escape_string($dbc,$row5['steps']);
			$steps = str_replace( array( '\'', '"'), '&#8217;', $steps);
			$steps = stripcslashes($steps);

		}

		if (isset($_POST['name']) AND $_POST['name']!=""){

			
			$id = mysqli_real_escape_string($dbc, $_POST['groupid']);
			$name = mysqli_real_escape_string($dbc, $_POST['name']);
			$type = mysqli_real_escape_string($dbc, $_POST['type']);
			$elements = mysqli_real_escape_string($dbc, $_POST['elements']);

			if (isset($_POST['steps'])){
				$steps = mysqli_real_escape_string($dbc, $_POST['steps']);
			}else{
				$steps="";
			}

			if(!mysqli_query($dbc,"UPDATE groups  SET name='$name', type='$type', steps='$steps', elements='$elements' WHERE id=$groupid")){
				echo "<div id='error' align='center'>Une erreur s&#39;est produite 0x2<br></div>", mysqli_error($dbc);
				die;
			}else{
				echo '<SCRIPT LANGUAGE="JavaScript">
				document.location.href="edit_gr.php?groupid='. $groupid .'";
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

			

			function delete_group(){
				var r=confirm("Voulez vous Supprimer cette famille ?");
				if(r){
					window.location.href ='edit_gr.php?todelgroupid='+<?php echo $groupid;?>;
				}
			}

				function validateform(){
				var s=htmlEntities(document.groups.name.value);
	  			if(s==''){
	  				alert("Une famille doit avoir un nom");
				}else{
				document.groups.submit();
		  		}
			}
			



			</script>

			<?php
			if ($type=="steps"){
			echo"<form name='groups' method='post'><input type='hidden' name='groupid' value='$groupid'>
			<table id='add_gr' align='center'>
				<tr align='center'>
					<td colspan='2' class='table_title'>Nom</td>			
				</tr>
				<tr align='center'>
					<td colspan='2'><input id='name' name='name' value='$name' autocomplete='off'></td>			
				</tr>
				<tr align='center'>
					<td colspan='2' class='table_title'>Type</td>			
				</tr>
				<tr align='center' id='groups_type'>
					<td>Elements <input type='radio' name='type' value='elements'  onclick='display(\"Elements\")'  style='margin-right:40px;'></td>
					<td>Etapes <input type='radio' name='type' value='steps' checked onclick='display(\"Etapes\")'></td>			
				</tr>
				<tr >
					<td colspan='2'>
						<table id='Etapes' >
							<tr align='center'>
								<td class='table_title'>Etapes:</td>
								<td class='table_title' >Elements:</td><td></td>
							</tr>
							<tr >
								<td> <textarea name='steps' id='elementsEtapes1'>$steps</textarea></td>
								<td> <textarea name='elements' id='elementsEtapes2'>$elements</textarea></td>
							</tr>
							<tr>
								<td class='exemple' align='center'>M:choix multiples. U: choix uniques<br>Ex: Taille:U,Viandes:M,Supplements:M</td>
								<td class='exemple' align='center'>Ex: XL:500,L:400/Poulet:0,viande:0/Kiri:50</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr >
					<td colspan='2'>
						<table id='Elements' align='center'  style='display:none;'>
							<tr align='center'>
								<td colspan='2' class='table_title' >Elements:</td><td></td>
							</tr>
							<tr >
								<td colspan='2'><textarea name='elements' id='elementsElements' disabled></textarea></td>
							<tr>
								<td colspan='2' class='exemple' align='center'>Ex: Pepsi:100,Ifri:60</td></tr>			
							</tr>
						</table>
					</td>
				</tr>
				<tr align='center'>
					<td><img width='50' src='img/save.png' onclick='validateform()'></td>
					<td><img width='50' src='img/cancel.png' onclick='delete_group()'></td>		
					</tr>
				</table></form>";
			}else{
			echo"<form name='groups' method='post'><input type='hidden' name='groupid' value='$groupid'>
			<table id='add_gr' align='center'>
				<tr align='center'>
					<td colspan='2' class='table_title'>Nom</td>			
				</tr>
				<tr align='center'>
					<td colspan='2'><input id='name' name='name' value='$name' autocomplete='off'></td>			
				</tr>
				<tr align='center'>
					<td colspan='2' class='table_title'>Type</td>			
				</tr>
				<tr align='center' id='groups_type'>
					<td>Elements <input type='radio' name='type' value='elements' checked onclick='display(\"Elements\")'  style='margin-right:40px;'></td>
					<td>Etapes <input type='radio' name='type' value='steps'  onclick='display(\"Etapes\")'></td>			
				</tr>
				<tr >
					<td colspan='2'>
						<table id='Etapes' style='display:none;'>
							<tr align='center'>
								<td class='table_title'>Etapes:</td>
								<td class='table_title' >Elements:</td><td></td>
							</tr>
							<tr >
								<td> <textarea name='steps' id='elementsEtapes1' disabled></textarea></td>
								<td> <textarea name='elements' id='elementsEtapes2' disabled></textarea></td>
							</tr>
							<tr>
								<td class='exemple' align='center'>M:choix multiples. U: choix uniques<br>Ex: Taille:U,Viandes:M,Supplements:M</td>
								<td class='exemple' align='center'>Ex: XL:500,L:400/Poulet:0,viande:0/Kiri:50</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr >
					<td colspan='2'>
						<table id='Elements' align='center'  >
							<tr align='center'>
								<td colspan='2' class='table_title' >Elements:</td><td></td>
							</tr>
							<tr >
								<td colspan='2'><textarea name='elements' id='elementsElements' >$elements</textarea></td>
							<tr>
								<td colspan='2' class='exemple' align='center'>Ex: Pepsi:100,Ifri:60</td></tr>			
							</tr>
						</table>
					</td>
				</tr>
				<tr align='center'>
					<td><img width='50' src='img/save.png' onclick='validateform()'></td>
					<td><img width='50' src='img/cancel.png' onclick='delete_group()'></td>		
					</tr>
				</table></form>";
			}

		}
	}else{
	echo '<SCRIPT LANGUAGE="JavaScript">
	document.location.href="settings.php";
	</SCRIPT>';
	}
}elseif(isset($_GET['todelgroupid'])){
	$todelgroupid=$_GET['todelgroupid'];
include_once("database_connection.php");
if(!mysqli_query($dbc,"DELETE FROM groups WHERE id=$todelgroupid")){
				echo "<div id='error' align='center'>Une erreur s&#39;est produite 0x6<br></div>", mysqli_error($dbc);
				die;
			}else{
				echo '<SCRIPT LANGUAGE="JavaScript">
				document.location.href="settings.php";
				</SCRIPT>';
			}
}elseif(isset($_GET['todelticketid'])){
	$todelticketid=$_GET['todelticketid'];
include_once("database_connection.php");
if(!mysqli_query($dbc,"DELETE FROM elements WHERE ticket_id=$todelticketid")){
				echo "<div id='error' align='center'>Une erreur s&#39;est produite 0x10<br></div>", mysqli_error($dbc);
				die;
			}
if(!mysqli_query($dbc,"DELETE FROM tickets WHERE id=$todelticketid")){
				echo "<div id='error' align='center'>Une erreur s&#39;est produite 0x12<br></div>", mysqli_error($dbc);
				die;
			}else{
				echo '<SCRIPT LANGUAGE="JavaScript">
				window.top.location.reload();
				</SCRIPT>';
			}


}
		?>