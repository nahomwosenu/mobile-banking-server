<?php 
 $id=$firstname=$lastname=$middlename=$age=$sex=$address='';
 $username=$password=$pin='';
 if($_SERVER['REQUEST_METHOD']=='POST'){
 	if(!empty($_POST['id'])){
 		$id=valid($_POST['id']);
 	}
 	else die('error id should not be empty');
 	if(!empty($_POST['firstname']))
 		$firstname=valid($_POST['firstname']);
 	else die('error firstname is required');
 	if(!empty($_POST['lastname']))
 		$lastname=valid($_POST['lastname']);
 	else die('error lastname is required');
 	if(!empty($_POST['middlename']))
 		$middlename=valid($_POST['middlename']);
 	else die('error middlename is required');
 	if(!empty($_POST['sex']))
 		$sex=valid($_POST['sex']);
 	else die('error sex is required');
 	if(!empty($_POST['age']))
 		$age=valid($_POST['age']);
 	else die('error age is required');
 	if(!empty($_POST['address']))
 		$address=valid($_POST['address']);
 	else die('error address is invalid');
 	if(!empty($_POST['username']))
 		$username=valid($_POST['username']);
 	else die('error username is required');
 	if(!empty($_POST['password']))
 		$password=valid($_POST['password']);
 	else die('error password is required');
 	register($id,$firstname,$lastname,$middlename,$sex,$age,$address,$username,$password);

 }
 function register($id,$fn,$ln,$mn,$sex,$age,$addr,$user,$pass){
 	$connect=mysqli_connect('localhost','root','','mobilebanking') or die('error connecting to db');
 	$query="insert into customer(id,firstname,lastname,middlename,sex,age,address,username) 
 	    values('$id','$fn','$ln','$mn','$sex','$age','$addr','$user')";
 	do{
 	$account_no=rand(1000,10000);
 	 }while(existAccount($account_no));
 	 $password=password_hash($pass,$PASSWORD_DEFAULT);
 	$query2="insert into user('account_no','password','type') values ('$account_no','$password','customer')";
 	$query3="insert into account(account_no,balance) values ('$account_no','0.00')";
 	$pin=rand(1000,9000);
 	$query4="insert into ussd(account_no,pin) values('$account_no','$pin')";
 	$result1=mysqli_query($connect,$query) or die('error customer not registered');
 	$result2=mysqli_query($connect,$query2) or die('error user not registered');
 	$result3=mysqli_query($connect,$query3) or die('error account not created');
 	$result4=mysqli_query($connect,$query4) or die('error ussd not created');
 	if($result1 && $result2 && $result3 && $result4)
 		die('true');
 	else die('false');
 }
 function valid($input){
 	$input=trim($input);
 	$input=htmlspecialchars($input);
 	$input=stripslashes($input);
 	return $input;
 }
 function existAccount($account_no){
 	$connect=mysqli_connect('localhost','root','','mobilebanking') or die('error connecting to db');;
 	$query="select account_no from customer where account_no='$account_no' ";
 	$result=mysqli_query($connect,$query) or die('error');
 	if($row=mysqli_fetch_array($result)){
 		return true;
 	}
 	else return false;
 }

?>