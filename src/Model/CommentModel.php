<?php

namespace App\Model;


use App\Component\EntityManager;
use App\Entity\CommentEntity;


class CommentModel extends EntityManager
{
    public static function getTable()
    {
        return 'comment';
    }

    public function count()
    {
        $sql = 'SELECT COUNT(1) FROM ' . self::getTable();

        $query = $this->load($sql);
        $result = $query->fetchColumn();
        $query->closeCursor();

        return $result;
    }

    public function get($idi)
    {
        $sql = 'SELECT * FROM ' . self::getTable()
             . ' WHERE `idi`=:idi';

        $query = $this->load($sql, [
            ':idi' => $idi,
        ]);

        if (0 < $query->rowCount()) {
            $result = $this->createEntity($query->fetch(\PDO::FETCH_ASSOC));
        } else {
            $result = false;
        }

        $query->closeCursor();

        return $result;
    }

    private function getAllForBuildTree()
    {
        $sql = 'SELECT * FROM ' . self::getTable() . ' ORDER BY `ide` DESC, `idi` ASC';

        $query = $this->load($sql);

        $result = [];
        if (0 < $query->rowCount()) {
            while (false !== ($data = $query->fetch(\PDO::FETCH_ASSOC))) {
                $result[] = $this->createEntity($data);
            }
        }

        $query->closeCursor();

        return $result;
    }

    public function getTree()
    {
        $comments = $this->getAllForBuildTree();

        $tree = [];
        foreach ($comments as $entity) {
            $children = null;
            if (isset($tree[$entity->getIdi()])) {
                $children = $tree[$entity->getIdi()];
                unset($tree[$entity->getIdi()]);
            }
            $ide = (int) $entity->getIde(); // convert NULL to Integer (zero).
            $tree[$ide][$entity->getIdi()] = [
                'entity' => $entity,
                'children' => $children
            ];
        }
        unset($comments);

        return $tree[0];
    }

    public function save(CommentEntity $entity)
    {
        if (null === $entity->getIdi()) {
            $sql = 'INSERT INTO ' . self::getTable()
                . ' (`idi`, `ide`, `text`, `date`, `level`) VALUE (:idi, :ide, :text, :date, :level);';
        } else {
            $sql = 'UPDATE ' . self::getTable()
                . ' SET `ide`=:ide, `text`=:text, `date`=:date, `level`=:level WHERE `idi`=:idi;';
        }

        $ide = (0 < $entity->getIde()) ? $entity->getIde() : null;

        $query = $this->load($sql, [
            ':idi'   => $entity->getIdi(),
            ':ide'   => $ide,
            ':text'  => $entity->getText(),
            ':date'  => $entity->getDate()->format('Y-m-d H:i:s'),
            ':level' => $entity->getLevel(),
        ]);
        $result = $query->rowCount();
        $query->closeCursor();

        return $result;
    }

    public function delete(CommentEntity $entity)
    {
        $sql = 'DELETE FROM ' . self::getTable()
             . ' WHERE `idi`=:idi';

        $query = $this->load($sql, [
            ':idi'   => $entity->getIdi()
        ]);
        $result = $query->rowCount();
        $query->closeCursor();

        return $result;
    }

    private function createEntity(array $data)
    {
        $ide = (0 < $data['ide']) ? $data['ide'] : null;

        $entity = new CommentEntity($data['idi']);
        $entity->setIde($ide);
        $entity->setText($data['text']);
        $entity->setDate($data['date']);
        $entity->setLevel($data['level']);

        return $entity;
    }
}