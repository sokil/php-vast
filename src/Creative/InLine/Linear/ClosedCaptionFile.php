<?php

/**
 * This file is part of the PHP-VAST package.
 *
 * (c) Dmytro Sokil <dmytro.sokil@gmail.com>
 *
 * File created by Leonardo Matos Rodriguez  <leon486@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sokil\Vast\Creative\InLine\Linear;

class ClosedCaptionFile
{
    /**
     * @var \DomElement
     */
    private $domElement;

    /**
     * @param \DomElement $domElement
     */
    public function __construct(\DomElement $domElement)
    {
        $this->domElement = $domElement;
    }

    /**
     * Set file mime type
     *
     * @param string $mime Mime type of the file
     */
    public function setType($mime)
    {
        $this->domElement->setAttribute('type', $mime);
        return $this;
    }

    /**
     * Set file language
     *
     * @param string $languag Language of the file e.g: 'en'
     */
    public function setLanguage($language)
    {
        $this->domElement->setAttribute('language', $language);
        return $this;
    }

    /**
     * Set file URL
     *
     * @param string $url URL of the file
     */
    public function setUrl($url)
    {
        $cdata = $this->domElement->ownerDocument->createCDATASection($url);

        // update CData
        if ($this->domElement->hasChildNodes()) {
            $this->domElement->replaceChild($cdata, $this->domElement->firstChild);
        } // insert CData
        else {
            $this->domElement->appendChild($cdata);
        }
        return $this;
    }
}
