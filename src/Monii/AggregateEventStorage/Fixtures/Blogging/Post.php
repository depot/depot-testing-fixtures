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

    public function __construct(PostId $postId, $tags = array())
    {
        $this->postId = $postId;
        $this->tags = $tags;
    }
}
