<?php

/**
 * This file is part of the PHP-VAST package.
 *
 * (c) Dmytro Sokil <dmytro.sokil@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sokil\Vast\Creative\InLine;

use Sokil\Vast\Creative\AbstractLinearCreative;

use Sokil\Vast\Creative\InLine\Linear\ClosedCaptionFile;
use Sokil\Vast\Creative\InLine\Linear\MediaFile;
use Sokil\Vast\Creative\InLine\Linear\AdParameters;

class Linear extends AbstractLinearCreative
{
    /**
     * @var \DOMElement
     */
    private $mediaFilesDomElement;
    
    /**
     * @var \DOMElement
     */
    private $closedCaptionFilesDomElement;

    /**
     * @var \DOMElement
     */
    private $adParametersDomElement;

    /**
     * Set duration value
     *
     * @param int|string $duration seconds or time in format "H:m:i"
     *
     * @return $this
     */
    public function setDuration($duration)
    {
        // get dom element
        $durationDomElement = $this->getDomElement()->getElementsByTagName('Duration')->item(0);
        if (!$durationDomElement) {
            $durationDomElement = $this->getDomElement()->ownerDocument->createElement('Duration');
            $this->getDomElement()->getElementsByTagName('Linear')->item(0)->appendChild($durationDomElement);
        }

        // set value
        if (is_numeric($duration)) {
            // in seconds
            $duration = $this->secondsToString($duration);
        }

        $durationDomElement->nodeValue = $duration;

        return $this;
    }
    
    
    /**
     * Creates a DOM element if it doesn't exist already
     *
     * @param string $domElementName The variable that hold the DOM element
     * @param string $tagName The name of the DOM element to be created
     * @param string $parentTagName The name of the parent tag that the element will be appended to
     *  if it doesn't exist
     *
     * @return VOID
     */
    private function createDomElement($domElement, $tagName, $parentTagName){
      if (empty($this->{$domElement})) {
          $this->{$domElement} = $this->getDomElement()->getElementsByTagName($tagName)->item(0);
          if (!$this->{$domElement}) {
              $this->{$domElement} = $this->getDomElement()->ownerDocument->createElement($tagName);
              $this->getDomElement()
                  ->getElementsByTagName($parentTagName)
                  ->item(0)
                  ->appendChild($this->{$domElement});
          }
      }
    }
      
    /**
     * @return MediaFile
     */
    public function createMediaFile()
    {
        $this->createDomElement('mediaFilesDomElement', 'MediaFiles', 'Linear');

        // dom
        $mediaFileDomElement = $this->mediaFilesDomElement->ownerDocument->createElement('MediaFile');
        $this->mediaFilesDomElement->appendChild($mediaFileDomElement);

        // object
        return $this->vastElementBuilder->createInLineAdLinearCreativeMediaFile($mediaFileDomElement);
    }

    /**
     * @return ClosedCaptionFile
     */
    public function createClosedCaptionFile()
    {
        // 
        $this->createDomElement('mediaFilesDomElement', 'MediaFiles', 'Linear');
        $this->createDomElement('closedCaptionFilesDomElement', 'ClosedCaptionFiles', 'MediaFiles');
        
        // dom
        $closedCaptionFileDomElement = $this->closedCaptionFilesDomElement->ownerDocument->createElement('ClosedCaptionFile');
        $this->closedCaptionFilesDomElement->appendChild($closedCaptionFileDomElement);

        // object
        return new ClosedCaptionFile($closedCaptionFileDomElement);
    }
    
        
    /**
     * @param array|string $params
     *
     * @return self
     */
    public function setAdParameters($params)
    {
        $this->adParametersDomElement = $this->getDomElement()->getElementsByTagName('AdParameters')->item(0);
        if (!$this->adParametersDomElement) {
            $this->adParametersDomElement = $this->getDomElement()->ownerDocument->createElement('AdParameters');
            $this->getDomElement()->getElementsByTagName('Linear')->item(0)->appendChild($this->adParametersDomElement);
        }

        if (is_array($params)) {
            $params = json_encode($params);
        }

        $cdata = $this->adParametersDomElement->ownerDocument->createCDATASection($params);

        // update CData
        if ($this->adParametersDomElement->hasChildNodes()) {
            $this->adParametersDomElement->replaceChild($cdata, $this->adParametersDomElement->firstChild);
        } // insert CData
        else {
            $this->adParametersDomElement->appendChild($cdata);
        }

        return $this;
    }

    /**
     * @param int|string $time seconds or time in format "H:m:i"
     * @return $this
     */
    public function skipAfter($time)
    {
        if (is_numeric($time)) {
            $time = $this->secondsToString($time);
        }

        $this->getDomElement()->getElementsByTagName('Linear')->item(0)->setAttribute('skipoffset', $time);

        return $this;
    }

    /**
     * <UniversalAdId> required element for the purpose of tracking ad creative, he added in VAST 4.0 spec.
     * Paragraph 3.7.1
     * https://iabtechlab.com/wp-content/uploads/2018/11/VAST4.1-final-Nov-8-2018.pdf
     *
     * @param int|string $idRegistry
     * @param int|string $universalAdId
     * @return $this
     */
    public function setUniversalAdId($idRegistry, $universalAdId)
    {
        $universalAdIdDomElement = $this->getDomElement()->ownerDocument->createElement('UniversalAdId');
        $universalAdIdDomElement->nodeValue = $universalAdId;
        $universalAdIdDomElement->setAttribute("idRegistry", $idRegistry);
        $this->getDomElement()->insertBefore($universalAdIdDomElement, $this->getDomElement()->firstChild);

        return $this;
    }

    /**
     * Set 'id' attribute of 'creative' element
     *
     * @param string $id
     * @return $this
     */
    public function setId($id)
    {
        $this->getDomElement()->setAttribute('id', $id);

        return $this;
    }

    /**
     * Set 'adId' attribute of 'creative' element
     *
     * @param string $adId
     * @return $this
     */
    public function setAdId($adId)
    {
        $this->getDomElement()->setAttribute('adId', $adId);

        return $this;
    }
}
