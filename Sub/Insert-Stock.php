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
			<div id="form_Box">
				<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
					<label name="Operation" for="Operation">Select Search Field:</label>
					<label type="Radio" name="ResName">Resource Name:
					<input type="Text" name="ResName"><br />
					<label type="Radio" name="ResLocation">Location:
					<input type="Text" name="ResLocation"><br />
					<label type="Radio" name="RQty">Quantity:
					<input type="Text" name="RQty"><br />
					<input type="submit" name="submit" value="Create">
				</form>
			</div>
			<?php
			$randint=RAND(1000,9999);
			$newTypeID=substr($_POST['ResName'], 0, 2) . $randint;
			$Insert_Res= "INSERT INTO Resourceta (TypeID, Name, Location)VALUES ('".$newTypeID."', '".$_POST['ResName']."', '".$_POST['ResLocation']."')";
			$Insert_Inv="INSERT INTO inventoryta (Qty, CheckID, TypeID)VALUES ('".$_POST['RQty']."', '".$CheckerID."', '".$newTypeID."')";
			if ($result = $mysqli->query($Insert_Res)){
				if ($result = $mysqli->query($Insert_Inv)){
					echo "Table Insert Successful";
				}
				else{
					echo "Table Insert Failed, Please Contact an Admin";
				}
			}
			else{
				echo "Table Insert Failed, Try Again";
			}
			
		}
			?>