var ASCII_ENTER = 13;
var ASCII_SPACE = 32;
var ASCII_BACKSPACE = 8;

$(document).ready(function(){
	var totalrow = $("#totalrow").val();
	loop_update_karyawan();
	
	for (i=1; i <= totalrow; i++)
	{
		addListener_karyawan(i);
	}
	addListener_bayar();
});

function loop_update_karyawan()
{
	//karyawan_update_barang(10 * 1000); // detik
	karyawan_update_focus(3 * 1000); // detik
}

function karyawan_update_focus(timeout)
{
	var krow = $("#totalrow").val();
	
	var isAdaFocus = false;
	for (var i=1; i<=krow; i++)
	{
		if ($("#id_menu"+i).is(":focus"))
		{
			isAdaFocus = true;
		}
	}
	if ($("#jml_bayar").is(":focus"))
	{
		isAdaFocus = true;
	}
	if (!isAdaFocus)
	{
		$("#id_menu1").focus();
	}
	
	if (timeout > 0)
	{
		setTimeout(function(){
			karyawan_update_focus(timeout);
		}, timeout);
	}
}

function get_detail_barang(krow)
{
	if ($("#id_menu"+krow).val() != "")
	{
		get_nama_barang($("#id_menu"+krow).val(), krow);
		get_harga_barang($("#id_menu"+krow).val(), krow);

		timeout_barang_karyawan = setTimeout(function(){
			updateHargaTotal(0);
			}, 1000);
	}
}

function addListener_karyawan(krow)
{
	$("#id_menu"+krow).keyup(function(event){
		if (event.keyCode == ASCII_ENTER)
		{
			var totalrow = $("#totalrow").val();
			if (krow == totalrow)
				$("#jml_bayar").focus();
			
			$("#id_menu"+(parseInt(krow)+1)).focus();
			
			get_detail_barang(krow);
		}
		//else
		if (event.keyCode == ASCII_SPACE)
		{
			$(this).val($(this).val().slice(0,-1));
			get_detail_barang(krow);
			
			$("#jml_bayar").focus();
		
			timeout_barang_karyawan = setTimeout(function(){
				updateHargaTotal(0);
				}, 1000);
		}
		else if(event.keyCode == ASCII_BACKSPACE) //hapus
		{
			var erased_row = krow - 1;
			if (erased_row == 0)
				erased_row = 1;
				
			$("#id_menu"+erased_row).val('');
			setTimeout(function(){
				$("#nama"+erased_row).val('');
				$("#harga"+erased_row).val('');
				$("#id_menu"+erased_row).focus();
			}, 200);
		
			timeout_barang_karyawan = setTimeout(function(){
				updateHargaTotal(0);
				}, 1000);
		}
	});
}

function addListener_bayar()
{
	$("#jml_bayar").keyup(function(event){
		var kembalian = parseInt($("#jml_bayar").val()) - parseInt($("#total_harga").val())
		$("#kembalian").val(kembalian);
		
		if(event.keyCode == ASCII_SPACE)
		{
			$(this).val($(this).val().slice(0,-1));
			if (kembalian >= 0)
			{
				post_order();
			}
		}
	});
}

function updateHargaTotal(timeout)
{
	var totalrow = $("#totalrow").val();
	
	var hargatotal = 0;
	for (i=1; i <=totalrow; i++)
	{
		var harga = parseInt($("#harga"+i).val());
		
		if (!isNaN(harga))
		{
			hargatotal += harga;
		}
	}
	$("#total_harga").val(hargatotal);
	
	if (timeout > 0)
	{
		setTimeout(function(){
			updateHargaTotal(timeout);
		}, timeout);
	}
}

function get_nama_barang(id_menu, row)
{
    $.ajax({
		type: 'GET',
		url: "ajax/get_nama_barang.php?id_menu="+id_menu,
		data: "",
		success: function(result){
			$("#nama"+row).val(result);
		}
	});
}

function get_harga_barang(id_menu, row)
{
    $.ajax({
		type: 'GET',
		url: "ajax/get_harga_barang.php?id_menu="+id_menu,
		data: "",
		success: function(result){
			$("#harga"+row).val(result);
		}
	});
}

function post_order()
{
	var id_menus = new Array();
	for(i = 1; i<=15; i++)
	{
		id_menus[i] = 0;
		if ($("#nama"+i).val() != "")
		{
			id_menus[i] = parseInt($("#id_menu"+i).val());
		}
	}
	
    $.ajax({
		type: 'GET',
		url: "ajax/post_order.php?id_menu1="+id_menus[1]+"&id_menu2="+id_menus[2]+"&id_menu3="+id_menus[3]+"&id_menu4="+id_menus[4]+"&id_menu5="+id_menus[5]+"&id_menu6="+id_menus[6]+"&id_menu7="+id_menus[7]+"&id_menu8="+id_menus[8]+"&id_menu9="+id_menus[9]+"&id_menu10="+id_menus[10]+"&id_menu11="+id_menus[11]+"&id_menu12="+id_menus[12]+"&id_menu13="+id_menus[13]+"&id_menu14="+id_menus[14]+"&id_menu15="+id_menus[15],
		data: "",
		success: function(result){
			if (result == "true")
			{
				location.reload();
			}
			else
			{
				$("#status").addClass("failure");
				$("#status").html("Gagal memasukkan data, silakan coba lagi nanti");
			}
		}
	});
}