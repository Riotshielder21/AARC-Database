<?php
	//Connect to the Databasee
	$host="localhost";
	$username="root";
	$pword="";
	$database="AARC";
	require("..\phpCore\db_Connect.php");
	
	//initialise 
	$Username = '';
	$Password = '';
		
	// Check if the form was submitted
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		
		//POST Username and Password
		$Username = $_POST['Username'];
		$Password = $_POST['Password'];
		
		// Check if file was uploaded without errors
		if(isset($_FILES["file"]) && $_FILES["file"]["error"] == 0){
			$filename = $_FILES["file"]["name"];
			$filetype = $_FILES["file"]["type"];
			$filesize = $_FILES["file"]["size"];
    
			// Verify file extension
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			//if(array_key_exists($ext, $unallowed)) die("Error: Please select a valid file format.");
    
			// Verify file size - 1GB maximum
			$maxsize = 128*1024*1024*1024;
			if($filesize > $maxsize) {die("Error: File size is larger than the allowed limit.");}
    
			// Verify MYME (Multi-purpose Internet Mail Extensions) type of the file
			//if(in_array($filetype, $allowed)){
				
				// Check whether file exists before uploading it
				if(file_exists("C:/xampp/htdocs/Uploads/" . $_FILES["file"]["name"])){
					echo $_FILES["file"]["name"] . " already exists.";
					echo "Please Rename your File or Request the old one deleted!";
				} else{
					
					//initialise 
					$userPrivilege=0;
					echo $userPrivilege;
					
					//Get Username's Password
					$querystring= "SELECT UserTa.UserID, UserTa.Username, UserTa.Password, UserTa.Privilege, CheckerTa.CheckID FROM UserTa WHERE UserTa.Username = '". $Username ."' INNER JOIN CheckerTa ON UserTa.UserID = CheckerTa.UserID";
					
					//Send Query to MySQL
					if ($result = $mysqli->query($querystring)){
						echo $userPrivilege;
						//Fetch Row as Username Field is Unique there should only be 1 return
						while ($row = $result->fetch_row()){
								$confPass= $row->password;
								
								//Check for password match before assigning the authority
								if ($confPass == $password){
									$userPrivilege= $row->privilege;
									$checkerID= $row->checkerID;
									echo $userPrivilege;
								}
								else {
									//Invalidate Authority
									$userPrivilege=0;
									echo $userPrivilege;
								}
						}
					}
					
					//Check Authority
					If ($userPrivilege==1){
						
						//Add a file copy to Directory Root
						move_uploaded_file($_FILES["file"]["tmp_name"], "C:/xampp/htdocs/Uploads/" . $_FILES["file"]["name"]);
						
						//Random File ID - this is a temporaty feature which will need a quey validation to make sure there are no other TypeID's the same so it an regenerate if thats the case
						$RANDINT4 = rand(1000, 9999);
						
						//Creates Querys to add file and data
						$addResour="INSERT INTO resourceTa (TypeID, name, location, filesize, filetype) VALUES ('f\'".$RANDINT4."\',\'". $name ."\',\'" . $filename . "\',\'" . $filetype . "\','C:/xampp/htdocs/Uploads/\'". $_FILES["file"]["name"] ."\',\'" . $filesize . "\')";
						$addInvent="INSERT INTO inventoryTa (TypeID, CheckID) VALUES ('f\'".$RANDINT4."\',\'" . $checkerID . "\',)";		
						
						//Runs first Query with error handles
						if ($result =  $mysqli -> Query($addResour)){
							$result->close();
							//Runs second Query with error handles
							if ($result =  $mysqli -> Query($addInvent)){
								$result->close();
								echo "Your file was uploaded successfully.";
							} else {
							echo "Error on File Table Update";
							}
						}
						else{
							echo "Error on File Table Update";
						}
						
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
			<div class="mItem"><a href="Request.html">Request</a></div>
			<div class="mItem"><a href="Upload.php">Upload</a></div>
			<div class="mItem" onclick="help()">Help</div>
		</div>
		
		<div id="titleBlock">
	
			<h1 id="title">AARC Document Upload Form</h1>
			<div class="mainBody" id="doubleBox">
				<form id="form_Box"  method="Post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
					<label name="Text">Please Enter Username and Password:</label><br >
					<input type="text" name="Username" Placeholder="Username:"/><br >
					<input type="text" name="Password" Placeholder="Password:"/><br >
					<label name="file" for="file">File:</label>
					<input type="file" name="file" id="fileSelect"><Label value="Max Size = 128MB" /><br />
					<input type="submit" name="submit" Value="submit">
				</form>
			</div>
		</div>
	</div>
</body>
</html>