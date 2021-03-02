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
			if (!isset($_POST['Username']) AND !isset($_POST['Password'])){
				
				//Display HTML form to get username and Password	?>
				<div id="form2">
				<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
					<br ><label name="Text">Please Enter:</label><br >
					<label>Username:</label><input type="text" name="Username" Placeholder="Username:"/><br >
					<label>Password:</label><input type="password" name="Password" Placeholder="Password:"/><br >
					<br ><input type="submit" name="submit" Value="Login" /></div>
				</form>
			<?php
			} else {
					
				//Filter and sanitize strings for values that may cause security issues
				$Username = filter_var(trim(stripslashes($_POST['Username'])));
				$Password = filter_var(trim(stripslashes($_POST['Password'])));
				
				//Setup Query string
				//$recordcount = "SELECT COUNT(*) FROM userTa WHERE Username='".$Username."' ";
				
				// Query For 0 Entries in database
				// $qresult = $mysqli->query($recordcount);
				// $qrow = mysql_fetch_assoc($qresult);
				// $size = $row['Count(*)'];
				
				//setup query for validating a user exists
				$recordcount = "SELECT *  FROM userTa WHERE Username='".$Username."' ";
				$recordscount = 0;
				$qresult = $mysqli->query($recordcount);
				while ($row = $qresult->fetch_row()){
					$recordscount += 1;
				}
				
				//If none exist, invalidate authority
				if ($recordscount>0){
					
					//Get Username's Password
					$querystring= "SELECT userta.UserID, userta.Username, userta.Password, userta.Privilege, checkerta.CheckID FROM userta INNER JOIN checkerta ON userta.UserID = checkerta.UserID WHERE userta.Username = '".$Username."'";

					//Send Query to MySQL
					if ($result = $mysqli->query($querystring)){
						
						//Fetch Row as Username Field is Unique there should only be 1 return
						while ($row = $result->fetch_object()){
							$confPass= $row->Password;
						
							//Check for password match before assigning the authority
							if ($confPass == $Password){
								$userPrivilege= $row->Privilege;
								$checkerID= $row->CheckID;
							}
							else {
								
								//Invalidate Authority
								echo "You do not have sufficent privileges!";
								$userPrivilege=0;
							}
						}
					} else {
						
						//Invalidate Authority
						echo "Server has not obtained the specific privileges, please contact an admin!";
						$userPrivilege=0;
					}
				} else {
					
					//Invalidate Authority
					$userPrivilege = 0;
				}
				
				//Check Authority
				If ($userPrivilege==1){
					$myquery='SELECT * FROM InventoryTa INNER JOIN ResourceTa ON InventoryTa.TypeID = ResourceTa.TypeID';
					?>
					<div id="Table_Box">
					<table>
						<thead>
							<th id="IDtd">ID</th><th id="Nametd">Resource Type</th><th id="Qtytd">Qty</th><th id="Datetd">Date Checked</th><th id="Checktd">Checker ID</th><th id="Typetd">Type ID</th><th id="Locationtd">Location</th><th id="amendid">Amend</th><th id="deleteid">Delete</th>
						</thead>
						<tbody>
					<?php
					
					// Get the Results from database and populate a table
					if ($result = $mysqli->query($myquery)){
						while ($row = $result->fetch_object()){
						echo "<tr>";
							echo "<td id='IDtd'>" .$row->ID. "</td>";
							echo "<td id='Nametd'>" .$row->RName. "</td>";
							echo "<td id='Qtytd'>" .$row->Qty. "</td>";
							echo "<td id='Datetd'>" .$row->DateChecked. "</td>";
							echo "<td id='Checktd'>" .$row->CheckID. "</td>";
							echo "<td id='Typetd'>" .$row->TypeID. "</td>";
							echo "<td id='Locationtd'>" .$row->RLocation. "</td>";
							echo "<td id='amendid'><a href='editdata.php?ID=".urlencode($row->ID)."&CheckID=".$checkerID."'>Amend</a></td>";
							echo "<td id='deleteid'><a href='deletedata.php?ID=".urlencode($row->ID)."&CheckID=".$checkerID."'>Delete</a></td>";
							echo "</tr>";
						}
						$result->close();
					}
					else{
						
						//Handle an error / fetch error
						echo "Error On Fetch!";
					}
					
					//Close the database
					$mysqli->close();
					
					//Display the inset values link
					echo "<a href='Insert-Stock.php?CheckerID='".$checkerID."'>New Stock</a>"
				?>
						</tbody>
					</table>
					</div>
				<?php
					} else {
						
						//For Invalid Authority users, display a form to query the database!
						if (!isset($_POST['Operation'])){?>
					<div id="form2">
					<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
						<label name="Operation" for="Operation">Select Search Field:</label><br >
						<input type="Radio" name="Operation" Checked Value=1> Resource Type<br />
						<input type="Radio" name="Operation" Value=2> Resource Location<br />
						<input type="Radio" name="Operation" Value=3> Resource ID<br /> 
						<input type="Radio" name="Operation" Value=4> Checker ID<br />
						<input type="Hidden" name="Username" Value="<?php //$Username ?>">
						<input type="Hidden" name="Password" Value="<?php //$Password ?>">
						<input type="text" name="criteria" placeholder="Search Criteria"/><br />
						<input type="submit" name="submit" value="Search">
					</form></div><?php
						} else {
							
						//For set form values, Run a database Query!
						$sOP = $_POST['Operation'];
						$sCri =filter_var(trim(stripslashes($_POST['criteria'])));
					
						if ($sOP == 1){
							$Query_String="SELECT InventoryTa.ID, ResourceTa.RName, InventoryTa.Qty, InventoryTa.DateChecked, InventoryTa.CheckID, ResourceTa.TypeID, ResourceTa.RLocation FROM ResourceTa INNER JOIN InventoryTa ON ResourceTa.TypeID = InventoryTa.TypeID WHERE ResourceTa.RName LIKE '%".$sCri."%'";
						}
						else if ($sOP == 2){
							$Query_String="SELECT InventoryTa.ID, ResourceTa.RName, InventoryTa.Qty, InventoryTa.DateChecked, InventoryTa.CheckID, ResourceTa.TypeID, ResourceTa.RLocation FROM ResourceTa INNER JOIN InventoryTa ON ResourceTa.TypeID = InventoryTa.TypeID WHERE ResourceTa.RLocation LIKE '%".$sCri."%'";
						}
						else if ($sOP == 3){
							$Query_String="SELECT InventoryTa.ID, ResourceTa.RName, InventoryTa.Qty, InventoryTa.DateChecked, InventoryTa.CheckID, ResourceTa.TypeID, ResourceTa.RLocation FROM ResourceTa INNER JOIN InventoryTa ON ResourceTa.TypeID = InventoryTa.TypeID WHERE ResourceTa.TypeID LIKE '%".$sCri."%'";
						}
						else{
							$Query_String="SELECT InventoryTa.ID, ResourceTa.RName, InventoryTa.Qty, InventoryTa.DateChecked, InventoryTa.CheckID, ResourceTa.TypeID, ResourceTa.RLocation FROM ResourceTa INNER JOIN InventoryTa ON ResourceTa.TypeID = InventoryTa.TypeID WHERE InventoryTa.CheckID LIKE '%".$sCri."%'";
						}?>
					<div id="Table_Box">
						<table>
							<thead>
							<th id="IDtd">ID</th><th id="Nametd">Resource Type</th><th id="Qtytd">Qty</th><th id="Datetd">Date Checked</th><th id="Checktd">Checker ID</th><th id="Typetd">Type ID</th><th id="Locationtd">Location</th>
							</thead>
							<tbody>
							<?php 
							
								//Display Values from query in an ordered table populating loop
								if ($result = $mysqli->query($Query_String)){
									while ($row = $result->fetch_object()){
											echo "<tr>";
											echo "<td id='IDtd'>" .$row->ID. "</td>";
											echo "<td id='Nametd'>" .$row->RName. "</td>";
											echo "<td id='Qtytd'>" .$row->Qty. "</td>";
											echo "<td id='Datetd'>" .$row->DateChecked. "</td>";
											echo "<td id='Checktd'>" .$row->CheckID. "</td>";
											echo "<td id='Typetd'>" .$row->TypeID. "</td>";
											echo "<td id='Locationtd'>" .$row->RLocation. "</td>";
											echo "</tr>";
									}
									$result->close();
								}
								$mysqli->close();
						}
					}
				}?>							
							</tbody>
						</table>
					</div>
			</div>
		</div>
	</div>
</body>
<footer>
<?php echo date('d:m:y h:i:s')?>
</footer>
</html>