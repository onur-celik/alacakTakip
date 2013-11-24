<?php
	session_start();
	
	if ($_POST['duty'])
	{
		$duty = $_POST['duty'];	
	}
	
	function connect_db()
	{
		$hostname   = "localhost";
		$user       = "root";
		$pass       = "";
		$db_name    = "alacakTakip";
		
		$link = mysql_connect($host, $user, $pass);
		mysql_select_db($db_name) or die('dbye baglanamadi');
		mysql_query("SET NAMES utf8");
	}
	
	switch($duty)
	{
		case "getSahip":
			connect_db();
			if ($q = mysql_query("SELECT * FROM ayarlar WHERE id='1'"))
			{
				if($data = mysql_fetch_object($q))
				{
					echo $data->value;
				}
			}
			else
			{
				echo 'bilinmeyen';
			}
		break;
		
		case "login":
			connect_db();
			$q 		= mysql_query("SELECT * FROM ayarlar WHERE id='2'");
			$data	= mysql_fetch_object($q);
			$sifre 	= $data->value;
			
			if ($_POST['password'] == $sifre)
			{
				$_SESSION['yetkili'] = 'authed';
				if($_SESSION['yetkili'])
				{
					echo "success";
				}
			}
			else
			{
				echo "failed";
			}
		break;
		
		case "logout":
		
			session_destroy();
			
			$_SESSION['yetkili'] = NULL;
			
			if($_SESSION['yetkili'])
			{
				echo "failed";
			}
			else
			{
				echo "success";
			}
			
		break;
		
		case "arama":
		
			if ($_POST['tip'] == 'isim')
			{
				connect_db();
				$query = $_POST['query'];
				
				$msquery = mysql_query("SELECT * FROM musteriler WHERE isimsoyisim LIKE '%$query%'");
				
				$resp = array();
				
				while($musteri = mysql_fetch_object($msquery))
				{
					$kisi = array(
						id => $musteri->id,
						isimsoyisim => $musteri->isimsoyisim,
						adres => $musteri->adres,
						telefon1 => $musteri->telefon1,
						telefon2 => $musteri->telefon2,
						telefon3 => $musteri->telefon3,
						hesap_durumu => $musteri->hesap_durumu
					);
					
					array_push($resp, $kisi);
				}
				
				echo json_encode($resp);
			}
			else
			{
				connect_db();
				$query = $_POST['query'];
				
				$msquery = mysql_query("SELECT * FROM musteriler WHERE telefon1 LIKE '%$query%' OR telefon2 LIKE '%$query%' OR telefon3 LIKE '%$query%'");

				$resp = array();
				
				while($musteri = mysql_fetch_object($msquery))
				{
					$kisi = array(
						id => $musteri->id,
						isimsoyisim => $musteri->isimsoyisim,
						adres => $musteri->adres,
						telefon => $musteri->telefon,
						hesap_durumu => $musteri->hesap_durumu
					);
					
					array_push($resp, $kisi);
				}
				
				echo json_encode($resp);
			}
		
		break;
		
		case "musteri_sil":
			connect_db();
			$id = $_POST['id'];
			
			$musterinin_islemleri 	 = mysql_query("SELECT * FROM islemler WHERE musteri_id='$id'");
			$musterinin_islem_sayisi = mysql_num_rows($musterinin_islemleri);
			
			if ($musterinin_islem_sayisi > 0)
			{
				while($row = mysql_fetch_object($musterinin_islemleri))
				{
					if(mysql_query("DELETE FROM islemler WHERE id='$row->id'"))
					{
							
					}
					else
					{
						echo 0;
					}
				}
			}
			
			
			if (mysql_query("DELETE FROM musteriler WHERE id='$id'"))
			{
				echo 1;
			}
			else
			{
				echo 0;
			}
		break;
		
		case "hesapDurumuToggle":
			connect_db();
			$id = $_POST['id'];
			$getQuery = mysql_query("SELECT hesap_durumu FROM musteriler WHERE id='$id'");
			$kisi = mysql_fetch_object($getQuery);
			
			if ($kisi->hesap_durumu == 0)
			{
				if (mysql_query("UPDATE musteriler SET hesap_durumu='1' WHERE id='$id'"))
				{
					echo 1;
				}
				else
				{
					echo "hesap kapaliydi.. acilirken sorun olustu";
				}
			}
			else
			{
				if (mysql_query("UPDATE musteriler SET hesap_durumu='0' WHERE id='$id'"))
				{
					echo 0;
				}
				else
				{
					echo "hesap acikti.. kapanirken sorun olustu";
				}
			}
			
		break;
		
		case "musteri_ekle":
			connect_db();
			$isimsoyisim 	= $_POST['isimsoyisim'];
			$adres 			= $_POST['adres'];
			$telefon1 		= $_POST['telefon1'];
			$telefon2 		= $_POST['telefon2'];
			$telefon3 		= $_POST['telefon3'];
			
			if ($msquery = mysql_query("INSERT INTO musteriler VALUES('', '$isimsoyisim', '$adres', '$telefon1', '$telefon2', '$telefon3', '0')"))
			{
				echo 1;
			}
			else
			{
				echo 0;
			}
			
		break;
		
		case "get_last_id":
			connect_db();
			$q = mysql_query("SELECT * FROM musteriler ORDER BY id DESC LIMIT 1");
			$row = mysql_fetch_object($q);
			
			echo $row->id;
			
		break;
		
		case "musteri_bilgilerini_guncelle":
			connect_db();
			$id = $_POST['id'];
			
			$msquery = mysql_query("SELECT * FROM musteriler WHERE id='$id'");
			$kisi = mysql_fetch_object($msquery);
			
			$bilgiler = array(
				isimsoyisim => $kisi->isimsoyisim,
				adres => $kisi->adres,
				telefon1 => $kisi->telefon1,
				telefon2 => $kisi->telefon2,
				telefon3 => $kisi->telefon3
			);
			
			echo json_encode($bilgiler);
			
		break;
		
		case "musteri_bilgi_guncelle_kaydet":
			connect_db();
			$id 			= $_POST['id'];
			$isimsoyisim 	= $_POST['isimsoyisim'];
			$adres 			= $_POST['adres'];
			$telefon1 		= $_POST['telefon1'];
			$telefon2 		= $_POST['telefon2'];
			$telefon3		= $_POST['telefon3'];
			
			if($msquery = mysql_query("UPDATE musteriler SET isimsoyisim='$isimsoyisim', adres='$adres', telefon1='$telefon1', telefon2='$telefon2', telefon3='$telefon3' WHERE id='$id' "))
			{
				echo 1;
			}
			else
			{
				echo 0;
			}
			
		break;
		
		case "alacak_ekle":
			connect_db();
			
			$id 		= $_POST['id'];
			$tarih 		= $_POST['tarih'];
			$aciklama	= $_POST['aciklama'];
			$tutar		= $_POST['tutar'];
			$tip		= 0;
			
			if (mysql_query("INSERT INTO islemler VALUES ('', '$id', '$tarih', '$aciklama', '$tutar', '$tip')"))
			{
				echo 1;
			}
			else
			{
				echo 0;
			}
		break;
		
		case "odeme_ekle":
			connect_db();
			
			$id 		= $_POST['id'];
			$tarih 		= $_POST['tarih'];
			$aciklama	= $_POST['aciklama'];
			$tutar		= $_POST['tutar'];
			$tip		= 1;
			
			if (mysql_query("INSERT INTO islemler VALUES ('', '$id', '$tarih', '$aciklama', '$tutar', '$tip')"))
			{
				echo 1;
			}
			else
			{
				echo 0;
			}
		break;
		
		case "islem_kaydi_sil":
			connect_db();
			$id = $_POST['id'];
			if (mysql_query("DELETE FROM islemler WHERE id='$id'"))
			{
				echo 1;
			}
			else
			{
				echo 0;
			}
		break;
		
		case "islem_kaydi_duzenle":
			connect_db();
			$id = $_POST['id'];
			
			$msquery = mysql_query("SELECT * FROM islemler WHERE id='$id'");
			
			$islem = mysql_fetch_object($msquery);
			
			$islemArr = array(
				tarih => $islem->tarih,
				aciklama => $islem->aciklama,
				tutar => $islem->tutar,
				tip => $islem->tip
			);
			
			echo json_encode($islemArr);
			
		break;
		
		case "islem_kaydi_guncelle":
			connect_db();
			
			$id 		= $_POST['id'];
			$tarih		= $_POST['tarih'];
			$aciklama	= $_POST['aciklama'];
			$tutar		= $_POST['tutar'];
			$tip		= $_POST['tip'];

			if (mysql_query("UPDATE islemler SET tarih='$tarih', aciklama='$aciklama', tutar='$tutar', tip='$tip' WHERE id='$id' "))
			{
				echo 1;
			}
			else
			{
				echo 0;
			}
			
		break;
		
		case "getTotalMusteri":
			connect_db();
			$msquery = mysql_query("SELECT * FROM musteriler");
			$total = mysql_num_rows($msquery);
			echo $total;
		break;
		
		case "getAcikHesaplar":
			connect_db();
			$msquery = mysql_query("SELECT * FROM musteriler WHERE hesap_durumu='1'");
			$total = mysql_num_rows($msquery);
			echo $total;
		break;
		
		case "getKapaliHesaplar":
			connect_db();
			$msquery = mysql_query("SELECT * FROM musteriler WHERE hesap_durumu='0'");
			$total = mysql_num_rows($msquery);
			echo $total;
		break;
		
		case "getToplamYapilanIs":
			connect_db();
			
			$msquery = mysql_query("SELECT * FROM islemler WHERE tip='0'");
			
			$total = 0;
			
			while($row=mysql_fetch_object($msquery))
			{
				$total = $total + $row->tutar;
			}
			
			echo $total;
		break;
		
		case "getToplamAlacak":
			connect_db();
			$alacakquery = mysql_query("SELECT * FROM islemler WHERE tip='0'");
			$odemequery = mysql_query("SELECT * FROM islemler WHERE tip='1'");
			
			$alacakToplam 	= 0;
			$odemeToplam 	= 0; 
			
			while($row = mysql_fetch_object($alacakquery))
			{
				$alacakToplam = $alacakToplam + $row->tutar;
			}
			
			while($row = mysql_fetch_object($odemequery))
			{
				$odemeToplam = $odemeToplam + $row->tutar;
			}
			
			//echo "a : " . $alacakToplam . " o : " . $odemeToplam;
			echo $alacakToplam - $odemeToplam;
		break;
		
	} // SWITCH / CASE end
	


	function sessionCtrl()
	{
		if (isset($_SESSION['yetkili']))
		{
			// giris yapildi
		}
		else
		{
			echo "
			<script>
				location.href = 'login.php';
			</script>
			";
		}
	}
	

function get_musteri_bilgileri($id)
{
	connect_db();
	
	$msquery = mysql_query("SELECT * FROM musteriler WHERE id='$id'");
	
	$musteri = mysql_fetch_object($msquery);
	
		$kisi = array(
			id => $musteri->id,
			isimsoyisim => $musteri->isimsoyisim,
			adres => $musteri->adres,
			telefon1 => $musteri->telefon1,
			telefon2 => $musteri->telefon2,
			telefon3 => $musteri->telefon3,
			hesap_durumu => $musteri->hesap_durumu
		);
	
	echo json_encode($kisi);
}

function get_alacakVerecek_bilgileri($id)
{
	connect_db();
	
	$msquery = mysql_query("SELECT * FROM islemler WHERE musteri_id='$id' ORDER BY tarih ASC");
	
	$butunAkis = array();
	
	while($paraAkisi = mysql_fetch_object($msquery))
	{
		$akis = array(
			id => $paraAkisi->id,
			tarih => $paraAkisi->tarih,
			aciklama => $paraAkisi->aciklama,
			tutar => $paraAkisi->tutar,
			tip => $paraAkisi->tip
		);
		
		array_push($butunAkis, $akis);
	}
	
	echo json_encode($butunAkis);
		
}	

function timeTR($par)
{
	
	$explode = explode(" ", $par);
	$explode2 = explode(".", $explode[0]);
	$zaman = substr($explode[1], 0, 5);
	
	if ($explode2[1] == "1") 
	{
		$ay = "Ocak";
	}
	elseif ($explode2[1] == "2") 
	{
		$ay = "Şubat";
	}
	elseif ($explode2[1] == "3") 
	{
		$ay = "Mart";
	}
	elseif ($explode2[1] == "4")
	{
		$ay = "Nisan";
	}
	elseif ($explode2[1] == "5")
	{
		$ay = "Mayıs";
	}
	elseif ($explode2[1] == "6")
	{
		$ay = "Haziran";
	}
	elseif ($explode2[1] == "7")
	{
		$ay = "Temmuz";
	}
	elseif ($explode2[1] == "8")
	{
		$ay = "Ağustos";
	}
	elseif ($explode2[1] == "9")
	{
		$ay = "Eylül";
	}
	elseif ($explode2[1] == "10")
	{
		$ay = "Ekim";
	}
	elseif ($explode2[1] == "11")
	{
		$ay = "Kasım";
	}
	elseif ($explode2[1] == "12")
	{
		$ay = "Aralık";
	}

	//return $explode2[2]." ".$ay." ".$explode2[0].", ".$zaman;
	return $explode2[2]." ".$ay." ".$explode2[0];
	
}

	
?>