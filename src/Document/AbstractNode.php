<?php

namespace Sokil\Vast\Document;

abstract class AbstractNode
{
    /**
     * @return \DOMElement
     */
    abstract protected function getDomElement();

    /**
     * Set cdata for given child node
     *
     * @param string $name name of node
     * @param string $value value
     *
     * @return $this
     */
    protected function setScalarNodeValue($name, $value)
    {
        // get tag
        $childDomElement = $this->getDomElement()->getElementsByTagName($name)->item(0);
        if ($childDomElement === null) {
            $childDomElement = $this->getDomElement()->ownerDocument->createElement($name, $value);
            $this->getDomElement()->appendChild($childDomElement);
        } else {
            $childDomElement->nodeValue = $value;
        }

        return $this;
    }

    /**
     * Set cdata for given child node
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
     * Get given tag value
     *
     * @param string $name
     *
     * @return string
     */
    protected function getScalarNodeValue($name)
    {
        $domElement = $this->getDomElement()->getElementsByTagName($name)->item(0);
        if ($domElement === null) {
            throw new \InvalidArgumentException(sprintf('Node with tag name %s not found', $name));
        }

        return $domElement->nodeValue;
    }

    /**
     * @param string $nodeName
     * @param string $value
     *
     * @return $this
     */
    protected function addCdataToArrayNode($nodeName, $value)
    {
        // create element
        $domElement = $this->getDomElement()->ownerDocument->createElement($nodeName);
        $this->getDomElement()->appendChild($domElement);

        // create cdata
        $cdata = $this->getDomElement()->ownerDocument->createCDATASection($value);
        $domElement->appendChild($cdata);

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
            $values[$i] = $domElements->item(0)->nodeValue;
        }

        return $values;
    }
}
