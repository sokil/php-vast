<?php

namespace Sokil\Vast\Ad;

class InLine extends \Sokil\Vast\Ad\Ad
{
    use \Sokil\Vast\Traits\UniqTag;
    use \Sokil\Vast\Traits\Error;
    use \Sokil\Vast\Traits\Impression;
    
    /**
     * @var \DomElement
     */
    private $extensionsDomElement;

    /**
     * UniqTag trait interface method
     *
     * @return \DOMElement
     */
    protected function getDomElement()
    {
        return $this->domElement->firstChild;
    }
    
    /**
     * Set Ad title
     *
     * @param string $value
     *
     * @return \Sokil\Vast\Ad\InLine
     */
    public function setAdTitle($value)
    {
        return $this->setTagValue('AdTitle', $value);
    }

    /**
     * @inheritdoc
     */
    protected function buildCreativeClassName($type)
    {
        return '\\Sokil\\Vast\\Ad\\InLine\\Creative\\' . $type;
    }

    /**
     * 
     * @return \Sokil\Vast\Ad\InLine\Creative\Linear
     */
    public function createLinearCreative()
    {
        return $this->_createCreative('Linear');
    }

    /**
     * Add extension
     *
     * @param string $type
     * @param string $value
     *
     * @return $this
     */
    public function addExtension($type, $value)
    {
        // get container
        if (!$this->extensionsDomElement) {
            // get creatives tag
            $this->extensionsDomElement = $this->domElement->getElementsByTagName('Extensions')->item(0);
            if (!$this->extensionsDomElement) {
                $this->extensionsDomElement = $this->domElement->ownerDocument->createElement('Extensions');
                $this->domElement->firstChild->appendChild($this->extensionsDomElement);
            }
        }
        
        // Creative dom element
        $extensionDomElement = $this->extensionsDomElement->ownerDocument->createElement('Extension');
        $this->extensionsDomElement->appendChild($extensionDomElement);
        
        // create cdata
        $cdata = $this->domElement->ownerDocument->createCDATASection($value);
        
        // append
        $extensionDomElement->setAttribute('type', $type);
        $extensionDomElement->appendChild($cdata);
        
        return $this;
    }
}