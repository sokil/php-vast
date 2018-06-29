<?php

namespace Sokil\Vast\Document;

abstract class AbstractNode
{
    /**
     * Root DOM element, represented by this Node class.
     *
     * @return \DOMElement
     */
    abstract protected function getDomElement();

    /**
     * Set cdata for given child node or create new child node
     *
     * @param string $name name of node
     * @param string $value value of cdata
     *
     * @return $this
     */
    protected function setScalarNodeCdata($name, $value)
    {
        // get tag
        $childDomElement = $this->getDomElement()->getElementsByTagName($name)->item(0);
        if ($childDomElement === null) {
            $childDomElement = $this->getDomElement()->ownerDocument->createElement($name);
            $this->getDomElement()->appendChild($childDomElement);
        }

        // upsert cdata
        $cdata = $this->getDomElement()->ownerDocument->createCDATASection($value);
        if ($childDomElement->hasChildNodes()) {
            // update cdata
            $childDomElement->replaceChild($cdata, $childDomElement->firstChild);
        } else {
            // insert cdata
            $childDomElement->appendChild($cdata);
        }

        return $this;
    }

    /**
     * @param string $name
     *
     * @return string|null null if node not found
     */
    protected function getScalarNodeValue($name)
    {
        $domElements = $this->getDomElement()->getElementsByTagName($name);
        if ($domElements->length === 0) {
            return null;
        }

        return $domElements->item(0)->nodeValue;
    }

    /**
     * Append new child node to node
     *
     * @param string $nodeName
     * @param string $value
     * @param array $attributes
     *
     * @return $this
     */
    protected function addCdataNode($nodeName, $value, array $attributes = array())
    {
        // create element
        $domElement = $this->getDomElement()->ownerDocument->createElement($nodeName);
        $this->getDomElement()->appendChild($domElement);

        // create cdata
        $cdata = $this->getDomElement()->ownerDocument->createCDATASection($value);
        $domElement->appendChild($cdata);

        // add attributes
        foreach ($attributes as $attributeId => $attributeValue) {
            $domElement->setAttribute($attributeId, $attributeValue);
        }

        return $this;
    }

    /**
     * @param string $nodeName
     *
     * @return string[]
     */
    protected function getValuesOfArrayNode($nodeName)
    {
        $domElements = $this->getDomElement()->getElementsByTagName($nodeName);

        $values = array();
        for ($i = 0; $i < $domElements->length; $i++) {
            $values[$i] = $domElements->item($i)->nodeValue;
        }

        return $values;
    }
}
