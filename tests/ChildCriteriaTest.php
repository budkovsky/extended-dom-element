<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Budkovsky\ExtendedDomElement\ChildCriteria;
use Budkovsky\ExtendedDomElement\ExtendedDomElementException;

class ChildCriteriaTest extends TestCase
{
    public function testFailsIfInvalidCriteria(): void
    {
        $exception = null;
        try {
            ChildCriteria::create('abcde:0:xyz');
        } catch (\Exception $exception) {
            
        }
        $this->assertInstanceOf(
            ExtendedDomElementException::class,
            $exception
        );
    }
    
    public function testFailsIfItemIndexNotNumeric(): void
    {
        $exception = null;
        try {
            ChildCriteria::create('abcd:xyz');
        } catch (\Exception $exception) {
            
        }
        $this->assertInstanceOf(
            ExtendedDomElementException::class,
            $exception
        );
    }
    
    public function testCanChildCriteriaMapElementName(): void
    {
        $childCriteria = ChildCriteria::create('aaa:5');
        $this->assertEquals('aaa', $childCriteria->getElementName());
        
        $childCriteria = ChildCriteria::create('bbb');
        $this->assertEquals('bbb', $childCriteria->getElementName());
    }
    
    public function testCanChildCriteriaMapIndex(): void
    {
        $childCriteria = ChildCriteria::create('ccc:5');
        $this->assertEquals(5, $childCriteria->getIndex());
        
        $childCriteria = ChildCriteria::create('ddd');
        $this->assertEquals(0, $childCriteria->getIndex());
    }
    
    public function testCanChildCriteriaMapAll(): void
    {
        $childCriteria = ChildCriteria::create('aaa');
        $this->assertEquals('aaa', $childCriteria->getElementName());
        $this->assertEquals(0, $childCriteria->getIndex());
        
        $childCriteria = ChildCriteria::create('bbb:8');
        $this->assertEquals('bbb', $childCriteria->getElementName());
        $this->assertEquals(8, $childCriteria->getIndex());
    }
}

