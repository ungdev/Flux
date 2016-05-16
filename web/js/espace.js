var timeoutFunc = function(again){
	if(again === undefined) {
		again = true;
	}

	var jqxhr = jQuery.getJSON( "/espace/json", function(data) {
		if(!data) {
			$('.connexionState').html('<span class="glyphicon glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> Impossible de mettre à jour !')
			$('.connexionState').css('color', 'red');
			return;
		}

		// Update problems on left sidebar
		if(!data.problemList) {
			$('#problems').html('Erreur de chargement..');
		}
		if($('#problems').data('array') === undefined || $('#problems').data('array') != JSON.stringify(data.problemList))
		{
			var currentCat = -1;
			var html = '';
			for (var cat in data.problemList) {
				if (data.problemList.hasOwnProperty(cat)) {
					var val = data.problemList[cat];

					// Print category name once
					if(currentCat != val.id_cat_prob) {
						currentCat = val.id_cat_prob;
						html += '<h4>'+val.cat+'</h4>';
					}

					// Print buttons
					if(val.gravite == 2) {
						html += '<div class="btn-group btn-group-problem" role="group">'
							+ '<a href="/espace/problem?type='+ val.id_type_prob +'&gravite=0" class="btn btn-success" title="Annuler le signalement"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></a>'
							+ '<span class="btn btn-danger">'+val.nom+'</span>'
							+ '</div>';
					}
					else if(val.gravite == 1) {
						html += '<div class="btn-group btn-group-problem" role="group">'
							+ '<a href="/espace/problem?type='+ val.id_type_prob +'&gravite=0" class="btn btn-success" title="Annuler le signalement"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></a>'
							+ '<a href="/espace/problem?type='+ val.id_type_prob +'&gravite=2" class="btn btn-warning" title="Signaler que le problème est URGENT">'+val.nom+'</a>'
							+ '</div>';
					}
					else {
						html += '<a href="/espace/problem?type='+ val.id_type_prob +'&gravite=1" class="btn btn-default btn-problem" title="Signaler un problème">'+val.nom+'</a>';
					}
				}
			}
			$('#problems').html(html);
			$('#problems').data('array', JSON.stringify(data.problemList))
		}

		// Update flux on main panel
		if(!data.fluxList) {
			$('#flux').html('Erreur de chargement..');
		}
		if($('#flux').data('array') === undefined || $('#flux').data('array') != JSON.stringify(data.fluxList))
		{
			currentCat = -1;
			html = '';
			for (var cat in data.fluxList) {
				if (data.fluxList.hasOwnProperty(cat)) {
					var val = data.fluxList[cat];

					// Print category name once
					if(currentCat != val.type_id) {
						if(currentCat != -1) {
							html += '</div>';
						}
						html += '<h4>'+val.type_name+' ('+val.conditionnement+')</h4><div class="row">';
						currentCat = val.type_id;
					}

					// Print buttons
					if(val.fin != null) {
						html += '<div class="col-md-4"><div class="btn-group btn-group-problem" role="group">'
							+ '<a href="/espace/flux?level=1&stock='+val.id+'" class="btn btn-success" title="Annuler"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>'
							+ '<span class="btn btn-danger">'+val.identifiant+' Terminé</span>'
							+ '</div></div>';
					}
					else if(val.entame != null) {
						html += '<div class="col-md-4"><div class="btn-group btn-group-problem" role="group">'
							+ '<a href="/espace/flux?level=0&stock='+val.id+'" class="btn btn-success" title="Annuler"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>'
							+ '<a href="/espace/flux?level=2&stock='+val.id+'" class="btn btn-warning" title="Indiquer comment terminé">'+val.identifiant+' Entamé</a>'
							+ '</div></div>';
					}
					else {
						html += '<div class="col-md-4"><a href="/espace/flux?level=1&stock='+val.id+'" class="btn btn-default btn-problem" title="Indiquer comment entamé">'+val.identifiant+'</a></div>';
					}
				}
			}
			html += '</div>';
			$('#flux').html(html);
			$('#flux').data('array', JSON.stringify(data.fluxList))
		}

		// Update chat on the right sidedpanel
		if(!data.messageList) {
			$('#chat').html('Erreur de chargement..');
		}
		var lastId = data.messageList[data.messageList.length-1].id;
		if($('#chat').data('lastId') === undefined || $('#chat').data('lastId') != lastId)
		{
			currentCat = -1;
			html = '';
			for (var msg in data.messageList) {
				if (data.messageList.hasOwnProperty(msg)) {
					var val = data.messageList[msg];

					var date = (new Date(val.date * 1000)).toLocaleTimeString();
					var color = 'black';
					var bold = 'bold';
					var author = val.login;
					if(val.me == 1) {
						bold = 'nomal';
						author = 'Moi';
					}
					if(val.droit) {
						author += ' → ' + val.droit
						color = 'red';
					}

					html += '<li class="clearfix"><div class="chat-body clearfix">'
						+ '<span class="time">['+ date +']</span> <span style="color:'+ color +';font-weight:'+bold+'" >'+ author  + '</span>: <br/>'
						+ val.message + '</div></li>';
				}
			}
			html += '</div>';
			$('#chat').html(html);
			$('#chat').data('lastId', lastId)
			$('#chat').parent().scrollTop( $('#chat').height() - $('#chat').parent().height() );
		}

		// Disable notification if last message id from me
		if (data.messageList[data.messageList.length-1].me == 1) {
			localStorage.setItem('espaceChatLastId', $('#chat').data('lastId'));
		}

		$('.connexionState').html('Mise à jour : ' + (new Date()).toLocaleTimeString())
		$('.connexionState').css('color', '#444');
		$('#chat-panel').find('input').prop('disabled', false);

	})
	.fail(function() {
		$('.connexionState').html('<span class="glyphicon glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> Impossible de mettre à jour !')
		$('.connexionState').css('color', 'red');
	})
	.always(function() {
		if(again) {
			setTimeout(timeoutFunc, 3000);
		}
	});
};
timeoutFunc();

// Chat notification
var notificationState = false;
var originalTitle = document.title;
setInterval(function () {
	// Blink everything on new message
	if(notificationState && (localStorage.getItem('espaceChatLastId') === undefined || localStorage.getItem('espaceChatLastId') != $('#chat').data('lastId'))) {
		$('#chat-panel').addClass('panel-danger');
		$('#chat-panel').css('background-color', '#FFCDCC');
		 document.title = 'Nouveau message !';
	}
	else {
		$('#chat-panel').removeClass('panel-danger');
		$('#chat-panel').css('background-color', 'white');
		 document.title = originalTitle;
	}
	notificationState = !notificationState;

}, 500);
// Stop notification on click
$('#chat-panel').click(function() {
	localStorage.setItem('espaceChatLastId', $('#chat').data('lastId'));
})

// Chat send message
var input = $('#chat-panel').find('input');
function sendMessage() {
	var val = input.val();
	if(val.length >= 1) {
		$.post('/espace/send', {'message' : val})
		input.focus();
		input.prop('disabled', true);
		input.val('');
		timeoutFunc(false);
	}
}
// Event that send message
$('#chat-panel').find('button').click(sendMessage);
input.keypress(function (e) {
	if (e.which == 13) {
		sendMessage()
		return false;
	}
});
