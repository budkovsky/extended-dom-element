<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Budkovsky\ExtendedDomElement\ExtendedDomElementTrait;
use Budkovsky\ExtendedDomElement\ExtendedDomElement;

/**
 * TODO tests for setXmlRoot, getXmlRoot, removeXmlNode
 */
final class ExtendedDomElementTraitTest extends TestCase
{
    use ExtendedDomElementTrait;
    
    public function testCanLoadXml(): void
    {
        $traitMock = $this->getMockForTrait(ExtendedDomElementTrait::class);
        $traitMock->loadXml($this->getSimpleXmlContent());
        
        $this->assertInstanceOf(
            ExtendedDomElement::class, 
            $traitMock->getXmlRoot()
        );
    }
    
    public function testCanGetElement(): void
    {
        $traitMock = $this->getMockForTrait(ExtendedDomElementTrait::class);
        $traitMock->loadXml($this->getSimpleXmlContent());
        
        $this->assertInstanceOf(
            ExtendedDomElement::class, 
            $traitMock->getXmlElement('food/name')
        );
        
        $this->assertInstanceOf(
            ExtendedDomElement::class,
            $traitMock->getXmlElement('food:1/price')
        );
        
        $this->assertInstanceOf(
            ExtendedDomElement::class,
            $traitMock->getXmlElement('food:2/description:0')
        );
    }
    
    public function testCanGetValue(): void
    {
        $traitMock = $this->getMockForTrait(ExtendedDomElementTrait::class);
        $traitMock->loadXml($this->getSimpleXmlContent());
        
        $this->assertEquals(
            $traitMock->getXmlValue('food/name'),
            'Belgian Waffles'
        );
        
        $this->assertEquals(
            $traitMock->getXmlValue('food:1/price:0'),
            '$7.95'
        );
    }
    
    public function testCanGetAttribute(): void
    {
        $traitMock = $this->getMockForTrait(ExtendedDomElementTrait::class);
        $traitMock->loadXml($this->getSimpleXmlContent());
        
        $this->assertEquals(
            'first-item',
            $traitMock->getXmlAttribute('food', 'id')
        );
        
        $this->assertEquals(
            'last-item',
            $traitMock->getXmlAttribute('food:4', 'id')
        );
    }
    
    public function testCanSetValue(): void
    {
        $traitMock = $this->getMockForTrait(ExtendedDomElementTrait::class);
        $traitMock->loadXml($this->getSimpleXmlContent());
            
        $selector1 = 'food/name';
        $value1 = 'Big Kahuna Burger';
        $traitMock->setXmlValue($selector1, $value1);
        $this->assertEquals(
            $value1,
            $traitMock->getXmlValue($selector1)
        );
        
        $selector2 = 'food:1/description:0';
        $value2 = 'This is a tasty burger!';
        $traitMock->setXmlValue($selector2, $value2);
        $this->assertEquals(
            $value2,
            $traitMock->getXmlValue($selector2)
        );
    }
    
    public function testCanSetAttribute(): void
    {
        $traitMock = $this->getMockForTrait(ExtendedDomElementTrait::class);
        $traitMock->loadXml($this->getSimpleXmlContent());
        
        $selector1 = 'food/price';
        $attribute1name = 'id';
        $attribute1value = 'first-element-price';
        $traitMock->setXmlAttribute($selector1, $attribute1name, $attribute1value);
        $this->assertEquals(
            $attribute1value, 
            $traitMock->getXmlAttribute($selector1, $attribute1name)
        );
        
        $selector2 = 'food:3/description';
        $attribute2name = 'id';
        $attribute2value = 'fourth-element-description';
        $traitMock->setXmlAttribute($selector2, $attribute2name, $attribute2value);
        $this->assertEquals(
            $attribute2value,
            $traitMock->getXmlAttribute($selector2, $attribute2name)
        );
    }
        
    protected function getSimpleXmlContent(): string
    {
        return file_get_contents($this->getXmlSampleFolder().'/simple.xml');
    }
    
    protected function getXmlSampleFolder(): string
    {
        return __DIR__.'/xml-sample';
    }
}
