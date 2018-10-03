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
			<div class="mItem"><a href="Request.php">Request</a></div>
			<div class="mItem"><a href="Upload.php">Upload</a></div>
		</div>
		
		<div id="titleBlock">
	
			<h1 id="title">AARC Database Controls</h1>
	
			<div class="mainBody" id="doubleBox">
			<div id="form_Box"><?php
			if (!isset($_POST['ResName']) AND !isset($_POST['ResLocation']) AND !isset($_POST['RQty'])){
				$_GET['CheckerID'];?>
				<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
					<label name="Operation" for="Operation">Input Item Data:</label><br >
					<label type="Radio" name="ResName">Resource Name:
					<input type="Text" name="ResName"><br />
					<label type="Radio" name="ResLocation">Location:
					<input type="Text" name="ResLocation"><br />
					<label type="Radio" name="RQty">Quantity:
					<input type="Text" name="RQty" Required><br />
					<input type="hidden" name="CheckID" value"<?php $CheckID; ?>">
					<input type="submit" name="submit" value="Create">
				</form>
			</div>
			<?php
			} else {
				$CheckID=$_POST['CheckID'];
				$randint=RAND(1000,9999);
				$name = filter_var(trim(stripslashes($_POST['ResName'])));
				$locat = filter_var(trim(stripslashes($_POST['ResLocation'])));
				$newTypeID=substr($name, 0, 2) . $randint;
				$Insert_Res= "INSERT INTO Resourceta (TypeID, Name, Location)VALUES ('".$newTypeID."', '".$name."', '".$locat."')";
				$Insert_Inv="INSERT INTO inventoryta (Qty, CheckID, TypeID)VALUES ('".$_POST['RQty']."', '".$CheckID."', '".$newTypeID."')";
				if ($result = $mysqli->query($Insert_Res)){
					if ($result = $mysqli->query($Insert_Inv)){
						echo "Table Insert Successful";
						echo "<br/><a id='plain' href='Database.php'>Back</a>";
					}
					else{
						echo "Table Insert Failed, Please Contact an Admin";
						echo "<br/><a id='plain' href='Database.php'>Back</a>";
					}
				}
				else{
					echo "Table Insert Failed, Please Return";
					echo "<br/><a id='plain' href='Database.php'>Back</a>";
				}
			$result->close();
			$mysqli->close();
			}
			?>
			</div>
		</div>
	</div>
</body>
<footer>
<?php echo date('d:m:y h:i:s')?>
</footer>
</html>