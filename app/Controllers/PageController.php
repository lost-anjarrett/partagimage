<?php
namespace Projet\Controllers;

use Projet\Models\Post;
use Projet\Models\Rating;
use \System\Controller;

class PageController extends Controller
{
    // @get index.php/home
    public function index()
    {
        $title = 'Accueil';
        $posts = (new Post)->getAllWithAuthor();
        $lastDrawings = (new Post)->getLasts(3);
        $data = compact('title', 'posts', 'lastDrawings');
        return $this->view('pages/home', $data);
	}


}
