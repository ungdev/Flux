window.addEvent('domready', function(){

    if ($chk($('texte_chat'))) {
        var dernier_id;
        
        $('texte_chat').scrollTop = 500000;
        
        //on chope une première fois l'id
        var jsonRequest = new Request.JSON({
            url: "chat?action=id_dernier_message",
            onComplete: function(reponse){
                dernier_id = reponse.id;
                
                //puis on fait la fonction en boucle	
                var refreshChat = function(){
                    var jsonRequest = new Request.JSON({
                        url: "chat?action=id_dernier_message",
                        onComplete: function(reponse){
                            if (reponse != null && reponse.id != dernier_id) {
                                dernier_id = reponse.id;
                                rechargeFenetre(1);
                            }
                        }
                    }).send();
                };
                refreshChat();
                refreshChat.periodical(5000); //5 seconces			
            }
        }).send();
        
        //envoie du form
        $('submit_form').addEvent('click', function(event){
            event.stop();
            var myHTMLRequest = new Request.HTML({
                url: 'chat',
                onComplete: function(reponse){
                    $('text_chat').setStyle('background', 'white');
                    rechargeFenetre(0);
                    $('text_chat').setProperty('value', '');
                },
            }).post($('form_chat'));
        });
        
        //function qui recharge la fenetre
        function rechargeFenetre(alert){
            $('texte_chat').set('load', {
                url: "chat?action=liste_messages",
                onComplete: function(){
                    $('texte_chat').scrollTop = 500000;
                    if (alert == 1) 
                        $('text_chat').setStyle('background', 'red');
                    else {
                        //faut mettre à jour le id...
                        var jsonRequest = new Request.JSON({
                            url: "chat?action=id_dernier_message",
                            onComplete: function(reponse){
                                dernier_id = reponse.id;
                            }
                        }).send();
                    }
                }
            });
            $('texte_chat').load('chat?action=liste_messages');
        }
        
        
        //on ajoute l'event pour enlever le rouge du chat nouveau message
        $('text_chat').addEvent('click', function(event){
            $('text_chat').setStyle('background', 'white');
        });
		
			var tjs_connecte = function(){
	        var myRequest = new Request({
	            method: 'get',
	            url: 'chat?action=rappel_connexion'
	        });
	        myRequest.send();
	    };
	    
	    tjs_connecte();
	    tjs_connecte.periodical(10000);
		
		//et enfin, le truc de délestage
		 $('h1_delestage').addEvent('click', function(event){
		 	if($('bloc_delestage').getStyle('visibility') == 'visible')
				$('bloc_delestage').setStyle('visibility', 'hidden');
			else if($('bloc_delestage').getStyle('visibility') == 'hidden')
				$('bloc_delestage').setStyle('visibility', 'visible');
        });
		
		$('text_chat').focus();

    }
    
    
    /* partie admin */
    
    //si ça bug, c peut etre qu'on a ailleurs acec un div fenetre_chat... alotrs, trouver autre chose que sur pages admin
    if ($chk($('fenetre_chat'))) {
        var memo_liste = 0;
        var memo_id;
        var derniers_id;
        var memo_nom;
		
		/* idées de needle pour fermer le chat qd on sort du focus
        $('fenetre_chat').addEvent('click', function(event){
			event.stopPropagation();
		});
		
		
		document.body.addEvent('click', function(event){
			if ($('onglet_chat').get('class') == 'info onglet') {
                $('fenetre_chat').setStyle('visibility', 'hidden');
                $('onglet_chat').set('class', 'off onglet');
            }
            else 
			{
                $('fenetre_chat').setStyle('visibility', 'visible');
                $('onglet_chat').set('class', 'info onglet');
            }
		});
		*/
		
        //on ajoute des event sur tous les boutons...
        Liens = $$('.choix_chat');
        
        Liens.each(function(item, index){
            item.addEvent('click', function(event){
                event.stop();
                $('fenetre_chat').setStyle('visibility', 'visible');
                $('onglet_chat').set('class', 'info onglet');
                $('onglet_chat').setStyle('visibility', 'visible');
                $('text_chat_admin').focus();
				
				$('text_chat_admin').addEvent('blur', function(event){
					$('fenetre_chat').setStyle('visibility', 'hidden');
         			$('onglet_chat').set('class', 'off onglet');
				});
				
                $('div_messages').empty();
                //on charge dedans le truc correspondant
                $('div_messages').set('load', {
                    onComplete: function(){
                        $('div_messages').scrollTop = 500000;
                    }
                });
                $('div_messages').load(item.get('href'));

                memo_nom = item.get('text');

                $('a_onglet_chat').set('text', 'Chat (' + memo_nom + ')');
				 if ($chk($(memo_nom)))
				 {
				 	$(memo_nom).setStyle('text-decoration', 'none');
                	$(memo_nom).setStyle('color', 'white');
				 }
                
            });
        });
        
        /* inutile sauf si on reveut un bouton fermer
         $('fermer_chat').addEvent('click', function(event){
         event.stop();
         $('fenetre_chat').setStyle('visibility', 'hidden');
         $('onglet_chat').set('class', 'off onglet');
         });
         */
		
        //on vérifie si il y a du nouveau message
        //on chope une première fois les ids
        var jsonRequest = new Request.JSON({
            url: "chat?action=id_dernier_message",
            onComplete: function(reponse){
                derniers_id = reponse;
                //puis on fait la fonction en boucle	
                refreshChatAdmin();
                refreshChatAdmin.periodical(5000); //5 seconces			
            }
        }).send();
        
        var refreshChatAdmin = function(){
            var jsonRequest = new Request.JSON({
                url: "chat?action=id_dernier_message",
                onComplete: function(reponse){
					//if ($chk($(reponse)))
					//{
                    if (reponse.toSource() !== derniers_id.toSource()) {
                        //alert(reponse);
                        for (i in reponse) {
                            if (reponse[i] != derniers_id[i]) {
                                //alert(i+" = "+reponse[i]);
                                if ($chk($(i))) {
                                    $(i).setStyle('text-decoration', 'blink');
                                    $(i).setStyle('color', '#FFFF00');
                                }
                                
                            }
                            
                        }
                        derniers_id = reponse;
                        rechargeFenetre(1);
                    }
                	//}
                }
            }).send();
        };
        
        function rechargeAvecAlert(){
            var jsonRequest = new Request.JSON({
                url: "chat?action=id_dernier_message",
                onComplete: function(reponse){
                    if (reponse.toSource() !== derniers_id.toSource()) {
                        //alert(reponse);
                        for (i in reponse) {
                            if (reponse[i] != derniers_id[i]) {
                                //alert(i+" = "+reponse[i]);
                                if ($chk($(i))) {
                                    $(i).setStyle('text-decoration', 'blink');
                                    $(i).setStyle('color', '#FFFF00');
                                }
                                
                            }
                            
                            $(memo_nom).setStyle('text-decoration', 'none');
                            $(memo_nom).setStyle('color', 'white');
                            
                        }
                        derniers_id = reponse;
                        rechargeFenetre(1);
                    }
                }
                
            }).send();
        };
        
        //function qui recharge la fenetre
        function rechargeFenetre(alert){
            $('div_messages').set('load', {
                onComplete: function(){
                    $('div_messages').scrollTop = 500000;
                }
            });
            $('div_messages').load("chat?action=" + memo_liste + "&id=" + memo_id);
        }
        
        //envoie du form
        $('submit_form').addEvent('click', function(event){
            event.stop();
            if (memo_liste != 0) {
                $(memo_nom).setStyle('text-decoration', 'none');
                var myHTMLRequest = new Request.HTML({
                    url: 'chat?liste=' + memo_liste + '&id=' + memo_id,
                    onComplete: function(reponse){
                        $('text_chat_admin').setProperty('value', '');
                        rechargeAvecAlert();
                    },
                }).post($('form_chat'));
            }
        });
        
        //fonction qui recharge la liste des connectes
        //var rechargeOnline = function () {
        //	$('liste_connectes').load("chat?action=liste_connectes");
        //}
        //rechargeOnline.periodical(10000);		
        
        var rechargeOnline = function(){
            var requetr = new Request.JSON({
                url: "chat?action=liste_connectes",
                onComplete: function(reponse){
                    for (i in reponse) {
                        //alert(i+reponse[i]);	  
                        var d = new Date();
						var d2 = new Date();
						d2.setTime(reponse[i]*1000);
						var h=d2.getHours();
						var m=d2.getMinutes();
						if (m<10) {m = "0" + m}
						var s=d2.getSeconds();
						if (s<10) {s = "0" + s}
						var date=h+'h'+m+':'+s;
						
						d2.setTime(reponse[i]*1000);
                        //si encore en ligne
                        if (parseInt(reponse[i])*1000 > parseInt(d.getTime() - 40000)) {
                            if ($chk($('div_de_'+i)))
							{
								$('div_de_'+i).set('class', 'online');
								$('span_de_'+i).set('text', ' - '+date);
							}	
                        }
						else
						{
							if ($chk($('div_de_'+i)))
							{
								$('div_de_'+i).set('class', 'offline');
								$('span_de_'+i).set('text', ' - '+date);
							}	
						}
                    }
                },
            }).send();
        };
        rechargeOnline();
		rechargeOnline.periodical(10000);
        
        //on ajoute l'event pour enlever le clignotant qd on parle
        $('text_chat_admin').addEvent('click', function(event){
            if ($chk($(memo_nom))) 
                $(memo_nom).setStyle('text-decoration', 'none');
            $(memo_nom).setStyle('color', 'white');
        });
        
        //lien de l'onglet
        $('onglet_chat').addEvent('click', function(event){
            event.stop();
            if ($('onglet_chat').get('class') == 'info onglet') {
                $('fenetre_chat').setStyle('visibility', 'hidden');
                $('onglet_chat').set('class', 'off onglet');
            }
            else {
                $('fenetre_chat').setStyle('visibility', 'visible');
                $('onglet_chat').set('class', 'info onglet');
				$('text_chat_admin').focus();
            }
        });
        
        
        
        
    }
    
    
    
});
