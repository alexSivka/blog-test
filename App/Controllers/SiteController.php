<?php

namespace App\Controllers;

use App\Models\Comment;

class SiteController {

    /**
     * main page render
     */
    public function index() :void
    {
        require_once ROOT . '/views/default.php';
    }

    /**
     * ajax method for comment list
     */
    public function getComments() :void
    {
        $model = new Comment();
        $comments = $model->getAll($_GET['direction'] ?? 'asc');
        die(
            json_encode($comments)
        );
    }

    /**
     * ajax method for adding comment
     */
    public function addComment() :void
    {
        $comment = new Comment($_POST);
        if(!$comment->validate()) {
            die(
                json_encode([
                    'status' => 'error',
                    'errors' => $comment->errors
                ])
            );
        }

        $comment->save();

        die(
            json_encode([
                'status' => 'success',
                'comment' => $comment->all()
            ])
        );
    }
}
