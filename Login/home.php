<?php
session_start();
include ("conn.php");
?>
<body style="background-color: #A0BACC;font-size: 20px">

<div >
    <img src="avatar3.png" alt="Avatar" class="avatar">
    <p style="position: absolute;top: 27%;left: 7%;"><?php

        $k_id= $_SESSION['k_id'];
        $query = $db->query("SELECT * FROM Kullanici WHERE k_id='$k_id'", PDO::FETCH_ASSOC);
        if ($say = $query->rowCount()) {
            if ($say > 0) {
                foreach ($query as $row) {
                    echo "Hoşgeldin " . $row['adi'] . " " . $row['soyadi'];
                }
            }
        }
    ?></p>
</div>

<form method="post" action="sorgu.php" class="frm">
    <input id="namanyay-search-box"  type="text" name="site" placeholder="Sorgulamak için domain adresi giriniz..."  autocomplete="off" required>
    <button id="namanyay-search-btn" type="submit">ARA</button>
</form>


<div class="menu" >
    <form action="home.php" method="post">
        <ul>
            <li>
                <a href="hesap.php" >Hesabım</a>
            </li>
            <li>
                <a href="domainler.php">
                       Domainlerim
                </a>
            </li>
            <li>
                <a href="cikis.php">Çıkış</a>
            </li>
        </ul>
    </form>

</div>

</body>
<style>


    .menu{
        position: absolute;
        top: 37%;
        left: 5%;
        width: 500px;
    }

    .frm{
        position: absolute;
        top: 7%;
        right: 40%;
    }
    #namanyay-search-box {

        background: #eee;
        padding:10px;
        border-radius:5px 0 0 5px;
        -moz-border-radius:5px 0 0 5px;
        -webkit-border-radius:5px 0 0 5px;
        -o-border-radius:5px 0 0 5px;
        border:0 none;
        width:500px;
        font-size: 15px;
    }
    #namanyay-search-btn {

        background:#5F849E;
        color:white;
        padding:10px 20px;
        border-radius:0 5px 5px 0;
        -moz-border-radius:0 5px 5px 0;
        -webkit-border-radius:0 5px 5px 0;
        -o-border-radius:0 5px 5px 0;
        border:0 none;
        font-weight:bold;
        width: 120px;
        font-size: 15px;
    }

    img.avatar {
        position: absolute;
        top: 5%;
        left: 5%;
        width: 10%;
        border-radius: 50%;
        background-color: white;
    }

    ul {
        padding: 0;
        margin: 0;
        list-style-type: none;
        width: 50%;
        display: inline-block;
    }

    ul li a {
        padding: 25px;
        display: block;
        text-decoration: none;
        background-color: #5F849E;
        color: #fff;
        font-size: 20px;
        border-left:5px solid #5F849E;
    }

    /*ul li a.active {
        background-color: #068587;
        border-left:5px solid #f2b134;
    }*/

    ul li a:hover:not(.active) {
        background-color: #2E7582;
        border-left:5px solid #F3F9FE;
    }

</style>