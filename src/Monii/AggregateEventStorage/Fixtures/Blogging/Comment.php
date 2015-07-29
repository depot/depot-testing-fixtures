<?php

namespace Monii\AggregateEventStorage\Fixtures\Blogging;

use Monii\AggregateEventStorage\Fixtures\Blogging\CommentId;

class Comment
{
    /**
     * @var CommentId
     */
    private $commentId;

    /**
     * @var string
     */
    private $comment;

    public function __construct(CommentId $commentId, $comment)
    {
        $this->commentId = $commentId;
        $this->comment = $comment;
    }
}
