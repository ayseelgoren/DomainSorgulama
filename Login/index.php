<?php
include ("conn.php");
session_start();
if(isset($_POST['kayit'])){

    if(isset($_POST["ad"])&& isset($_POST["soyad"])&&isset($_POST["psw"])&&isset($_POST["psw-repeat"])&&isset($_POST["email"])){
        // Post ettirdik
        $ad         = $_POST["ad"];
        $soyad      = $_POST["soyad"];
        $email		= $_POST["email"];
        $password	= $_POST["psw"];
        $teksifre   = $_POST["psw-repeat"];

        if( filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) ){

            if($_POST["psw"]==$_POST["psw-repeat"]){
                $query  = $db->query("SELECT * FROM Kullanici WHERE eposta='$email'",PDO::FETCH_ASSOC);
                if ( $say = $query -> rowCount() ){

                    $msg="Bu mail adresi kayıtlıdır.Başka bir mail adresi kullanınız...";


                }
                else{
                    $result = $db->prepare("INSERT INTO Kullanici SET  adi=?,soyadi=?,eposta=?,sifre=?");
                    $result->execute(array($ad,$soyad,$email,$password));
                    $msg="Kayıt Oldunuz Lütfen Giriş Yapınız...";
                }
            }
            else{
                $msg="Girdiğiniz şifreler birbirlerini tutmuyor.Tekrar deneyiniz..";
            }

        }
        else{
            $msg="Lütfen mail adresi giriniz...";
        }

    }
    else{
        $msg="Boş Değer Var...";
    }
}
if(isset($_POST['giris'])){


    if(isset($_POST["psw"])&& isset($_POST["email"]))
    {
        if(filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){

            $email =$_POST["email"];
            $pass =$_POST["psw"];
            $query  = $db->query("SELECT * FROM Kullanici WHERE eposta='$email' && sifre='$pass'",PDO::FETCH_ASSOC);
            if ($query->rowCount()>0){
                    session_start();
                    $_SESSION['oturum']=true;
                    $_SESSION['eposta']=$email;
                    $_SESSION['sifre']=$pass;
                    foreach( $query as $row ){
                        $_SESSION['ad']=$row['adi'];
                        $_SESSION['soyad']=$row['soyadi'];
                        $_SESSION['k_id']=$row['k_id'];
                    }

                    header("Location:home.php");
            }
            else{
                $msg_2="Böyle bir kullanıcı bulunmamaktadır...";

            }
        }
        else{
            $msg_2="E-posta adresininizi kontrol ediniz...";
        }

    }
    else{
        $msg_2="Mail ve şifre bilgilerini boş bırakmayınız";
    }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Domain Sorgulama</title>
    <link href="https://fonts.googleapis.com/css?family=Lobster&display=swap" rel="stylesheet">
</head>
<body style="background-color: #A0BACC;font-size: 20px">

<p class="wcm">Domain Sorgulama</p>

<div style="position:absolute;right:20%;width:25%;margin-top:5%">

    <form action="index.php"  method="post">

        <div class="imgcontainer">
            <img src="avatar3.png" alt="Avatar" class="avatar">
        </div>
        <h3 style="text-align: center">Kayıt Ol</h3>
        <div class="container">

            <input type="text" placeholder="Adınız" name="ad" autocomplete="off"  maxlength="20" required>

            <input type="text" placeholder="Soyadınız" name="soyad" autocomplete="off"  maxlength="15" required></i>


            <input type="text" placeholder="Email@xyz.com" name="email" autocomplete="off"  maxlength="30" required>


            <input type="password" placeholder="Şifreniz" name="psw"  minlength="5" autocomplete="off"  maxlength="15" required>


            <input type="password" placeholder="Tekrar Şifreniz" name="psw-repeat" minlength="5" maxlength="15" autocomplete="off" required>

            <div class="clearfix">
                <button type="submit" class="signupbtn" name="kayit">Kayıt Ol</button>
            </div>
            <p style="color: #E1001F"><?php echo $msg;?></p>
        </div>
    </form>
</div>


<div style="position: absolute;left:20%;width:25%;margin-top: 5%">


    <form action="index.php"  method="post">
        <div class="imgcontainer">
            <img src="avatar3.png" alt="Avatar" class="avatar">
        </div>
        <h3 style="text-align: center">Giriş Yap</h3>
        <div class="container">

            <input type="text" placeholder="Email@xyz.com" name="email" autocomplete="off" minlength="5" maxlength="30" required>


            <input type="password" placeholder="Şifreniz" name="psw" minlength="5" maxlength="15" autocomplete="off" required>


            <div class="clearfix" >
                <button type="submit" class="loginbtn" name="giris">Giriş Yap</button>
            </div>
            <p style="color: #E1001F"><?php echo $msg_2;?></p>
        </div>
    </form>

</div>

</body>
</html>





<style>
    .msg{
        position:absolute;
        right:16%;
        width:24px;
        top:5%;
        color: #E1001F;
    }
    .wcm{
        position: relative;
        top: 60px;
        font-family: 'Lobster', cursive;
        font-size: 80px;
        text-align: center;
        margin: 0;
        width: 95%;
    }
    input[type=text], input[type=password] {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        box-sizing: border-box;
    }


    @media screen and (max-width: 300px) {
        span.psw {
            display: block;
            float: none;
        }
        .cancelbtn {
            width: 100%;
        }
    }
    .imgcontainer {
        text-align: center;
        margin: 18px 0 8px 0;
    }

    img.avatar {
        width: 20%;
        border-radius: 50%;
    }

    .container {
        padding: 40px;
    }
    span.psw {
        float: right;
        padding-top: 16px;
    }
    body {font-family: Arial, Helvetica, sans-serif;}
    form {border: 3px solid #f1f1f1;}

    /* Full-width input fields */
    input[type=text], input[type=password] {
        width: 100%;
        padding: 15px;
        margin: 5px 0 22px 0;
        display: inline-block;
        border: none;
        background: #f1f1f1;
    }

    input[type=text]:focus, input[type=password]:focus {
        background-color: #ddd;
        outline: none;
    }

    hr {
        border: 1px solid #f1f1f1;
        margin-bottom: 25px;
    }

    /* Set a style for all buttons */
    button {
        background-color: #2E7582;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
        opacity: 0.9;
        font-size: 15px;
        border-radius: 17px;
    }

    button:hover {
        opacity:1;
    }

    /* Extra styles for the cancel button */
    .cancelbtn {
        padding: 14px 20px;
        background-color: #f44336;
    }

    /* Float cancel and signup buttons and add an equal width */
    .cancelbtn, .signupbtn ,.loginbtn{
      margin-left: 28%;
        width: 50%;
    }

    /* Add padding to container elements */
    .container {
        padding: 16px;
    }

    /* Clear floats */
    .clearfix::after {
        content: "";
        clear: both;
        display: table;
    }

    /* Change styles for cancel button and signup button on extra small screens */
    @media screen and (max-width: 300px) {
        .cancelbtn, .signupbtn ,.loginbtn{
            width: 50%;
        }
    }
</style>