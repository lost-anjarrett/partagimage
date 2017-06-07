<?php
namespace System;


class Controller
{
    public function view($template, $data = [])
    {
        // On supprime certains caractères spéciaux pour éviter qu'un utilisateur malveillant puisse atteindre un fichier qui ne soit pas situé dans /views
        $template = str_replace(['../', ';', '%' ], '', $template);
        $data = str_replace(['../', ';', '%' ], '', $data);
        extract($data);
        // On "ouvre" le cache
        ob_start();
        // On charge le layout (+ le template enfant) dans le cache
        include(__DIR__.'/../ressources/views/layout.phtml');
        // On renvoie le contenu généré et vide le cache
        $view = ob_get_contents();

        ob_get_clean();

        return $view;
    }

    public function redirect($location)
    {
        header('location: '.$location);
        exit;
    }
}
