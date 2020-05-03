<?php 
require_once('model/Manager.php');

class CommentsManager extends Manager {

    public function getComments($postId) {
        $db = $this->dbConnect();
        $comments = $db->prepare('SELECT id, user, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr, upvote, reported  FROM comments WHERE post_id = ? ORDER BY creation_date DESC');
        $comments->execute(array($postId));

        return $comments;
    }

    public function addComment($postId, $user, $content) {
        $db = $this->dbConnect();
        $comment = $db->prepare('INSERT INTO comments(post_id, user, content, creation_date, upvote, reported) VALUES(?,?,?,NOW(), 0, 0)');
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
}