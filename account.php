<?php 
 include_once("customer.php");
 $request='';
 if($_SERVER['REQUEST_METHOD']=='POST'){
 	if(!empty($_POST['request']))
 		$request=valid($_POST['request']);
 	else die('error no data specified');
 	if($request=='deposite'){
 		$amount=$account='';
 		if(!empty($_POST['amount']) && !empty($_POST['account_no'])){
 			$amount=valid($_POST['amount']);
 			$account_no=valid($_POST['account_no']);
 			deposite($account_no,$amount);
 		}
 		else die('error you need to specify amount and account number!');

 	}
 	else if($request=='changepassword'){
 		$acount=$password=$newPassword='';
 		if(!empty($_POST['account']) && !empty($_POST['password']) && !empty($_POST['newpassword'])){
 			$acount=valid($_POST['account']);
 			$password=valid($_POST['password']);
 			$newPassword=valid($_POST['newpassword']);
 			changePasssword($acount,$password,$newPassword);
 		}else die('error data not specified');
 	}
 	else if($request=='withdraw'){
 		$amount=$account='';
 		if(!empty($_POST['amount']) && !empty($_POST['account_no'])){
 			$amount=valid($_POST['amount']);
 			$account_no=valid($_POST['account_no']);
 			withdraw($account_no,$amount);
 		}
 		else die('error you need to specify amount and account number!');
 		
 	}
 	else if($request=='transfer'){
      $account1=$amount=$account2='';
      if(!empty($_POST['fromAccount']) && !empty($_POST['toAccount']) && 
      	 !empty($_POST['amount'])){
      	 $account1=$_POST['fromAccount'];
      	$account2=$_POST['toAccount'];
      	$amount=$_POST['amount'];
      	if(!existAccount($account2))
      		die('error account not found!');
      	transfer($account1,$account2,$amount);
      }
 	}
 	else if($request=='account_by_id'){
 		if(!empty($_POST['id'])){
 			$id=valid($_POST['id']);
 			getAccountById($id);
 		}
 		else die('error id is required');
 	}
 	else if($request=='account_by_name'){
 		if(!empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['middlename'])){
 			$fname=valid($_POST['firstname']);
 			$lname=valid($_POST['lastname']);
 			$mname=valid($_POST['middlename']);
 			getAccountNumber($fname,$lname,$mname);
 		}
 	}
 	else if($request=='balance'){
 		if(!empty($_POST['account_no'])){
 			$account=valid($_POST['account_no']);
 			$balance=getBalance($account);
 			die('balance='.$balance);
 		}

 	}
 }
 function changePasssword($account,$password,$newPassword){
    $connect=mysqli_connect('localhost','root','','mobilebanking');
    $query="select password from user where account_no='$account'";
    $result=mysqli_query($connect,$query) or die('error internal database');
    if($row=mysqli_fetch_array($result)){
    	$hash=$row['password'];
    	if(password_verify($password,$hash)==true){
    		$temp=password_hash($newPassword,PASSWORD_DEFAULT);
    		$query="update user set password='$temp' where account_no='$account'";
    		$result=mysqli_query($connect,$query) or die('error failed');
    		if($result)
    			die('true');
    		else die('error unknown');

    	}
    	else die('error incorrect password ');

    }
    else{
    	die('error');
    }

 }
 function deposite($account,$amount){
   $connect=mysqli_connect('localhost','root','','mobilebanking') 
   or die('error connecting to database failed');
   $balance=getBalance($account);
   $balance=$balance+$amount;
   $query="update account set balance='$balance' where account_no='$account'";
   $result=mysqli_query($connect,$query) or die('error balance not deposited!');
   if($result)
   	 die('true');
   	else die('false');
 }
 function withdraw($account,$amount){
 	$connect=mysqli_connect('localhost','root','','mobilebanking') 
   or die('error connecting to database failed');
   $balance=getBalance($account);
   if($balance >($amount+25))
   $balance=$balance+$amount;
   else die('error not enough balance!');
   $query="update account set balance='$balance' where account_no='$account'";
   $result=mysqli_query($connect,$query) or die('error withdrawal failed!');
   if($result)
   	 die('true');
   	else die('false');

 }
 function getBalance($account){
   $connect=mysqli_connect('localhost','root','','mobilebanking') 
   or die('error connecting to database failed');
   $query="select balance from account where account_no='$account'";
   $result=mysqli_query($connect,$query) or die('error balance could not be retrieved');
   if($row=mysqli_fetch_array($result))
   	return $row['balance'];
   else return 0;
 }
 function transfer($fromAccount,$toAccount,$amount){
   $connect=mysqli_connect('localhost','root','','mobilebanking') 
   or die('error connecting to database failed');
   $frBalance=getBalance($fromAccount);
   $toBalance=getBalance($toAccount);
   if($frBalance > $amount+25){
   	$frBalance=$frBalance-$amount;
   	$toBalance=$toBalance+$amount;
   }
   else die('error not enough balance to transfer');
   $query1="update account set balance='$frBalance' where account_no='$fromAccount'";
   $query2="update account set balance='$toBalance' where account_no='$toAccount'";
   $result1=mysqli_query($connect,$query1) or die('error transfer failed');
   $result2=mysqli_query($connect,$query2) or die('error transfer failed2');
   if($result1 && $result2)
   	die('true '.getDetail($toAccount));
   else die('false');
 }
 function getAccountNumber($firstname,$lastname,$middlename){
 	$connect=mysqli_connect('localhost','root','','mobilebanking');
 	$query="select account_no from customer where firstname='$firstname' and lastname='$lastname' and middlename='$middlename'";
 	$result=mysqli_query($connect,$query) or die('error account not found!');
 	if($row=mysqli_fetch_array($result)){
 		$account_no=$row['account_no'];
 		die($account_no);
 	}
 	else die('error account not found');
 }
 function getAccountById($id){
 	$connect=mysqli_connect('localhost','root','','mobilebanking');
 	$query="select account_no from customer where id='$id'";
 	$result=mysqli_query($connect,$query);
 	if($row=mysqli_fetch_array($result)){
 		$account=$row['acount_no'];
 		die($account);
 	}
 	else die('error account not found');
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