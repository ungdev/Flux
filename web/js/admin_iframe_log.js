window.addEvent('domready', function(){

	var memory_reload;

	$('select_type_stock').addEvent('change', function(event){
		event.stop();
		$('div_table_stock').set('load', {
			onComplete: function(){
				SubmitEspace = $$('.select_espace_deplace');
				SubmitEspace.each(function(item, index){
					item.addEvent('change', function(event){
						event.stop();
						if(confirm('Déplacer le fut ?'))
						{
							$('tr_log_'+item.get('name')).load('?action=bouger_stock&id_stock='+item.get('name')+'&id_espace='+item.value);
						}
					});
				});
			},
		});
		$('div_table_stock').load('?action=table_stock&id_stock='+$('select_type_stock').value);
		memory_reload = '?action=table_stock&id_stock='+$('select_type_stock').value;
	});

	$('select_type_espace').addEvent('change', function(event){
		event.stop();
		$('div_table_stock').set('load', {
			onComplete: function(){
				/*
				SubmitEspace = $$('.select_espace_deplace');
				SubmitEspace.each(function(item, index){
					item.addEvent('change', function(event){
						event.stop();
						if(confirm('Déplacer le fut ?'))
						{
							$('tr_log_'+item.get('name')).load('?action=bouger_stock&id_stock='+item.get('name')+'&id_espace='+item.value);
						}
					});
				});*/
			},
		});
		$('div_table_stock').load('?action=table_stock&id_espace='+$('select_type_espace').value);
		memory_reload = '?action=table_stock&id_espace='+$('select_type_espace').value;
	});

	$('a_reload_page_log').addEvent('click', function(event){
		event.stop();
		$('div_table_stock').set('load', {
			onComplete: function(){
				SubmitEspace = $$('.select_espace_deplace');
				SubmitEspace.each(function(item, index){
					item.addEvent('change', function(event){
						event.stop();
						if(confirm('Déplacer le fut ?'))
						{
							$('tr_log_'+item.get('name')).load('?action=bouger_stock&id_stock='+item.get('name')+'&id_espace='+item.value);
						}
					});
				});
			},
		});
		$('div_table_stock').load(memory_reload);
	});

});
