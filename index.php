<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Trade Log</title>
		<link rel="stylesheet" href="master.css">
		<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;700;800&display=swap" rel="stylesheet">
	</head>
	<body>
	<p id="shift">PRESS &lt; SHIFT &gt; TO ENABLE AMENDMENTS</p>
		<?php
			//db initiation
			$db = mysqli_connect("localhost", "root", "pass", "TRD");
			$sql = "SELECT *, round((((EXIT_CAP-ENTRY_CAP)/ENTRY_CAP)*100), 2) as 'TRD_PNL' FROM `trades` order by TRD_ID desc";
			$query = mysqli_query($db, $sql);
		?>
		<div class="form-component">
			<form id="form">
				<input type="text" autocomplete="off" id="TRD_ID" name="TRD_ID" placeholder="Trade ID :" value="">
				<input type="text" autofocus="true" autocomplete="off" id="ENTRY_DATE" name="ENTRY_DATE" placeholder="Entry Date :" value="<?php echo date('Y-m-d');  ?>">
				<input type="text" autocomplete="off" id="TRD_ASSET" name="TRD_ASSET" placeholder="Ticker :">
				<input type="text" autocomplete="off" id="TRD_POS" name="TRD_POS" placeholder="Position :">
				<input type="text" autocomplete="off" id="TRD_QUANTITY" name="TRD_QUANTITY" placeholder="Quantity :">
				<input type="text" autocomplete="off" id="TRD_LEVERAGE" name="TRD_LEVERAGE" placeholder="Leverage :">
				<input type="text" autocomplete="off" id="TRD_MARGIN" name="TRD_MARGIN" placeholder="Margin :">
				<input type="text" autocomplete="off" id="ENTRY_CAP" name="ENTRY_CAP" placeholder="Entry Capital :">
				<input type="text" autocomplete="off" id="EXIT_CAP" name="EXIT_CAP" placeholder="Exit Capital :">
				<input type="button" id="edit" value="Amend Trade">
				<input type="button" id="submit" value="Submit Trade">
			</form>
		</div>
		<div class="tab-container">
		<div class="tab-title">
			<h1>Trade History</h1>
			<a id="export">Export to CSV</a>
		</div>
		<div class="tabular">
		<table>
			<tr>
				<th>Trade ID</th>
				<th>Entry Date</th>
				<th>Asset</th>
				<th>Position</th>
				<th>Quantity</th>
				<th>Leverage</th>
				<th>Inital Margin</th>
				<th>Capital On Entry</th>
				<th>Capital On Exit</th>
				<th>PNL %</th>
				<th>Actions</th>
			</tr>
			<?php
				while ($rows = mysqli_fetch_array($query)) {
					echo '<tr><td>'.$rows['TRD_ID'].'</td>';
					echo '<td>'.$rows['ENTRY_DATE'].'</td>';
					echo '<td>'.$rows['TRD_ASSET'].'</td>';
					echo '<td>'.$rows['TRD_POS'].'</td>';
					echo '<td>'.$rows['TRD_QUANTITY'].'</td>';
					echo '<td>'.$rows['TRD_LEVERAGE'].'</td>';
					echo '<td>'.$rows['TRD_MARGIN'].'</td>';
					echo '<td>'.$rows['ENTRY_CAP'].'</td>';
					echo '<td>'.$rows['EXIT_CAP'].'</td>';
					echo '<td>'.$rows['TRD_PNL'].'</td>';
					echo '<td><a class="del" attr="'.$rows['TRD_ID'].'">Remove</a></td></tr>';
				}
			?>
		</table>
		</div>
		</div>
	</body>
	<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
	<script>
		$(document).ready(function(){
			$('#edit').hide();
			$(document).on('keydown',function(e) {
				if(e.which == 16) {
					$('#submit').hide();
					$('#edit').show();
				}
			});
			$(document).on('keyup',function(e) {
				if(e.which == 16) {
					$('#submit').show();
					$('#edit').hide();
				}
			});
			$('.del').click(function(){
				var $this = $(this);
				var TRD_ID=$this.attr('attr');
	
				var r = confirm("Are You Sure You Want To Delete This Entry?");
				if (r == true) {
					$.ajax({
					type: "POST",
					url: "delete.php",
					data:
					{
						'TRD_ID' :TRD_ID
					},
					success: function(data)
					{
						location.reload();
					}
					});
				} else {
					console.log('deletion failure');
				}

			});	
			$('#edit').click(function(){
				var r = confirm("Are You Sure You Want To Amend This Entry?");
				if (r == true) {
				var TRD_ID=$('#TRD_ID').val().toUpperCase();
				var ENTRY_DATE=$('#ENTRY_DATE').val().toUpperCase();
				var TRD_ASSET=$('#TRD_ASSET').val().toUpperCase();
				var TRD_POS=$('#TRD_POS').val().toUpperCase();
				var TRD_QUANTITY=$('#TRD_QUANTITY').val().toUpperCase();
				var TRD_LEVERAGE=$('#TRD_LEVERAGE').val().toUpperCase();
				var TRD_MARGIN=$('#TRD_MARGIN').val().toUpperCase();
				var ENTRY_CAP=$('#ENTRY_CAP').val().toUpperCase();
				var EXIT_CAP=$('#EXIT_CAP').val().toUpperCase();

				$.ajax({
				type: "POST",
				url: "update.php",
				data:
				{
					'TRD_ID' :TRD_ID,
					'ENTRY_DATE' :ENTRY_DATE,
					'TRD_ASSET' :TRD_ASSET,
					'TRD_POS' :TRD_POS,
					'TRD_QUANTITY' :TRD_QUANTITY,
					'TRD_LEVERAGE' :TRD_LEVERAGE,
					'TRD_MARGIN' :TRD_MARGIN,
					'ENTRY_CAP' :ENTRY_CAP,
					'EXIT_CAP' :EXIT_CAP
				},
				success: function(data)
				{
					location.reload();
					console.log('foo who');
				}
				});
				} else {
					console.log('amendment failure');
				}
			});	
			$('#submit').click(function(){
				var ENTRY_DATE=$('#ENTRY_DATE').val().toUpperCase();
				var TRD_ASSET=$('#TRD_ASSET').val().toUpperCase();
				var TRD_POS=$('#TRD_POS').val().toUpperCase();
				var TRD_QUANTITY=$('#TRD_QUANTITY').val().toUpperCase();
				var TRD_LEVERAGE=$('#TRD_LEVERAGE').val().toUpperCase();
				var TRD_MARGIN=$('#TRD_MARGIN').val().toUpperCase();
				var ENTRY_CAP=$('#ENTRY_CAP').val().toUpperCase();
				var EXIT_CAP=$('#EXIT_CAP').val().toUpperCase();

				$.ajax({
				type: "POST",
				url: "server.php",
				data:
				{
					'ENTRY_DATE' :ENTRY_DATE,
					'TRD_ASSET' :TRD_ASSET,
					'TRD_POS' :TRD_POS,
					'TRD_QUANTITY' :TRD_QUANTITY,
					'TRD_LEVERAGE' :TRD_LEVERAGE,
					'TRD_MARGIN' :TRD_MARGIN,
					'ENTRY_CAP' :ENTRY_CAP,
					'EXIT_CAP' :EXIT_CAP
				},
				success: function(data)
				{
					location.reload();
				}
				});
			});
		});
	</script>
</html>
