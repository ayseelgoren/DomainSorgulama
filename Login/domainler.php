<?php
session_start();
include ("conn.php");
include ("home.php");

?>
    <ul class="sorgu">
        <br>
        <li class="li">Domainlerim</li><br>
        <?php
        $k_id= $_SESSION['k_id'];

        $query = $db->query("SELECT * FROM Domainler WHERE k_id='$k_id'", PDO::FETCH_ASSOC);
        if ($say = $query->rowCount()) {
            if ($say > 0) {
                foreach ($query as $row) {
                    ?>
                    <form  action="post.php" method="post" >

                    <input type="submit" class="btn" name="site" value="<?php echo $row['site_adi'] ;?>" />
                    </form>
                    <?php

                }

            }
        }

        ?>
    </ul>

    <?php

?>

</body>
<style>
    .btn {
        background-color: #649DBB;
        border: none;
        color: white;
        padding: 18px 60px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        margin: 4px 2px;
        cursor: pointer;
        border-radius: 16px;
        font-size: 20px;
    }

    .btn:hover {
        background-color: #84C2D9;
    }

    .sorgu{
        position: absolute;
        top: 20%;
        left: 30%;
        width: 28%;
        background-color: #5F849E;
        text-align: center;
    }


    ul {
        padding: 0;
        margin: 0;
        list-style-type: none;
        width: 250px;
        display: inline-block;
    }

    .li{
        padding: 15px;
        display: block;
        text-decoration: none;
        background-color: #5F849E;
        color: #fff;
        font-size: 30px;
        border-left:5px solid #5F849E;
    }


    ul li a:hover:not(.active) {
        background-color: #2E7582;
        border-left:5px solid #F3F9FE;
    }

</style>