<?php

namespace Monii\AggregateEventStorage\Fixtures\Blogging;

use Monii\AggregateEventStorage\Fixtures\Blogging\PostId;

class Post
{
    /**
     * @var PostId
     */
    private $postId;

    /**
     * @var array
     */
    private $tags;

    /**
     * @var array
     */
    private $comments;

    public function __construct(PostId $postId, $tags = array(), $comments = array())
    {
        $this->postId = $postId;
        $this->tags = $tags;
        $this->comments = $comments;
    }
}
