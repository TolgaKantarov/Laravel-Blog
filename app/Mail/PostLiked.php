<?php

namespace App\Mail;

use App\Models\Post;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PostLiked extends Mailable
{
    use Queueable, SerializesModels;

    public $liker;

    public $post;

    public function __construct(User $liker, Post $post)
    {
        $this->liker = $liker;
        $this->post = $post;
    }

    public function build()
    {
        return $this->markdown('emails.posts.post_liked')
            ->subject('Someone liked your post');
    }
}