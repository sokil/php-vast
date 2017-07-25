<?php

namespace Sokil\Vast\Ad;

class InLine extends AbstractAdNode
{
    /**
     * @var \DomElement
     */
    private $extensionsDomElement;
    
    /**
     * Set Ad title
     *
     * @param string $value
     *
     * @return \Sokil\Vast\Ad\InLine
     */
    public function setAdTitle($value)
    {
        $this->setScalarNodeCdata('AdTitle', $value);
        return $this;
    }

    /**
     * @inheritdoc
     */
    protected function buildCreativeClassName($type)
    {
        return '\\Sokil\\Vast\\Creative\\InLine\\' . $type;
    }

    /**
     * Create Linear creative
     *
     * @return \Sokil\Vast\Creative\Inline\Linear
     */
    public function createLinearCreative()
    {
        return $this->buildCreative('Linear');
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
            $this->extensionsDomElement = $this->getDomElement()->getElementsByTagName('Extensions')->item(0);
            if (!$this->extensionsDomElement) {
                $this->extensionsDomElement = $this->getDomElement()->ownerDocument->createElement('Extensions');
                $this->getDomElement()->firstChild->appendChild($this->extensionsDomElement);
            }
        }
        
        // Creative dom element
        $extensionDomElement = $this->extensionsDomElement->ownerDocument->createElement('Extension');
        $this->extensionsDomElement->appendChild($extensionDomElement);
        
        // create cdata
        $cdata = $this->getDomElement()->ownerDocument->createCDATASection($value);
        
        // append
        $extensionDomElement->setAttribute('type', $type);
        $extensionDomElement->appendChild($cdata);
        
        return $this;
    }
}
