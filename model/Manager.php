<?php

class Manager
{
    protected function dbConnect()
    {
        $db = new \PDO('mysql:host=localhost;dbname=projet-4;charset=utf8', 'root', '');
        return $db;
    }
}
