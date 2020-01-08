<?php
session_start();
include ("conn.php");
include ("home.php");
if(isset($_SESSION['oturum']))
{
    ?>
    <ul class="sorgu">
        <p class="baslik">Hesap Bilgileri</p>
<?php
        $k_id= $_SESSION['k_id'];

        $query = $db->query("SELECT * FROM Kullanici WHERE k_id='$k_id'", PDO::FETCH_ASSOC);
        if ($say = $query->rowCount()) {
        if ($say > 0) {
        foreach ($query as $row) {
        ?>
        <form  action="hesap.php" method="post" >

            <input type="text" class="button" name="ad" value="<?php echo $row['adi'] ;?>" /><br>
            <input type="text" class="button" name="soyad" value="<?php echo $row['soyadi'] ;?>" /><br>
            <input type="text" class="button" name="eposta" value="<?php echo $row['eposta'] ;?>" /><br>
            <input type="text" class="button" name="sifre" value="<?php echo $row['sifre'] ;?>" /><br><br>

            <input type="submit" class="btn" name="duzenle" value="Düzenle" /><br>

        </form>

        <?php


                }

            }
        }
        ?>
    </ul>

    <?php
}

if(isset($_POST['duzenle']))
{
    $k_id= $_SESSION['k_id'];
    $adi=$_POST['ad'];
    $soyadi=$_POST['soyad'];
    $eposta=$_POST['eposta'];
    $sifre=$_POST['sifre'];

    $query = $db->query("UPDATE Kullanici SET adi='$adi', soyadi='$soyadi', eposta='$eposta', sifre='$sifre' WHERE k_id='$k_id'", PDO::FETCH_ASSOC);
        if($query->rowCount()>0)
        {
            ?>
            <ul class="sorgu">
                <p class="baslik">Hesap Bilgileri</p>
                <?php
                $k_id= $_SESSION['k_id'];

                $query = $db->query("SELECT * FROM Kullanici WHERE k_id='$k_id'", PDO::FETCH_ASSOC);
                if ($say = $query->rowCount()) {
                    if ($say > 0) {
                        foreach ($query as $row) {
                            $_SESSION['ad']=$row['adi'];
                            $_SESSION['soyad']=$row['soyadi'];
                            $_SESSION['eposta']=$row['eposta'];
                            $_SESSION['sifre']=$row['sifre'];
                            ?>
                            <form  action="hesap.php" method="post" >

                                <input type="text" class="button" name="ad" value="<?php echo $row['adi'] ;?>"  autocomplete="off"/><br>
                                <input type="text" class="button" name="soyad" value="<?php echo $row['soyadi'] ;?>"  autocomplete="off"/><br>
                                <input type="text" class="button" name="eposta" value="<?php echo $row['eposta'] ;?>"  autocomplete="off"/><br>
                                <input type="text" class="button" name="sifre" value="<?php echo $row['sifre'] ;?>"  autocomplete="off"/><br><br>

                                <input type="submit" class="btn" name="duzenle" value="Düzenle" /><br>

                            </form>

                            <?php


                        }

                    }
                }
                ?>
            </ul>

            <?php
            echo "<b class='msg2'>İşlem Gerçekleşmiştir...</b>";
        }
        else{
            echo "<b class='msg'>Hiçbir değişiklik yok...</b>";
        }

}
?>
<style>
    .msg{
        position:absolute;
        right:42%;
        width:10%;
        bottom:15%;
        color: #E1001F;
    }
    .msg2{
        position:absolute;
        right:42%;
        width:10%;
        bottom:15%;
        color: #03A003;
    }
    .baslik{
        padding: 15px;
        display: block;
        text-decoration: none;
        color: white;
        background-color: #5F849E;
        font-size: 30px;
        border-left:5px solid #5F849E;
    }
    .button {
        background-color: white;
        border: none;
        color: black;
        padding: 15px 30px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        margin: 10px 5% 10px 5%;
        cursor: pointer;
        border-radius: 5px;
        font-size: 20px;
    }
    .sorgu{
        position: absolute;
        top: 25%;
        left: 30%;
        width: 28%;
        background-color: #5F849E;
        text-align: center;
    }
    .btn {
        background-color: #A0BACC;
        border: none;
        color: white;
        padding: 15px 50px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        margin: 10px 5% 10px 5%;
        cursor: pointer;
        border-radius: 16px;
        font-size: 20px;

    }

    .btn:hover {
        background-color: #649DBB;
    }
</style>
