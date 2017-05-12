<?php 
 if($_SEVER['REQUEST_METHOD']=='POST'){

 }

?>
<html>
<head>
</head>
<body>
<?php 
 if(empty($_SESSION['user'])){
 	?>
 <h1>This is a web-based controller for mobile application </h1>
 <form action='<?php echo $_SEVER['PHP_SELF'] ?>' method='POST'>
  Username: <input type='text' name='username'><br/>
  Password: <input type='password' name='password'><br/>
  <input type='submit' value='Login'>
 </form>
<?php 
}
else {
?>
 <h1>Welcome Select an Operation to continue</h1>
 <a href='createaccount.php'>Create new customer account</a>
 <a href='managecustomer.php'>Manage customer account</a>
 <a href='transactionlog.php'>Manage Transaction Log</a>
 <a href='manageussd.php'>Manage USSD Requests</a>
<?php 
}
?>
</body>
</html>