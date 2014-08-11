<?php
	$host = "192.168.1.8";
	$database = "blackjack_db";
	$usrnm = "Kenji";
	$pswrd = "kenji123";

    //konek ke sql
    $koneksi = mysql_connect($host, $usrnm, $pswrd);
    if ($koneksi) //jika koneksi berhasil
    {
        //echo "koneksi berhasil";
        $thequery = mysql_select_db($database, $koneksi); //coba konek ke db
    }
    else
    {
        echo "Koneksi ke server gagal";
    }
?>