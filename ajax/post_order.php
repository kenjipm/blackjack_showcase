<?php
include "koneksi_server.php";

$id_menus[1] = $_GET['id_menu1'];
$id_menus[2] = $_GET['id_menu2'];
$id_menus[3] = $_GET['id_menu3'];
$id_menus[4] = $_GET['id_menu4'];
$id_menus[5] = $_GET['id_menu5'];

$id_menus[6] = $_GET['id_menu6'];
$id_menus[7] = $_GET['id_menu7'];
$id_menus[8] = $_GET['id_menu8'];
$id_menus[9] = $_GET['id_menu9'];
$id_menus[10] = $_GET['id_menu10'];

$id_menus[11] = $_GET['id_menu11'];
$id_menus[12] = $_GET['id_menu12'];
$id_menus[13] = $_GET['id_menu13'];
$id_menus[14] = $_GET['id_menu14'];
$id_menus[15] = $_GET['id_menu15'];

// ambil no_pembeli & session_no
$query = "SELECT jumlah_pembeli, session_no FROM variabel";
$res = mysql_query($query);
if (!mysql_num_rows($res))
{
	return false;
}
$row = mysql_fetch_array($res);
$jumlah_pembeli = $row['jumlah_pembeli'];
$session_no = $row['session_no'];

//masukin ke tabel order
$query = "INSERT INTO t_order (no_pembeli, nama_pembeli, keterangan, paid, session_no) 
VALUES (".($jumlah_pembeli+1).", \"Kalimas\", \"\", 1, ".$session_no.")";
$res = mysql_query($query);
$id_insert = mysql_insert_id();

//masukin ke tabel order_menu
$start = true;
$jml_menu = count($id_menus);
$query = "INSERT INTO t_order_menu (id_order, id_menu, menu_sequence, keterangan, harga_awal, discount, harga, harga_min, harga_base, harga_setor, nama_setor, done, waktu_done) 
VALUES ";
for($i=1; $i<=$jml_menu; $i++)
{
	//echo "id menu : ".$id_menus[$i];
	if (($id_menus[$i] != 0) && ($id_menus[$i] != "NaN"))
	{
		//echo "\r\nmasuk id menu not 0 : ".$id_menus[$i];
		//ambil detail barangnya dulu
		$query2 = "SELECT harga, harga_min, harga_base, harga_setor, nama_setor FROM t_menu WHERE id = ".$id_menus[$i]."";
		$res2 = mysql_query($query2);
		if (!mysql_num_rows($res2))
		{
			return false;
		}
		$menu = mysql_fetch_array($res2);
		
		//baru masukin ke tabel order_menu
		if (!$start) //kalo pake if $i > 1 takutnya row menu ke-1 kosong
		{
			$query .= ", ";
		}
		else
		{
			$start = false;
		}
		$query .= "(".$id_insert.", ".$id_menus[$i].", ".$i.", \"\", ".$menu['harga'].", 0, ".$menu['harga'].", ".$menu['harga_min'].", ".$menu['harga_base'].", ".$menu['harga_setor'].", \"".$menu['nama_setor']."\", 1, CURRENT_TIMESTAMP)";
	}
}

$res = mysql_query($query);
if ($res)
{
	echo "true";
}
else
{
	echo "false";
}
?>