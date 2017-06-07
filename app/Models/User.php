<?php
namespace Projet\Models;

use System\Model;
use DateTime;

 class User extends Model
 {
     const TABLE = 'users';

     protected $name;
     protected $email;
     protected $dob;
     protected $password;
     protected $created_at;
     protected $updated_at;

     /**
      * @return mixed
      */
     public function getId()
     {
         return $this->id;
     }

     public function getName()
     {
         return $this->name;
     }

     public function getEmail()
     {
         return $this->email;
     }

     public function getDob()
     {
         return $this->dob;
     }

     public function getPassword()
     {
         return $this->password;
     }

     public function getCreatedAt()
     {
         return $this->created_at;
     }

     public function getUpdatedAt()
     {
         return $this->updated_at;
     }

     public function getUrlAttribute()
     {
         return 'user/'.$this->id;
     }

     /**
      * @param mixed $name
      * @return $this
      */
     public function setName($name)
     {
         $this->name = $name;
         return $this;
     }

     /**
      * @param mixed $email
      * @return $this
      */
     public function setEmail($email)
     {
         $emailRegexp = '#^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$#';
         // filter_var($email_a, FILTER_VALIDATE_EMAIL) est beaucoup plus simple qu'une regexp...
         if (preg_match($emailRegexp, $email)) {
             $this->email = $email;
         }
         return $this;
     }

     /**
      * @param mixed $dob
      * @return $this
      */
     public function setBirthday($dob)
     {
         $dobRegexp = '#^\d{4}-[01]\d-[0123]\d$#';
         if (preg_match($dobRegexp, $dob)) {
             $this->dob = $dob;
         }
         return $this;
     }

     /**
      * @param mixed $password
      * @return $this
      */
     public function setPassword($password)
     {
         $this->password = password_hash($password, PASSWORD_BCRYPT);
         return $this;
     }

     public function getAge()
     {
         $today = new DateTime('NOW');
         $userDOB= new DateTime($this->dob);
         return $today->diff($userDOB)->y;
     }

     public function isUser()
     {
         return $this->id == $_SESSION['userId'];
     }
 }
