<?php

/*
 * 
 * Auteur : SoX <flosox@gmail.com>
 * Modification : 21/04/09 par SoX
 * 
 * Description : Gestion des requêtes MySQL
 * 
 */

class sql
{
  // Le constructeur se connecte directement à la base
  public function __construct()
  {
    global $config;
    $link = mysql_connect($config['database']['host'], $config['database']['user'], $config['database']['pass']);
    mysql_select_db($config['database']['base']);
	if (!$link)
    {
      die('Impossible de se connecter : ' . mysql_error());
    }
  }

  // Le destructeur clos la connection
  public function __destruct()
  {
    mysql_close();
  }

  /*
   * Exemple : $sql->select('id', 'user', "WHERE nom='toto'");
   * Retour : Tableau a simple ou double entree
   */
  public function select($field, $table, $option='')
  {
  	$query = mysql_query('SELECT '.$field.' FROM '.$table.' '.$option);
	if (!$query) {
      die('Impossible d\'exécuter la requête : ' . mysql_error());
    }
	// S'il n'y a de ligne, renvoi de 0
    if(mysql_num_rows($query)===0)
      return 0;
	// S'il n'y a qu'une ligne, renvoi direct du tableau
    elseif(mysql_num_rows($query)===1)
	{
      $result = mysql_fetch_assoc($query);
	}
	// Sinon creation d'un tableau a double entree
	else
	  $result = array();
	  while ($table = mysql_fetch_assoc($query))
	  {
	  	$result[]=$table;
	  }
	//S'il n'y a qu'un champ demande
	if (substr_count($field, ',')===0 && $field !='*')
	{
	  $tmp = array();
	  if(array_key_exists($field, $result))
        $tmp[] = $result[$field];
      else
        foreach($result as $value)
        {
          $tmp[] = $value[$field];
        }
	  $result = $tmp;
	}
	return $result;	
  }

  /*
   * Exemple : $sql->select_count('id', 'user', "WHERE nom='toto'");
   * Retour : Entier
   */  
  public function select_count($field, $table, $option='')
  {
  	$query = mysql_query('SELECT COUNT('.$field.') FROM `'.$table.'` '.$option);
	if (!$query) {
      die('Impossible d\'exécuter la requête : ' . mysql_error());
    }
    $result = mysql_result($query, 0);
	return $result;	
  }

  /*
   * Exemple : $sql->insert('user', '`nom`, `prenom`', "'durand', toto'");
   */
  public function insert($table, $field, $value)
  {
  	$query = mysql_query('INSERT INTO `'.$table.'` ('.$field.') VALUES ('.$value.')');
  	if (!$query) {
      die('Impossible d\'exécuter la requête : ' . mysql_error());
    }
  }
  
  /*
   * Exemple : $sql->update('user', "`nom` = 'durand', `prenom` = 'toto'", '`id`=5');
   */
  public function update($table, $changement, $where)
  {
  	$query = mysql_query('UPDATE `'.$table.'` SET '.$changement.' WHERE '.$where);
  	if (!$query) {
      die('Impossible d\'exécuter la requête : ' . mysql_error());
    }
  }

  /*
   * Exemple : $sql->delete('user', '`id`=5');
   */
  public function delete($table, $where)
  {
  	$query = mysql_query('DELETE FROM `'.$table.'` WHERE '.$where);
  	if (!$query) {
      die('Impossible d\'exécuter la requête : ' . mysql_error());
    }
  }
  
  /*
   * Exemple : $sql->query(');
   */
  public function query($query)
  {
  	$query = mysql_query($query);
  	if (!$query) {
      die('Impossible d\'exécuter la requête : ' . mysql_error());
    }
	return $query;
  }
}
?>
