<?php
/**
 * Simple HTML DOM Parser adapter
 * This is a simple adapter that makes DOMElement work with the find method
 */

// Create a DOM adapter class
class DOMAdapter {
    private $element;
    
    public function __construct($element) {
        $this->element = $element;
    }
    
    public function find($selector) {
        $xpath = new DOMXPath($this->element->ownerDocument);
        $result = [];
        
        // Convert CSS selector to XPath (simplified)
        if ($selector == "img") {
            $query = ".//img";
        } elseif ($selector == "source") {
            $query = ".//source";
        } elseif ($selector == "div") {
            $query = ".//div";
        } elseif ($selector == "a") {
            $query = ".//a";
        } else {
            $query = ".//*";
        }
        
        $elements = $xpath->query($query, $this->element);
        foreach ($elements as $el) {
            $result[] = new DOMElementEnhanced($el);
        }
        
        return $result;
    }
}

// Enhance DOMElement with additional methods
class DOMElementEnhanced {
    private $element;
    
    public function __construct($element) {
        $this->element = $element;
    }
    
    public function hasAttribute($name) {
        return $this->element->hasAttribute($name);
    }
    
    public function getAttribute($name) {
        return $this->element->getAttribute($name);
    }
    
    public function find($selector) {
        $adapter = new DOMAdapter($this->element);
        return $adapter->find($selector);
    }
}

// Add a find method to DOMElement
if (!method_exists("DOMElement", "find")) {
    function dom_element_find($element, $selector) {
        $adapter = new DOMAdapter($element);
        return $adapter->find($selector);
    }
}

// Define a wrapper function to add find method to DOMElement objects
function addFindMethod($element) {
    return new DOMElementEnhanced($element);
}
