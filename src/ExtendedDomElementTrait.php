<?php
declare(strict_types=1);

namespace Budkovsky\ExtendedDomElement;

/**
 * Trait for simplify operations on DOMDocument with ExtendedDomElement
 */
trait ExtendedDomElementTrait
{
    /**
     * @var ExtendedDomElement
     */
    protected $xmlRoot;
    
    /**
     * @param string $xml String of XML content
     * @param ?bool $standalone
     * @param ?bool $preserveWhiteSpace
     * @param ?bool $formatOutput
     * @throws ExtendedDomElementException
     * @return self
     */
    public function loadXml(
        string $xml,
        ?bool $standalone = null,
        ?bool $preserveWhiteSpace = null,
        ?bool $formatOutput = null
    ): self {
        $dom = ExtendedDomElement::getDomDocument();
        if ($standalone !== null) {
            $dom->xmlStandalone = $standalone;
        }
        if ($preserveWhiteSpace !== null) {
            $dom->preserveWhiteSpace = $preserveWhiteSpace;
        }
        if ($formatOutput !== null) {
            $dom->formatOutput = $formatOutput;
        }
        if (!$dom->loadXML($xml)) {
            throw new ExtendedDomElementException('Unexpected error while loading XML');
        }
        $this->setXmlRoot($dom->documentElement);
        
        return $this;
    }
    
    /**
     * @param string $selector node path for ExtendedDomElement relative to self::xmlRoot
     * @param string $value nodeValue
     * @throws InvalidPathException;
     * @return self
     */
    public function setXmlValue(string $selector, ?string $value): self
    {
        $this->xmlRoot->setValue($selector, $value);
        
        return $this;
    }
    
    /**
     * @param ExtendedDomElement $xmlRoot
     * @return self
     */
    public function setXmlRoot(ExtendedDomElement $xmlRoot): self
    {
        $this->xmlRoot = $xmlRoot;
        
        return $this;
    }
    
    /**
     * @return ExtendedDomElement
     */
    public function getXmlRoot(): ?ExtendedDomElement
    {
        return $this->xmlRoot;
    }
    
    /**
     * @param string $selector
     * @return ExtendedDomElement
     */
    public function getXmlElement(string $selector): ?ExtendedDomElement
    {
        return $this->xmlRoot->getElement($selector);
    }
       
    /**
     * @param string $selector
     * @return string
     */
    public function getXmlValue(string $selector): string
    {
        return $this->xmlRoot->getValue($selector);
    }
       
    /**
     * @param \DOMNode $oldNode
     * @return self
     */
    public function removeXmlNode(\DOMNode $oldNode): self
    {
        ExtendedDomElement::removeNode($oldNode);
        
        return $this;
    }
     
    /**
     * @param string $selector
     * @param string $name
     * @return string
     */
    public function getXmlAttribute(string $selector, string $name): ?string
    {
        $element = $this->xmlRoot->getElement($selector);
        if (!$element) {
            return null;
        }
        
        return $element->getAttribute($name);
    }
       
    /**
     * @param string $selector attribute element select
     * @param string $name attribute name
     * @param string $value asttribute value
     * @return self
     */
    public function setXmlAttribute(string $selector, string $name, string $value): self
    {
        $element = $this->xmlRoot->getElement($selector);
        if ($element) {
            $element->setAttribute($name, $value);
        }
        
        return $this;
    }
}
