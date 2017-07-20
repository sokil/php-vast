<?php

namespace Sokil\Vast\Ad;

use Sokil\Vast\Creative\AbstractLinearCreative;
use Sokil\Vast\Document\Node;

abstract class AbstractAd extends Node
{
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
     * @var \Sokil\Vast\Util\ElementWrapper
     */
    private $elementWrapper;

    /**
     * Get element wrapper helper
     *
     * @return \Sokil\Vast\Util\ElementWrapper
     */
    protected function getElementWrapper()
    {
        if (null === $this->elementWrapper) {
            $this->elementWrapper = new \Sokil\Vast\Util\ElementWrapper(
                $this->domElement->firstChild
            );
        }

        return $this->elementWrapper;
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
     * @return InLine|Wrapper|AbstractAd
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
     * @return InLine|Wrapper|AbstractAd
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
     *
     * @throws \Exception
     *
     * @return AbstractLinearCreative
     */
    protected function buildCreative($type)
    {
        // check type
        $creativeClassName = $this->buildCreativeClassName($type);
        if (!class_exists($creativeClassName)) {
            throw new \Exception('Wrong creative specified: ' . var_export($creativeClassName, true));
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
