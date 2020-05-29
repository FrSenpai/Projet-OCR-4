<?php 
namespace Projet\model;
use Projet\model\Manager;


class UsersManager extends Manager {

    //Add user
    public function addUser($user) {
        $db = $this->dbConnect();
        $newUser = $db->prepare('INSERT INTO users(pseudo, pass, isAdmin) VALUES(?, ?, 0)');
        $affectedUser = $newUser->execute(array($user->getPseudo(), $user->getPass()));

        return $affectedUser;
    }

    //get user by pseudo
    public function getUserByPseudo($user) {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT pseudo, pass, isAdmin FROM users WHERE pseudo = ?');
        $req->execute(array($user->getPseudo()));
        $affectedUser = $req->fetch();
        return $affectedUser;
    }

    
    //Count user
    public function countUsers() {
        $db = $this->dbConnect();
        $req = $db->query('SELECT COUNT(*) FROM users');
        $nbUsers = $req->fetchColumn();
        return $nbUsers;
    }

    //Delete user
    public function deleteUserByPseudo($user) {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM users WHERE pseudo= ?');
        $affectedUser = $req->execute(array($user->getPseudo()));
        return $affectedUser;
    }
}