<?php
namespace Projet\Models;

use System\Model;
use Projet\Models\User;
use Projet\Models\Post;
use Projet\Traits\HasAuthor;

class Comment extends Model
{
    use HasAuthor;

    const TABLE = 'comments';

    protected $author_id;
    protected $post_id;
    protected $content;
    protected $created_at;
    protected $updated_at;

    public function getId()
    {
        return $this->id ;
    }

    public function getAuthorId()
    {
        return $this->author_id ;
    }

    public function getPostId()
    {
        return $this->post_id ;
    }

    public function getContent()
    {
        return $this->content ;
    }

    public function getCreatedAt()
    {
        return $this->created_at ;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at ;
    }

    public function setId($id)
    {
        $this->id = $id ;
        return $this;
    }

    public function setAuthorId($id)
    {
        $this->author_id = $id ;
        return $this;
    }

    public function setPostId($id)
    {
        $this->post_id = $id ;
        return $this;
    }

    public function setContent($content)
    {
        $this->content = $content ;
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

    public function findAllByPost($id)
    {
        $comments = $this->db->query("SELECT * FROM ".static::TABLE." WHERE post_id = ? ORDER BY created_at DESC", [$id]);

        return $this->getCollection($comments);
    }

    public function create()
    {
        parent::create();
        $post = (new Post)->find($this->post_id);
        $post->increaseNbComments()
                ->update();
    }

    public function delete()
    {
        $post = (new Post)->find($this->post_id);
        $post->decreaseNbComments()
                ->update();
        parent::delete();
    }
}
