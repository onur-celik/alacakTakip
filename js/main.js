//vars
var postUrl = 'php_functions.php';
var stack_bottomright = {"dir1": "up", "dir2": "left", "firstpos1": 25, "firstpos2": 25};
/* DOCUMENT READY */
$(function(){
	$.pnotify.defaults.history = false;
	$.pnotify.defaults.delay = 4000;
	
	getSahip();
	getTotalMusteri();
	getAcikHesaplar();
	getKapaliHesaplar();
	getToplamAlacak();
	getToplamYapilanIs();
		
		
});
/* DOCUMENT READY END */


function getSahip()
{
	var params = 
	{
		duty : 'getSahip'
	}
	
	$.post(postUrl, params, function(resp)
	{
		$('span#sahip').text(resp);
		$('title').prepend(resp + ' ');
	});
}

function ayarlar()
{
	alert('coming soon');
}

function login()
{
	var pass = $('input[type="password"]').val();
	
	var params = 
	{
		duty 		: 'login',
		password 	: pass 
	}
	
	$.post(postUrl, params, function(resp){
		if (resp == 'success')
		{
			
			$.pnotify({
			    title	: 'Başarılı',
			    text	: 'Hoşgeldiniz!.',
			    type	: 'success',
			    addclass: "stack-bottomright",
			    stack   : stack_bottomright
			});
				
			setTimeout(function(){
				location.href = "index.php";
			},1200);
		}
		else
		{	
			console.log(resp);
			$.pnotify({
			    title	: 'Parola Hatalı',
			    text	: 'Lütfen parolanızı kontrol edip tekrar deneyin!',
			    type	: 'error',
			    addclass: "stack-bottomright",
			    stack   : stack_bottomright
			});
		}
	})
}

function logout()
{
	var params = 
	{
		duty 		: 'logout'
	}
	
	$.post(postUrl, params, function(resp){
		if (resp == 'success')
		{
			location.href = 'login.php';
		}
		else
		{
			$.pnotify({
			    title	: 'Hata!',
			    text	: 'Çıkış Yapılamadı!',
			    type	: 'error',
			    addclass: "stack-bottomright",
			    stack   : stack_bottomright
			});
		}
	})
}

function arama()
{
	var query = $('input#arama').val();
	if (query != '')
	{
		$.fancybox.showLoading();
		
		if (arama_tipi(query) == 'isim')
		{
			var params = 
			{
				duty 	: 'arama',
				tip		: 'isim',
				query	: query
			}		
			
			$.post(postUrl, params, function(resp){
				arama_goster($.parseJSON(resp));
			});
		}
		else
		{
			var params = 
			{
				duty 	: 'arama',
				tip		: 'telefon',
				query	: query
			}		
			
			$.post(postUrl, params, function(resp){
				arama_goster($.parseJSON(resp));
			});
		}	
	}
	else
	{	
		$.pnotify({
		    title	: 'Arama Boş',
		    text	: 'Lütfen İsim, Soyisim ya da Telefon Numarası Yazınız!.',
		    type	: 'error',
		    addclass: "stack-bottomright",
		    stack   : stack_bottomright
		});
	}
	
}


function arama_tipi(query)
{
	var tip = '';
	var alpha_regex = /[a-zA-Z]+.*|.*[a-zA-Z]+|.*[a-zA-Z]+.*/i;

	if (query.match(alpha_regex))
	{
		return tip = 'isim';
	}
	else
	{
		return tip = 'telefon';
	}	
}

function arama_goster(sonuc)
{
	$('#arama_sonuc span#sonuc_container').empty();
	$.each(sonuc, function(k,v)
	{
		var tmpl = '<i class="glyphicon glyphicon-user"></i> <a href="musteri.php?id='+$(v)[0].id+'">'+$(v)[0].isimsoyisim+'</a><br />';
		$('#arama_sonuc span#sonuc_container').append(tmpl)	
	});
	$.fancybox( {href : '#arama_sonuc'} );
}

function generateUI(kisi)
{
	kisi = $.parseJSON(kisi);
	$('#UI_isimsoyisim').text(kisi.isimsoyisim);
	$('#UI_adres').text(kisi.adres);
	$('#UI_telefon1').text(kisi.telefon1);
	$('#UI_telefon2').text(kisi.telefon2);
	$('#UI_telefon3').text(kisi.telefon3);
	$('#UI_id').text(kisi.id);
	$('#UI_btn_musteri_sil').attr('onclick', 'musteri.sil('+kisi.id+');');
	$('#UI_btn_hesap_durumu').attr('onclick', 'musteri.hesapDurumuToggle('+kisi.id+');');
	$('#UI_btn_alacak_ekle').attr('onclick', 'musteri.alacakEkle('+kisi.id+');');
	$('#UI_btn_odeme_ekle').attr('onclick', 'musteri.odemeEkle('+kisi.id+');');
	$('#UI_btn_bilgileri_guncelle').attr('onclick', 'musteri.bilgileriGuncelle('+kisi.id+');');
	$('#UI_btn_alacak_ekle_kaydet').attr('onclick', 'musteri.alacakEkle_kaydet('+kisi.id+');');
	$('#UI_btn_odeme_ekle_kaydet').attr('onclick', 'musteri.odemeEkle_kaydet('+kisi.id+');');
	$('#UI_btn_bilgi_guncelle_kaydet').attr('onclick', 'musteri.bilgileriGuncelle_kaydet('+kisi.id+');');
	
	if (kisi.hesap_durumu == 1)
	{
		$('#UI_hesap_durumu').text('AÇIK');
	}
	else
	{
		$('#UI_hesap_durumu').text('KAPALI');
	}
}

function generateTable(paraAkisi)
{
	var akis = $.parseJSON(paraAkisi);
	var bakiye = 0;
	$.each(akis, function(k,v)
	{
		$this = $(v)[0];
		if ($this.tip == 1){
			bakiye -= parseInt($this.tutar);
			var tmpl = '<tr class="success">'+
							'<td width="120">'+$this.tarih+'</td>'+
							'<td><strong>'+$this.aciklama+'</strong></td>'+
							'<td width="110">'+$this.tutar+' TL</td>'+
							'<td width="80" class="text-center">'+
							'<button class="btn btn-xs btn-default" onclick="musteri.islem.duzenle('+$this.id+');"><i class="glyphicon glyphicon-pencil"></i></button>'+
							' <button class="btn btn-xs btn-default" onclick="musteri.islem.sil('+$this.id+');"><i class="glyphicon glyphicon-remove"></i></button>'+
							'</td>'+
						'</tr>';
			$('table#islemler tbody').append(tmpl);
		}
		else
		{
			bakiye += parseInt($this.tutar);
			var tmpl = '<tr class="danger">'+
							'<td width="120">'+$this.tarih+'</td>'+
							'<td><strong>'+$this.aciklama+'</strong></td>'+
							'<td width="110">'+$this.tutar+' TL</td>'+
							'<td width="80" class="text-center">'+
							'<button class="btn btn-xs btn-default" onclick="musteri.islem.duzenle('+$this.id+');"><i class="glyphicon glyphicon-pencil"></i></button>'+
							' <button class="btn btn-xs btn-default" onclick="musteri.islem.sil('+$this.id+');"><i class="glyphicon glyphicon-remove"></i></button>'+
							'</td>'+
						'</tr>';
			$('table#islemler tbody').append(tmpl);
		}
	});
	
	
	
	$('#UI_bakiye_tutar').empty().text(bakiye + ' TL');
}

var musteri = 
{
	ekleme_formu : function()
	{
		$.fancybox.showLoading();
		$.fancybox( {href : '#musteri_ekleme_formu'} );
	},
	
	
	ekle : function()
	{		
		var params = 
		{
			duty 		: 'musteri_ekle',
			isimsoyisim	: $('#ekle_isimsoyisim').val(),
			adres		: $('#ekle_adres').val(),
			telefon1	: $('#ekle_telefon1').val(),
			telefon2	: $('#ekle_telefon2').val(),
			telefon3	: $('#ekle_telefon3').val(),
		}
		
		$.post(postUrl, params, function(resp){
			if (resp == 1)
			{
				$.pnotify({
				    title	: 'Başarılı',
				    text	: 'Müşteri başarıyla eklendi!.',
				    type	: 'success',
				    addclass: "stack-bottomright",
				    stack   : stack_bottomright
				});

				var params2 = 
				{
					duty	: 'get_last_id'
				};
				$.post(postUrl, params2, function(resp)
				{
					setTimeout(function(){
						location.href = 'musteri.php?id='+resp;	
					},1200);
				});
			}
			else
			{
				$.pnotify({
				    title	: 'Hata',
				    text	: 'Müşteri eklenirken bir sorun oluştu!.',
				    type	: 'error',
				    addclass: "stack-bottomright",
				    stack   : stack_bottomright
				});
			}
		});
	},
	
	sil : function(id)
	{
		var params = 
		{
			duty : 'musteri_sil',
			id : id
		}
		
		if (confirm('Müşteriyi silmek istediğinizden emin misiniz?'))
		{
			$.post(postUrl, params, function(resp){
				if (resp == '1')
				{
					$.pnotify({
					    title	: 'Başarılı',
					    text	: 'Müşteri başarıyla silindi!.',
					    type	: 'success',
					    addclass: "stack-bottomright",
					    stack   : stack_bottomright
					});
					setTimeout(function(){
						location.href = "index.php";
					},1200);
				}
				else
				{
					$.pnotify({
					    title	: 'Hata',
					    text	: 'Silme İşlemi Sırasında Bir Hata Oluştu!.',
					    type	: 'error',
					    addclass: "stack-bottomright",
					    stack   : stack_bottomright
					});
				}
			});	
		}	
	},
	
	hesapDurumuToggle : function(id)
	{
		var params = 
		{
			duty : 'hesapDurumuToggle',
			id : id
		}
		
		$.post(postUrl, params, function(resp){
			if (resp == 1)
			{
				$('#UI_hesap_durumu').text('AÇIK');
			}
			else
			{
				$('#UI_hesap_durumu').text('KAPALI');
			}
		});
	},
	
	alacakEkle : function(musteri_id)
	{
		$.fancybox.showLoading();
		$.fancybox( {href : '#alacak_ekle'} );
	},
	
	alacakEkle_kaydet : function(musteri_id)
	{
		var params = 
		{
			duty : 'alacak_ekle',
			id : musteri_id,
			tarih : $('#alacak_ekle #tarih').val() ,
			aciklama : $('#alacak_ekle #aciklama').val() ,
			tutar : $('#alacak_ekle #tutar').val()
		}
		
/*
		var hede1 = new Date(params.tarih);
		var hede2 = new Date(hede1).getTime()/1000+10800;
		var hede3 = new Date(hede2);
		
		console.log(params.tarih);
		console.log(hede1);
		console.log(hede2);
		console.log(hede3);
		
		return false;
*/
		$.post(postUrl, params, function(resp){
			if (resp == 1)
			{	
				$.pnotify({
				    title	: 'Başarılı',
				    text	: 'Alacak bilgisi başarıyla eklendi!',
				    type	: 'success',
				    addclass: "stack-bottomright",
				    stack   : stack_bottomright
				});
				setTimeout(function(){
					location.reload();
				},1200);
				
			}
			else
			{
				$.pnotify({
				    title	: 'Hata!',
				    text	: 'Alacak bilgisi eklenirken bir hata oluştu!.',
				    type	: 'error',
				    addclass: "stack-bottomright",
				    stack   : stack_bottomright
				});
			}
		});
	},
	
	odemeEkle : function(musteri_id)
	{
		$.fancybox.showLoading();
		$.fancybox( {href : '#odeme_ekle'} );
	},
	
	odemeEkle_kaydet : function(musteri_id)
	{
		params = 
		{
			duty : 'odeme_ekle',
			id : musteri_id,
			tarih : $('#odeme_ekle #tarih').val() ,
			aciklama : $('#odeme_ekle #aciklama').val() ,
			tutar : $('#odeme_ekle #tutar').val()
		}
		
		$.post(postUrl, params, function(resp){
			if (resp == 1)
			{
				$.pnotify({
				    title	: 'Başarılı',
				    text	: 'Ödeme bilgisi başarıyla eklendi!',
				    type	: 'success',
				    addclass: "stack-bottomright",
				    stack   : stack_bottomright
				});
				setTimeout(function(){
					location.reload();
				},1200);
			}
			else
			{
				$.pnotify({
				    title	: 'Hata!',
				    text	: 'Ödeme bilgisi eklenirken bir hata oluştu!.',
				    type	: 'error',
				    addclass: "stack-bottomright",
				    stack   : stack_bottomright
				});
			}
		});
	},
	
	bilgileriGuncelle : function(musteri_id)
	{
		$.fancybox.showLoading();
		$.fancybox( {href : '#bilgileri_guncelle'} );
		var params =
		{
			duty : 'musteri_bilgilerini_guncelle',
			id : musteri_id
		};
		
		$.post(postUrl, params, function(resp){
			var kisi = $.parseJSON(resp);
			
			$('#bg_isimsoyisim').val(kisi.isimsoyisim);
			$('#bg_adres').text(kisi.adres);
			$('#bg_telefon1').val(kisi.telefon1);
			$('#bg_telefon2').val(kisi.telefon2);
			$('#bg_telefon3').val(kisi.telefon3);
		});
	},
	
	bilgileriGuncelle_kaydet : function(musteri_id)
	{
		params = 
		{
			duty 		: 'musteri_bilgi_guncelle_kaydet',
			id 			: musteri_id,
			isimsoyisim : $('#bg_isimsoyisim').val() ,
			adres 		: $('#bg_adres').val() ,
			telefon1 	: $('#bg_telefon1').val(),
			telefon2 	: $('#bg_telefon2').val(),
			telefon3 	: $('#bg_telefon3').val()
		}
		
		$.post(postUrl, params, function(resp){
			if (resp == 1)
			{
				$.pnotify({
				    title	: 'Başarılı',
				    text	: 'Müşteri bilgileri başarıyla güncellendi!',
				    type	: 'success',
				    addclass: "stack-bottomright",
				    stack   : stack_bottomright
				});
				setTimeout(function(){
					location.reload();
				},1200);
			}
			else
			{
				$.pnotify({
				    title	: 'Hata!',
				    text	: 'Müşteri bilgileri güncellenirken bir hata oluştu!.',
				    type	: 'error',
				    addclass: "stack-bottomright",
				    stack   : stack_bottomright
				});
			}
		});
	},
	
	islem : 
	{
		duzenle : function(islem_id)
		{
			$.fancybox.showLoading();
			$.fancybox( {href : '#islem_kaydi_guncelle'} );
			
			$('#UI_btn_islem_kaydi_guncelle_kaydet').attr('onclick', 'musteri.islem.guncelle('+islem_id+');');
			
			var params = 
			{
				duty 	: 'islem_kaydi_duzenle',
				id 		: islem_id
			}
			
			$.post(postUrl, params, function(resp){
				var islem = $.parseJSON(resp);
				$('#islem_kaydi_guncelle #tarih').val(islem.tarih);
				$('#islem_kaydi_guncelle #aciklama').val(islem.aciklama);
				$('#islem_kaydi_guncelle #tutar').val(islem.tutar);
				
				if (islem.tip == '0')
				{	
					$('#islem_kaydi_guncelle #tip option[value="1"]').prop('selected', false);
					$('#islem_kaydi_guncelle #tip option[value="0"]').prop('selected', true);
				}
				else
				{	
					$('#islem_kaydi_guncelle #tip option[value="0"]').prop('selected', false);
					$('#islem_kaydi_guncelle #tip option[value="1"]').prop('selected', true);
				}
			});
		},
		
		guncelle : function(islem_id)
		{
			var params = 
			{
				duty 	: 'islem_kaydi_guncelle',
				id 		: islem_id,
				tarih	: $('#islem_kaydi_guncelle #tarih').val(),
				aciklama: $('#islem_kaydi_guncelle #aciklama').val(),
				tutar	: $('#islem_kaydi_guncelle #tutar').val(),
				tip		: $('#islem_kaydi_guncelle #tip option:selected').val()
			}
			
			$.post(postUrl, params, function(resp){
				if (resp == 1)
				{
					$.pnotify({
					    title	: 'Başarılı',
					    text	: 'İşlem kaydı başarıyla güncellendi!.',
					    type	: 'success',
					    addclass: "stack-bottomright",
					    stack   : stack_bottomright
					});
					
					setTimeout(function(){
						location.reload();
					},1200);
				}
				else
				{
					$.pnotify({
					    title	: 'Hata!',
					    text	: 'İşlem kaydı güncellenirken bir hata oluştu!.',
					    type	: 'error',
					    addclass: "stack-bottomright",
					    stack   : stack_bottomright
					});
				}
			});
		},
		
		sil : function(islem_id)
		{
			if (confirm('İşlem kaydını silmek istediğinizden emin misiniz?'))
			{
				var params =
				{
					duty : 'islem_kaydi_sil',
					id : islem_id
				}
				
				$.post(postUrl, params, function(resp){
					if (resp == 1)
					{
						$.pnotify({
						    title	: 'Başarılı',
						    text	: 'İşlem kaydı başarıyla silindi!.',
						    type	: 'success',
						    addclass: "stack-bottomright",
						    stack   : stack_bottomright
						});
						setTimeout(function(){
							location.reload();
						},1200);
					}
					else
					{
						$.pnotify({
						    title	: 'Hata!',
						    text	: 'İşlem kaydı silinirken bir hata oluştu!.',
						    type	: 'error',
						    addclass: "stack-bottomright",
						    stack   : stack_bottomright
						});
					}
				});
				
			}
		},
	}
}



function getTotalMusteri()
{
	var params = 
	{
		duty : 'getTotalMusteri'
	}
	
	$.post(postUrl, params, function(resp)
	{
		$('span#total_musteri').text(resp);
	});
}

function getAcikHesaplar()
{
	var params = 
	{
		duty : 'getAcikHesaplar'
	}
	
	$.post(postUrl, params, function(resp)
	{
		$('span#acik_hesaplar').text(resp);
	});
}

function getKapaliHesaplar()
{
	var params = 
	{
		duty : 'getKapaliHesaplar'
	}
	
	$.post(postUrl, params, function(resp)
	{
		$('span#kapali_hesaplar').text(resp);
	});
}

function getToplamAlacak()
{
	var params = 
	{
		duty : 'getToplamAlacak'
	}
	
	$.post(postUrl, params, function(resp)
	{
		$('span#toplam_alacak').text(resp+' TL');
	});
}

function getToplamYapilanIs()
{
	$.fancybox.showLoading();
	var params = 
	{
		duty : 'getToplamYapilanIs'
	}
	
	$.post(postUrl, params, function(resp)
	{
		$('span#toplam_yapilan_is').text(resp+' TL');
		$.fancybox.hideLoading();
	});
}