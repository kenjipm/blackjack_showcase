<?php
include "koneksi_server.php";

$query = "SELECT session_no FROM variabel";
$res = mysql_query($query);
if (!mysql_num_rows($res))
{
	return false;
}
$row = mysql_fetch_array($res);
$session_no = $row['session_no'];

$barang_titip_terjual = array();
$list_id_barang_titip_terjual = array();
$id_ke_no_urut = array();

//ambil ordernya dulu
$query = "SELECT id FROM t_order WHERE session_no = ".$session_no."";
$res = mysql_query($query);
if (!mysql_num_rows($res))
{
	return false;
}
while ($row = mysql_fetch_array($res))
{
	//baru ambil per menunya
	$query2 = "SELECT id_menu FROM t_order_menu WHERE id_order = ".$row['id']."";
	$res2 = mysql_query($query2);
	if (!mysql_num_rows($res2))
	{
		return false;
	}
	
	while ($row2 = mysql_fetch_array($res2))
	{
		//ambil detail per menu buat dicek titip jaul atau bukan
		$query3 = "SELECT id, nama FROM t_menu WHERE id = ".$row2['id_menu']."";
		$res3 = mysql_query($query3);
		if (!mysql_num_rows($res3))
		{
			return false;
		}
		$row3 = mysql_fetch_array($res3);
		if (strlen($row3['nama']) >= 3)
		{
			if (substr($row3['nama'], 0, 3) == "[T]")
			{
				if (!in_array($row3['id'], $list_id_barang_titip_terjual))
				{
					$no_urut = count($list_id_barang_titip_terjual) + 1;
					
					$barang_titip_terjual[$no_urut]['nama'] = $row3['nama'];
					$barang_titip_terjual[$no_urut]['jumlah'] = 1;

					$list_id_barang_titip_terjual[] = $row3['id'];
					$id_ke_no_urut[$row3['id']] = $no_urut;
				}
				else
				{
					$barang_titip_terjual[$id_ke_no_urut[$row3['id']]]['jumlah']++;
				}
			}
		}
	}
}
?>

<?php
	$totalrow = 20;
	$totalcol = 2;
	
	for ($i=1; $i<=$totalrow; $i++)
	{
		?>
		<tr>
		<?php
			for ($j=1; $j<=$totalcol; $j++)
			{
				$urutan = (($j-1)*$totalrow)+$i;
				?>
				<td class="nama" id="nama<?=$urutan?>">
					<?php
						if (isset($barang_titip_terjual[$urutan]['nama']))
						{
							echo $barang_titip_terjual[$urutan]['nama'];
						}
					?>
				</td>
				<td class="jumlah" id="jumlah<?=$urutan?>">
					<?php
						if (isset($barang_titip_terjual[$urutan]['jumlah']))
						{
							echo $barang_titip_terjual[$urutan]['jumlah'];
						}
					?>
				</td>
				<?php
			}
		?>
		</tr>
		<?php
	}
?>