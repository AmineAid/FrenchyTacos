<?php
if(isset($_GET['element'])){
?>
<br><br><br><br><br><br><br><br><br><br><div align='right'>
	<table><tr><td align='center'><img src='img/uparrow.png' onclick='document.getElementById("quantity").value++;' width='150'></td><td></td></tr>
	<tr><td><input id='quantity' value='1' style='font-size:80px; width:200px; text-align:center;'></td><td style='width:500px;' align='center'><img src='img/validate.png' onclick="window.top.mq('<?php echo $_GET['element'];?>',''+document.getElementById('quantity').value+'')" width='150'></td></tr>
	<tr><td  align='center'><img src='img/downarrow.png' onclick='if(document.getElementById("quantity").value > 0)document.getElementById("quantity").value--;' width='150'></td><td></td></tr></table>
	<br>
</div>
<?php
} ?>