<?php 
 if(empty($_SESSION['user'])){
  header('Location: admin.php');
 }
 else{
?>
<html>
<head>
<title>Create Customer Account</title>
</head>
<body>
 <h1>Create A New Customer Account</h1>
 <form action='<?php echo $_SERVER['PHP_SELF'] ?>' method='POST'>
 </form>
</body>
</html>