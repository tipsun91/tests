<?php

namespace App\Component;


class EntityManager
{
    /**
     * $db PDO
     */
    private $db;

    private function db()
    {
        if (null === $this->db) {
            $this->db = new \PDO('mysql:dbname=test;host=127.0.0.1;', 'root', '');
        }

        return $this->db;
    }

    protected function load($sql, $args=[])
    {
        $query = $this->db()->prepare($sql);

        if ($query && $query->execute($args)) {
            return $query;
        } else {
            return false;
        }
    }
}