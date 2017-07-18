<?php

namespace Sokil\Vast\Ad;

abstract class Ad
{    
    /**
     *
     * @var \DomNode
     */
    protected $domElement;

    /**
     * Creatives
     *
     * @var array
     */
    private $creatives = array();

    /**
     * @var \DomElement
     */
    private $creativesDomElement;

    /**
     * Ad constructor.
     *
     * @param \DomElement $domElement
     */
    public function __construct(\DomElement $domElement) 
    {
        $this->domElement = $domElement;
    }

    /**
     * Get id for Ad element
     *
     * @return string
     */
    public function getId()
    {
        return $this->domElement->getAttribute('id');
    }
    
    /**
     * Set 'id' attribute of 'ad' element
     *
     * @param string $id
     *
     * @return \Sokil\Vast\Ad\InLine|\Sokil\Vast\Ad\Wrapper
     */
    public function setId($id)
    {
        $this->domElement->setAttribute('id', $id);

        return $this;
    }

    /**
     * Add `AdSystem` element to `Ad' element
     *
     * @param string $adSystem
     *
     * @return \Sokil\Vast\Ad\InLine|\Sokil\Vast\Ad\Wrapper
     */
    public function setAdSystem($adSystem)
    {
        $adSystemDomElement = $this->domElement->getElementsByTagName('AdSystem')->item(0);
        if ($adSystemDomElement) {
            $adSystemDomElement->nodeValue = $adSystem;
        } else {
            $adSystemDomElement = $this->domElement->ownerDocument->createElement('AdSystem', $adSystem);
            $this->domElement->firstChild->appendChild($adSystemDomElement);
        }

        return $this;
    }

    /**
     * Build class name for creative of given type
     *
     * @param string $type
     *
     * @return string
     */
    abstract protected function buildCreativeClassName($type);

    /**
     * Create "creative" object of given type
     *
     * @param string $type
     * @throws \Exception
     *
     * @return \Sokil\Vast\Ad\InLine\Creative\Base
     */
    protected function _createCreative($type)
    {
        // check type
        $creativeClassName = $this->buildCreativeClassName($type);
        if (!class_exists($creativeClassName)) {
            throw new \Exception('Wrong creative specified');
        }

        // get container
        if (!$this->creativesDomElement) {
            // get creatives tag
            $this->creativesDomElement = $this->domElement->getElementsByTagName('Creatives')->item(0);
            if (!$this->creativesDomElement) {
                $this->creativesDomElement = $this->domElement->ownerDocument->createElement('Creatives');
                $this->domElement->firstChild->appendChild($this->creativesDomElement);
            }
        }

        // Creative dom element
        $creativeDomElement = $this->creativesDomElement->ownerDocument->createElement('Creative');
        $this->creativesDomElement->appendChild($creativeDomElement);

        // Cteative type dom element
        $creativeTypeDomElement = $this->domElement->ownerDocument->createElement($type);
        $creativeDomElement->appendChild($creativeTypeDomElement);

        // object
        $creative = new $creativeClassName($creativeDomElement);
        $this->creatives[] = $creative;

        return $creative;
    }
}