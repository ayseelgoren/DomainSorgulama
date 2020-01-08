<?php
session_start();
include ("conn.php");
include ("sorgulama.php");

if(isset($_POST['buton']))
{
    $_SESSION['domain']=$_SESSION['site'];
}
if(isset( $_SESSION['domain']) ){

    $k_id= $_SESSION['k_id'];
    $site=$_SESSION['domain'];

    $query  = $db->query("SELECT * FROM Domainler WHERE k_id='$k_id' && site_adi='$site'",PDO::FETCH_ASSOC);
    if ( isset($query) && $query->rowCount()==0){
            $result = $db->prepare("INSERT INTO Domainler SET  k_id=?,site_adi=?");
            $result->execute(array($k_id,$site));
            if($result){
                header("Location:domainler.php");
            }
            else
                echo "işlem başarısız";

    }
    else{
            echo "<b class='p'>Listenizde Zaten bulunmaktadır...</b>";
    }



}
?>
<style>
    .p{
        position:absolute;
        right:15%;
        width:25%;
        top:72%;
        color: #E1001F;
    }
</style>


