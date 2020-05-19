<?php 
namespace Projet\model;
use DateTime;

class Comment {

    private $_id;
    private $_post_id;
    private $_user;
    private $_content;
    private $_creation_date;
    private $_reported;

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

    public function setPostId(int $postId)
    {
        $this->_post_id = $postId;
    }

    public function setUser(string $user)
    {
        $this->_user = $user;
    }

    public function setContent(string $content)
    {
        $this->_content = $content;
    }

    public function setCreationDate($creation_date)
    {
        $this->_creation_date = new DateTime($creation_date);
    }

    public function setReported(bool $reported) {
        $this->_reported = $reported;
    }

    // GETTERS
    public function getId(): int
    {
        return $this->_id;
    }

    public function getPostId(): int
    {
        return $this->_post_id;
    }

    public function getUser(): string
    {
        return $this->_user;
    }

    public function getContent(): string
    {
        return $this->_content;
    }

    public function getCreationDate()
    {
        return $this->_creation_date;
    }

    public function getReported(): bool {
        return $this->_reported;
    }

}