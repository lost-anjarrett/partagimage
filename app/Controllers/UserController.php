<?php
namespace Projet\Controllers;

use \System\Controller;
use Projet\Models\User;  // On importe la classe User (à vous de résoudre le bug qui se produira lors de l'importation)
use Projet\Models\Post;

class UserController extends Controller
{


	// Listera tous les membres inscrits
	// @get: index.php/users
	public function index()
    {
        $users = (new User)->findAll();
        $title = 'Liste des membres';

        $data = compact('title', 'users');

        return $this->view('user/list', $data);
	}

	// Afficher le profil d'un utilisateur
	// @get: index.php/user/{id}
	public function show($id)
    {  // $id est l'id de l'utilisateur dont on veut afficher le détail
        $user = (new User)->find($id);
        $title = ucfirst($user->getName());
		$posts = (new Post)->findAllByAuthor($id);

        $data = compact('title', 'user', 'posts');
        return $this->view('user/profile', $data);
	}

	public function update($id)
	{
		$user = (new User)->find($id);
		$title = 'Modifier votre profil';
		$errors = [];
		$success = '';

		if (isset($_POST['action'])){
			verifyToken();
			extract($_POST);

			switch ($action) {
				case 'name':
					if (strlen($name) < 3 || strlen($name) > 20) {
		                $errors[] = 'Le nom d\'utilisateur doit faire entre 3 et 20 caractères';
		            }
		            if (!ctype_alnum($name)) {
		                $errors[] = 'Le nom d\'utilisateur doit contenir uniquement des caractères alphanumériques';
		            }
		            if ((new User)->findOneBy('name', $name)) {
		                $errors[] = 'Ce nom d\'utilisateur existe déjà';
		            }
					$value = $name;
					break;

				case 'email':
		            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		                $errors[] = 'Votre adresse email n\'est pas valide';
		            }
		            if ((new User)->findOneBy('email', $email)) {
		                $errors[] = 'Il y a déjà un compte qui utilise cette adresse email';
		            }
					$value = $email;
					break;

				case 'password':
					if ( !password_verify($oldPassword, $user->getPassword()) ) {
						$errors[] = 'Le mot de passe est incorrect';
						break;
					}
		            if ($password == '') {
		                $errors[] = 'Vous devez choisir un mot de passe';
		            }
		            if ($password != $confirmPassword) {
		                $errors[] = 'Les mots de passe ne correspondent pas';
		            }
					$value = $password;
					break;
			}
			if(empty($errors)) {
				$method = 'set'.ucfirst($action);
				$user->$method($value);
				$user = $user->update();
				$success = 'Votre profil a bien été modifié !';
			}
		}

		$data = compact('title', 'user', 'errors', 'success');
		return $this->view('user/edit', $data);
	}

}
