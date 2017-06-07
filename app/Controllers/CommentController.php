<?php
namespace Projet\Controllers;

use \System\Controller;
use Projet\Models\Comment;

class CommentController extends Controller
{
    public function create($id)
    {
        if (!empty($_POST) && isLogged()) {
            verifyToken();

            extract($_POST);

            $comment = (new Comment)->setPostId($id)
                    ->setAuthorId($_SESSION['userId'])
                    ->setContent($content)
                    ->create();

        }

        $this->redirect('../'.$id);
    }
}
