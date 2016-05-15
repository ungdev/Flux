<?php

namespace lib;

/**
 * Wrapper autour des fonctions mysqli_*.
 */
class SQL
{
    /**
     * Connexion à la base de données.
     */
    public function __construct()
    {
        global $config;

        $this->link = mysqli_connect($config['database']['host'], $config['database']['user'], $config['database']['pass']);
        mysqli_set_charset($this->link, 'utf8');

        if (!$this->link) {
            die('Impossible de se connecter à la base de données: '.($this->link ? mysqli_error($this->link) : (($err = mysqli_connect_error()) ? $err : false)));
        }

        mysqli_query($this->link, 'USE '.$config['database']['base']);
    }

    /**
     * Fermeture propre de la connexion à MySQL.
     */
    public function __destruct()
    {
        if ($this->link) {
            mysqli_close($this->link);
        }
    }

    /**
     * Récupération de valeurs depuis une table.
     *
     * @todo   Retourner null en cas d'aucun résultat.
     * @todo   Vérifier le comportement en cas d'un seul résultat, il devrait être
     *         retourné directement.
     *
     * @param string $field
     * @param string $table
     * @param string $where
     *
     * @return int|array
     */
    public function select($field, $table, $where = '')
    {
        $query = mysqli_query($this->link, 'SELECT '.$field.' FROM '.$table.' '.$where);
        $this->checkError($query);

        // Si jamais la requête n'a rien retourné, on renvoie 0.
        // S'il y a eu un résultat, on renvoie directement celui-ci.
        // Sinon, on crée un tableau qui va recevoir les résultats.
        // XXX: Voir commentaire du docblock de la méthode.
        if (mysqli_num_rows($query) === 0) {
            return 0;
        } else {
            $result = [];
        }

        while ($table = mysqli_fetch_assoc($query)) {
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
     * @param string $field
     * @param string $table
     * @param string $clause
     *
     * @return int
     */
    public function select_count($field, $table, $where = '')
    {
        $query = mysqli_query($this->link, 'SELECT COUNT('.$field.') as count FROM '.$table.' '.$where);

        $this->checkError($query);

        $result = $query->fetch_assoc()['count'];

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
        $query = mysqli_query($this->link, 'INSERT INTO '.$table.' ('.$field.') VALUES ('.$values.')');

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
        $query = mysqli_query($this->link, 'UPDATE '.$table.' SET '.$newValue.' WHERE '.$where);

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
        $query = mysqli_query($this->link, 'DELETE FROM '.$table.' WHERE '.$where);

        $this->checkError($query);
    }

    /**
     * Requête « raw », directement passée à la base de données.
     *
     * @param string $query
     *
     * @return ressource Resultat de la requête sous forme de ressource
     */
    public function query($query)
    {
        $query = mysqli_query($this->link, $query);

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
            die('Impossible d\'exécuter la requête : '.mysqli_error($this->link));
        }
    }
}
