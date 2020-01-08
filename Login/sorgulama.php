<?php
session_start();
include ("conn.php");
include ("home.php");
if(isset($_SESSION['site']) ) {
    ?>
    <body>

    <form action="domain.php" class="sorgu" method="post" >
        <ul class='ull'>
            <br><b>Domain Bilgileri</b>
            <?php
            $id = $_SESSION['sonid'];
            $query = $db->query("SELECT * FROM Domain_ WHERE id='$id'", PDO::FETCH_ASSOC);
            if ($say = $query->rowCount()) {
                if ($say > 0) {
                    foreach ($query as $row) {
                        echo "<br><br><li class='lii'>Site : " . $_SESSION['site']  . "</li>";
                        echo "<li class='lii'>Alexa Global Değeri : " . $row['alexa_global'] . "</li>";
                        echo "<li class='lii'>Alexa Türkiye Değeri : " . $row['alexa_turkiye'] . "</li>";
                        echo "<li class='lii'>Domain Yaşı : " . $row['yas'] . "</li>";
                        echo "<li class='lii'>Domain Oluşturma Tarihi : " . $_SESSION['date'] . "</li>";
                        echo "<li class='lii'>Title : " . $row['title'] . "</li>";
                        echo "<li class='lii'>Meta : " . $row['meta'] . "</li>";
                        echo "<li class='lii'>Google Pagerank Değeri : " . $row['pagerank'] . "</li>";
                    }

                }
            }


            ?>

        </ul>
        <br><br><br>
        <button type="submit" class="button" name="buton">Listeleme Ekle</button>
        <br><br><br>
    </form>
    </body>
    <?php
}
?>
<style>

    .ull,.lii{
        list-style-type: square;
        margin-left: 40px;
        width: 90%;
    }
    .sorgu{
        position: absolute;
        top: 25%;
        left: 25%;
        width: 50%;
        background-color: #5F849E;
        color: white;
        font-size: 20px;
    }
    .button {
        background-color: #A0BACC;
        border: none;
        color: white;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        margin: 4px 2px 0px 67%;
        cursor: pointer;
        border-radius: 16px;
        font-size: 20px;


    }

    .button:hover {
        background-color: #649DBB;
    }
</style>