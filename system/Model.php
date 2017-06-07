<?php
namespace System;

use System\DB;

abstract class Model {

   protected $db;
   protected $id;

   public function __construct () {

       $this->db = new DB;

   }

   public function getId()
   {
       return $this->id;
   }

 /**
     * @return array
     */
    public function toArray(){
        //get_object_vars retourne un tab associatif avec les propriétés de l'objet (ex ['id' => 2, 'name' => 'Toto' ... ]

        $attributes = get_object_vars($this);

        unset($attributes['db']);  // On supprime l'index db qui ne fait pas référence à une colonne de table

        // array_filter élimine les entrées valant FALSE (comme null, '', 0 etc...)
        return array_filter($attributes);

    }

    public static function getColumns()
    {
        $properties = get_class_vars(static::class);
        unset($properties['db'], $properties['author']);
        return array_keys($properties);
    }

    /**
     * @return User
     */
    // Cette méthode permet de retrouver un utilisateur en bdd en fonction de son id et de le restitué sous forme d'objet de la classe User
    public function find($id){

        $result = $this->db->queryOne('SELECT * FROM ' . static::TABLE . ' WHERE id = ?', [$id]);   // $result est un tableau associatif

        return $this->getInstance($result);  // La méthode getInstance va transformer le tableau associatif result soit en objet de la classe User ou Post (ou autre class si on est dans un autre context)

    }

    // Cette méthode renvoit une collection d'objet de la classe User repésentant toutes les lignes (entrées) de la table users
    public function findAll(){

        $datas = $this->db->query('SELECT * FROM ' . static::TABLE);   // Renverra un tableau à 2 dimensions: http://conception.website/3wa/PHP/Cours/fetchAll.jpg

        return $this->getCollection($datas);

    }

    public function findOneBy($column, $value)
    {
        // Sécurisation du paramètre en autorisant uniquement les caractère alphanumérique ou _
		$this->checkColumn($column);

        $result = $this->db->queryOne('SELECT * FROM ' . static::TABLE . ' WHERE '.$column.' = ?', [$value]);

        return $this->getInstance($result);
    }

    public function findAllBy($column, $value)
    {
        $this->checkColumn($column);

        $result = $this->db->query('SELECT * FROM ' . static::TABLE . ' WHERE '.$column.' = ?', [$value]);

        return $this->getCollection($result);
    }

    // Méthode permettant d'insérer une nouvelle entrée dans la table users

    /*

	  $user = new User();

		$user->setName("JohnDoe");
		$user->setBirthday("1988-09-21");
		$user->setEmail("MrNobody@domaine.com");
		$user->setPassword("azertyuiop");

		$user->create();


    */
    public function create(){


        // On va générer dynamiquement la requête SQL:

        $datas = $this->toArray();

        $columns = array_keys($datas);  // ex: ['name', 'birthday','email','password']

        $columnsList = implode(', ', $columns);   // "name, birthday ,email ,password"

        $paramsList = ':' . implode(', :', $columns);  // ":name, :birthday, :email ,:password, :city"

        $sql = "INSERT INTO ". static::TABLE ." (". $columnsList  . ", created_at) VALUES (". $paramsList . ", NOW())";

        $this->db->execute($sql, $datas);

        // On va récupérer l'id de l'entrée fraichement insérer en base de données

        $id = $this->db->getPdo()->lastInsertId();  // la méthode lastInsertId renvoit la valeur de la clé primaire de la dernière entrée insérée en base de données

        return $this->find($id);


    }

    /*

     // On souhaite récupérer les informations associées à l'entrée de la table users avec l'id 5
	   $user = (new User)->find(5);

     // On veut ensuite modifier son nom d'utilisateur :
	   $user->setName("Charlie");

	   $user->update(); // Met à jour les informations associées à l'entrée de la table users avec l'id 5
	  */
    public function update()
    {


        // On va générer dynamiquement la requête SQL:
        $datas = $this->toArray();

        unset($datas['updated_at'], $datas['created_at']);


        $columns = array_keys($datas);  // ['id','name', 'birthday','email','password','created_at']

        $sql = "UPDATE ". static::TABLE ." SET ";

        foreach($columns as $column){

           $sql .= "$column = :$column, ";

        }

        $sql .= "updated_at = NOW() WHERE id = :id";


        $this->db->execute($sql, $datas);

        return $this;

    }

    public function delete()
    {
        $sql = "DELETE FROM " . static::TABLE . " WHERE id = ?";

        $this->db->execute($sql, [$this->id]);
    }

    public function getInstance($result){

        if ($result){  // vérifie si $result ne Vaut pas false (dans le cas où la requête n'aurait renvoyé aucun résultat)
            //static fait référence à la classe

            $instance = new static;
           // nouvel objet de la class "courante"
            foreach ($result as $key => $value) {   // http://conception.website/3wa/PHP/Demos/?file=foreach3
                // en première exécution de la boucle $key vaudra
                $instance->$key = $value;
            }
            return $instance;

        }
        else
        {
            return null;
        }

    }

    public function getCollection($results){

        if($results) {

            $collection = [];

            foreach ($results as $result){  // $result est un tableau associatif représentant une ligne de la table users

                $collection[] = $this->getInstance($result);

            }

            return $collection;

       }

       return null;

    }

    public function getLasts($nbr)
    {
        if (!is_int($nbr)) {
            die('Il faut entrer un nombre');
        }

        $datas = $this->db->query('SELECT * FROM ' . static::TABLE . ' ORDER BY created_at DESC LIMIT 0, '.$nbr);

        return $this->getCollection($datas);
    }


    protected function checkColumn($column)
    {
        if(!preg_match('#^[a-zA-Z0-9_]+$#', $column)){

            die('Error: invalid column param');

        }
    }

}
