<?php
namespace Projet\Controllers;

use \System\Controller;
use Projet\Models\Post;
use Projet\Models\Comment;

class PostController extends Controller
{
    public function create()
    {
        if (!isLogged()) {
            redirect('../login');
        }

        if (isset($_POST) && !empty($_POST)) {
            verifyToken();

            extract($_POST);
            $img = $drawing;

    		$fileName = randString(20).'.png'; // La fonction randString est dans le fichier app/helpers.php

    	    $this->saveImgToFile($img, $fileName);

            // Enregistrement en BD
            $post = (new Post)->setAuthorId($_SESSION['userId'])
                    ->setTitle($title)
                    ->setDescription($description)
                    ->setDrawingSrc($fileName)
                    ->create();
            $this->redirect('../home');
        }


        $title = 'New Post';
        $data = compact('title');
        return $this->view('post/form', $data);
    }

    public function destroy($id)
    {
        if (!empty($_POST)) {
            verifyToken();
        }

        $post = (new Post)->find($id);

        if (!$post->isAuthor()) {
            die('Vous n\'êtes pas l\'auteur de ce post');
        }

        unlink('uploads/drawings/'.$post->getFileName());
        $post->delete();

        $this->redirect('../../home');
    }

    public function update($id)
    {
        $post = (new Post)->find($id);

        if (isset($_POST) && !empty($_POST)) {
            verifyToken();

            extract($_POST);
            $img = $drawing;

    		$fileName = str_replace(url('uploads/drawings/'), '', $_POST['drawing_src']);

    	    if ($this->saveImgToFile($img, $fileName) !== false) {
                // Update en BD
                $post->setTitle($title)
                        ->setDescription($description)
                        ->update();
                $this->redirect('../../home');
            }
            else {
                echo 'pedidebroblemeu';
            }
        }

        $title = 'Modifier un Post';
        $data = compact('title', 'post');
        return $this->view('post/form', $data);
    }

    protected function saveImgToFile($img, $fileName)
    {
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $fileData = base64_decode($img);
        // sauvegarde dans le dossier uploads/drawings/
         return file_put_contents(__DIR__.'/../../uploads/drawings/'.$fileName, $fileData);
    }

    public function show($id)
    {
        $post = (new Post)->getOneWithAuthor($id);
        $title = $post->getTitle();
        $comments = (new Comment)->getAllWithAuthor("WHERE post_id = ?", [$id]);

        $data = compact('title', 'post', 'comments');
        return $this->view('post/single', $data);
    }
}
