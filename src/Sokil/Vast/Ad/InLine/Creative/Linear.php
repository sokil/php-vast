<?php

namespace Sokil\Vast\Ad\InLine\Creative;

class Linear extends Base
{
    private $_mediaFilesDomElement;
    
    public function setDuration($duration)
    {
        // get dom element
        $durationDomElement = $this->_domElement->getElementsByTagName('Duration')->item(0);
        if(!$durationDomElement) {
            $durationDomElement = $this->_domElement->ownerDocument->createElement('Duration');
            $this->_domElement->appendChild($durationDomElement);
        }
        
        // set value
        if(is_numeric($duration)) {
            // in seconds
            $duration = $this->_secondsToString($duration);
        }
        
        $durationDomElement->nodeValue = $duration;
        
        return $this;
    }
    
    public function createMediaFile()
    {
        if(!$this->_mediaFilesDomElement) {
            $this->_mediaFilesDomElement = $this->_domElement->getElementsByTagName('MediaFiles')->item(0);
            if(!$this->_mediaFilesDomElement) {
                $this->_mediaFilesDomElement = $this->_domElement->ownerDocument->createElement('MediaFiles');
                $this->_domElement->appendChild($this->_mediaFilesDomElement);
            }
        }
        
        // dom
        $mediaFileDomElement = $this->_mediaFilesDomElement->ownerDocument->createElement('MediaFile');
        $this->_mediaFilesDomElement->appendChild($mediaFileDomElement);
        
        // object
        return new Base\MediaFile($mediaFileDomElement);
    }
    
    private function _secondsToString($seconds)
    {
        $seconds = (int) $seconds;
        
        $time = array();
        
        // get gours
        $hours = floor($seconds / 3600);
        if($hours)
            $time[] = str_pad($hours, 2, '0', STR_PAD_LEFT);
        
        // get minutes
        $seconds = $seconds % 3600;
        $time[] = str_pad(floor($seconds / 60), 2, '0', STR_PAD_LEFT);
        
        // get seconds
        $time[] = str_pad($seconds % 60, 2, '0', STR_PAD_LEFT);
        
        return implode(':', $time);
    }
}