<!DOCTYPE html>
<html lang='en'>
<head>
	<meta charset='utf-8'>
    
    <!-- SET TITLE -->
	<title>BlackJack Showcase</title>
    
    <!-- SET CSS -->
    <link rel='stylesheet' href='css/default.css' type='text/css' media='screen'/>
    
    <!-- SET JS -->
    <script type='text/javascript' src='js/jquery-1.9.1.min.js'></script>
    <script type='text/javascript' src='js/default.js'></script>
    
</head>
<body>
<!-- ECHO FIXED HEADER -->
<center><h1>BlackJack Showcase</h1></center>

	<!-- START OF CONTAINER -->
	<div id='container'>
		<div id="body">
			<table>
				<?php
					$totalrow = 15;
					for ($i=1; $i<=$totalrow; $i++)
					{
						?>
						<tr>
							<td><input type='text' id="id_menu<?=$i?>"/></td>
							<td><input disabled="disabled" id="nama<?=$i?>"/></td>
							<td><input disabled="disabled" id="harga<?=$i?>"/></td>
						</tr>
						<?php
					}
				?>
			</table>
			<input type="hidden" id="totalrow" value="<?=$totalrow?>"/>
			<hr size=2/>
			<table>
				<tr>
					<td></td>
					<td class="right"><b>Total Harga :</b></td>
					<td><input disabled="disabled" id="total_harga"/></td>
				</tr>
				<tr>
					<td></td>
					<td class="right"><b>Bayar :</b></td>
					<td><input id="jml_bayar"/></td>
				</tr>
				<tr>
					<td></td>
					<td class="right"><b>Kembalian :</b></td>
					<td><input disabled="disabled" id="kembalian"/></td>
				</tr>
				<tr>
					<td id="status" class="right"></td>
				</tr>
			</table>
		</div>
	</div>
	<!-- END OF CONTAINER -->
</body>
</html>