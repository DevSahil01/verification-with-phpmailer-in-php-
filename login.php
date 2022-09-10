<?php session_start(); ?>
<?php 
include("connection.php");
if(isset($_POST['submit']))
{
  $email_id=mysqli_real_escape_string($conn,$_POST['email_id']);
  $password=mysqli_real_escape_string($conn,$_POST['password']);
  $hash_psw=hash('md5',$password);
  $query="SELECT * FROM teacher_info WHERE email_id='$email_id' AND password='$hash_psw'";
  $data=mysqli_query($conn,$query);
  $result=mysqli_fetch_array($data);
  if($result>0)
{
    if($result['verified_email_id']==1)
    {
       header("location:homepage.php");
    }
    else{
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
         header("location:verification.php");
        }
    }
  }
  else{
    echo"<script> alert('you are not registered user'); </script>";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <style>
      body{
        margin:0;
      }
    </style>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Login page
    </title>
</head>
<body> 
<div class="container border rounded-5 border-3  mt-5 text-center bg-light h-75">
      <h1>Login</h1>
    <form method="post">
  <div class="form-outline mt-4 row d-flex justify-content-center">
    <label for="exampleInputEmail1" class="mr-5 font-weight-bold">Email Adress:</label><br>
    <input type="email" class="form-control w-50 mx-3 my-2 py-2" name="email_id"  id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter your email ID">
  </div>
  <div class="form-outline mt-4 row d-flex justify-content-center mb-3">
    <label for="exampleInputPassword1" class="mr-5 ml-3">Password:</label><br>
    <input type="password" class="form-control w-50 mx-2 my-2 py-2" name="password" id="exampleInputPassword1" placeholder="Enter your Password" required>
  </div>
  <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" onclick="showpassword()">
  <label class="form-check-label" for="flexCheckDefault">
    Show Password
  </label><br><br>
  <a href="reset_psw.php">Forgot Password ? </a><br>
  <button type="submit" value="submit" name="submit" class="btn btn-success my-4 w-25 py-2">Submit</button>
</form>

<!-- *** javascript code for password visibility **** -->
<script>
function showpassword(){
 var psw=document.getElementById("exampleInputPassword1");
 if(psw.type=="password"){
  psw.type="text";
 }
 else{
  psw.type="password";
 }
}
</script>
</div>
</body>
</html>