<?php 
if (isset($_GET['uprice1']) AND $_GET['number_of_active_rows']>=1){
	include_once("database_connection.php");
	$number_of_active_rows = mysqli_real_escape_string($dbc, $_GET['number_of_active_rows']);
	$total = mysqli_real_escape_string($dbc, $_GET['total']);
	$time = time();
	$query3="select * from defaults WHERE name='maxnumber'";
	$result3 = mysqli_query($dbc,$query3);
	$row3 = mysqli_fetch_array($result3,MYSQLI_ASSOC);
	$maxnumber=$row3['maxnumber'];

	$query1="select number from tickets order by id desc limit 0,1";
	$result1 = mysqli_query($dbc,$query1);
	$row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC);
	$lastnumber=$row1['number'];
	if(!$result1 OR mysqli_affected_rows($dbc)==0 OR $lastnumber<1 OR $lastnumber>=$maxnumber){
		$number=1;
	}else{
	$number=$lastnumber+1;
	}

			

	if (!mysqli_query($dbc,"INSERT INTO tickets  (number, price, time, status) VALUES('$number','$total', '$time','1')")){
		echo "<div id='error' align='center'>Une erreur s&#39;est produite 0x3<br></div>", mysqli_error($dbc);
		echo'<script>alert("une erreur s\'est produite 0x3")</script>';
		die;
	}
	$ticket_id=mysqli_insert_id($dbc);
	for ($i=1; $i <= $number_of_active_rows;$i++){
		$designation = mysqli_real_escape_string($dbc, $_GET["designation$i"]);
		$uprice = mysqli_real_escape_string($dbc, $_GET["uprice$i"]);
		$price = mysqli_real_escape_string($dbc, $_GET["price$i"]);
		$q = mysqli_real_escape_string($dbc, $_GET["q$i"]);
		
		if (!mysqli_query($dbc,"INSERT INTO elements  (ticket_id, designation, uprice, q, price) VALUES('$ticket_id','$designation', '$uprice', '$q','$price')")){
			echo "<div id='error' align='center'>Une erreur s&#39;est produite 0x4<br></div>", mysqli_error($dbc);
			echo'<script>alert("une erreur s\'est produite 0x4")</script>';
			die;
		}

	}
	





	if(isset($_GET['print'])){
		echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="save_ticket.php?print=1&ticket_id='.$ticket_id.'";</SCRIPT>';
	}else{
 		echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="save_ticket.php";</SCRIPT>';
	} 

}elseif(isset($_GET['print']) AND $_GET['print']=="1"){
	$emporter=0;
	include_once("database_connection.php");
	$ticket_id=$_GET['ticket_id'];
	$query1="select * from tickets WHERE id='$ticket_id'";
	$result1 = mysqli_query($dbc,$query1);
	if($result1 AND mysqli_affected_rows($dbc)!=0){
		while($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)){
			$price = $row1['price'];
			$time = $row1['time'];
			$number = $row1['number'];
			$query2="select id from elements WHERE ticket_id='$ticket_id' AND designation='A Emporter'";
			$result2 = mysqli_query($dbc,$query2);
			$total=0;
			if($result2 AND mysqli_affected_rows($dbc)!=0){
				$emporter=1;
			}
			$query2="select id from elements WHERE ticket_id='$ticket_id' AND designation='A Livrer'";
			$result2 = mysqli_query($dbc,$query2);
			$total=0;
			if($result2 AND mysqli_affected_rows($dbc)!=0){
				$emporter=2;
			}
			if(isset($_GET['notcurrent'])){
				echo '<html><body onafterprint="document.location.href=\'save_ticket.php?notcurrent=1&emporter='. $emporter .'&ticket_id='.$ticket_id.'&print=2\'">';
			}else{
				echo '<html><body onafterprint="document.location.href=\'save_ticket.php?ticket_id='.$ticket_id.'&emporter=' .$emporter. '&print=2\'">';
			}

			echo'<div align="center"> <table id="ticket_top" width="100%">
					<tr>
						<td id="logotd" width="70"><img src="img/logo.png" width="70"></td>
						<td align="center" > <b>Frenchy&#8217; Tacos</b><br>Azazga<br>( Gare routi&egrave;re )<br><i>Tel: 0540 328 848</i></td>
					</tr>
					</table><table width="100%"><tr style="font-size:12px;background-color:black;color:white;"><td align="center">Qte</td><td align="center"> Produit </td>
					<td align="center">P U</td><td align="center">P T</td></tr>';
			
			$query2="select * from elements WHERE ticket_id='$ticket_id' order by id desc";
			$result2 = mysqli_query($dbc,$query2);
			$total=0;
			if($result2 AND mysqli_affected_rows($dbc)!=0){

				while($row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC)){
		
					$designation=mysqli_real_escape_string($dbc,$row2['designation']);
					$designation = str_replace( array( '\'', '"'), '&#8217;', $designation);
					$designation = stripcslashes($designation);
					if($designation != "A Emporter" AND $designation != "A Livrer" ){
						$uprice = number_format($row2['uprice'],0);
						$price = $row2['price'];
						$q = number_format($row2['q'],0);
						echo "	<tr style='font-size:12px;'>
									<td style='vertical-align:top;'> $q </td>
									<td style='width:100%;'> $designation </td>
									<td style='vertical-align:top;'>$uprice</td>
									<td style='vertical-align:top;'>$price</td>
								</tr>";
						$total+=$price;
					}
				}
			}else{echo "<tr><td>Aucun element a afficher pour le ticket N $ticket_id </td></tr>";}
			$total=number_format($total,2);
			echo "<tr style='border-bottom:1px solid black;font-size:13px;'><td></td><td></td><td>Total:</td><td><b>$total</b></td></table><hr width='80%'>
			<div align='left'>".date('d-m-Y H:i',$time)."</div><font size='6'>Ticket <u>N:<font size='7'><b>$number</b></font></u></font><br>
			<font size='2'><i>Mot de passe <u>Wifi</u>:</i> \"Taco_pass\"</font></div>";
		}

		echo '<SCRIPT LANGUAGE="JavaScript">window.print();</SCRIPT>';
	}

}elseif(isset($_GET['print']) AND isset($_GET['print'])=="2"){
	include_once("database_connection.php");
	$ticket_id=$_GET['ticket_id'];
	$query1="select number from tickets WHERE id='$ticket_id'";
	$result1 = mysqli_query($dbc,$query1);
	if($result1 AND mysqli_affected_rows($dbc)!=0){
		$row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC);
		$number=$row1['number'];
		if(isset($_GET['notcurrent'])){
				echo '<html><body onafterprint="document.location.href=\'save_ticket.php?notcurrent=1\'"><div align="center"><table width="100%">';
			}else{
			echo '<html><body onafterprint="document.location.href=\'save_ticket.php\'"><div align="center"><table width="100%">';
			}
		
		
		// ---------------------------Cuisto-------------------
			if(isset($_GET['emporter']) AND $_GET['emporter'] == 1){echo '<font size="5" style="text-align:left;">"<b><u>A Emporter</b></u>"</font><br>';}
			if(isset($_GET['emporter']) AND $_GET['emporter'] == 2){echo '<font size="5" style="text-align:left;">"<b><u>A Livrer</b></u>"</font><br>';}
		echo'<font size="6">Ticket <u>N:<font size="7"><b>'.$number.'</b></font></u></font><br>
		<table width="100%">';
		$query2="select * from elements WHERE ticket_id='$ticket_id' order by id desc";
		$result2 = mysqli_query($dbc,$query2);
		if($result2 AND mysqli_affected_rows($dbc)!=0){
			while($row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC)){
				$designation=mysqli_real_escape_string($dbc,$row2['designation']);
				$designation = str_replace( array( '\'', '"'), '&#8217;', $designation);
				$designation = stripcslashes($designation);
				if($designation != "A Emporter"){
					$q = number_format($row2['q'],0);
					echo "	<tr style='font-size:16px;'>
								<td style='vertical-align:top;text-align:left; padding-right:5px;'> <b>$q</b> </td>
								<td style='border-bottom:1px solid black; width:100%;'> $designation </td>
								</tr>";
				}
			}
		}else{echo "<tr><td>Aucun element a afficher pour le ticket N $ticket_id </td></tr>";}
	}
	echo '<SCRIPT LANGUAGE="JavaScript">window.print();</SCRIPT>';

	
}elseif(!isset($_GET['notcurrent'])){
 echo '<SCRIPT LANGUAGE="JavaScript">
 window.top.location.reload();</SCRIPT>';
}
?>
</body></html>


