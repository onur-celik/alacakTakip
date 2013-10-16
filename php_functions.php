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
		$db_name    = "halacoglu";
		
		$link = mysql_connect($host, $user, $pass);
		mysql_select_db($db_name) or die('dbye baglanamadi');
		mysql_query("SET NAMES utf8");
	}
	
	switch($duty)
	{
		case "login":
			if ($_POST['password'] == 'onur')
			{
				$_SESSION['yetkili'] = 'nesrin';
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
						telefon => $musteri->telefon,
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
				
				$msquery = mysql_query("SELECT * FROM musteriler WHERE telefon LIKE '%$query%'");

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
			telefon => $musteri->telefon,
			hesap_durumu => $musteri->hesap_durumu
		);
	
	echo json_encode($kisi);
}
	
	
?>