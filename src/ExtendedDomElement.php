<?php
declare(strict_types=1);

namespace Budkovsky\ExtendedDomElement;

class ExtendedDomElement extends \DOMElement
{
    const SELECTOR_SEPARATOR = '/';
    
    /**
     * @param string $version
     * @param string $encoding
     * @return \DOMDocument
     */
    public static function getDomDocument(string $version = '1.0', ?string $encoding = 'UTF-8'): \DOMDocument
    {
        $document = new \DOMDocument($version, $encoding);
        $document->registerNodeClass(\DOMElement::class, static::class);
        
        return $document;
    }
    
    /**
     * @param string $selector
     * @return ExtendedDomElement|NULL
     */
    public function getElement(string $selector): ?ExtendedDomElement
    {
        $currentElement = null;
        $explodedSelector = explode(static::SELECTOR_SEPARATOR, trim($selector));
        
        while ($criteria = array_shift($explodedSelector)) {
            $currentElement = $currentElement ?: $this;
            $currentElement = $criteria == '..'
                ? $currentElement->parentNode
                : $this->getChild($currentElement, ChildCriteria::create($criteria));
            if (!$currentElement) {
                break;
            }
        }
        
        return $currentElement;
    }
    
    /**
     * @param string $selector
     * @return string|NULL
     */
    public function getValue(string $selector): string
    {
        return $this->getElement($selector)->nodeValue;
    }
    
    /**
     * @param string $selector
     * @param string $value
     * @return ExtendedDomElement
     */
    public function setValue(string $selector, string $value): ?ExtendedDomElement
    {
        $this->getElement($selector)->nodeValue = $value;
        
        return $this;
    }
    
    /**
     * Return DOMDocument's root node as ExtendedDomElement object
     * @param string $content XML content
     * @throws ExtendedDomElement
     * @return ExtendedDomElement
     */
    public static function getXmlRootElement(string $content): self
    {
        $dom = static::getDomDocument();
        if (!$dom->loadXML($content)) {
            throw new ExtendedDomElementException(
                'Unexpected error during XML loading'
            );
        }
        
        return $dom->documentElement;
    }
    
    /**
     * @param \DOMNode
     * @return \DOMNode old child
     */
    public static function removeNode(\DOMNode $oldNode): \DOMNode
    {
        return $oldNode->parentNode->removeChild($oldNode);
    }
    
    /**
     * @param ExtendedDomElement $parent
     * @param ChildCriteria $childCriteria
     * @return ExtendedDomElement
     */
    protected function getChild(ExtendedDomElement $parent, ChildCriteria $childCriteria): ?ExtendedDomElement
    {
        $counter = -1;
        foreach ($parent->childNodes as $node) {
            /** @var \DOMNode $node */
            $isElement = $node->nodeType == XML_ELEMENT_NODE;
            $isNameValid = $node->localName == $childCriteria->getElementName();
            if (!$isElement || !$isNameValid) {
                continue;
            }
            if (++$counter == $childCriteria->getIndex()) {
                return $node;
            }
        }
        
        return null;
    }
}
