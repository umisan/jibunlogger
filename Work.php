<?php

/**
 * Created by PhpStorm.
 * User: umino
 * Date: 17/01/15
 * Time: 17:46
 */
require_once "./database.php";
class Work
{
    public $userId;
    public $workName;
    public $startTime;
    public $endTime;
    public $color;

    function __construct($id, $name, $start, $end, $color)
    {
        //TODO nullではないことを保証する
        $this->userId = $id;
        $this->workName = $name;
        $this->startTime = $start;
        $this->endTime = $end;
        $this->color = $color;
    }

    public function addToDatabase()
    {
        $query = '';
        if($this->color === '')
        {
            $query = sprintf("INSERT INTO work(user_id, work_name, start_time, end_time) VALUES (\"%s\", \"%s\", \"%s\", \"%s\")",
                $this->userId,
                mysql_real_escape_string($this->workName),
                $this->startTime,
                $this->endTime);
        }else{
            $query = sprintf("INSERT INTO work VALUES (\"%s\", \"%s\", \"%s\", \"%s\, \"%s\")",
                $this->userId,
                mysql_real_escape_string($this->workName),
                $this->startTime,
                $this->endTime);
        }
        var_dump($query);
        $state = Database::issue($query);
        $insertedId = mysql_insert_id();

        $result = array(
            'state' => $state,
            'id' => $insertedId,
        );
        return $result;
    }
}