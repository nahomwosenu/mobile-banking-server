<?php 
 $account_no=$username=$password='';
 if($_SERVER['REQUEST_METHOD']=='POST'){
 	if(!empty($_POST['account_no']))
 		$account_no=valid($_POST['account_no']);
 	else if(!empty($_POST['username']))
 		$username=valid($_POST['username']);
 	else die('error account_no or username is required');
 	if(!empty($_POST['password']))
 		$password=valid($_POST['password']);
 	else die('error password is required');
 	if(!empty($account_no))
 	login($account_no,$password);
    else if(!empty($username))
    login2($username,$password);
 }
 function valid($input){
 	$input=trim($input);
 	$input=htmlspecialchars($input);
 	$input=stripslashes($input);
 	return $input;
 }

 function login($account,$password){
 	$connect=mysqli_connect('localhost','root','','mobilebanking') or die('error connecting to db');
 	$query="select password,type from user where account_no='$account'";
 	$result=mysqli_query($connect,$query) or die(mysqli_error($connect));
 	if($row=mysqli_fetch_array($result)){
 		$pass=$row['password'];
 		$type=$row['type'];
 		if(password_verify($password,$pass))
 			die('true '.$type);
 		else die('false error');
 	}
 	die('false');
 }
 function login2($username,$password){
 	$connect=mysqli_connect('localhost','root','','mobilebanking') or die('error connecting to db');
 	$account=getAccount($username);
 	$query="select password,type from user where account_no='$account'";
 	$result=mysqli_query($connect,$query) or die('error');
 	if($row=mysqli_fetch_array($result)){
 		$hash=$row['password'];
 		$type=$row['type'];
 		if(password_verify($password,$hash)==true){
 			die('true '.$type.' '.$account);
 		}
 		else die('false Error');
 	}
 	else die('false failed');
 }
 function getAccount($username){
 	$connect=mysqli_connect('localhost','root','','mobilebanking') or die('error connecting to db');
 	$query="select account_no from customer where username='$username'";
 	$result=mysqli_query($connect,$query) or die('error');
 	if($row=mysqli_fetch_array($result)){
 		$r=$row['account_no'];
 		return $r;
 	}
 	return 0;
 }
?>
