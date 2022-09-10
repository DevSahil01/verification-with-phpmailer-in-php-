<!-- include connection file and session start and get the stored values in the session-->
<?php
session_start();
include("connection.php");
$email=hash('md5',$_SESSION['mail']);
$otp=$_SESSION['otp'];
?>
<!-- otp verification and verify email from the database -->
<?php
if($_GET['type']=="verification"){
if(isset($_POST['submit'])){
  $ent_otp=$_POST['otp'];
  if($ent_otp==$otp){
    $update="UPDATE teacher_info SET verified_email_id='1' WHERE email_id='$email'";
    $sql=mysqli_query($conn,$update);
    session_destroy();
    if($sql){
      header("location:homepage.php");
    }
    else{
      echo("something went wrong");
    }
  }
  else{
    echo("otp is invalid,please enter valid email.");
  }
}
}
else{
  if(isset($_POST['submit'])){
    $ent_otp=$_POST['otp'];
    if($ent_otp==$otp){
      header("location:new_psw.php?email=$email");
    }
    else{
      echo"invalid otp";
    }
  }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdeli  vr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Verification page</title>
</head>
<body>
  <div class="container bg-light w-100 h-50" >
    <p>The verification code is send to your email <b><?php echo$email; ?></b></p>
    <p>Please check your email to get the verification code </p>
    </div>
    <div class="container my-5 border rounded-3 d-flex justify-content-center">
      <form method="post">
        <div class="mb-5">
          <label for="exampleInput" class="form-label">Enter OTP</label>
          <input type="text" class="form-control w-75" name="otp" id="exampleInput">
        </div>
        <button type="submit" name="submit" class="btn btn-primary mb-4">Submit</button>
      </form>
    </div>
    
  </body>
  </html>