<?php

namespace App\Utils\Graph;

class Link
{
    public Node $from;
    public Node $to;
    public int $qty = 0;

    public function __construct(Node $from, Node $to, int $qty)
    {
        $this->from = $from;
        $this->to = $to;
        $this->qty = $qty;

        $from->attach($this);
        $to->attach($this);
    }
}