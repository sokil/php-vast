<?php

namespace Sokil\Vast\Ad\InLine;

class Creative
{
    private $_domElement;
    
    private $_list = array();
    
    public function __construct(\DomElement $domElement)
    {
        $this->_domElement = $domElement;
    }
    
    /**
     * 
     * @param string $type
     * @return \Sokil\Vast\Ad\InLine\Creative\Base
     * @throws \Exception
     */
    public function add($type)
    {
        // check type
        $creativeClassName = '\\Sokil\Vast\\Ad\\InLine\\Creative\\' . $type;
        if(!class_exists($creativeClassName)) {
            throw new \Exception('Wrong crative specified');
        }
        
        // dom
        $creativeTypeDomElement = $this->_domElement->ownerDocument->createElement($type);
        $this->_domElement->appendChild($creativeTypeDomElement);
        
        // object
        $creative = new $creativeClassName($creativeTypeDomElement);
        $this->_list[] = $creative;
        
        return $creative;
    }
    
    /**
     * 
     * @return \Sokil\Vast\Ad\InLine\Creative\Linear
     */
    public function addLinear()
    {
        return $this->add('Linear');
    }
}