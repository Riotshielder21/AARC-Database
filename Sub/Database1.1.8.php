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
			<div class="mItem"><a href="">Database</a></div>
			<div class="mItem"><a href="Network.html">Network</a></div>
			<div class="mItem"><a href="Request.html">Request</a></div>
			<div class="mItem"><a href="Upload.php">Upload</a></div>
			<div class="mItem" onclick="help()">Help</div>
		</div>
		
		<div id="titleBlock">
	
			<h1 id="title">AARC Database Controls</h1>
	
			<div class="mainBody" id="doubleBox">
			<?php 
			if (!isset($_POST['Username']) AND !isset($_POST['Password'])){?>
				<div id="form_Box">
				<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
					<label name="Text">Please Enter Username and Password:</label><br >
					<input type="text" name="Username" Placeholder="Username:"/><br >
					<input type="text" name="Password" Placeholder="Password:"/><br >
					<input type="submit" name="submit" Value="Login" /></div>
				</form>
			<?php
				} else {
					$Username = $_POST['Username'];
					$Password = $_POST['Password'];
					$objectno = 0;
					// if ($result = $mysqli->query("SELECT * From userTa")){
						// while ($row=$result->fetch_object()){
							// echo $row->UserID;
						// }
					// $result->close();
					
					// }
					$q1String= "SELECT Count(*) FROM userTa, checkerTa WHERE userTa.Username = '" . $Username . "' INNER JOIN userTa ON userTa.UserID = checkerTa.UserID;";
					
					$Qstring = "SELECT Username, password, privilege, userID, checkerID FROM userTa, checkerTa WHERE userTa.Username = '" . $Username . "' INNER JOIN userTa ON userTa.UserID = checkerTa.UserID;";
					
					try{
					$result = $mysqli->query("SELECT Count(*) FROM userTa, checkerTa");
					echo $result(0);
					}
					catch (mysqliexec $e){
						echo "Error " . $e->getMessage();
						exit();
					}
					
						// while ($Password != $confPass or ($checkerID="Ur01" and ($confPass = "Password1" or $Password="Password1" ))){
							// if ($row = $result->fetch_object(objectno)){
								// $confPass= $row->password;
								// $userPriv= $row->privilege;
								// $checkerID= $row->checkerID;
								// $objectno +=1;
							// }
							// else {
								// $userPriv=0;
							// }
						//}
					}
					if ($userPriv==1){
						$myquery='SELECT * FROM InventoryTa INNER JOIN InventoryTa ON ResourceTa.TypeID = InventoryTa.TypeID';
						?>
						<div id="Table_Box">
						<table>
							<thead>
								<th>ID</th><th>Resource Type</th><th>Qty</th><th>Date Checked</th><th>Checker ID</th><th>Type ID</th><th>Location</th>
							</thead>
						<tbody>
						<?php
						if ($result = $mysqli->query($myquery)){
							while ($row = $result->fetch_object()){
								echo "<tr>";
								echo "<td>" .$row->ID. "</td>";
								echo "<td>" .$row->Name. "</td>";
								echo "<td>" .$row->Qty. "</td>";
								echo "<td>" .$row->DateChecked. "</td>";
								echo "<td>" .$row->CheckerID. "</td>";
								echo "<td>" .$row->TypeID. "</td>";
								echo "<td>" .$row->Location. "</td>";
								echo "<td><a href='editdata.php?id=".urlencode($row->ID)."&CheckerID=".urlencode($row->CheckID)."'>Amend</a></td>";
								echo "<td><a href='deletedata.php?id=".urlencode($row->ID)."&CheckerID=".urlencode($row->CheckID)."'>Delete</a></td>";
								echo "</tr>";
							}
							$result->close();
						}
						$mysqli->close();
						echo "<a href='database.php?Insert=True&Username=".$Username."'>New Stock</a>"
					?>
						</tbody>
						<table>
						</div>
					<?php
					}
					else {?>
					<div id="form_Box">
					<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
						<label name="Operation" for="Operation">Select Search Field:</label>
						<input type="Radio" name="Operation" Checked Value=1> Resource Type<br />
						<input type="Radio" name="Operation" Value=2> Resource Location<br />
						<input type="Radio" name="Operation" Value=3> Resource ID<br /> 
						<input type="Radio" name="Operation" Value=4> Checker ID<br />
						<input type="text" name="criteria" placeholder="Search Criteria"/><br />
						<input type="submit" name="submit" value="Search">
					</form></div><?php
					}
						$sOP = $_POST['Operation'];
						$sCri =$_POST['criteria'];
					
						if ($sOP == 1){
							$Query_String='SELECT InventoryTa.ID, ResourceTa.RName, InventoryTa.Qty, InventoryTa.DateChecked, InventoryTa.CheckID, ResourceTa.TypeID, ResourceTa.RLocation FROM ResourceTa WHERE ResourceTa.RName = \''.$sCri.'\' INNER JOIN InventoryTa ON ResourceTa.TypeID = InventoryTa.TypeID';
						}
						else if ($sOP == 2){
							$Query_String='SELECT InventoryTa.ID, ResourceTa.RName, InventoryTa.Qty, InventoryTa.DateChecked, InventoryTa.CheckID, ResourceTa.TypeID, ResourceTa.RLocation FROM ResourceTa WHERE ResourceTa.RLocation = \''.$sCri.'\' INNER JOIN InventoryTa ON ResourceTa.TypeID = InventoryTa.TypeID';
						}
						else if ($sOP == 3){
							$Query_String='SELECT InventoryTa.ID, ResourceTa.RName, InventoryTa.Qty, InventoryTa.DateChecked, InventoryTa.CheckID, ResourceTa.TypeID, ResourceTa.RLocation FROM ResourceTa WHERE ResourceTa.TypeID = \''.$sCri.'\' INNER JOIN InventoryTa ON ResourceTa.TypeID = InventoryTa.TypeID';
						}
						else{
							$Query_String='SELECT InventoryTa.ID, ResourceTa.RName, InventoryTa.Qty, InventoryTa.DateChecked, InventoryTa.CheckID, ResourceTa.TypeID, ResourceTa.RLocation FROM ResourceTa WHERE InventoryTa.CheckID = \''.$sCri.'\' INNER JOIN InventoryTa ON ResourceTa.TypeID = InventoryTa.TypeID';
						}?>
					<div id="Table_Box">
						<table>
							<thead>
							<th>ID</th><th>Resource Type</th><th>Qty</th><th>Date Checked</th><th>Checker ID</th><th>Type ID</th><th>Location</th>
							</thead>
								<tbody>
							<?php 
								if ($result = $mysqli->query($Query_String)){
									while ($row = $result->fetch_object()){
											echo "<tr>";
											echo "<td>" .$row->ID. "</td>";
											echo "<td>" .$row->Name. "</td>";
											echo "<td>" .$row->Qty. "</td>";
											echo "<td>" .$row->DateChecked. "</td>";
											echo "<td>" .$row->CheckerID. "</td>";
											echo "<td>" .$row->TypeID. "</td>";
											echo "<td>" .$row->Location. "</td>";
											echo "</tr>";
									}
									$result->close();
								}
								$mysqli->close();
								?>
							</tbody>
						<table>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>