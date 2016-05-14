<?php
$chat = new chat();

//si on vient du form
if(isset($_POST['text_chat']))
{
  $chat->enregistrer_message($_GET['liste'], $_GET['id']);
}

//si on est en rechargement ajax
elseif(isset($_GET['action']) AND $_GET['action'] == 'liste_connectes')
{
  $chat->encore_connecte();
}
elseif(isset($_GET['action']) AND $_GET['action'] == 'liste_messages')
{
  $chat->liste_messages();
}
elseif(isset($_GET['action']) AND $_GET['action'] == 'id_dernier_message')
{
  $chat->Json_id_dernier_message();
  
}
elseif(isset($_GET['action']) AND $_GET['action'] == 'toliste')
{
  $chat->liste_messages_toliste($_GET['id']);
  
}
elseif(isset($_GET['action']) AND $_GET['action'] == 'toqqn')
{
  $chat->liste_messages_toqqn($_GET['id']);
  
}
elseif(isset($_GET['action']) AND $_GET['action'] == 'rappel_connexion')
{
  $chat->rappel_connexion();
  
}
else
{
  $chat->afficheChat();
}



?>
