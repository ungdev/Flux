<?php

$chat = new Chat();

//si on vient du form
if (array_key_exists('text_chat', $_POST)) {
    $liste = (isset($_GET['liste']))?$_GET['liste']:'';
    $id = (isset($_GET['id']))?$_GET['id']:'';
    $chat->enregistrer_message($liste, $id);
}

// On évite d'afficher une erreur de type notice suite à un éventuel switch sur
// un index qui n'existe pas.
if (!array_key_exists('action', $_GET)) {
    $chat->afficheChat();
} else {
    switch ($_GET['action']) {
    case 'liste_connectes':
      $chat->encore_connecte();
      break;

    case 'liste_messages':
      $chat->liste_messages();
      break;

    case 'id_dernier_message':
      $chat->Json_id_dernier_message();
      break;

    case 'toliste':
      if (!array_key_exists('id', $_GET)) {
          throw new InvalidArgumentException('Pas de valeur `id` pour Chat::liste_messages_toliste(id)');
      }
      $chat->liste_messages_toliste($_GET['id']);
      break;

    case 'toqqn':
      if (!array_key_exists('id', $_GET)) {
          throw new InvalidArgumentException('Pas de valeur `id` pour Chat::liste_messages_toqqn(id)');
      }
      $chat->liste_messages_toqqn($_GET['id']);
      break;

    case 'rappel_connexion':
      $chat->rappel_connexion();
      break;

    default:
      $chat->afficheChat();
  }
}
