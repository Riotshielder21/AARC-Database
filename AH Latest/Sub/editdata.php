<?php 
	//Connect to the Databasee
	$host="localhost";
	$username="root";
	$pword="";
	$database="aarc";
	require("..\phpCore\db_Connect.php");

?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="..\Styles\stylespage.css"/>
	<link rel="stylesheet" type="text/css" href="..\Styles\menutrans.css"/>
	<link rel="script" type="text/js" href="..\Script\help.js/>
	<title>AARC Database Management System</title>
	<meta charset="UTF-8"/>
	<meta name="AARC Database Management System" content="Upload, Request, SQL, Database, Stock, Inventory"/>
	<meta name="keywords" content="HTML,CSS,JavaScript, SQL, PHP, Club, Database, Management, AARC, Stock, Inventory, Troubleshooting, Help, "/>
	<meta name="viewportW" content="width=device-width, initial-scale=1.0"/>
	<meta name="viewportH" content="height=device-height, initial-scale=1.0"/>
	<meta name="author" content="Jack Watt"/>
</head>
<body>
	<div id="box">		
		<div Class="Menu">
			<div class="mItem"><a href="..\index.html">Home</a><div id="tMenuStat">|||</div></div>
			<div class="mItem"><a href="Database.php">Database</a></div>
			<div class="mItem"><a href="Network.html">Network</a></div>
			<div class="mItem"><a href="Request.php">Request</a></div>
			<div class="mItem"><a href="Upload.php">Upload</a></div>
			<div class="mItem" onclick="help()">Help</div>
		</div>
		
		<div id="titleBlock">
	
			<h1 id="title">AARC Database Controls</h1>
	
			<div class="mainBody" id="doubleBox"> 
				<?php
				if($_SERVER["REQUEST_METHOD"] == "POST"){
					
					$fld=$_POST['Field'];
					$val=$_POST['Amend'];
					$CheckID2 = $_POST['CheckID2'];
					$ID2 = $_POST['ID2'];
					
					
					if ($fld == 1){
						$Query_String="UPDATE ResourceTa, InventoryTa SET ResourceTa.RName='".$val."', InventoryTa.CheckID='".$CheckID2."', InventoryTa.DateChecked='". date('y:m:d h:i:s') ."' WHERE InventoryTa.ID='".$ID2."' AND ResourceTa.TypeID = InventoryTa.TypeID";
					}
					else if ($fld == 2){
						$Query_String="UPDATE ResourceTa, InventoryTa SET InventoryTa.Qty='".$val."', InventoryTa.CheckID='".$CheckID2."', InventoryTa.DateChecked='". date('y:m:d h:i:s') ."' WHERE InventoryTa.ID='".$ID2."' AND ResourceTa.TypeID = InventoryTa.TypeID";
					}
					else{
						$Query_String="UPDATE ResourceTa, InventoryTa SET ResourceTa.RLocation='".$val."', InventoryTa.CheckID='".$CheckID2."', InventoryTa.DateChecked='". date('y:m:d h:i:s') ."' WHERE InventoryTa.ID='".$ID2."' AND ResourceTa.TypeID = InventoryTa.TypeID";
					}
					
					if ($result = $mysqli->query($Query_String)){
						echo "Success, the row for ID=".$ID2." has been Updated";
					}
				
					else{
						echo "Update failed, Please contact the Administrator<br />";
						print_r($mysqli->error_list);
						echo "Update Failed, for the row for ID=".$ID2;
					}
					echo '<br/><a id="plain" href="Database.php">Back</a>';
					$mysqli->close();
				} else {
					?>
			<form id="noborder"action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
				<table>
					<thead>
						<th><label name="Operation" for="Operation">Tick the field which you wish to Change</label></th>
					</thead>
					<tr>
						<td><input type="Radio" name="Field" value="1" Checked>RName</td>
						<td><input type="Radio" name="Field" value="2">Qty</td>
						<td><input type="Radio" name="Field" value="3">RLocation</td>
						 <input type="Hidden" name="ID2" value="<?php $_GET['ID']?>">
						 <input type="Hidden" name="CheckID2" value="<?php $_GET['CheckID']?>">
					</tr>
					<tr>
						<td>
						<input type="Text" name="Amend">
						<input type="submit" name="submit" value="Update">
						</td>
					</tr>
				</table>
				</form>
				<?php }?>
			</div>
		</div>
	</div>
</body>
<footer>
<?php echo date('d:m:y h:i:s')?>
</footer>
</html>			