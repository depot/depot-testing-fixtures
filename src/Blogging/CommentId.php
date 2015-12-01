<?php

namespace Depot\Testing\Fixtures\Blogging;

class CommentId
{
    /**
     * @var int|string
     */
    private $value;

    private function __construct($value)
    {
        $this->value = $value;
    }

    public static function fromString($string)
    {
        return new self($string);
    }

    public function __toString()
    {
        return (string)$this->value;
    }
}
