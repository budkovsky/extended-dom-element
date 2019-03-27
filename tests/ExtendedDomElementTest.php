<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Budkovsky\ExtendedDomElement\ExtendedDomElement;

final class ExtendedDomElementTest extends TestCase
{
    public function testCanCreateDomDocument(): void
    {
        $this->assertInstanceOf(
            \DOMDocument::class,
            ExtendedDomElement::getDomDocument()
        );
    }
    
    public function testCanRegisterExtendedDomElement(): void
    {
        $this->assertInstanceOf(
            ExtendedDomElement::class,
            ExtendedDomElement::getDomDocument()->createElement('test')
        );
    }
    
    public function testCanGetElement(): void
    {
        /** @var ExtendedDomElement $documentElement */
        $documentElement = self::getDocumentElement();
        
        $this->assertInstanceOf(
            ExtendedDomElement::class,
            $documentElement
        );
        $this->assertInstanceOf(
            ExtendedDomElement::class,
            $documentElement->getElement('food')
        );
        $this->assertInstanceOf(
            ExtendedDomElement::class,
            $documentElement->getElement('food:0')
            );
        $this->assertInstanceOf(
            ExtendedDomElement::class,
            $documentElement->getElement('food/name')
        );
        $this->assertInstanceOf(
            ExtendedDomElement::class,
            $documentElement->getElement('food:0/name')
        );
        $this->assertInstanceOf(
            ExtendedDomElement::class,
            $documentElement->getElement('food/name:0')
        );
        $this->assertInstanceOf(
            ExtendedDomElement::class,
            $documentElement->getElement('food:0/name:0')
        );
        $this->assertEquals(
            'Belgian Waffles',
            $documentElement->getElement('food/name')->nodeValue
        );
        $this->assertEquals(
            '$7.95',
            $documentElement->getElement('food:1/price')->nodeValue
        );
        $this->assertEquals(
            '600',
            $documentElement->getElement('food:3/calories:0')->nodeValue
        );
        $this->assertEquals(
            'breakfast_menu',
            $documentElement->getElement('food/..')->localName
        );
    }
    
    public function testCanGetValue(): void
    {
        /** @var ExtendedDomElement $documentElement */
        $documentElement = static::getDocumentElement();
        $this->assertEquals(
            'Belgian Waffles',
            $documentElement->getValue('food/name')
        );
        $this->assertEquals(
            '$5.95',
            $documentElement->getValue('food:0/price')
        );
        $this->assertEquals(
            '$7.95',
            $documentElement->getValue('food:1/price:0')
        );
    }
    
    public function testCanSetValue(): void
    {
        /** @var ExtendedDomElement $documentElement */
        $documentElement = static::getDocumentElement();
        $name = 'Big Kahuna Burger';
        $description = 'This is a tasty burger!';
        $documentElement
            ->setValue('food:1/name', $name)
            ->setValue('food:1/description', $description);
        
        $this->assertEquals(
            $name,
            $documentElement->getValue('food:1/name')
        );
        $this->assertEquals(
            $description,
            $documentElement->getValue('food:1/description')
        );
    }
    
    /**
     * @see ./xml-sample/simple.xml
     * @return ExtendedDomElement
     */
    protected static function getDocumentElement(): ExtendedDomElement
    {
        /** @var \DOMDocument $document */
        $document = ExtendedDomElement::getDomDocument();
        $document->load(__DIR__.'/xml-sample/simple.xml');
        
        return $document->documentElement;
        
    }
}
