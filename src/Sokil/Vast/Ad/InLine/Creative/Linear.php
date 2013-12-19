<?php

namespace Sokil\Vast\Ad\InLine\Creative;

class Linear extends Base
{
    /**
     * not to be confused with an impression, this event indicates that an individual creative
     * portion of the ad was viewed. An impression indicates the first frame of the ad was displayed; however
     * an ad may be composed of multiple creative, or creative that only play on some platforms and not
     * others. This event enables ad servers to track which ad creative are viewed, and therefore, which
     * platforms are more common.
     */
    const EVENT_TYPE_CREATIVEVIEW = 'creativeView'; // 
                     
    /**
     * this event is used to indicate that an individual creative within the ad was loaded and playback
     * began. As with creativeView, this event is another way of tracking creative playback.
     */
    const EVENT_TYPE_START = 'start';
    
    // the creative played for at least 25% of the total duration.
    const EVENT_TYPE_FIRSTQUARTILE = 'firstQuartile';
    
    // the creative played for at least 50% of the total duration.
    const EVENT_TYPE_MIDPOINT = 'midpoint';
    
    // the creative played for at least 75% of the duration.
    const EVENT_TYPE_ = 'thirdQuartile';
    
    // The creative was played to the end at normal speed.
    const EVENT_TYPE_COMPLETE = 'complete';
    
    // the user activated the mute control and muted the creative.
    const EVENT_TYPE_MUTE = 'mute';
    
    // the user activated the mute control and unmuted the creative.
    const EVENT_TYPE_UNMUTE = 'unmute';
    
    // the user clicked the pause control and stopped the creative.
    const EVENT_TYPE_PAUSE = 'pause';
    
    // the user activated the rewind control to access a previous point in the creative timeline.
    const EVENT_TYPE_REWIND = 'rewind';
    
    // the user activated the resume control after the creative had been stopped or paused.
    const EVENT_TYPE_RESUME = 'resume';
    
    // the user activated a control to extend the video player to the edges of the viewer’s screen.
    const EVENT_TYPE_FULLSCREEN = 'fullscreen';
    
    // the user activated the control to reduce video player size to original dimensions.
    const EVENT_TYPE_EXITFULLSCREEN = 'exitFullscreen';
    
    // the user activated a control to expand the creative.
    const EVENT_TYPE_EXPAND = 'expand';
    
    // the user activated a control to reduce the creative to its original dimensions.
    const EVENT_TYPE_COLLAPSE = 'collapse';
    
    /**
     * the user activated a control that launched an additional portion of the
     * creative. The name of this event distinguishes it from the existing “acceptInvitation” event described in
     * the 2008 IAB Digital Video In-Stream Ad Metrics Definitions, which defines the “acceptInivitation”
     * metric as applying to non-linear ads only. The “acceptInvitationLinear” event extends the metric for use
     * in Linear creative.
     */
    const EVENT_TYPE_ACCEPTINVITATIONLINEAR = 'acceptInvitationLinear';
    
    /**
     * the user clicked the close button on the creative. The name of this event distinguishes it
     * from the existing “close” event described in the 2008 IAB Digital Video In-Stream Ad Metrics
     * Definitions, which defines the “close” metric as applying to non-linear ads only. The “closeLinear” event
     * extends the “close” event for use in Linear creative.
     */
    const EVENT_TYPE_CLOSELINEAR = 'closeLinear';
    
    // the user activated a skip control to skip the creative, which is a different control than the one used to close the creative.
    const EVENT_TYPE_SKIP = 'skip';
    
    /**
     * the creative played for a duration at normal speed that is equal to or greater than the
     * value provided in an additional attribute for offset . Offset values can be time in the format
     * HH:MM:SS or HH:MM:SS.mmm or a percentage value in the format n% . Multiple progress ev
     */
    const EVENT_TYPE_PROGRESS = 'progress';
    
    private $_mediaFilesDomElement;
    
    private $_videoClicksDomElement;
    
    private $_trackingEventsDomElement;
    
    public function setDuration($duration)
    {
        // get dom element
        $durationDomElement = $this->_domElement->getElementsByTagName('Duration')->item(0);
        if(!$durationDomElement) {
            $durationDomElement = $this->_domElement->ownerDocument->createElement('Duration');
            $this->_domElement->firstChild->appendChild($durationDomElement);
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
                $this->_domElement->firstChild->appendChild($this->_mediaFilesDomElement);
            }
        }
        
        // dom
        $mediaFileDomElement = $this->_mediaFilesDomElement->ownerDocument->createElement('MediaFile');
        $this->_mediaFilesDomElement->appendChild($mediaFileDomElement);
        
        // object
        return new Base\MediaFile($mediaFileDomElement);
    }
    
    private function _getVideoClipsDomElement()
    {
        // create container
        if($this->_videoClicksDomElement) {
            return $this->_videoClicksDomElement;
        }
        
        $this->_videoClicksDomElement = $this->_domElement->getElementsByTagName('VideoClips')->item(0);
        if($this->_videoClicksDomElement) {
            return $this->_videoClicksDomElement;
        }
        
        $this->_videoClicksDomElement = $this->_domElement->ownerDocument->createElement('VideoClips');
        $this->_domElement->firstChild->appendChild($this->_videoClicksDomElement);
        
        return $this->_videoClicksDomElement;
    }
    
    /**
     * 
     * @param type $url
     * @return \Sokil\Vast\Ad\InLine\Creative\Linear
     */
    public function setVideoClipsClickThrough($url)
    {
        // create cdata
        $cdata = $this->_domElement->ownerDocument->createCDATASection($url);
        
        // create ClickThrough
        $clickThroughDomElement = $this->_getVideoClipsDomElement()->getElementsByTagName('ClickThrough')->item(0);
        if(!$clickThroughDomElement) {
            $clickThroughDomElement = $this->_domElement->ownerDocument->createElement('ClickThrough');
            $this->_getVideoClipsDomElement()->appendChild($clickThroughDomElement);
        }
        
        // update CData
        if($clickThroughDomElement->hasChildNodes()) {
            $clickThroughDomElement->replaceChild($cdata, $clickThroughDomElement->firstChild);
        }
        
        // insert CData
        else {
            $clickThroughDomElement->appendChild($cdata);
        }
        
        return $this;
    }
    
    /**
     * 
     * @param type $url
     * @return \Sokil\Vast\Ad\InLine\Creative\Linear
     */
    public function addVideoClipsClickTracking($url)
    {
        // create ClickTracking
        $clickTrackingDomElement = $this->_domElement->ownerDocument->createElement('ClickTracking');
        $this->_getVideoClipsDomElement()->appendChild($clickTrackingDomElement);
        
        // create cdata
        $cdata = $this->_domElement->ownerDocument->createCDATASection($url);
        $clickTrackingDomElement->appendChild($cdata);
        
        return $this;
    }
    
    /**
     * 
     * @param type $url
     * @return \Sokil\Vast\Ad\InLine\Creative\Linear
     */
    public function addVideoClipsCustomClick($url)
    {
        // create CustomClick
        $customClickDomElement = $this->_domElement->ownerDocument->createElement('CustomClick');
        $this->_getVideoClipsDomElement()->appendChild($customClickDomElement);
        
        // create cdata
        $cdata = $this->_domElement->ownerDocument->createCDATASection($url);
        $customClickDomElement->appendChild($cdata);
        
        return $this;
    }
    
    private function _getTrackingEventsDomElement()
    {
        // create container
        if($this->_trackingEventsDomElement) {
            return $this->_trackingEventsDomElement;
        }
        
        $this->_trackingEventsDomElement = $this->_domElement->getElementsByTagName('TrackingEvents')->item(0);
        if($this->_trackingEventsDomElement) {
            return $this->_trackingEventsDomElement;
        }
        
        $this->_trackingEventsDomElement = $this->_domElement->ownerDocument->createElement('TrackingEvents');
        $this->_domElement->firstChild->appendChild($this->_trackingEventsDomElement);
        
        return $this->_trackingEventsDomElement;
    }
    
    public function addTrackingEvent($event, $url)
    {
        // create Tracking
        $trackingDomElement = $this->_domElement->ownerDocument->createElement('Tracking');
        $this->_getTrackingEventsDomElement()->appendChild($trackingDomElement);
        
        // add event attribute
        $trackingDomElement->setAttribute('event', $event);
        
        // create cdata
        $cdata = $this->_domElement->ownerDocument->createCDATASection($url);
        $trackingDomElement->appendChild($cdata);
        
        return $this;
    }
    
        
    public function skipAfter($time) {
        if(is_numeric($time)) {
            $time = $this->_secondsToString($time);
        }
        
        $this->_domElement->setAttribute('skipoffset', $time);
        
        return $this;
    }
    
    private function _secondsToString($seconds)
    {
        $seconds = (int) $seconds;
        
        $time = array();
        
        // get hours
        $hours = floor($seconds / 3600);
        $time[] = str_pad($hours, 2, '0', STR_PAD_LEFT);
        
        // get minutes
        $seconds = $seconds % 3600;
        $time[] = str_pad(floor($seconds / 60), 2, '0', STR_PAD_LEFT);
        
        // get seconds
        $time[] = str_pad($seconds % 60, 2, '0', STR_PAD_LEFT);
        
        return implode(':', $time);
    }
}