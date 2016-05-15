window.addEvent('domready', function(){
	
	var memory_reload;
	
	$('select_type_stock').addEvent('change', function(event){
		event.stop();
		$('div_table_stock').load('?action=table_stock&id_stock='+$('select_type_stock').value);
		memory_reload = '?action=table_stock&id_stock='+$('select_type_stock').value;
	});
	SubmitEspace = $('select_type_espace');
	SubmitEspace.addEvent('change', function(event){
		event.stop();
		if(confirm('Déplacer les futs ?'))
		{
			var form = document.forms.matrice;
			for (i=0 ; i<= form.length-1 ; i++){
				if (form[i].type == 'checkbox' && form[i].checked){
																				$(form[i].name).load('?action=bouger_stock&id_stock='+form[i].value+'&id_espace='+SubmitEspace.value);
				}		
			}
			$('div_table_stock').load(memory_reload);
		}
	});
});



		colors = ["#ffffff", "#00ff00"];
		cRGB = [];
		function toRGB(color){
				var rgb = "rgb(" + parseInt(color.substring(1,3), 16) + ", " + parseInt(color.substring(3,5), 16) + ", " + parseInt(color.substring(5,7), 16) + ")";		
				return rgb;
		}
		for(var i=0; i<colors.length; i++){
				cRGB[i] = toRGB(colors[i]);
		}
		function changeColor(target){
				var swapper = navigator.appVersion.indexOf("MSIE")!=-1 ? toRGB(document.getElementById(target).style.backgroundColor) : document.getElementById(target).style.backgroundColor;
				var set = false;
				var xx;
				for(var i=0; i<cRGB.length; i++){
						if(swapper == cRGB[i]){
								if(((i+1)) >= cRGB.length){
										xx = 0;
								}else{
										xx = i+1;
								}
								document.getElementById(target).style.background = colors[xx];
								set = true;
								i=cRGB.length;
						}
				}
				set ? null : document.getElementById(target).style.background = colors[1];
		}
