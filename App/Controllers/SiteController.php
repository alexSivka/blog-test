<?php

namespace App\Controllers;

use App\Models\Comment;

class SiteController {
    public function index()
    {
        require_once ROOT . '/views/default.php';
    }

    public function addComment()
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

        die(
            json_encode([
                'status' => 'success',
                'comment' => $comment->all()
            ])
        );
    }
}
