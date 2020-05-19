<?php 
namespace Projet\model;
use DateTime;

use Projet\model\{
    Comment,
    CommentsManager,
    UsersManager
};

class User
{
    private $_id;
    private $_pseudo;
    private $_pass;
    private $_isAdmin;


    public function __construct($value = array())
    {
        if (!empty($value))
            $this->hydrate($value);
    }

    public function hydrate($data)
    {
        foreach ($data as $attribut => $value) {
            $method = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $attribut)));
            if (is_callable(array($this, $method))) {
                $this->$method($value);
            }
        }
    }

    // SETTERS
    public function setId(int $id)
    {
        $this->_id = $id;
    }

    public function setPseudo(string $pseudo)
    {
        $this->_pseudo = $pseudo;
    }

    public function setPass(string $pass)
    {
        $this->_pass = $pass;
    }

    public function setisAdmin(string $isAdmin)
    {
        $this->_isAdmin = $isAdmin;
    }

    // GETTERS
    public function getId(): int
    {
        return $this->_id;
    }

    public function getPseudo(): string
    {
        return $this->_pseudo;
    }

    public function getPassw(): string
    {
        return $this->_pass;
    }

    public function getisAdmin(): string
    {
        return $this->_isAdmin;
    }


    public function showAdminPanel($limite, $page) {
        //Calcul pour la pagination des commentaires signalés
        $debut = ($page - 1) * $limite;
        $commentsManager = new CommentsManager();
        $nbElements = $commentsManager->countCommentsReported();
        $nombreDeCommentaires = ceil($nbElements / $limite);
        $nbComment = $commentsManager->getCommentsReportedWithPagination($limite, $debut);

        //On prépare certaines statistiques
        $usersManager = new UsersManager();
        $nbUsers = $usersManager->countUsers();

        $postsManager = new PostsManager();
        $nbPosts = $postsManager->countNbPosts();

        $nbComments = $commentsManager->countComments();

        require('view/backend/dashboard.php');
    }

}
