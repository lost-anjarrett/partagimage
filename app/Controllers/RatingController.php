<?php
namespace Projet\Controllers;

use \System\Controller;
use Projet\Models\Rating;

class RatingController extends Controller
{
    public function rate($id)
    {
        if (isset($_POST['rating']) && isLogged()) {
            verifyToken();

            extract($_POST);

            $postedRate = (new Rating)->setPostId($id)
                    ->setAuthorId($_SESSION['userId']);

            $checkedRate = $postedRate->checkIfRated();

            if ($checkedRate) {
                $checkedRate->setRating($rating)->update();
            }
            else {
                $postedRate->setRating($rating)->create();
            }
            ob_start();
            include(__DIR__.'/../../ressources/views/rating/rate_result.phtml');
            $view = ob_get_contents();

            ob_get_clean();

            return $view;
        }

        return 'une erreur s\'est produite';
    }
}
