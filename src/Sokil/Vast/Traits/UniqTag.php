<?php

namespace Sokil\Vast\Traits;

trait UniqTag
{
    /**
     * Set value for given tag
     *
     * @param string $name
     * @param string $value
     *
     * @return $this
     */
    public function setTagValue($name, $value)
    {
        $el = $this->getDomElement();

        $cdata = $el->ownerDocument->createCDATASection((string) $value);

        // get tag
        $tagElement = $el->getElementsByTagName((string) $name)->item(0);
        if (!$tagElement) {
            $tagElement = $el->ownerDocument->createElement($name);
            $el->appendChild($tagElement);
        }

        // update CData
        if ($tagElement->hasChildNodes()) {
            $tagElement->replaceChild($cdata, $tagElement->firstChild);
        } else { // insert cdata
            $tagElement->appendChild($cdata);
        }

        return $this;
    }

    /**
     * Get given tag value
     *
     * @param string $name
     *
     * @return null|string
     */
    public function getTagValue($name)
    {
        $el = $this->getDomElement();
        $tagElement = $el->getElementsByTagName($name)->item(0);
        if (!$tagElement) {
            return null;
        }
        return (string) $tagElement->nodeValue;
    }

    /**
     * Get DomElement object where trait tag should added
     *
     * @return \DOMElement
     */
    abstract protected function getDomElement();
}