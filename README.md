# Extended DOMElement for PHP

Extended DOMElement is an extension of DOMElement object 
from [DOMDocument library](https://www.php.net/manual/en/class.domdocument.php).
This package allows to select descendant elements direclty from parent element
in XPath-like way. 

## Requirements
* PHP 7.1+
* DOMDocument PHP extension(ext-dom)

## How does it work?

Just create your DOMDocument object this way:

```php
use Budkovsky\ExtendedDomElement\ExtendedDomElement;
#...
$dom = ExtendedDomElement::getDomDocument();
```
You can use it like normal DOMDocument object with extra element's selector feature.
Every element object in this document will be created as ExtendedDomelement
instead of deafult DOMDocument type.
Now you can load XML document from string/file or create new nodes dynamically. 
If you want to select any element from your DOM object just use:

```php
$dom->documentElement->getElement('element1/subelement2/subelement3');
#OR
$dom->getElementById('some-element')->getElement->(subelement1/subelement2/subelement3');
```

If default, name in selector is matched to the first child with valid element name.
If you want to match different, non-first child on given DOMDocument level, just add colon char and index number to the selector.

```php
$dom->documentElement->getElement('someelement:2/subelement:4);
```
