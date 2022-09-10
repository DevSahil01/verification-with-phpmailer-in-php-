<?php 
include("connection.php");
session_start();
?>
<?php
if(isset($_POST['submit'])){
$email_id=mysqli_real_escape_string($conn,$_POST['email_id']);
$query="select * from teacher_info where email_id='$email_id'";
$sql=mysqli_query($conn,$query);
$result=mysqli_fetch_array($sql);
if($result>0){
    $otp = rand(100000,999999);
    $_SESSION['otp'] = $otp;
    $_SESSION['mail'] = $email_id;
    require "Mail/phpmailer/PHPMailerAutoload.php";
    $mail = new PHPMailer;

    $mail->isSMTP();
    $mail->Host='smtp.gmail.com';
    $mail->Port=587;
    $mail->SMTPAuth=true;
    $mail->SMTPSecure='tls';

    $mail->Username='salmankhan.s98765@gmail.com';
    $mail->Password='uegwygrlofigosqu';

    $mail->setFrom('email account', 'OTP Verification');
    $mail->addAddress($email_id);

    $mail->isHTML(true);
    $mail->Subject="Your verification code";
    $mail->Body="<p>Dear user, </p> <h3>Your verify OTP code is $otp <br></h3>
    <br><br>";
    if(!$mail->send()){
          echo("Register Failed, Invalid Email");
    }
    else{
       echo("Register Successfully, OTP sent to '$email_id'");
       header( "Location:verification.php?type=reset_psw" );
      }
  }
}
else{
    echo"user is not found";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
</head>
<body>
<div class="container my-5 border rounded-3">
      <form method="post">
        <div class="mb-5">
          <label for="exampleInput" class="form-label">Enter your Email</label>
          <input type="email" class="form-control w-75" name="email_id" id="exampleInput">
        </div>
        <button type="submit" name="submit" class="btn btn-primary mb-4 ml-5">Submit</button>
      </form>
    </div>
</body>
</html>