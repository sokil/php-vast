<?php

namespace Sokil\Vast\Ad;

use Sokil\Vast\Creative\AbstractLinearCreative;
use Sokil\Vast\Document\AbstractNode;

abstract class AbstractAdNode extends AbstractNode
{
    /**
     * @var \DOMElement
     */
    private $domElement;

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
     * @param \DOMElement $domElement instance of \Vast\Ad element
     */
    public function __construct(\DOMElement $domElement)
    {
        $this->domElement = $domElement;
    }

    /**
     * Instance of "\Vast\Ad\(InLine|Wrapper)" emenet
     *
     * @return \DOMElement
     */
    protected function getDomElement()
    {
        return $this->domElement->firstChild;
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
     * @return InLine|Wrapper|AbstractAdNode
     */
    public function setId($id)
    {
        $this->domElement->setAttribute('id', $id);

        return $this;
    }

    /**
     * Format a VAST 3.0 response that groups multiple ads into a sequential pod of ads
     *
     * @param int $sequence a number greater than zero (0) that identifies the sequence in which an ad should play;
     *                      all <Ad> elements with sequence values are part of a pod and are intended to be played
     *                      in sequence
     *
     * @return InLine|Wrapper|AbstractAdNode
     */
    public function setSequence($sequence)
    {
        $this->domElement->setAttribute('sequence', $sequence);
        return $this;
    }

    /**
     * @return int
     */
    public function getSequence()
    {
        return (int)($this->domElement->getAttribute('sequence'));
    }

    /**
     * /Vast/Ad/Inline/AdSystem element
     *
     * @param string $adSystem
     *
     * @return InLine|Wrapper|AbstractAdNode
     */
    public function setAdSystem($adSystem)
    {
        $this->setScalarNodeCdata('AdSystem', $adSystem);
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

        // Creative type dom element
        $creativeTypeDomElement = $this->domElement->ownerDocument->createElement($type);
        $creativeDomElement->appendChild($creativeTypeDomElement);

        // object
        $creative = new $creativeClassName($creativeDomElement);
        $this->creatives[] = $creative;

        return $creative;
    }

        /**
     * Add Error tracking url.
     * Allowed multiple error elements.
     *
     * @param string $url
     *
     * @return $this
     */
    public function addError($url)
    {
        $this->addCdataToArrayNode('Error', $url);
        return $this;
    }

    /**
     * Get previously set error tracking url value
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->getValuesOfArrayNode('Error');
    }

    /**
     * Add Impression tracking url
     * Allowed multiple impressions
     *
     * @param string $url
     *
     * @return $this
     */
    public function addImpression($url)
    {
        $this->addCdataToArrayNode('Impression', $url);
        return $this;
    }

    /**
     * @deprecated Ad may have multiple impressions, so use self::addImpression()
     *
     * @param string $url
     */
    public function setImpression($url)
    {
        $this->addImpression($url);
    }

    /**
     * Get previously set impression tracking url value
     *
     * @return array
     */
    public function getImpressions()
    {
        return $this->getValuesOfArrayNode('Impression');
    }
}
