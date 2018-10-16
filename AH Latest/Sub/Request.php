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
			<div class="mItem"<div class="mItem"><a href="..\index.html">Home</a><div id="tMenuStat">|||</div></div>
			<div class="mItem"><a href="Database.php">Database</a></div>
			<div class="mItem"><a href="Network.html">Network</a></div>
			<div class="mItem"><a href="Request.php">Request</a></div>
			<div class="mItem"><a href="Upload.php">Upload</a></div>
			<div class="mItem" onclick="help()">Help</div>
		</div>
		
		<div id="titleBlock">
	
			<h1 id="title">AARC Requests Form</h1>
	
			<div class="mainBody">
				<?php
				
	// initialise 
	// $Username = '';
	// $Password = '';
	// $Submit = 0;
		
	// Check if the form was submitted
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		
		//POST Username and Password and report content
		// $Username = filter_var(trim(stripslashes($_POST['Username'])));
		// $Password = filter_var(trim(stripslashes($_POST['Password'])));
		// $Title = filter_var(trim($_POST['title']));
		// $Report = filter_var(trim($_POST['report']));

		
		//Get Username's Password
		// $querystring= "SELECT userta.UserID, userta.Username, userta.Password, userta.Privilege, checkerta.CheckID FROM userta INNER JOIN checkerta ON userta.UserID = checkerta.UserID WHERE userta.Username = '".$Username."'";

		//Send Query to MySQL
		// if ($result = $mysqli->query($querystring)){
						
			//Fetch Row as Username Field is Unique there should only be 1 return
			// while ($row = $result->fetch_object()){
				// $confPass= $row->Password;
						
				//Check for password match before assigning the authority
				// if ($confPass == $Password){
					// $Submit = 1;
				// }
			// }
			
			//Check Authority
			// If ($submit==1){
				
				$fname = substr($title, 0, 2) . date ('m:d-h:i');
				$reportfile = fopen("C:/Users/User/Desktop/".$fname.".txt", "w") or die("Unable to open file!");
				fwrite($reportfile, $title . "\n");
				fwrite($reportfile, $report);
				fclose($reportfile);
				echo "Upload Complete!";
						
			//Where user has no Authority, rejection handles
			// } else{
				// echo "For security reasons, Please contact a member with an account before making a Report!";
			// }
		// } else {
			// echo "Failed to retrieve user details";
		// }
	} else {?>
				<div class="mainBody" id="doubleBox">
					<form method="Post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
						<!--<label id="usrform" name="Text">Please Enter Username and Password:</label><br />
						<input type="text" name="Username" Placeholder="Username:"/><br />
						<input type="password" name="Password" Placeholder="Password:"/><br /><br />-->
						<label name="report" for="report">Report:</label>
						<input type="Text" name="title" id="tbox"><br />
						<textarea form="usrform" name="report" id="report"><br />
						<input type="submit" name="submit" Value="submit">
					</form>
<?php}?>
			</div>
		</div>
	</div>
</body>
<footer>
<?php echo date('d:m:y h:i:s');?>
</footer>
</html>