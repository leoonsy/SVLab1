<?php
namespace app\model;

class Note {
    public $id;
    public $userId;
    public $name;
    public $description;
    public $date;

    public function setNote($id, $userId, $name, $description, $date) {
        $this->id = $id;
        $this->userId = $userId;
        $this->name = $name;
        $this->description = $description;
        $this->date = $date;
    }
}