<?php
namespace Projet\Models;

use System\Model;
use Projet\Models\User;
use Projet\Models\Comment;
use Projet\Traits\HasAuthor;

class Post extends Model
{
    use HasAuthor;

    const TABLE = 'posts';

    protected $author_id;
    protected $title;
    protected $description;
    protected $drawing_src;
    protected $nb_comments;
    protected $rating_avg;
    protected $created_at;
    protected $updated_at;


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getAuthorId()
    {
        return $this->author_id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getDrawingSrc()
    {
        return url('uploads/drawings/'.$this->drawing_src);
    }

    public function getFileName()
    {
        return $this->drawing_src;
    }

    public function getNbComments()
    {
        return $this->nb_comments;
    }

    public function getRatingAvg()
    {
        return $this->rating_avg;
    }

    /**
     * @return mixed
     */
     public function getCreatedAt()
     {
         return $this->created_at;
     }

    /**
     * @return mixed
     */
     public function getUpdatedAt()
     {
         return $this->updated_at;
     }

    /**
     * @param mixed $author_id
     * @return $this
     */
    public function setAuthorId($author_id)
    {
        $this->author_id = $author_id;
        return $this;
    }

    /**
     * @param mixed $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param mixed $content
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @param mixed $content
     * @return $this
     */
    public function setDrawingSrc($src)
    {
        $this->drawing_src = $src;
        return $this;
    }

    public function setRatingAvg($avg)
    {
        $this->rating_avg = $avg;
        return $this;
    }

    public function increaseNbComments()
    {
        $this->nb_comments ++;
        return $this;
    }


    public function decreaseNbComments()
    {
        $this->nb_comments --;
        return $this;
    }



}
