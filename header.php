<?php
	include "php_functions.php";
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>Müşteri Takip Sistemi</title>
		<link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
		 
		<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
		<link rel="stylesheet" href="css/jquery.fancybox.css" type="text/css" />
		<link rel="stylesheet" href="css/datepicker.css" type="text/css" />
		<link rel="stylesheet" href="css/jquery.pnotify.default.css" type="text/css" />
		<link rel="stylesheet" href="css/jquery.pnotify.default.icons.css" type="text/css" />
		<link rel="stylesheet/less" href="css/main.less" type="text/css" />
		
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
		<script type="text/javascript" src="js/bootstrap-datepicker.tr.js"></script>
		<script type="text/javascript" src="js/lesscss.min.js"></script>
		<script type="text/javascript" src="js/jquery.fancybox.js"></script>
		<script type="text/javascript" src="js/jquery.pnotify.js"></script>
		<script type="text/javascript" src="js/main.js"></script>
		
		
	</head>
	 
	<body>
	
	<div class="container">
	
		<div class="row" id="header">
			<?php
				if (isset($_SESSION['yetkili']))
				{
					echo '<div class="col-sm-6 col-lg-6">';
				}
				else
				{
					echo '<div class="col-sm-6 col-lg-6 col-sm-offset-3 col-lg-offset-3">';
				}
			?>
				<a href="index.php"><h1 class="proxima-regular"><span id="sahip"></span> Müşteri Takip Sistemi</h1></a>
			</div>
			<?php
				if (isset($_SESSION['yetkili']))
				{
					echo '
					
						<div class="col-sm-6 col-lg-6">
						<br />
						<div class="input-group">
							<input type="search" class="form-control" id="arama" placeholder="İsim, Soyisim veya Telefon Yazınız">
							<span class="input-group-btn">
								<button class="btn btn-primary" type="button" onclick="arama();">
									<i class="glyphicon glyphicon-search"></i> Ara
								</button>
							</span>
						</div>
					</div>
					<div id="arama_sonuc" style="width:400px;">
						<h4>Arama Sonuçları</h4><span id="sonuc_container"></span>
					</div>
					<div id="musteri_ekleme_formu" style="width:400px;">
						İsim Soyisim : 
						<input type="text" class="form-control" id="ekle_isimsoyisim"/>
						Adres :
						<textarea id="ekle_adres" class="form-control"></textarea>
						Telefon1 : 
						<input type="text" class="form-control" id="ekle_telefon1"/>
						Telefon2 : 
						<input type="text" class="form-control" id="ekle_telefon2"/>
						Telefon3 : 
						<input type="text" class="form-control" id="ekle_telefon3"/>
						<br />
						<button class="btn btn-xs btn-success" onclick="musteri.ekle();">
							<i class="glyphicon glyphicon-plus"></i> Ekle
						</button>
					</div>
					<div id="ayarlar" style="width:400px;">
						Şirket İsmi : 
						<input type="text" class="form-control" id="sirket_ismi"/>
						<br />
						E-posta : 
						<input type="text" class="form-control" id="email"/>
						<br />
						<table width="100%">
							<tr>
								<td>
									Yeni Şifre : 
									<input type="password" class="form-control" id="yeni_sifre"/>
								</td>
								<td>&nbsp;</td>
								<td>
									Yeni Şifre Tekrar: 
									<input type="password" class="form-control" id="yeni_sifre_tekrar"/>
								</td>
							</tr>
						</table>
						
						
						<br />
						<button class="btn btn-xs btn-success" onclick="ayarlar.guncelle();">
							<i class="glyphicon glyphicon-plus"></i> Güncelle
						</button>
					</div>
					';
				}
			?>
			
		</div>
		
		
		<hr />
	<?php
		if (isset($_SESSION['yetkili']))
		{
			echo '
			
				<div class="row">
					<div class="col-sm-6 col-lg-6">
						<i class="glyphicon glyphicon-calendar"></i> 
						<strong>Bugün : </strong>'; 
							$tar = date("Y.m.d H:i:s");
							echo timeTR($tar); 
			echo'
					</div>
					<div class="col-sm-6 col-lg-6 text-right">
						<button class="btn btn-primary btn-sm" onclick="location.href=\'musteri_listesi.php\';">
							<i class="glyphicon glyphicon-list"></i> Müşteri Listesi
						</button>
						<button class="btn btn-success btn-sm" onclick="musteri.ekleme_formu();">
							<i class="glyphicon glyphicon-plus"></i> Müşteri Ekle
						</button>
						<button class="btn btn-warning btn-sm" onclick="yedekAl();">
							<i class="glyphicon glyphicon-hdd"></i> Yedek Al
						</button>
						<button class="btn btn-info btn-sm" onclick="ayarlar.form();">
							<i class="glyphicon glyphicon-wrench"></i> Ayarlar
						</button>
						<button class="btn btn-danger btn-sm" onclick="logout();">
							<i class="glyphicon glyphicon-log-out"></i> Çıkış Yap
						</button>
					</div>
				</div>
				
				<hr />
				
			';
		}
	?>
		
	<script>
		$(function(){
			$('#arama_sonuc, #musteri_ekleme_formu, #ayarlar').hide();
		});
	</script>