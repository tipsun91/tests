<?php

namespace App\Model;


use App\Component\Model;


class AdjacencyList extends Model
{
    const TABLE = 'alist';

    private static $qtCount;
    private static $qtSelect;
    private static $qtInsert;
    private static $qtParents;
    private static $qtChildren;

    private static $isPrepared;
    private static $isLoaded;

    public function __construct()
    {
        if (! self::$isPrepared) {
            $this->prepareQueries();
            self::$isPrepared = true;
        }
        if (! self::$isLoaded) {
            $this->loadTreeData();
            self::$isLoaded = true;
        }
    }

    private function prepareQueries()
    {
        $table = self::TABLE;

        self::$qtCount = <<<QT
SELECT COUNT(1)
FROM {$table};
QT;

        self::$qtSelect = <<<QT
SELECT *
FROM {$table}
ORDER BY `pid` DESC;
QT;

        self::$qtInsert = <<<QT
INSERT INTO
{$table} (`id`, `pid`, `title`)
VALUE (:id, :pid, :title);
QT;

        self::$qtParents = <<<QT
SELECT
    `t0`.*
FROM (
    SELECT
        `t1`.`id`,
    	`t1`.`title`,
        COUNT(`t1`.`id`) AS `quantity`
    FROM
        {$table} as `t1`,
        {$table} as `t2`
    WHERE
        `t1`.`id` = `t2`.`pid`
    GROUP BY
        `t1`.`id`
) AS `t0`
WHERE
    `t0`.`quantity` >= 3
ORDER BY
    `t0`.`id`;
QT;

        self::$qtChildren = <<<QT
SELECT
    *
FROM
    {$table} AS `t0` 
WHERE
	0 < `t0`.`pid`
	AND `t0`.`pid` IS NOT NULL
	AND `t0`.`id` NOT IN (
		SELECT
		    `t1`.`pid`
		FROM
		    {$table} as `t1`
	)
	AND `t0`.`pid` IN (
		SELECT
		    `t2`.`id`
		FROM
		    {$table} as `t2`
		WHERE
			0 < `t2`.`pid`
			AND `t2`.`pid` IS NOT NULL
	)
QT;
    }

    public function count()
    {
        return $this->db()->query(self::$qtCount)->fetchColumn();
    }

    private function loadTreeData()
    {
        $items = [
            [1,0,'EEE'],
                [2,1,'KK'],
                [3,1,'LK'],
            [4,0,'RE'],
            [5,0,'LO'],
                [6,5,'EW'],
                [7,5,'FS'],
            [8,0,'DF'],
                [9,8,'JJJ'],
                    [10,9,'WW'],
                    [11,9,'LL'],
                        [12,11,'SS'],
                            [13,12,'SD'],
                            [14,12,'HR'],
                                [15,14,'JS'],
                                    [16,15,'PP'],
                                [17,14,'ET'],
                [18,8,'ED'],
                [19,8,'AC'],
            [20,0,'PPP'],
        ];

        $this->db()->beginTransaction();
        $q = $this->db()->prepare(self::$qtInsert);

        try {
            foreach ($items as $item) {
                $q->execute([
                    ':id'   => $item[0],
                    ':pid'   => $item[1],
                    ':title' => $item[2],
                ]);
            }
        } catch (\PDOException $e) {
            $this->db()->rollBack();
        }

        $this->db()->commit();
    }

    public function getTree()
    {
        $result = [];

        $items = $this->exemplary(self::$qtSelect);
        foreach ($items as $cell) {
            if (isset($result[$cell['id']])) {
                $cell['items'] = $result[$cell['id']];
                unset($result[$cell['id']]);
            }
            $result[$cell['pid']][$cell['id']] = $cell;
        }

        return $result;
    }

    public function getParents()
    {
        return $this->exemplary(self::$qtParents);
    }

    public function getChildren()
    {
        return $this->exemplary(self::$qtChildren);
    }

    private function exemplary($query)
    {
        $result = [];

        if (0 < $this->count()) {
            if (($q = $this->db()->query($query))) {
                $result = $q->fetchAll(\PDO::FETCH_ASSOC);
                $q->closeCursor();
            }
        }

        return $result;
    }
}