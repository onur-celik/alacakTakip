<?php 
	include "header.php"; 
	sessionCtrl();
?>

<!--
<div class="row">
	<div class="col-sm-6 col-lg-6 col-sm-offset-3 col-lg-offset-3 well">
		<strong>Toplam Müşteri :</strong> <span id="total_musteri"></span><br />
		<strong>Açık Hesaplar :</strong> <span id="acik_hesaplar"></span><br />
		<strong>Kapanmış Hesaplar :</strong> <span id="kapali_hesaplar"></span><br />
		<strong>Toplam Yapılan İş :</strong> <span id="toplam_yapilan_is"></span><br />
		<strong>Toplam Alacak :</strong> <span id="toplam_alacak"></span><br />
	</div>
</div>
-->
<div class="row">
	<div class="col-sm-4 col-lg-4">
		<div class="well">
			<strong>Toplam Müşteri :</strong>
			<br />
			<span id="total_musteri"></span><br />
		</div>
	</div>
	<div class="col-sm-4 col-lg-4">
		<div class="well">
			<strong>Açık Hesaplar :</strong>
			<br />
			<span id="acik_hesaplar"></span><br />
		</div>
	</div>
	<div class="col-sm-4 col-lg-4">
		<div class="well">
			<strong>Kapanmış Hesaplar :</strong>
			<br />
			<span id="kapali_hesaplar"></span><br />
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-6 col-lg-6">
		<div class="well">
			<strong>Toplam Yapılan İş :</strong>
			<br />
			<span id="toplam_yapilan_is"></span><br />
		</div>
	</div>
	<div class="col-sm-6 col-lg-6">
		<div class="well">
			<strong>Toplam Alacak :</strong>
			<br />
			<span id="toplam_alacak"></span><br />
		</div>
	</div>
</div>

<?php include "footer.php"; ?>