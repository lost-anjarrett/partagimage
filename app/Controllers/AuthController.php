<?php
namespace Projet\Controllers;

use Projet\Models\User;
use \System\Controller;

class AuthController extends Controller
{
    public function register()
    {
        if (isset($_POST) && !empty($_POST)) {
            extract($_POST);
            $errors = [];

            if (strlen($username) < 3 || strlen($username) > 20) {
                $errors[] = 'Le nom d\'utilisateur doit faire entre 3 et 20 caractères';
            }
            if (!ctype_alnum($username)) {
                $errors[] = 'Le nom d\'utilisateur doit contenir uniquement des caractères alphanumériques';
            }
            if ((new User)->findOneBy('name', $username)) {
                $errors[] = 'Ce nom d\'utilisateur existe déjà';
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Votre adresse email n\'est pas valide';
            }
            if ((new User)->findOneBy('email', $email)) {
                $errors[] = 'Il y a déjà un compte qui utilise cette adresse email';
            }
            if ($password == '') {
                $errors[] = 'Vous devez choisir un mot de passe';
            }
            if ($password != $confirmPassword) {
                $errors[] = 'Les mots de passe ne correspondent pas';
            }

            if (empty($errors)) {
                $user = (new User)->setName($username)
                    ->setEmail($email)
                    ->setBirthday( formatDate($year, $month, $day) )
                    ->setPassword($password)
                    ->create();
                $this->redirect('login');
            }

        }

        $title = 'Inscription';
        $data = compact('title', 'errors');
        return $this->view('auth/register', $data);
    }

    public function login()
    {
        if (isset($_POST) && !empty($_POST)) {
            extract($_POST);
            $user = (new User)->findOneBy('name', $username);

            if (!$user || !password_verify($password, $user->getPassword()) ) {
                $error = 'Le nom d\'utilisateur n\'existe pas ou le mot de passe est incorrect';
            }

            if(!isset($error)) {
                session_start();
                $_SESSION['userId'] = $user->getId();
                $_SESSION['csrf_token'] = randString(50);
                $this->redirect('home');
            }
        }


        $title = 'Connexion';
        $data = compact('title', 'error');
        return $this->view('auth/login', $data);
    }

    public function logout()
    {
        $_SESSION = [];

        session_destroy();

        $this->redirect('home');
    }
}
