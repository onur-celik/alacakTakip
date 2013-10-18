<?php 
	include "header.php"; 
	sessionCtrl();
?>

<div class="row">
	<div class="col-sm-6 col-lg-6 col-sm-offset-3 col-lg-offset-3 well">
		<strong>Toplam Müşteri :</strong> <span id="total_musteri"></span><br />
		<strong>Açık Hesaplar :</strong> <span id="acik_hesaplar"></span><br />
		<strong>Kapanmış Hesaplar :</strong> <span id="kapali_hesaplar"></span><br />
		
	</div>
</div>

<?php include "footer.php"; ?>