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
		//sets encoding to utf8
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
		
	}
	


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