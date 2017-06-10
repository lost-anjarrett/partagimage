<?php
namespace Projet\Models;

use System\Model;

class Rating extends Model
{
    const TABLE = 'ratings';

    protected $post_id;
    protected $author_id;
    protected $rating;
    protected $created_at;
    protected $updated_at;

    public function getPostId()
    {
        return $this->post_id ;
    }

    public function getAuthorId()
    {
        return $this->author_id ;
    }

    public function getRating()
    {
        return $this->rating ;
    }

    public function getCreatedAt()
    {
        return $this->created_at ;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at ;
    }

    public function setPostId($id)
    {
        $this->post_id = $id ;
        return $this;
    }

    public function setAuthorId($id)
    {
        $this->author_id = $id ;
        return $this;
    }

    public function setRating($rating)
    {
        $this->rating = $rating ;
        return $this;
    }

    public function setCreatedAt($date)
    {
        $this->created_at = $date ;
        return $this;
    }

    public function setUpdatedAt($date)
    {
        $this->updated_at = $date ;
        return $this;
    }

    public function checkIfRated()
    {
        $result =  $this->db->queryOne("SELECT * FROM ".static::TABLE." WHERE post_id = ? AND author_id = ?", [$this->post_id, $this->author_id]);

        return $this->getInstance($result);
    }

    public function getAvg()
    {
        $avg = $this->db->queryOne("SELECT AVG(rating) AS avg FROM ".static::TABLE." WHERE post_id = ?", [$this->post_id]);
        return round($avg['avg']);
    }

    public function getNbRatings()
    {
        $count = $this->db->queryOne("SELECT COUNT(rating) AS nbr FROM ".static::TABLE." WHERE post_id = ?", [$this->post_id]);
        return round($count['nbr']);
    }

    public function create()
    {
        parent::create();
        $avg = $this->getAvg();
        $count = $this->getNbRatings();
        (new Post)->find($this->post_id)
                ->setRatingAvg($avg)
                ->setNbRatings($count)
                ->update();
    }

    public function update()
    {
        parent::update();
        $avg = $this->getAvg();
        $count = $this->getNbRatings();
        (new Post)->find($this->post_id)
                ->setRatingAvg($avg)
                ->setNbRatings($count)
                ->update();
    }
}
