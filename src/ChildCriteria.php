<?php
declare(strict_types=1);

namespace Budkovsky\ExtendedDomElement;

class ChildCriteria
{
    const CRITERIA_SEPARATOR = ':';

    /**
     * @var string
     */
    protected $elementName;
    
    /**
     * @var int
     */
    protected $index;
    
    /**
     * Non-public constructor
     */
    protected function __construct(string $elementName, int $index)
    {
        $this->elementName = $elementName;
        $this->index = $index;
    }
    
    /**
     * @return string
     */
    public function getElementName(): string
    {
        return $this->elementName;
    }
    
    /**
     * @return int
     */
    public function getIndex(): int
    {
        return $this->index;
    }
    
    /**
     * @param string $criteria
     * @return ChildCriteria
     */
    public static function create(string $criteria): ChildCriteria
    {
        $items = explode(static::CRITERIA_SEPARATOR, trim(
            $criteria, 
            implode(null, [static::CRITERIA_SEPARATOR, ' '])
        ));
        
        self::validateElements($items);
        
        $childCriteria = new static(
            $items[0], 
            (int)($items[1] ?? 0)
        );
        
        return $childCriteria;
    }
    
    /**
     * @param array $items
     * @throws ExtendedDomElementException
     */
    protected static function validateElements(array $items): void
    {
        if (count($items) !== 1 && count($items) !== 2) {
            throw new ExtendedDomElementException(
                'Unexpected error while generating ChildCriteria, check criteria string'
            );
        }
        if (isset($items[1]) && !is_numeric($items[1])) {
            throw new ExtendedDomElementException(
                'Invalid index in criteria string, must be numeric only string or empty'
            );
        }
    }
}


