<?php 

namespace Projet\model;
use Projet\model\Manager;
use PDO;


class CommentsManager extends Manager {

    public function getComments($post) {
        $db = $this->dbConnect();
        $comments = $db->prepare('SELECT id, user, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr, reported  FROM comments WHERE post_id = ? ORDER BY creation_date DESC');
        $comments->execute(array($post->getId()));

        return $comments;
    }

    public function addComment($comment) {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO comments(post_id, user, content, creation_date, reported) VALUES(?,?,?,NOW(), 0)');
        $affectedLines = $req->execute(array($comment->getPostId(), $comment->getUser(), $comment->getContent()));

        return $affectedLines;
    }

    public function reportComment($comment) {
        $db = $this->dbConnect();
        $reportedComment = $db->prepare('UPDATE comments SET reported = 1 WHERE id = ?');
        $affectedComment = $reportedComment->execute(array($comment->getId()));

        return $affectedComment;
    }

    public function getCommentsReported() {
        $db = $this->dbConnect();
        $comments = $db->query('SELECT * FROM comments WHERE reported = 1');

        return $comments;
    }

    public function deleteComment($comment) {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM comments WHERE id = ?');
        $affectedComment = $req->execute(array($comment->getId()));
        
        return $affectedComment;
    }

    public function deleteCommentByUser($user) {
        $db = $this->dbConnect();
        $comments = $db->prepare('DELETE FROM comments WHERE user = ?');
        $deletedComments = $comments->execute(array($user->getPseudo()));

        return $deletedComments;
    }

    public function countCommentsReported() {
        $db = $this->dbConnect();
        $comment = $db->query('SELECT COUNT(*) FROM comments WHERE reported = 1');
        $nbRows = $comment->fetchColumn();

        return $nbRows;
    }

    public function getCommentsReportedWithPagination($limite, $debut) {

        $db = $this->dbConnect();
        $nbComments = $db->prepare("SELECT * FROM comments WHERE reported = 1 LIMIT :limite OFFSET :debut");
        $nbComments->bindValue('limite', $limite, PDO::PARAM_INT);
        $nbComments->bindValue('debut', $debut, PDO::PARAM_INT);
        $nbComments->execute();

        return $nbComments;
    }

    public function countComments() {
        $db = $this->dbConnect();
        $comment = $db->query('SELECT COUNT(*) FROM comments');
        $nbRows = $comment->fetchColumn();
        return $nbRows;
    }

    public function deleteCommentByPostId($post) {
        $db = $this->dbConnect();
        $comments = $db->prepare("DELETE FROM comments WHERE post_id = ?");
        $deletedComments = $comments->execute(array($post->getId()));

        return $deletedComments;
    }

    public function unreportComment($comment) {
        $db = $this->dbConnect();
        $req = $db->prepare("UPDATE comments SET reported = 0 WHERE id=?");
        $affectedComment = $req->execute(array($comment->getId()));

        return $affectedComment;
    }
}