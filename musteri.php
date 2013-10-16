<?php 
	include "header.php"; 
	sessionCtrl();
	
	$id = $_GET['id'];
	
	
	
?>
	<script>
		$(function(){
			var musteriBilgileri = <?php echo get_musteri_bilgileri($id); ?>;
			generateUI(JSON.stringify(musteriBilgileri));
		});
	</script>
	
	
	<div class="row alert alert-info">
		<div class="col-sm-7 col-lg-7">
			<span style="font-size:50px; font-weight:900; color:rgba(0,0,0,0.9);" id="UI_isimsoyisim"></span>
			<br />
			<strong>Adres : </strong> <span id="UI_adres"></span>
			<br />
			<strong>Telefon : </strong> <span id="UI_telefon"></span>
		</div>
		<div class="col-sm-5 col-lg-5">
			<strong>Müşteri ID : </strong> <span id="UI_id"></span>
			<br />
			<strong>Hesap Durumu : </strong> <span class="badge" id="UI_hesap_durumu"></span>
			<br />
			<br />
			<button class="btn btn-xs btn-warning">
				<i class="glyphicon glyphicon-minus"></i> Alacak Ekle
			</button>
			<button class="btn btn-xs btn-success">
				<i class="glyphicon glyphicon-plus"></i> Ödeme Ekle
			</button>
			<button class="btn btn-xs btn-primary" id="UI_btn_hesap_durumu">
				<i class="glyphicon glyphicon-ok"></i> Hesabı Aç / Kapat
			</button>
			<br />
			<br />
			<button class="btn btn-xs btn-default">
				<i class="glyphicon glyphicon-pencil"></i> Müşteri Bilgilerini Güncelle
			</button>
			<button class="btn btn-xs btn-danger" id="UI_btn_musteri_sil">
				<i class="glyphicon glyphicon-remove"></i> Müşteriyi Sil
			</button>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-12 col-lg-12">
			<table class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th>Tarih</th>
						<th>Açıklama</th>
						<th>Tutar</th>
						<th>İşlem</th>
					</tr>
				</thead>
				<tbody>
					<tr class="danger">
						<td>21-02-2013</td>
						<td>Cam Balkon</td>
						<td>1500 TL</td>
						<td width="100">
							<button class="btn btn-xs btn-default"><i class="glyphicon glyphicon-pencil"></i></button>
							<button class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i></button>
						</td>
					</tr>
					<tr class="success">
						<td>23-02-2013</td>
						<td>Nesrine Ödenen</td>
						<td>500 TL</td>
						<td>
							<button class="btn btn-xs btn-default"><i class="glyphicon glyphicon-pencil"></i></button>
							<button class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i></button>
						</td>
					</tr>
					<tr class="success">
						<td>23-02-2013</td>
						<td>Ayşeye Ödenen</td>
						<td>500 TL</td>
						<td>
							<button class="btn btn-xs btn-default"><i class="glyphicon glyphicon-pencil"></i></button>
							<button class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i></button>
						</td>
					</tr>
				</tbody>
				<tfoot>
					<tr class="warning">
						<th colspan="2">
							Bakiye :
						</th>
						<th colspan="2">
							500 TL
						</th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
	
	
	
	
<?php include "footer.php"; ?>