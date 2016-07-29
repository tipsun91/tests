<?php

namespace App\Entity;


class CommentEntity
{
    private $idi;
    private $ide;

    private $text;
    private $date;

    private $level = 0;


    /**
     * @param mixed $idi
     */
    public function __construct($idi=null)
    {
        $this->idi = $idi;
    }

    /**
     * @return mixed
     */
    public function getIdi()
    {
        return $this->idi;
    }


    /**
     * @param mixed $ide
     */
    public function setIde($ide)
    {
        $this->ide = $ide;
    }

    /**
     * @return mixed
     */
    public function getIde()
    {
        return $this->ide;
    }


    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }


    /**
     *
     */
    public function setDate($date)
    {
        $this->date = new \DateTime($date);
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }


    /**
     * @param mixed $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }

    /**
     * @return mixed
     */
    public function getLevel()
    {
        return $this->level;
    }
}
