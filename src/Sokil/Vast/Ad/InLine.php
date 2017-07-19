<?php

namespace Sokil\Vast\Ad;

class InLine extends \Sokil\Vast\Ad\Ad
{
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
        $this->getElementWrapper()->setUniqTagValue('AdTitle', $value);

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

    /**
     * Add Error tracking url
     *
     * @param string $url
     *
     * @return $this
     */
    public function setError($url)
    {
        $this->getElementWrapper()->setUniqTagValue('Error', $url);

        return $this;
    }

    /**
     * Get previously set Error tracking url value
     *
     * @return null|string
     */
    public function getError()
    {
        return $this->getElementWrapper()->getUniqTagValue('Error');
    }
    /**
     * Add Impression tracking url
     * NB! Non standard! By standard multiple impressions should be allowed.
     *
     * @param string $url
     *
     * @return $this
     */
    public function setImpression($url)
    {
        $this->getElementWrapper()->setUniqTagValue('Impression', $url);

        return $this;
    }

    /**
     * Get previously set Impression tracking url value
     *
     * @return null|string
     */
    public function getImpression()
    {
        return $this->getElementWrapper()->getUniqTagValue('Impression');
    }
}