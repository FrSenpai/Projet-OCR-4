<?php 
require_once('model/Manager.php');

class UsersManager extends Manager {
    //Get user

    //Add user
    public function addUser($pseudo, $password) {
        $db = $this->dbConnect();
        $newUser = $db->prepare('INSERT INTO users(pseudo, password, isAdmin) VALUES(?, ?, 0)');
        $affectedUser = $newUser->execute(array($pseudo, $password));

        return $affectedUser;
    }
    //Count user

    //Delete user
}