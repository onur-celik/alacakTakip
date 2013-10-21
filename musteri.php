<?php 
	include "header.php"; 
	sessionCtrl();
	
	$id = $_GET['id'];
	 
    /*
print_r( getdate() );
    echo mktime();
*/
?>
	<script>
		$(function(){
			var musteriBilgileri = <?php echo get_musteri_bilgileri($id); ?>;
			generateUI(JSON.stringify(musteriBilgileri));
			
			var alacakVerecekBilgileri = <?php echo get_alacakVerecek_bilgileri($id); ?>;
			generateTable(JSON.stringify(alacakVerecekBilgileri));
			
			$('#alacak_ekle, #odeme_ekle, #bilgileri_guncelle, #islem_kaydi_guncelle').hide();
			$('#islem_kaydi_guncelle input#tarih, #alacak_ekle input#tarih, #odeme_ekle input#tarih')
				.datepicker({
					format: "mm/dd/yyyy",
					todayBtn: "linked",
					language: "tr",
					autoclose: true,
					todayHighlight: true
				});
		});
		
	</script>
	
	
	<div class="row alert alert-info">
		<div class="col-sm-7 col-lg-7">
			<span style="font-size:50px; font-weight:900; color:rgba(0,0,0,0.9);" id="UI_isimsoyisim"></span>
			<br />
			<strong>Adres : </strong> <span id="UI_adres"></span>
			<br />
			<strong>Telefon1 : </strong> <span id="UI_telefon1"></span>
			<br />
			<strong>Telefon2 : </strong> <span id="UI_telefon2"></span>
			<br />
			<strong>Telefon3 : </strong> <span id="UI_telefon3"></span>
		</div>
		<div class="col-sm-5 col-lg-5">
			<strong>Müşteri ID : </strong> <span id="UI_id"></span>
			<br />
			<strong>Hesap Durumu : </strong> <span class="badge" id="UI_hesap_durumu"></span>
			<br />
			<br />
			<button class="btn btn-xs btn-warning" id="UI_btn_alacak_ekle">
				<i class="glyphicon glyphicon-minus"></i> Alacak Ekle
			</button>
			<button class="btn btn-xs btn-success" id="UI_btn_odeme_ekle">
				<i class="glyphicon glyphicon-plus"></i> Ödeme Ekle
			</button>
			<button class="btn btn-xs btn-primary" id="UI_btn_hesap_durumu">
				<i class="glyphicon glyphicon-ok"></i> Hesabı Aç / Kapat
			</button>
			<br />
			<br />
			<button class="btn btn-xs btn-default" id="UI_btn_bilgileri_guncelle">
				<i class="glyphicon glyphicon-pencil"></i> Müşteri Bilgilerini Güncelle
			</button>
			<button class="btn btn-xs btn-danger" id="UI_btn_musteri_sil">
				<i class="glyphicon glyphicon-remove"></i> Müşteriyi Sil
			</button>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-12 col-lg-12">
			<div class="table-responsive">
				<table class="table table-bordered table-striped table-hover" id="islemler">
					<thead>
						<tr>
							<th>Tarih</th>
							<th>Açıklama</th>
							<th>Tutar</th>
							<th>İşlem</th>
						</tr>
					</thead>
					<tbody>
						<!-- database den geliyor... -->
					</tbody>
					<tfoot>
						<tr class="warning">
							<th colspan="2">Bakiye :</th>
							<th colspan="2" id="UI_bakiye_tutar"></th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
	
	<div id="alacak_ekle">
		Tarih : 
		<input type="text" class="form-control" id="tarih"/>
		Açıklama :
		<input type="text" class="form-control" id="aciklama"/>
		Tutar : 
		<input type="text" class="form-control" id="tutar"/>
		<br />
		<button class="btn btn-xs btn-warning" id="UI_btn_alacak_ekle_kaydet">
			<i class="glyphicon glyphicon-minus"></i> Alacak Ekle
		</button>
			
	</div>
	
	<div id="odeme_ekle">
		Tarih : 
		<input type="text" class="form-control" id="tarih"/>
		Açıklama :
		<input type="text" class="form-control" id="aciklama"/>
		Tutar : 
		<input type="text" class="form-control" id="tutar"/>
		<br />
		<button class="btn btn-xs btn-success" id="UI_btn_odeme_ekle_kaydet">
			<i class="glyphicon glyphicon-plus"></i> Ödeme Ekle
		</button>
	</div>
	
	<div id="islem_kaydi_guncelle">
		Tarih : 
		<input type="text" class="form-control" id="tarih"/>
		Açıklama :
		<input type="text" class="form-control" id="aciklama"/>
		Tutar : 
		<input type="text" class="form-control" id="tutar"/>	
		Tip :
		<select id="tip" class="form-control">
			<option value="0">Alacak</option>
			<option value="1">Ödeme</option>
		</select>
		<br />
		<button class="btn btn-xs btn-success" id="UI_btn_islem_kaydi_guncelle_kaydet">
			<i class="glyphicon glyphicon-ok"></i> Güncelle
		</button>
	</div>
	
	<div id="bilgileri_guncelle" style="width:400px;">
		İsim Soyisim : 
		<input type="text" class="form-control" id="bg_isimsoyisim"/>
		Adres :
		<textarea id="bg_adres" class="form-control"></textarea>
		Telefon1 : 
		<input type="text" class="form-control" id="bg_telefon1"/>
		Telefon2 : 
		<input type="text" class="form-control" id="bg_telefon2"/>
		Telefon3 : 
		<input type="text" class="form-control" id="bg_telefon3"/>
		<br />
		<button class="btn btn-xs btn-success" id="UI_btn_bilgi_guncelle_kaydet">
			<i class="glyphicon glyphicon-ok"></i> Güncelle
		</button>
	</div>
	
	
<?php include "footer.php"; ?>