<?php
session_start();
include ("conn.php");


    if (isset($_POST['site']) && !empty($_POST['site']) && strstr($_POST['site'], ".com"))
{

    $_SESSION['site'] = $_POST['site'];
    $ad=$_SESSION['site'];

    //curl işlemini gerçekleştiren fonksiyon
    function curlWebsite($url)
    {
        $ch = curl_init(); //Curl işlemi başlatır.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Curl sonucu veri gelmesini sağlar.
        curl_setopt($ch, CURLOPT_URL, $url); // Curl ile çekilecek url belirlenir.
        $result = curl_exec($ch); // Curl gerçekleştirilir.
        return $result; // Sonuç döndürülür.
    }
    //yaş değerini hesaplayacak fonksiyon
    function getAge($mysql_date) {

        if($mysql_date==0)
        {
            return 0;
        }
        else{
            list($y,$m,$d) = explode("-",$mysql_date);
            $age = date('Y')-$y;
            date('md')<$m.$d ? $age--:null; //Tarihle beraber ay-gün kontrolü de yapılıyor.
            return $age;
        }
    }
    //Preg match all işlemini gerçekleştiren fonksiyon
    function ara($bas, $son, $yazi)
    {
        @preg_match_all('/' . preg_quote($bas, '/') .
            '(.*?)'. preg_quote($son, '/').'/i', $yazi, $m);
        return @$m[1];
    }

    //Alexa ifadeleri çekme işlemini gerçekleştiriyor.
    $url = 'http://data.alexa.com/data?cli=10&url='.$ad;

    $adi = $ad."/";

    $alexa = curlWebsite("$url");

    $xml = simplexml_load_string($alexa); // Gelen string datayı XML olarak parse eder. Bu sayede içerisindeki değişkenlere ulaşabilirsin.


    //Domain yaşını bulmak için kullanılıyor.
    $tarih = date("Y-m-d");

    $url_yas = "https://who.is/whois/" . $ad;

    $icerik = file_get_contents($url_yas);

    $tr=explode('.',$_SESSION['site']);

    if(count($tr)==2){
        preg_match_all('/<div class=\\"col-md-8 queryResponseBodyValue">.*?<\\/div>/is', $icerik, $k);
        $yas = $k[0][5];
        $bol = explode('<div class="col-md-8 queryResponseBodyValue">', $yas);
        $age = getAge($bol[1]);
        $_SESSION['date']=$bol[1];
    }
    elseif(count($tr)==3)
    {
        $aylar=array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
        preg_match_all('/<div class=\\"col-md-12 queryResponseBodyValue">.*?<\\/div>/is', $icerik, $k);
        $yas=explode('Created on..............:',$k[0][1]);
        $bol=explode('.',$yas[1]);
        $ay=explode('-',$bol[0]);
        for ($i=0;$i<12;$i++){
            if($aylar[$i]==$ay[1])
            {
                $eski   = $ay[1];
                $yeni   = $i+1;
                $bol[0] = str_replace($eski, $yeni,$bol[0]);
                $age=getAge($bol[0]);
                $_SESSION['date']=$bol[0];
            }

        }
    }

    $url_seo = 'http://www.'.$ad;

    //title
    $seo = file_get_contents($url_seo);

    $seo_title=explode('<title>',$seo);

    if($seo_title[1]==null)
    {
        $seo_title=explode('<title id="pageTitle">',$seo);

        $title=explode('</title>',$seo_title[1]);
        $_SESSION['title']=$title[0];

    }
    else{

        $title=explode('</title>',$seo_title[1]);
        $_SESSION['title']=$title[0];
    }

    //meta
    $seo_meta=get_meta_tags($url_seo);


    $meta_2 =	mb_convert_encoding($seo_meta["description"], "UTF-8", "auto");
    $meta=$meta_2;

    if($meta_2==null){
        $meta=mb_convert_encoding($seo_meta["description"], "UTF-8", "ISO-8859-9");
    }

    $_SESSION['meta'] = $meta;


    //Pagerank ın bulunmasında kullanılıyor.

    $ornek=curl_init();
    curl_setopt($ornek,CURLOPT_URL,"http://www.pageranktool.net/");
    curl_setopt($ornek,CURLOPT_POST,1);
    curl_setopt ($ornek, CURLOPT_POSTFIELDS, "domainData=$ad");
    curl_setopt($ornek, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ornek, CURLOPT_VERBOSE, 1);
    curl_setopt($ornek, CURLOPT_NOBODY, 0);
    curl_setopt($ornek,CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ornek, CURLOPT_TIMEOUT, 3000);
    curl_setopt($ornek,CURLOPT_SSL_VERIFYPEER,true);
    $gelen_veri = curl_exec($ornek);
    $page_rank = ara('td>','</td>',$gelen_veri);
    $pr=explode('/',$page_rank[2]);
    $_SESSION['page'] = $page = $pr[0];

    //Veritabanına kayıt ekleme

    try {

        if (empty($xml->SD->COUNTRY["RANK"])) {//Global
            $turkiye = 0;
        } else {
            $turkiye = $xml->SD->COUNTRY["RANK"] . PHP_EOL;
        }
        if (empty($xml->SD->RANK["DELTA"])) {//Fark
            $fark = 0;
        } else {
            $fark = $xml->SD->RANK["DELTA"] . PHP_EOL;
        }
        if (empty($xml->SD->REACH["RANK"])) {//Türkiye
            $global = 0;
        } else {
            $global = $xml->SD->REACH["RANK"] . PHP_EOL;
        }
        if($xml["URL"]=="404" || $xml["URL"]!=($ad."/"))//Boş ve hatalı dönüşlerin engellenmesi için
        {
            header("location:index.php");
        }

        else{
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = $db->prepare("INSERT INTO Domain_ SET
                          site=?,
                          alexa_global=?,
                          alexa_fark=?,
                          alexa_turkiye=?,
                          yas=?,
                          tarih=?,
                          title=?,
                          meta=?,
                          pagerank=?");
            $insert = $query->execute(array(
                $adi, $global,  $fark, $turkiye, $age, $tarih, $title[0], $meta, $page ));
            if($insert){
                $sonid = $db->lastInsertId();
                $_SESSION['sonid']=$sonid;
                //var_dump($insert);
            }

        }

    }
    catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
    header("location:sorgulama.php");

}
else{
    echo "<b class='msg'>Lütfen domain adresi giriniz...</b>";
    header("location:home.php");
}
?>
<style>
    .msg{
        position:absolute;
        right:16%;
        width:24px;
        top:5%
        color: #E1001F;
    }
</style>
