<?php
namespace Projet\Traits;

use Projet\Models\User;

trait HasAuthor
{
    protected $author;

    public function getAuthor()
    {
        return $this->author;
    }

    public function setAuthor(User $user)
    {
        $this->author = $user;
        return $this;
    }

    public function isAuthor()
    {
        return $_SESSION['userId'] == $this->author_id;
    }

    protected function getAuthorsFromQuery($query)
    {
         foreach ($query as $index => $line) {

             $query[$index] = $this->getAuthorFromQueryOne($line);
         }
         return $query;
    }

    protected function getAuthorFromQueryOne($query)
    {
         $query['author'] = [];

         foreach ($query as $key => $value) {
             if (strpos($key, 'user_') === 0) {
                 $query['author'][str_replace('user_', '', $key)] = $value;
                 unset($query[$key]);
             }
         }

         $query['author'] = (new User)->getInstance( $query['author'] );

         return $query;
     }

     protected function getUserParamsList()
     {
         $props = User::getColumns();

         foreach ($props as $index => $prop) {
             $props[$index] = 'u.'.$prop.' AS user_'.$prop;
         }
         return implode(', ', $props);
     }

     /**
      *  Cette fonction a pour but de réunir les champs relatifs à user
      *  en un seul champ author qui contiendra une instance de User
      *  sous réserve que la requête SQL les renvoie aliasé sous la forme
      *  user_nomduchamp
      */
    public function getAllWithAuthor($condition = '', $value = [])
    {
        $paramsList = $this->getUserParamsList();

        $posts = $this->db
            ->query("SELECT ".static::TABLE.".*, ".$paramsList."
                       FROM ".static::TABLE."
                       INNER JOIN users AS u ON ".static::TABLE.".author_id = u.id
                       ".$condition."
                       ORDER BY created_at DESC", $value);

        return $this->getCollection( $this->getAuthorsFromQuery($posts) );
    }

    public function getOneWithAuthor($id)
    {
        $paramsList = $this->getUserParamsList();

        $post = $this->db
            ->queryOne("SELECT t.*, ".$paramsList."
                       FROM ".static::TABLE." AS t
                       INNER JOIN users AS u ON t.author_id = u.id
                       WHERE t.id = ?", [$id]);

        return $this->getInstance( $this->getAuthorFromQueryOne($post) );
    }

    public function findAllByAuthor($id)
    {
        $posts = $this->db->query("SELECT * FROM ".static::TABLE." WHERE author_id = ? ORDER BY created_at DESC", [$id]);

        return $this->getCollection($posts);
    }


}
