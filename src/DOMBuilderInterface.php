<?php
namespace Budkovsky\ExtendedDomElement;

interface DOMBuilderInterface
{
    /**
     * @param string $xml String of XML content
     * @param ?bool $standalone
     * @param ?bool $preserveWhiteSpace
     * @param ?bool $formatOutput
     */
    function loadXml(
        string $xml,
        ?bool $standalone = null,
        ?bool $preserveWhiteSpace = null,
        ?bool $formatOutput = null
    );

    /**
     * @param string $selector node path for ExtendedDomElement relative to xmlRoot(document element)
     * @param string $value nodeValue
     */
    function setXmlValue(string $selector, ?string $value);

    /**
     * @param ExtendedDomElement $xmlRoot
     *
     */
    function setXmlRoot(ExtendedDomElement $xmlRoot);

    /**
     * Get xmlRoot(document element)
     * @return ExtendedDomElement
     */
    function getXmlRoot(): ?ExtendedDomElement;

    /**
     * @param string $selector
     * @return ExtendedDomElement|NULL
     */
    function getXmlElement(string $selector): ?ExtendedDomElement;

    /**
     * @param string $selector
     * @return string
     */
    function getXmlValue(string $selector): string;

    /**
     * @param \DOMNode $oldNode
     */
    function removeXmlNode(\DOMNode $oldNode);

    /**
     * @param string $selector
     * @param string $name
     * @return string|NULL
     */
    function getXmlAttribute(string $selector, string $name): ?string;

    /**
     * @param string $selector attribute element select
     * @param string $name attribute name
     * @param string $value asttribute value
     */
    public function setXmlAttribute(string $selector, string $name, string $value);
}
