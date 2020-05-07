<?php 
Session_start();
?>
<html><head>
<title>Frenchy Tacos</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/style.css" type="text/css" rel="stylesheet"/>	
<script> 
function display_group(name,type,steps,elements){
	if(type == "steps"){
		var step = steps.split(",");
		var group_elements="<table id='elements_table'><tr>";
		var step_name=[]
		var step_choice=[]
		var element_name=[]
		var element_price=[]
		var element_background=[]
		for (var i = 0; i <= step.length-1; i++){
			
			var step_split=step[i].toString().split(":");
			step_name[i]=step_split[0];
			step_choice[i]=step_split[1];
			
			group_elements+='<td class="col_title" >'+step_name[i]+'</td>';
			
		};
		group_elements+="<td id='quantity_col'rowspan='2'><img src='img/uparrow.png' onclick='document.getElementById(\"quantity\").value++;' width='90'>";
		group_elements+="<br><input id='quantity' value='1'><br>";
		group_elements+="<img src='img/downarrow.png' onclick='if(document.getElementById(\"quantity\").value > 1)document.getElementById(\"quantity\").value--;' width='90'>";
		group_elements+="<td id='validate_col'rowspan='2'><img id='validate_img' src='img/validate.png' onclick='validate_steps(\""+name+"\",\""+type+"\",\""+steps+"\",\""+elements+"\")' width='90'></td></tr>";
		group_elements+="<tr id='elements_row'>";

		var elements = elements.toString().split("/");
		for (var i = 0; i <= elements.length-1; i++){
			group_elements+="<td id='elements_col'><div style='display:block;height:680px;overflow:auto;''>";
			var element = elements[i].toString().split(",")
			for (var j = 0; j <= element.length-1; j++){
				
				var element_split=element[j].split(":");
				element_name[j]=element_split[0];
				element_price[j]=element_split[1];
				if(element_background[j]=element_split[2]){
					
				}else{
					element_background[j]="brown;width:0px;height:0px";
				}
				if(step_choice[i] == "U" || step_choice[i] == "u" ){
					group_elements+='<label><input type="radio" id="'+element_name[j]+'" name="'+step_name[i]+'"  value="0"> <div class="choice" ><div id="element_ball" style="background:'+element_background[j]+';"></div>'+element_name[j]+'</div></label>';
				}else if(step_choice[i] == "MQ" || step_choice[i] == "MQ" ){
					group_elements+='<label><input type="checkbox" id="'+element_name[j]+'" name="'+step_name[i]+'" value="0"> <div class="choice" id="'+element_name[j]+'_choice" onclick="load(\'q.php?element='+element_name[j]+'\')"><div id="element_ball" style="background:'+element_background[j]+';"></div>'+element_name[j]+'</div></label>';
				}else{
					group_elements+='<label><input type="checkbox" id="'+element_name[j]+'" name="'+step_name[i]+'" value="0"> <div class="choice" ><div id="element_ball" style="background:'+element_background[j]+';"></div>'+element_name[j]+'</div></label>';
				
				}
				
			};
			group_elements+="</div></td>";
		};
		group_elements+="</tr></table>";
		document.getElementById('group_elements').innerHTML=group_elements;

	}else{ //type == elements
		var element_name=[]
		var element_price=[]
		var element_background=[]
		
		
		group_elements='<table id="elements_table"><tr><td><table><tr>';
		var element = elements.toString().split(",")
		var lack;
		var h
		for ( h = 0; h <= element.length-1; h++){
			
			var element_split=element[h].toString().split(":");
			element_name[h]=element_split[0];
			element_price[h]=element_split[1];
			if(element_background[h]=element_split[2]){
					
				}else{
					element_background[h]="brown;width:0px;height:0px";
				}
			if(h%5 == 0){
				group_elements+='</tr><tr><td class="elementtd"><label><div class="choice"  onclick=\'validate_element(\"'+element_name[h]+'\",\"'+element_price[h]+'\",\"'+elements+'\")\'><div id="element_ball" style="background:'+element_background[h]+';"></div>'+element_name[h]+'</div></label></td>';
			}else{	
				group_elements+='<td class="elementtd"><label> <div class="choice"  onclick=\'validate_element(\"'+element_name[h]+'\",\"'+element_price[h]+'\",\"'+elements+'\")\'><div id="element_ball" style="background:'+element_background[h]+';"></div>'+element_name[h]+'</div></label></td>';
			}

			
			};
			while (h%5 != 0) {
    			group_elements+='<td></td>';
    			h++;
			}
		group_elements+="</tr></table></td></tr>";
		
		
		group_elements+="<table>";
		document.getElementById('group_elements').innerHTML=group_elements;
	}

}

function validate_steps(group,type,steps,elements){
	show_ticket(document.getElementById('number_of_tickets').value);
	var quantity=document.getElementById('quantity').value;

	var total = document.getElementById('total').value;
	var step_name=[]
	var step_choice=[]
	var element_name=[]
	var element_price=[]
	var ticket_row_name=group;
	var ticket_row_onclick="display_group('"+group+"','"+type+"','"+steps+"','"+elements+"');";
		ticket_row_onclick+="document.getElementById('quantity').value='"+quantity+"';";
	var ticket_row_price=0;
	var step = steps.toString().split(",");
	for (var i = 0; i <= step.length-1; i++){
		var step_split=step[i].toString().split(":");
		step_name[i]=step_split[0];
	}

	var elements = elements.toString().split("/");
	for (var i = 0; i <= elements.length-1; i++){
		var element = elements[i].toString().split(",");
		var firsttime = 0 ;
		for (var j = 0; j <= element.length-1; j++){
			var element_split=element[j].split(":");
			element_name[j]=element_split[0];
			element_price[j]=element_split[1];
			element_input=document.getElementById(element_name[j]);
			if(element_input.checked == true && element_input.name == step_name[i]){
				if(firsttime == 0 && i >= 1){
						ticket_row_name+= "<br> ";
						 firsttime= 1 ;
					}
				if(element_input.value >1){
					ticket_row_onclick+="document.getElementById('"+element_name[j]+"').checked=true;";
					ticket_row_onclick+="document.getElementById('"+element_name[j]+"_choice').value="+element_input.value+";";
					ticket_row_onclick+="document.getElementById('"+element_name[j]+"_choice').innerHTML='"+element_name[j]+" x"+element_input.value+"';";
					ticket_row_name+= ". "+element_input.value+"x "+element_name[j]+"";	
					ticket_row_price+= Number(element_price[j])*Number(element_input.value);
				}else{
					ticket_row_onclick+="document.getElementById('"+element_name[j]+"').checked=true;";
					ticket_row_name+=". "+element_name[j]+"";
					ticket_row_price+= Number(element_price[j]);
				}
					


			}
		}

	}
	var precedent_row=document.getElementById('number_of_active_rows').value;
	document.getElementById('number_of_active_rows').value++;
	var next_row=document.getElementById('number_of_active_rows').value;
	document.getElementById('ticket_row_number'+next_row).style.display = "table-row";
	document.getElementById('ticket_element_quantity'+next_row).disabled = false;
	document.getElementById('ticket_element_name'+next_row).disabled = false;
	document.getElementById('ticket_element_uprice'+next_row).disabled = false;
	document.getElementById('ticket_element_price'+next_row).disabled = false;

	document.getElementById('ticket_element_quantity'+next_row).value = quantity;
	document.getElementById('ticket_element_name'+next_row).value = ticket_row_name;
	ticket_row_onclick+="remove_ticket_row("+next_row+")";
	document.getElementById('ticket_element_name'+next_row).setAttribute('onclick',''+ticket_row_onclick+'');
	document.getElementById('ticket_element_uprice'+next_row).value = ticket_row_price;
	document.getElementById('ticket_element_price'+next_row).value = Math.round(ticket_row_price * quantity * 100) / 100;;

	document.getElementById('total').value= Math.round((Number(ticket_row_price) * Number(quantity)) + Number(total));
	document.getElementById('total_ticket'+document.getElementById('number_of_tickets').value).value= Math.round((Number(ticket_row_price) * Number(quantity)) + Number(total));
	
	
	var element = elements.toString().split(",")
	for (var j = 0; j <= element.length-1; j++){
		var element_split=element[j].split(":");
		element_name[j]=element_split[0];
		document.getElementById(element_name[j]).checked = false;
		if (document.getElementById(element_name[j]).value != 0){
			document.getElementById(element_name[j]+'_choice').innerHTML = element_name[j];
			document.getElementById(element_name[j]).value = 0;
		}
	}
	document.getElementById('quantity').value=1;





}

function validate_element(ticket_row_name,ticket_row_price,elements){
	show_ticket(document.getElementById('number_of_tickets').value);
	var quantity
	var total=document.getElementById('total').value;
	total= Number(total);
	var precedent_row=document.getElementById('number_of_active_rows').value;
	precedent_row= +precedent_row;
	var allreadythere=0;
	for (var i = 1; i <= precedent_row; i++) {
		
		if(document.getElementById('ticket_element_name'+i).value == ticket_row_name){
			allreadythere=1;
			if (event.shiftKey) {
				if(document.getElementById('ticket_element_quantity'+i).value > 1){
					document.getElementById('ticket_element_quantity'+i).value--;
					quantity=document.getElementById('ticket_element_quantity'+i).value;
					document.getElementById('ticket_element_price'+i).value = Math.round(ticket_row_price * quantity * 100) / 100;
					document.getElementById('total').value= Math.round(Number(total) - Number(ticket_row_price));
					document.getElementById('total_ticket'+document.getElementById('number_of_tickets').value).value= Number(document.getElementById('total').value);
				}else{ 
					remove_ticket_row(i);
				}
		
			}else{
				document.getElementById('ticket_element_quantity'+i).value++;
				quantity=document.getElementById('ticket_element_quantity'+i).value;
				document.getElementById('ticket_element_price'+i).value = Number(document.getElementById('ticket_element_price'+i).value) + Number(ticket_row_price) ;
				document.getElementById('total').value = Number(document.getElementById('total').value) + Number(ticket_row_price);
				document.getElementById('total_ticket'+document.getElementById('number_of_tickets').value).value= Number(document.getElementById('total').value);
	
			}
		i=99999;
		}
	};
	if(allreadythere == 0){
		document.getElementById('number_of_active_rows').value++;
		var next_row=document.getElementById('number_of_active_rows').value;
		document.getElementById('ticket_row_number'+next_row).style.display = "table-row";
		document.getElementById('ticket_element_quantity'+next_row).disabled = false;
		document.getElementById('ticket_element_name'+next_row).disabled = false;
		document.getElementById('ticket_element_uprice'+next_row).disabled = false;
		document.getElementById('ticket_element_price'+next_row).disabled = false;

		document.getElementById('ticket_element_quantity'+next_row).value = 1;
		document.getElementById('ticket_element_name'+next_row).value = ticket_row_name;
		document.getElementById('ticket_element_uprice'+next_row).value = ticket_row_price;
		document.getElementById('ticket_element_price'+next_row).value = Number(document.getElementById('ticket_element_price'+i).value) + Number(ticket_row_price) ;

		document.getElementById('total').value = Number(document.getElementById('total').value) + Number(ticket_row_price);
		document.getElementById('total_ticket'+document.getElementById('number_of_tickets').value).value= Number(document.getElementById('total').value);
	
	}
	
}






function remove_ticket_row(number){
	var oldvalueof_number_of_active_rows=document.getElementById('number_of_active_rows').value
	document.getElementById('number_of_active_rows').value--;
	document.getElementById('total').value= Math.round(Number(document.getElementById('total').value) - Number(document.getElementById('ticket_element_price'+number).value));
	document.getElementById('total_ticket'+document.getElementById('number_of_tickets').value).value= Number(document.getElementById('total').value);
	if (oldvalueof_number_of_active_rows == number){
		document.getElementById('ticket_element_quantity'+number).value = 0;
		document.getElementById('ticket_element_name'+number).value = '';
		document.getElementById('ticket_element_uprice'+number).value = 0;
		document.getElementById('ticket_element_price'+number).value = 0 ;
		document.getElementById('ticket_element_quantity'+number).disabled = true;
		document.getElementById('ticket_element_name'+number).disabled = true;
		document.getElementById('ticket_element_uprice'+number).disabled = true;
		document.getElementById('ticket_element_price'+number).disabled = true;
		document.getElementById('ticket_row_number'+number).style.display = "none";
	}else{
		var j;
		var onclick;
		for (var i = number; i < oldvalueof_number_of_active_rows; i++) {
			j = Number(i) + 1;
			document.getElementById('ticket_element_quantity'+i).value=document.getElementById('ticket_element_quantity'+j).value
			document.getElementById('ticket_element_name'+i).value=document.getElementById('ticket_element_name'+j).value
			if(onclick =document.getElementById('ticket_element_name'+j).getAttribute('onclick')){
			if(i < 10){
				onclick = onclick.substring(0, onclick.length-2);
			}else if(i < 100){
				onclick = onclick.substring(0, onclick.length-3);
			}else{
				onclick = onclick.substring(0, onclick.length-4);
			}
			onclick+=i+')';
			document.getElementById('ticket_element_name'+i).setAttribute('onclick',''+onclick+'');
			}else{
				document.getElementById('ticket_element_name'+i).setAttribute('onclick','');
			}
			document.getElementById('ticket_element_uprice'+i).value=document.getElementById('ticket_element_uprice'+j).value
			document.getElementById('ticket_element_price'+i).value=document.getElementById('ticket_element_price'+j).value
		};
		document.getElementById('ticket_element_quantity'+oldvalueof_number_of_active_rows).value = 0;
		document.getElementById('ticket_element_name'+oldvalueof_number_of_active_rows).value = '';
		document.getElementById('ticket_element_uprice'+oldvalueof_number_of_active_rows).value = 0;
		document.getElementById('ticket_element_price'+oldvalueof_number_of_active_rows).value = 0 ;
		document.getElementById('ticket_element_quantity'+oldvalueof_number_of_active_rows).disabled = true;
		document.getElementById('ticket_element_name'+oldvalueof_number_of_active_rows).disabled = true;
		document.getElementById('ticket_element_uprice'+oldvalueof_number_of_active_rows).disabled = true;
		document.getElementById('ticket_element_price'+oldvalueof_number_of_active_rows).disabled = true;
		document.getElementById('ticket_row_number'+oldvalueof_number_of_active_rows).style.display = "none";

	}
}


/*function calculate(){
	var total=0;
	if(document.getElementById('number_of_active_rows').value>=1){

		
		for (var i = 1; i <= document.getElementById('number_of_active_rows').value; i++) {

		total+=Number(document.getElementById('ticket_element_price'+i));
		alert('le total est de '+total+'  ffff  ticket_element_price'+i+' and'+ document.getElementById('ticket_element_price'+i));
		};
	}
	document.getElementById('total').value=total;
}

*/
function mq(a,b){
	if(b != 0){
	document.getElementById(a).checked=true;
	document.getElementById(a).value=b;
	document.getElementById(a+"_choice").innerHTML=""+a+" <i>x"+b+"</i>";
	document.getElementById("onTop").style.display='none';
	}else{
	document.getElementById(a).checked=false;
	document.getElementById(a).value=0;
	document.getElementById(a+"_choice").innerHTML=a;
	document.getElementById("onTop").style.display='none';
	}

}
function save_ticket(){
	var number_of_active_rows= document.getElementById('number_of_active_rows').value;
	if(number_of_active_rows > 0){


		var link="save_ticket.php?total="+document.getElementById('total').value+"&number_of_active_rows="+number_of_active_rows;

		for (var i = 1; i <= number_of_active_rows; i++) {
			link+="&designation"+i+"="+document.getElementById('ticket_element_name'+i).value+"&q"+i+"="+document.getElementById('ticket_element_quantity'+i).value+"&uprice"+i+"="+document.getElementById('ticket_element_uprice'+i).value+"&price"+i+"="+document.getElementById('ticket_element_price'+i).value;
		};

		document.getElementById("php_gate").innerHTML='<iframe src="'+link+'" ></iframe>';
		
	}

}
function save_print_ticket(){
	if(document.getElementById('active_ticket').value != document.getElementById('number_of_tickets').value){
		var alias='ticket'+document.getElementById('active_ticket').value+'id';
		
		var id=document.getElementById(alias).value
		document.getElementById("php_gate").innerHTML='<iframe src="save_ticket.php?notcurrent=1&print=1&ticket_id='+id+'" ></iframe>';

	}else{

	var number_of_active_rows= document.getElementById('number_of_active_rows').value;
	if(number_of_active_rows > 0){


		var link="save_ticket.php?print=1&total="+document.getElementById('total').value+"&number_of_active_rows="+number_of_active_rows;

		for (var i = 1; i <= number_of_active_rows; i++) {
			link+="&designation"+i+"="+document.getElementById('ticket_element_name'+i).value+"&q"+i+"="+document.getElementById('ticket_element_quantity'+i).value+"&uprice"+i+"="+document.getElementById('ticket_element_uprice'+i).value+"&price"+i+"="+document.getElementById('ticket_element_price'+i).value;
		};

		document.getElementById("php_gate").innerHTML='<iframe src="'+link+'" ></iframe>';
	}
}

}
function show_ticket(a) {
	if(a >= 1 && a<= Number(document.getElementById('number_of_tickets').value)){
		var number_of_tickets=document.getElementById('number_of_tickets').value;

		for (var i = 1; i <= Number(number_of_tickets); i++) {
			document.getElementById('ticket_number'+i).style.display='none';
		};
		document.getElementById('ticket_number'+a).style.display='block';
		document.getElementById('total').value=document.getElementById('total_ticket'+a).value
		document.getElementById('active_ticket').value=a;
		
	}


}



	function load(a) {
     document.getElementById("onTop").style.display='block';
     document.getElementById("onTop").innerHTML='<img src="img/close.png" width="50" onclick="document.getElementById(\'onTop\').style.display=\'none\';"'+
      'style="position:absolute;z-index:1; top:0px;right:0px;"><iframe width="100%" height="100%" style="border:none;"src="'+a+'" ></iframe>';
}

function delete_ticket(id){
				var r=confirm("Voulez Vous Supprimer Le Ticket N "+id+" ?");
				if(r){
					load('edit_gr.php?todelticketid='+id);
				}
			}

</script>
</head>
<body id="indexpage">
<table id="index">
<tr id='toprow'>
	<td id='groups' rowspan="2">
		<table width='100%'>
			<tr>
				<td align='left'><a href="/*closekiosk*"><img src="img/close.png" width="60" style='position:relative;margin:10px;10px;'></a></td>
				<td align='center'><a  href="#" onclick="load('settings.php')"><img src="img/setting.png" width="70"></a></td>
			</tr>
		</table>

		</div><table id='groups_table'>
		<?php
		include_once("database_connection.php");
		$query1="select * from groups order by name";
		$result1 = mysqli_query($dbc,$query1);
			if($result1 AND mysqli_affected_rows($dbc)!=0){
				$i=1;
				while($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)){
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
					if($i%2 != 0){
						echo "<tr><td style='display: table-cell;vertical-align: middle;'><div class='group_name'  onclick='display_group(\"$name\",\"$type\",\"$steps\",\"$elements\")'>$name</div></td>";
					}else{
						echo "<td style='display: table-cell;vertical-align: middle;'><div class='group_name' onclick='display_group(\"$name\",\"$type\",\"$steps\",\"$elements\")'>$name</div></td></tr>";
					}

					$i++;
				}
				if($i%2 == 0){
					echo '<td></td></tr>';
				}
			}
		?>
		</table>

	</td>
	<td id='ticket_view'><div style="display:block;height:200px;overflow:auto;">
	

		<input type='hidden' name="number_of_active_rows" id="number_of_active_rows" value='0'>
		
		
		<?php

		$query1="(select * from tickets order by id desc limit 0,100)order by id";
		$result1 = mysqli_query($dbc,$query1);
		$j=1;
		if($result1 AND mysqli_affected_rows($dbc)!=0){
			while($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)){
				$ticket_id = $row1['id'];
				$price = $row1['price'];
				$time = $row1['time'];
				$number = $row1['number'];
				$h=$j-1;
				if($h>0){
					echo '<table id="ticket_number'.$j.'" style="display:none;">
							<tr>
								<td align="center" colspan="3">
								<input type="hidden" id="total_ticket'.$j.'" value="'.$price.'">
								<input type="hidden" id="ticket'.$j.'id" value="'.$ticket_id.'">
								<i style="font-size:22px;">Ticket N '.$ticket_id.', Commande N '.$number.'</i>';
								if(isset($_SESSION['lg'])){
									echo "<a href='#' onclick='delete_ticket($ticket_id)'> <img src='img/cancel.png' width='15'></a>";
								}
								echo'</td>
							</tr>
							<tr>
								<td style="vertical-align: top;"><img src="img/left.png" width="60" onclick="show_ticket(\''. $h .'\')"> </td>
									<td><table>';
				}else{	
					echo '<table id="ticket_number'.$j.'" style="display:none;">
							<tr>
								<td align="center" colspan="3"><i style="font-size:22px;">Ticket N '.$ticket_id.', Commande N '.$number.'</i>
								<input type="hidden" id="total_ticket'.$j.'" value="'.$price.'">
								<input type="hidden" id="ticket'.$j.'id" value="'.$ticket_id.'">
								</td>
							</tr>
							<tr>
								<td style="vertical-align: top;"></td><td><table>';
				}
	
				$query2="select * from elements WHERE ticket_id='$ticket_id' order by id desc";
				$result2 = mysqli_query($dbc,$query2);
				if($result2 AND mysqli_affected_rows($dbc)!=0){

					while($row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC)){
			
						$designation=mysqli_real_escape_string($dbc,$row2['designation']);
						$designation = str_replace( array( '\'', '"'), '&#8217;', $designation);
						$designation = stripcslashes($designation);
						$uprice = $row2['uprice'];
						$price = $row2['price'];
						$q = $row2['q'];

						echo "<tr>
						<td><input class='ticket_element_quantity' value='$q' disabled></td>
						<td><input class='ticket_element_name' value='$designation' disabled></td>
						<td><input class='ticket_element_uprice' value='$uprice' disabled></td>
						<td><input class='ticket_element_price' value='$price' disabled>
						</tr>";
					}
				}else{echo "<tr><td>Aucun element a afficher pour le ticket N $ticket_id </td></tr>";}
			
				$w=$j+1;

				echo '</table></td ><td style="vertical-align: top;"><img src="img/right.png" width="60" onclick="show_ticket(\''. $w .'\')"> </td></tr></table>';
				
				$j++;

			}

		}


		echo "<input type='hidden' id='number_of_tickets' value='$j'><input type='hidden' id='total_ticket$j' value='0'>";
		

		echo '<table id="ticket_number'.$j.'"><tr><td style="vertical-align: top;">
		<input type="hidden" id="active_ticket" value="'.$j.'">';
		$j--;
		echo '<img src="img/left.png" width="60"  onclick="show_ticket(\''. $j .'\')"> </td><td><table>';
		for ($i=19; $i > 0 ; $i--) { 		
			echo "<tr style='display:none' id='ticket_row_number".$i."'><td><input id='ticket_element_quantity" .$i. "' class='ticket_element_quantity' name='ticket_element_quantity" .$i. "' disabled></td>
			<td><input id='ticket_element_name" .$i. "' name='ticket_element_name" .$i. "' class='ticket_element_name' disabled></td>
			<td><input id='ticket_element_uprice" .$i. "' name='ticket_element_uprice" .$i. "' class='ticket_element_uprice' disabled></td>
			<td><input id='ticket_element_price" .$i. "' name='ticket_element_price" .$i. "' class='ticket_element_price' disabled>
			<td><img src='img/remove.png' width='40' onclick='remove_ticket_row(".$i.")'></td></tr>";
		}
		echo '</table></td></tr></table>';
		?>
		
	</div></td>
	<td id='menu'>

		<table>
			<tr id='adition'>
				<td >Total:</td>
				<td colspan="2"> <input name='total' id='total' value='0'> </td>
			</tr>
			<tr id="bouttons">
				<td><a href="#" onclick='window.location.reload();'><img src="img/cancel.png" width="70"></a></td>
				<td><a href="#" onclick='save_ticket()'><img src="img/validate_2.png" width="70"></a></td>
				<td><a href="#" onclick='save_print_ticket()'><img src="img/print.png" width="70"></a></td>
			</tr>
		</table>
	</td>
</tr>
<tr id='bottomrow'>
	<td id='group_elements' colspan="2">
		
	</td>
</tr>
</table>
<div id='onTop' style='display:none'></div>
<div id='php_gate' style='display:none'></div>
<input type='hidden' id='active_ticket'>
</body>
</html>