<?php 

namespace Projet\model;
use Projet\model\Manager;
use PDO;


class CommentsManager extends Manager {

    public function getComments($postId) {
        $db = $this->dbConnect();
        $comments = $db->prepare('SELECT id, user, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr, reported  FROM comments WHERE post_id = ? ORDER BY creation_date DESC');
        $comments->execute(array($postId));

        return $comments;
    }

    public function addComment($postId, $user, $content) {
        $db = $this->dbConnect();
        $comment = $db->prepare('INSERT INTO comments(post_id, user, content, creation_date, reported) VALUES(?,?,?,NOW(), 0)');
        $affectedLines = $comment->execute(array($postId, $user, $content));

        return $affectedLines;
    }

    //TODO : Bloquer à une fois le nombre de like/com (liaison table user/com IMPERATIF)

    public function reportComment($commentId) {
        $db = $this->dbConnect();
        $reportedComment = $db->prepare('UPDATE comments SET reported = 1 WHERE id = ?');
        $affectedComment = $reportedComment->execute(array($commentId));

        return $affectedComment;
    }

    public function getCommentsReported() {
        $db = $this->dbConnect();
        $comments = $db->query('SELECT * FROM comments WHERE reported = 1');

        return $comments;
    }

    public function deleteComment($commentId) {
        $db = $this->dbConnect();
        $comment = $db->prepare('DELETE FROM comments WHERE id = ?');
        $affectedComment = $comment->execute(array($commentId));
        
        return $affectedComment;
    }

    public function deleteCommentByUser($user) {
        $db = $this->dbConnect();
        $comments = $db->prepare('DELETE FROM comments WHERE user = ?');
        $deletedComments = $comments->execute(array($user));

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

    public function deleteCommentByPostId($postId) {
        $db = $this->dbConnect();
        $comments = $db->prepare("DELETE FROM comments WHERE post_id = ?");
        $deletedComments = $comments->execute(array($postId));

        return $deletedComments;
    }

    public function unreportComment($commentId) {
        $db = $this->dbConnect();
        $comment = $db->prepare("UPDATE comments SET reported = 0 WHERE id=?");
        $comment->execute(array($commentId));

        return $comment;
    }
}