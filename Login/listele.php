<?php
session_start();
include("conn.php");
include("home.php");


?>
<body>
<form action="#" method="post" class="date" >

    <i  style="display:inline">1.Tarih Aralığı :

        <input  type="date"  name="giris_tarih" autocomplete="off" class='fas fa-calendar-alt' min="2019-07-17" tabindex="1" >

        2.Tarih Aralığı :

        <input  type="date" name="cikis_tarih" autocomplete="off" class='fas fa-calendar-alt' min="2019-07-17" tabindex="2"></i><br><br>

    <input type="submit"  value="Göster" id="gonder" class="button" >

</form>
<p><?php echo "Site Adı : ".$_SESSION['sorsite'];?></p>
    <table id="customers">

        <tr>
            <th>Tarih</th>
            <th>Alexa Global</th>
            <th>Alexa Global Değişimi</th>
            <th>Alexa Türkiye</th>
            <th>Alexa Türkiye Değişimi</th>
            <th>Domain Yaşı</th>
            <th>Title</th>
            <th>Meta</th>
            <th>Google Pagerank</th>
        </tr>
        <?php
        $adi=$_SESSION['sorsite']."/";
        //Tarih aralıkları girilmeden tüm verilerin bulunmasını sağlıyor
        if($_SESSION['sorsite'] && !isset($_POST['giris_tarih']) && !isset($_POST['cikis_tarih']))
        {

            $data=array();
            $ar=array();
            $adet=0;
        try{
        $date=$db->query("SELECT DISTINCT tarih,alexa_global,alexa_turkiye FROM Domain_ WHERE site='$adi' ",PDO::FETCH_ASSOC);
        if($date->rowCount())
        {
            foreach ($date as $item)
            {
                $tarih=$item['tarih'];
                $g_fark=$item['alexa_global'];
                $t_fark=$item['alexa_turkiye'];
                    $veri=$db->query("SELECT * FROM Domain_ WHERE tarih='$tarih' AND alexa_global='$g_fark'AND alexa_turkiye='$t_fark' AND site='$adi' " , PDO::FETCH_ASSOC);
                    if($veri->rowCount()){
                        foreach ($veri as $row) {
                            array_push($ar,$row);
                            $adet++;
                            break;
                        }
                    }

            }
            $i=0;
            while ($i<count($ar)) {
                if($ar[$i]['tarih'] == $ar[$i+1]['tarih']){
                    if($ar[$i]['alexa_global'] >= $ar[$i+1]['alexa_global']){
                        array_push($data,$ar[$i+1]);
                    }
                    else{
                        array_push($data,$ar[$i]);
                    }
                    $i=$i+2;
                }
                else{
                    array_push($data,$ar[$i]);
                    $i++;
                }

            }

            ///buraya yazılacak
            for($i=0;$i<count($data);$i++) {


                echo "<tr><td>" . $data[$i]['tarih'] . "</td><td>" . $data[$i]['alexa_global'] . "</td>";

                //Alexa Global karşılaştırılması
                if ($i != 0) {
                    if ($data[$i - 1]['alexa_global'] > $data[$i]['alexa_global']) {
                        $rank = "-".($data[$i - 1]['alexa_global'] - $data[$i]['alexa_global']);
                        echo "<td style='background-color: #38CC4A'>" . $rank . "</td>";

                    } elseif ($data[$i - 1]['alexa_global'] < $data[$i]['alexa_global']) {
                        $rank = "+".($data[$i]['alexa_global'] - $data[$i - 1]['alexa_global']);
                        echo "<td style='background-color: #E1001F'>" . $rank . "</td>";

                    } else {

                        echo "<td style='background-color: #FFE5C0'>" . $rank. "</td>";
                    }

                } else {
                    $rank = 0;
                    echo "<td style='background-color: #FFE5C0'>" .  $rank . "</td>";
                }

                echo "<td>" . $data[$i]['alexa_turkiye'] . "</td>";

                //Alexa Türkiye karşılaştırılması
                if ($i != 0) {
                    if ($data[$i - 1]['alexa_turkiye'] > $data[$i]['alexa_turkiye']) {
                        $t_rank = "-".($data[$i - 1]['alexa_turkiye'] - $data[$i]['alexa_turkiye']);
                        echo "<td style='background-color: #38CC4A'>" . $t_rank . "</td>";

                    } elseif ($data[$i - 1]['alexa_turkiye'] < $data[$i]['alexa_turkiye']) {
                        $t_rank = "+".($data[$i]['alexa_turkiye'] - $data[$i - 1]['alexa_turkiye']);
                        echo "<td style='background-color: #E1001F'>" . $t_rank . "</td>";

                    } else {

                        echo "<td style='background-color: #FFE5C0'>" . $t_rank . "</td>";
                    }

                } else {
                    $t_rank = 0;
                    echo "<td style='background-color: #FFE5C0'>" . $t_rank . "</td>";
                }

                echo "<td>" . $data[$i]['yas'] . "</td>";


                //Title Sorgusu
                if (mb_strlen($data[$i]['title']) >= 10 && mb_strlen($data[$i]['title']) <= 70) {
                    echo "<td style='color: #38CC4A'>" . $data[$i]['title'] . "</td>";
                } elseif (mb_strlen($data[$i]['title']) < 10) {
                    echo "<td style='color: #FF6E14'>" . $data[$i]['title'] . "</td>";
                } else {
                    echo "<td style='color: #E1001F'>" . $data[$i]['title'] . "</td>";
                }

                //Meta Sorgusu
                if (mb_strlen($data[$i]['meta']) >= 70 && mb_strlen($data[$i]['meta']) <= 160) {
                    echo "<td style='color: #38CC4A'>" . $data[$i]['meta'] . "</td>";
                } elseif (mb_strlen($data[$i]['meta']) < 70) {
                    echo "<td style='color: #FF6E14'>" . $data[$i]['meta'] . "</td>";
                } else {
                    echo "<td style='color: #E1001F'>" . $data[$i]['meta'] . "</td>";
                }

                //pagerank sorgusu
                if ($i != 0) {
                    if ($data[$i - 1]['pagerank'] < $data[$i]['pagerank'])
                        echo "<td style='color: #38CC4A'>" . $data[$i]['pagerank'] . "</td></tr>";
                    elseif ($data[$i - 1]['pagerank'] > $data[$i]['pagerank'])
                        echo "<td style='color: #E1001F'>" . $data[$i]['pagerank'] . "</td></tr>";
                    else
                        echo "<td style='color: #FFE5C0'>" . $data[$i]['pagerank'] . "</td></tr>";
                }
                else {
                    echo "<td style='color: #FFE5C0'>" . $data[$i]['pagerank'] . "</td></tr>";
                }

            }

        }

        ?>
    </table>


    <?php
    }
        catch (PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }

    }
        elseif(isset($_SESSION['sorsite']) && isset($_POST['giris_tarih']) && isset($_POST['cikis_tarih'])){

            $g_tarih = $_POST['giris_tarih'];
            $c_tarih = $_POST['cikis_tarih'];
            $data=array();
            $ar=array();
            $adet=0;
            try{
                if($g_tarih<=$c_tarih){

                $date=$db->query("SELECT DISTINCT tarih,alexa_global,alexa_turkiye FROM Domain_ WHERE site='$adi' ",PDO::FETCH_ASSOC);
                if($date->rowCount())
                {
                    foreach ($date as $item)
                        {
                            $tarih=$item['tarih'];
                            $g_fark=$item['alexa_global'];
                            $t_fark=$item['alexa_turkiye'];
                            $veri=$db->query("SELECT * FROM Domain_ WHERE tarih='$tarih' AND alexa_global='$g_fark'AND alexa_turkiye='$t_fark' AND site='$adi'   AND tarih BETWEEN '$g_tarih' AND '$c_tarih'" , PDO::FETCH_ASSOC);
                            if($veri->rowCount()){
                                foreach ($veri as $row) {
                                    array_push($ar,$row);
                                    $adet++;
                                    break;
                                }
                            }


                        }

                    $i=0;
                    while ($i<count($ar)) {
                        if($ar[$i]['tarih'] == $ar[$i+1]['tarih']){
                            if($ar[$i]['alexa_global'] >= $ar[$i+1]['alexa_global']){
                                array_push($data,$ar[$i+1]);
                            }
                            else{
                                array_push($data,$ar[$i]);
                            }
                            $i=$i+2;
                        }
                        else{
                            array_push($data,$ar[$i]);
                            $i++;
                        }

                    }

                    ///buraya yazılacak
                    for($i=0;$i<count($data);$i++) {


                        echo "<tr><td>" . $data[$i]['tarih'] . "</td><td>" . $data[$i]['alexa_global'] . "</td>";

                        //Alexa Global karşılaştırılması
                        if ($i != 0) {
                            if ($data[$i - 1]['alexa_global'] > $data[$i]['alexa_global']) {
                                $rank = "-".($data[$i - 1]['alexa_global'] - $data[$i]['alexa_global']);
                                echo "<td style='background-color: #38CC4A'>" . $rank . "</td>";

                            } elseif ($data[$i - 1]['alexa_global'] < $data[$i]['alexa_global']) {
                                $rank = "+".($data[$i]['alexa_global'] - $data[$i - 1]['alexa_global']);
                                echo "<td style='background-color: #E1001F'>" . $rank . "</td>";

                            } else {

                                echo "<td style='background-color: #FFE5C0'>" . $rank. "</td>";
                            }

                        } else {
                            $rank = 0;
                            echo "<td style='background-color: #FFE5C0'>" .  $rank . "</td>";
                        }

                        echo "<td>" . $data[$i]['alexa_turkiye'] . "</td>";

                        //Alexa Türkiye karşılaştırılması
                        if ($i != 0) {
                            if ($data[$i - 1]['alexa_turkiye'] > $data[$i]['alexa_turkiye']) {
                                $t_rank = "-".($data[$i - 1]['alexa_turkiye'] - $data[$i]['alexa_turkiye']);
                                echo "<td style='background-color: #38CC4A'>" . $t_rank . "</td>";

                            } elseif ($data[$i - 1]['alexa_turkiye'] < $data[$i]['alexa_turkiye']) {
                                $t_rank = "+".($data[$i]['alexa_turkiye'] - $data[$i - 1]['alexa_turkiye']);
                                echo "<td style='background-color: #E1001F'>" . $t_rank . "</td>";

                            } else {

                                echo "<td style='background-color: #FFE5C0'>" . $t_rank . "</td>";
                            }

                        } else {
                            $t_rank = 0;
                            echo "<td style='background-color: #FFE5C0'>" . $t_rank . "</td>";
                        }

                        echo "<td>" . $data[$i]['yas'] . "</td>";


                        //Title Sorgusu
                        if (mb_strlen($data[$i]['title']) >= 10 && mb_strlen($data[$i]['title']) <= 70) {
                            echo "<td style='color: #38CC4A'>" . $data[$i]['title'] . "</td>";
                        } elseif (mb_strlen($data[$i]['title']) < 10) {
                            echo "<td style='color: #FF6E14'>" . $data[$i]['title'] . "</td>";
                        } else {
                            echo "<td style='color: #E1001F'>" . $data[$i]['title'] . "</td>";
                        }

                        //Meta Sorgusu
                        if (mb_strlen($data[$i]['meta']) >= 70 && mb_strlen($data[$i]['meta']) <= 160) {
                            echo "<td style='color: #38CC4A'>" . $data[$i]['meta'] . "</td>";
                        } elseif (mb_strlen($data[$i]['meta']) < 70) {
                            echo "<td style='color: #FF6E14'>" . $data[$i]['meta'] . "</td>";
                        } else {
                            echo "<td style='color: #E1001F'>" . $data[$i]['meta'] . "</td>";
                        }

                        //pagerank sorgusu
                        if ($i != 0) {
                            if ($data[$i - 1]['pagerank'] < $data[$i]['pagerank'])
                                echo "<td style='color: #38CC4A'>" . $data[$i]['pagerank'] . "</td></tr>";
                            elseif ($data[$i - 1]['pagerank'] > $data[$i]['pagerank'])
                                echo "<td style='color: #E1001F'>" . $data[$i]['pagerank'] . "</td></tr>";
                            else
                                echo "<td style='color: #FFE5C0'>" . $data[$i]['pagerank'] . "</td></tr>";
                        }
                        else {
                            echo "<td style='color: #FFE5C0'>" . $data[$i]['pagerank'] . "</td></tr>";
                        }

                    }

                }

                ?>
                </table>


                <?php
               }

                else{
                    echo "<b class='msg'>Yanlış tarih aralığı girdiniz.Kontrol ediniz...</b>";
                }
            }
            catch (PDOException $e) {
                echo $sql . "<br>" . $e->getMessage();
            }

          }

?>

</body>
<style>
    .msg{
        position:absolute;
        right:3%;
        width:24%;
        top:17%;
        color: #E1001F;
    }
    .button {
        background-color: #649DBB;
        border: none;
        color: white;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        margin: 4px 2px;
        cursor: pointer;
        border-radius: 16px;
        font-size: 20px;
    }

    .button:hover {
        background-color: #84C2D9;
    }
    .date{
        position: absolute;
        right: 7%;
        top: 6%;
        width: 620px;
        border-radius: 20px;
        padding: 10px;
        text-align: center;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 17px;
    }
    p{
        position:absolute;
        top: 12%;
        left: 20%;
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
    }
    #customers {
        position:absolute;
        top: 20%;
        right: 5%;
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width:75%;

    }

    #customers td, #customers th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #customers tr{background-color: #5F849E;}

    #customers tr:hover {background-color: #ddd;}

    #customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #5F849E;
        color: white;
    }
</style>

