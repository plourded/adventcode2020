<?php

namespace App\Utils\Graph;

class Graph
{
    protected array $links = [];
    protected array $nodes = [];

    public function __construct(array $nodes=[], array $links=[])
    {
        $this->nodes = $nodes;
        $this->links = $links;
    }

    public function firstOrCreateNode(string $color): Node
    {
        if( !isset($this->nodes[$color]) )
        {
            $this->nodes[$color] = new Node($color);
        }
        return $this->nodes[$color];
    }

    public function addLink(Node $node_1, Node $node_2, int $qty)
    {
        $this->links[] = new Link($node_1, $node_2, $qty);
    }

    public function findRecursiveParentForNode(string $color): array
    {
        $parents = [];

        $origin = $this->firstOrCreateNode($color);
        $link_to_climbs = $origin->in_links;

        while( count($link_to_climbs) )
        {
            /** Link $link */
            $link = array_shift($link_to_climbs);

            if(!isset($parents[ $link->from->color ]))
                $parents[$link->from->color] = 1;

            $new_links = array_reduce($link->from->in_links, function($carry, $item) use ($parents){
                if(!isset($parents[ $item->from->color ]))
                    $carry[] = $item;

                return $carry;
            }, []);

            $link_to_climbs = array_merge($link_to_climbs, $new_links);
        }

        return $parents;
    }

    public function findRecursiveChildCountForNode(string $color): int
    {
        $children = [];
        $count = 0;

        $origin = $this->firstOrCreateNode($color);
        $link_to_climbs = $origin->out_links;

        $children[] = $origin;

        while( count($link_to_climbs) )
        {
            /** Link $link */
            $link = array_shift($link_to_climbs);

            if(!isset($children[ $link->to->color ]))
            {
                $count += $link->qty;
                $children[$link->to->color] = 1;
            }

            $new_links = array_reduce($link->to->out_links, function($carry, $item) use ($children){
                if(!isset($children[ $item->to->color ]))
                    $carry[] = $item;

                return $carry;
            }, []);

            $link_to_climbs = array_merge($link_to_climbs, $new_links);
        }

        return $count;
    }

    public function countChildren(string $color, array $traversed_node = []): int
    {
        $count = 0;

        $origin = $this->firstOrCreateNode($color);
        $traversed_node[$origin->color] = 1;

        $links = array_reduce($origin->out_links, function($carry, $item) use ($traversed_node){
            if(!isset($traversed_node[ $item->to->color ]))
                $carry[] = $item;

            return $carry;
        }, []);

        foreach ($links as $link)
        {
            $count += $link->qty;

            if(count($link->to->out_links))
            {
                $count += $link->qty * $this->countChildren($link->to->color, $traversed_node);
            }
        }

        return $count;
    }
}