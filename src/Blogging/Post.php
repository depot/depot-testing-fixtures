<?php

namespace Depot\Testing\Fixtures\Blogging;

use Depot\Testing\Fixtures\Blogging\PostId;

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
     * @var Comment[]
     */
    private $comments;

    public function __construct(PostId $postId, $tags = array(), $comments = array())
    {
        $this->postId = $postId;
        $this->tags = $tags;
        $this->comments = $comments;
    }
}
