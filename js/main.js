/* DOCUMENT READY */
$(function(){
	
		
		
});
/* DOCUMENT READY END */


function login()
{
	var pass = $('input[type="password"]').val();
	
	var params = 
	{
		duty 		: 'login',
		password 	: pass 
	}
	
	$.post('php_functions.php', params, function(resp){
		if (resp == 'success')
		{
			location.href = 'index.php';
		}
		else
		{
			alert('Parola Hatalı!');
		}
	})
}

function logout()
{
	var params = 
	{
		duty 		: 'logout'
	}
	
	$.post('php_functions.php', params, function(resp){
		if (resp == 'success')
		{
			location.href = 'login.php';
		}
		else
		{
			alert('Çıkış Yapılamadı!');
		}
	})
}

function arama()
{
	$.fancybox.showLoading();
	var query = $('input#arama').val();
	
	if (arama_tipi(query) == 'isim')
	{
		var params = 
		{
			duty 	: 'arama',
			tip		: 'isim',
			query	: query
		}		
		
		$.post('php_functions.php', params, function(resp){
			console.log($.parseJSON(resp));
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
		
		$.post('php_functions.php', params, function(resp){
			console.log($.parseJSON(resp));
			arama_goster($.parseJSON(resp));
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
	$('#UI_telefon').text(kisi.telefon);
	$('#UI_id').text(kisi.id);
	$('#UI_btn_musteri_sil').attr('onclick', 'musteri.sil('+kisi.id+');');
	$('#UI_btn_hesap_durumu').attr('onclick', 'musteri.hesapDurumuToggle('+kisi.id+');');
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
							'<td width="150">'+$this.tarih+'</td>'+
							'<td>'+$this.aciklama+'</td>'+
							'<td width="150">'+$this.tutar+' TL</td>'+
							'<td width="100">'+
							'<button class="btn btn-xs btn-default"><i class="glyphicon glyphicon-pencil"></i></button>'+
							'<button class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i></button>'+
							'</td>'+
						'</tr>';
			$('table#islemler tbody').append(tmpl);
		}
		else
		{
			bakiye += parseInt($this.tutar);
			var tmpl = '<tr class="danger">'+
							'<td>'+$this.tarih+'</td>'+
							'<td>'+$this.aciklama+'</td>'+
							'<td>'+$this.tutar+' TL</td>'+
							'<td width="100">'+
							'<button class="btn btn-xs btn-default"><i class="glyphicon glyphicon-pencil"></i></button>'+
							'<button class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i></button>'+
							'</td>'+
						'</tr>';
			$('table#islemler tbody').append(tmpl);
		}
	});
	
	
	$('#UI_bakiye_tutar').empty().text(bakiye + ' TL');
}

var musteri = 
{
	sil : function(id)
	{
		var params = 
		{
			duty : 'musteri_sil',
			id : id
		}
		
		if (confirm('Müşteriyi silmek istediğinizden emin misiniz?'))
		{
			$.post('php_functions.php', params, function(resp){
				if (resp == '1')
				{
					alert('Müşteri Başarıyla Silindi!.');
					location.href = "index.php";
				}
				else
				{
					alert('Silme İşlemi Sırasında Bir Hata Oluştu!.');
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
		
		$.post('php_functions.php', params, function(resp){
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
}