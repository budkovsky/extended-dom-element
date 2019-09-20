<?php
declare(strict_types = 1);

namespace Budkovsky\ExtendedDomElement;

use Budkovsky\Aid\Abstraction\CollectionAbstract;

/**
 * DOMNode collection
 */
class DOMNodeCollection extends CollectionAbstract
{
    /**
     * Add DOMNode object to the collection
     * @param \DOMNode $node
     * @return DOMNodeCollection
     */
    public function add(\DOMNode $node): DOMNodeCollection
    {
        $this->collection[] = $node;
    }
}
