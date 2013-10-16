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
	if (kisi.hesap_durumu == 1)
	{
		$('#UI_hesap_durumu').text('AÇIK');
	}
	else
	{
		$('#UI_hesap_durumu').text('KAPALI');
	}
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
		
		var confirm = alert('hede');
		
		if (confirm)
		{
			$.post('php_functions.php', params, function(resp){
				console.log(resp);
			});	
		}
		
	}
}