<?php
namespace src\models;
use \core\Model;

class User extends Model {
    protected int $id;
    protected string $name;
    protected string $email;
    protected string $avatar;
    protected string $birthdate;
    protected string $city;
    protected string $work;
    protected string $cover;

    public function __construct($id = null, $name = '', $email = '', $avatar = '', $birthdate = '', $city = '', $work = '', $cover = ''){
        $this->setId($id);
        $this->setName($name);
        $this->setEmail($email);
        $this->setAvatar($avatar);
        $this->setBirthDate($birthdate);
        $this->setCity($city);
        $this->setWork($work);
        $this->setCover($cover);
    }

    //SETs
    public function setId($id){
        $this->id = intval($id);
    }

    public function setName($name){
        $this->name = $name;
    }

    public function setEmail($email){
        $this->email = $email;
    }
    
    public function setAvatar($avatar){
        $this->avatar = $avatar;
    }
    
    public function setBirthDate($birthdate){
        $this->birthdate = $birthdate;
    }

    public function setCity($city){
        $this->city = $city;
    }

    public function setWork($work){
        $this->work = $work;
    }
    
    public function setCover($cover){
        $this->cover = $cover;
    }


    //GETs
    public function getId(){
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getAvatar(){
        return $this->avatar;
    }

    public function getCity(){
        return $this->city;
    }
    
    public function getWork(){
        return $this->work;
    }

    public function getCover(){
        return $this->cover;
    }
}