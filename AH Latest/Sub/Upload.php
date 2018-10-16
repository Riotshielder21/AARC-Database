<?php
	//Connect to the Databasee
	$host="localhost";
	$username="root";
	$pword="";
	$database="AARC";
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
	
			<h1 id="title">AARC Document Upload Form</h1>
			
			<div class="mainBody" id="doubleBox">
				<form method="Post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
					<label name="Text">Please Enter Username and Password:</label><br />
					<input type="text" name="Username" Placeholder="Username:"/><br />
					<input type="password" name="Password" Placeholder="Password:"/><br />
					<label name="file" for="file">File:</label>
					<input type="file" name="file" id="fileSelect"><Label value="Max Size = 128MB" /><br />
					<input type="submit" name="submit" Value="submit">
				</form>
				<br />
				<?php
				
	//initialise 
	$Username = '';
	$Password = '';
		
	// Check if the form was submitted
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		
		//POST Username and Password
		$Username = filter_var(trim(stripslashes($_POST['Username'])));
		$Password = filter_var(trim(stripslashes($_POST['Password'])));
		
		// Check if file was uploaded without errors
		if(isset($_FILES["file"]) && $_FILES["file"]["error"] == 0){
			$filename = $_FILES["file"]["name"];
			$filetype = $_FILES["file"]["type"];
			$filesize = $_FILES["file"]["size"];
			//$filexten = $_FILES["file"][""];
			
			// Verify file extension
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			//if(array_key_exists($ext, $unallowed)) die("Error: Please select a valid file format.");
    
			// Verify file size - 1GB maximum
			$maxsize = 128*1024*1024*1024;
			if($filesize > $maxsize) {die("Error: File size is larger than the allowed limit.");}
    
			// Verify MYME (Multi-purpose Internet Mail Extensions) type of the file
			//if(in_array($filetype, $allowed)){
				
			// Check whether file exists before uploading it
			if(file_exists("C:/share/" . $_FILES["file"]["name"])){
				echo $_FILES["file"]["name"] . " already exists.";
				echo "Please Rename your File or Request the old one deleted!";
			} else{
					
				//initialise 
				$userPrivilege=0;
					
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
						
						//Random File ID - this is a temporaty feature which will need a quey validation to make sure there are no other TypeID's the same so it an regenerate if thats the case
						$RANDINT4 = rand(1000, 9999);
						
						//Creates Querys to add file and data
						$addResour="INSERT INTO resourceTa (TypeID, RName, RLocation, Filesize, Filetype, FileAuthor) VALUES('f".$RANDINT4."','" . $filename . "','C:/share/". $_FILES["file"]["name"] ."','" . $filesize . "','" . $filetype . "', '".$Username."')";
						$addInvent="INSERT INTO inventoryTa (TypeID, CheckID) VALUES ('f".$RANDINT4."','" . $checkerID . "')";		
						
						//Runs first Query with error handles
						if ($result1 =  $mysqli -> Query($addResour)){
							
							//Runs second Query with error handles
							if ($result2 =  $mysqli -> Query($addInvent)){
								
								//provide user with response
								echo "Your file was uploaded successfully.";
								
								//Add a file copy to Directory Root
								move_uploaded_file($_FILES["file"]["tmp_name"], "C:/share/" . $_FILES["file"]["name"]);
						
							} else {
							echo "Error on Table Update 2";
							}
						}
						
						else{
							echo "Error on Table Update 1";
						}
						
						$mysqli->close();
						
					//Where user has no Authority, rejection handles
					} else{
						echo "You do not have sufficent privileges to upload files to the server for security reasons, Please contact an admin or member with sufficient privileges before Uploading!";
					}
					
			//	} 
			//} else{
			//	echo "Error: There was a problem uploading your file. Please try again."; }
			}
		} else{
			echo "Error: " . $_FILES["file"]["error"];
		}
	}
	
?>
			</div>
		</div></div>
</body>
<footer>
<?php echo date('d:m:y h:i:s')?>
</footer>
</html>
	