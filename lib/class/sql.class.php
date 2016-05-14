<?php

/**
 * Wrapper autour des fonctions mysql_*
 *
 * @todo: Migrer vers mysqli_* pour supporter PHP7.
 */
class SQL
{
    /**
     * Connexion à la base de données.
     */
    public function __construct()
    {
        global $config;

        $this->link = mysql_connect($config['database']['host'], $config['database']['user'], $config['database']['pass']);
        mysql_select_db($config['database']['base']);
        if (!$this->link) {
            die('Impossible de se connecter à la base de données: '.mysql_error());
        }
    }

    /**
     * Fermeture propre de la connexion à MySQL.
     */
    public function __destruct()
    {
        mysql_close();
    }

    /**
     * Récupération de valeurs depuis une table.
     *
     * @todo   Retourner null en cas d'aucun résultat.
     * @todo   Vérifier le comportement en cas d'un seul résultat, il devrait être
     *         retourné directement.
     *
     * @param  string $field
     * @param  string $table
     * @param  string $where
     * @return int|array
     */
    public function select($field, $table, $where = '')
    {
        $query = mysql_query('SELECT '.$field.' FROM `'.$table.'` '.$where);

        $this->checkError($query);

        // Si jamais la requête n'a rien retourné, on renvoie 0.
        // S'il y a eu un résultat, on renvoie directement celui-ci.
        // Sinon, on crée un tableau qui va recevoir les résultats.
        // XXX: Voir commentaire du docblock de la méthode.
        if (mysql_num_rows($query) === 0) {
            return 0;
        } elseif (mysql_num_rows($query) === 1) {
            $result = mysql_fetch_assoc($query);
        } else {
            $result = [];
        }

        while ($table = mysql_fetch_assoc($query)) {
            $result[] = $table;
        }

        //S'il n'y a qu'un champ demandé et qu'il n'est pas *,
        if (substr_count($field, ',') === 0 && $field != '*') {
            $tmp = [];
            if (array_key_exists($field, $result)) {
                $tmp[] = $result[$field];
            } else {
                foreach ($result as $value) {
                    $tmp[] = $value[$field];
                }
            }
            $result = $tmp;
        }

        return $result;
    }

    /**
     * Retourne le nombre de résultats pour un champ donné.
     *
     * @param  string $field
     * @param  string $table
     * @param  string $clause
     * @return int
     */
    public function select_count($field, $table, $where = '')
    {
        $query = mysql_query('SELECT COUNT('.$field.') FROM `'.$table.'` '.$where);

        $this->checkError($query);

        $result = mysql_result($query, 0);

        return $result;
    }

    /**
     * Insère une nouvelle entrée dans une table.
     *
     * @param string $table
     * @param string $field
     * @param string $values
     */
    public function insert($table, $field, $values)
    {
        $query = mysql_query('INSERT INTO `'.$table.'` ('.$field.') VALUES ('.$values.')');

        $this->checkError($query);
    }

    /**
     *  Mise à jour d'une entrée d'une des tables.
     *
     * @param string $table
     * @param string $newValue
     * @param string $where
     */
    public function update($table, $newValue, $where)
    {
        $query = mysql_query('UPDATE `'.$table.'` SET '.$newValue.' WHERE '.$where);

        $this->checkError($query);
    }

    /**
     * Supprime une entrée d'une des tables.
     *
     * @param string $table
     * @param string $where
     */
    public function delete($table, $where)
    {
        $query = mysql_query('DELETE FROM `'.$table.'` WHERE '.$where);

        $this->checkError($query);
    }

    /**
     * Requête « raw », directement passée à la base de données.
     *
     * @param  string    $query
     * @return ressource Resultat de la requête sous forme de ressource
     */
    public function query($query)
    {
        $query = mysql_query($query);

        $this->checkError($query);

        return $query;
    }

    /**
     * Gestion des éventuelles erreurs sur des requêtes.
     *
     * @param mixed $query
     */
    protected function checkError($query)
    {
        if (!$query) {
            die('Impossible d\'exécuter la requête : '.mysql_error());
        }
    }
}
