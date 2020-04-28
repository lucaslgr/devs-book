<?php
namespace src\models;
use \core\Model;

class User extends Model {
    protected int $id;
    protected string $name;
    protected string $email;

    public function __construct($id = null, $name = '', $email = ''){
        $this->setId($id);
        $this->setName($name);
        $this->setEmail($email);
    }

    public function setId($id){
        $this->id = intval($id);
    }

    public function setName($name){
        $this->name = $name;
    }

    public function setEmail($email){
        $this->email = $email;
    }
}