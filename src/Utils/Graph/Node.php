<?php

namespace App\Utils\Graph;

class Node
{
    public string $color = "";

    public array $in_links = [];
    public array $out_links = [];


    public function __construct(string $color)
    {
        $this->color = $color;
    }

    public function attach(Link $link)
    {
        if( $link->from->color === $this->color)
            $this->out_links[] = $link;
        else
            $this->in_links[] = $link;
    }
}