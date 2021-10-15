<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
        <title>Subscribe Action</title>
        <link href="standard.css" rel="stylesheet" type="text/css">
        <meta charset="UTF-8"/>
</head>
<body>
<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	$fname = $lname = $email = $stat = $pet = $course = " "; //varaibles to hold input values
	$errors = [];                                            //array to hold erroy messages

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (empty($_POST["firstname"])) { //first name validation - extra precaution 
    			$errors['fnameErr']  = "\n*First name is required"; //I have firstname flagged as 'required' in <form>
  		} else {
			$fname = test_input($_POST["firstname"]);
        		if (!preg_match("/^[a-zA-Z ]*$/",$fname)) {
        			$errors['fnameErr']  = "\n*Only letters and white space allowed for first name";
			}
		}
		if (empty($_POST["lastname"])) { //last name validation - extra precaution
                        $errors['lnameErr'] = "\n*Last name is required"; //I have last name flagged as 'required' in <form>
                } else {
			 $lname = test_input($_POST["lastname"]);
        		if (!preg_match("/^[a-zA-Z ]*$/",$lname)) {
        		       $errors['lnameErr'] = "\n*Only letters and white space allowed for last name";
			}
                }
		if (empty($_POST["email"])) { //email validation - extra precaution
                        $errors['emailErr'] = "\n*Email is required"; //I have email name flagged as 'required' in <form>
                } else {
                         $email = test_input($_POST["email"]);
        		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        		      $errors['emailErr'] = "\n*Invalid email format";
			}
                }
		if (empty($_POST["status"])) { //status validation
                        $errors['statErr'] = "\n*Status field required";
                } else {
                         $stat = test_input($_POST["status"]);
		}
		if (empty($_POST["pet"])) { //pet validation - extra precaution because 'cat' selected by default
                        $errors['petErr'] = "\n*Favorite pet field required";
                } else {
                        $pet = test_input($_POST["pet"]);
                }
		if (empty($_POST["course"])) { //course validation - checks to make sure only 3 digits entered
                        $errors['courseErr'] = "\n*Course required";
                } else {
			$course = test_input($_POST["course"]);
			if (strlen($course) != 3) {          
                                $errors['courseErr']  = "\n*Please enter a valid course number";
                        }
		}

		if(empty($errors)) { //if "errors" array empty after input validation -> no errors found
        		$string = $fname . ' ' . $lname . ' ' .  $email . ' ' . $stat . ' ' . $pet . ' ' . $course;
       			$fp = fopen("subscribe_data.txt", "a+"); 
        		fwrite($fp, $string); //write concenated string of input data to output file
        		fclose($fp);
        	
			echo 'Welcome ' . $fname;
        		exit;
		}
		else{ //if "error" array not empty,
    			foreach($errors as $val){ //traverse array and print each error
        			echo $val . '<br/>'; 
			}
    		}
}
	function test_input($data) { 
 		$data = trim($data);
  		$data = stripslashes($data);
  		$data = htmlspecialchars($data);
 		return $data;
	}
?>
</body>
</html>
