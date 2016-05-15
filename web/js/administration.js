var retourperiode;

window.addEvent('domready', function() {
	//le truc de SoX pour ses liens
	Liens = $$('.a_onglet');
	Liens.each(function(item, index){
		item.addEvent('click', function(event){
			event.stop();
			
			if ($chk($('table_admin_problemes'))) 
			{
				$clear(retourperiode);
			}
			
			Liens2 = $$('.onglet');
			Liens2.each(function(item, index){
				item.set('class', 'off onglet');
			});
			$(item.get('href')).set('class', 'info onglet');
			$('fenetre_chat').setStyle('visibility', 'hidden');
			
			$('contenu').set('load', {
				onComplete: function(){
					//page administration
					if ($chk($$('.a_iframe'))) {
						iframe = $$('.a_iframe');
						iframe.each(function(item, index){
							var memo = 0;
							item.addEvent('click', function(event){
								event.stop();
								if (memo == 0) {
									$$('.colonne').setStyle('display', 'none');
									$(item.get('href')).setStyle('display', 'block');
									$(item.get('href')).setStyle('width', '100%');
									memo = 1;
								}
								else {
									$(item.get('href')).setStyle('width', '25%');
									$$('.colonne').setStyle('display', 'block');
									memo = 0;
								}
								
							});
						});
					}
					
					if ($chk($('table_admin_problemes'))) 
					{
						
						FormProb = $$('.form_problemes_admin');
						
						FormProb.each(function(element){
								element.addEvent('submit', function(event){
								event.stop();
								element.send();
							});
						});
						
						var rechargePb = function(){
							$('contenu').set('load', {
                					onComplete: function(){
										
										$clear(retourperiode);
										retourperiode = rechargePb.periodical(5000); //5 seconces	
										
										var d = new Date();
										var h=d.getHours();
										var m=d.getMinutes();
										if (m<10) {m = "0" + m}
										var s=d.getSeconds();
										if (s<10) {s = "0" + s}
										var date='dernier reload : '+h+'h'+m+':'+s;
										
										$('h_pb_load').set('text', date);
										
										FormProb = $$('.form_problemes_admin');
						
										FormProb.each(function(element){
												element.addEvent('submit', function(event){
												event.stop();
												element.send();
											});
										});
										
										InputProb = $$('.input_form_problemes');
						
										InputProb.each(function(element){
											element.addEvent('focus', function(event){
												event.stop();
												$clear(retourperiode);
												retourperiode = rechargePb.periodical(30000);
											});
											element.addEvent('blur', function(event){
												event.stop();
												$clear(retourperiode);
												retourperiode = rechargePb.periodical(5000); //5 seconces	
											});
											
										});
										/*
										InputProb = $$('.input_form_problemes');
										InputProb.each(function(element){
												element.addEvent('blur', function(event){
												event.stop();
												$clear(retourperiode);
												retourperiode = rechargePb.periodical(5000); //5 seconces	
											});
										});*/
									},
							});
							$('contenu').load('admin_problemes');
							
	                	};
	                	retourperiode = rechargePb.periodical(5000); //5 seconces		
					}
					
				},
			});
			$('contenu').load(item.get('href'));
		});
			
	});
	

	
});


function fullscreen(){

document.getElementById('iframe_admin').style.width = parseInt(document.body.clientWidth)+'px';
document.getElementById('iframe_admin').style.height = '10000px';
document.getElementById('iframe_admin').style.position = 'absolute';
document.getElementById('iframe_admin').style.top = '0px';
document.getElementById('iframe_admin').style.left = '0px';

}

function minimize(){
document.getElementById('iframe_admin').style.position = 'relative';
document.getElementById('iframe_admin').style.width ='100%';
document.getElementById('iframe_admin').style.height = '500';
}
function refresh(){
window.location = window.location;
}
