<?php
include("connection.php");
session_start();
$email=$_SESSION['mail'];
?>
<?php
if(isset($_POST['submit'])){
$hash_psw=hash('md5',$_POST['new_psw']);
$new_psw=mysqli_real_escape_string($conn,$hash_psw);
$query="update teacher_info set password='$new_psw' where email_id='$email'";
$sql=mysqli_query($conn,$query);
if($sql){
    echo"the password is changed successfully";
    session_destroy();
    echo" <a href='login.php'>login here </a>";
}
else{
    echo"the password is not changed";
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New password</title>
</head>
<body>
<div class="container my-5 border rounded-3 d-flex justify-content-center">
      <form method="post">
        <div class="mb-5">
          <label for="exampleInput" class="form-label">Enter New Password</label>
          <input type="text" class="form-control w-75" name="new_psw" id="exampleInput">
        </div>
        <button type="submit" name="submit" class="btn btn-primary mb-4">Submit</button>
      </form>
    </div>
</body>
</html>