<?php
include "koneksi_server.php";

$id_menu = $_GET['id_menu'];
$query = "SELECT nama FROM t_menu WHERE id = ".$id_menu."";
$res = mysql_query($query);
if (!mysql_num_rows($res))
{
	return false;
}
$row = mysql_fetch_array($res);
echo $row['nama'];
?>