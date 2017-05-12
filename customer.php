<?php 
 function getDetail($account){
   $connect=mysqli_connect('localhost','root','','mobilebanking');
   $query="select * from customer where account_no='$account'";
   $result=mysqli_query($connect,$query);
   $data='';
   if($row=mysqli_fetch_array($result)){
   	$data=$row['firstname'].','.$row['lastname'].','.$row['middlename'].','.$row['age'].','.$row['sex'].','.$row['username'].','.$row['id'].','.$data;
   	die('true '.$data);
   }
   else die('false');
 }
?>