<?php

namespace Sokil\Vast\Stub\CustomElementBuilder;

use Sokil\Vast\ElementBuilder;
use Sokil\Vast\Stub\CustomElementBuilder\Element\CustomDocument;
use Sokil\Vast\Stub\CustomElementBuilder\Element\CustomInLine;
use Sokil\Vast\Stub\CustomElementBuilder\Element\CustomMediaFile;
use Sokil\Vast\Stub\CustomElementBuilder\Element\CustomWrapper;
use Sokil\Vast\Stub\CustomElementBuilder\Element\CustomWrapperAdLinearCreative;
use Sokil\Vast\Stub\CustomElementBuilder\Element\CustomInLineAdLinearCreative;

class CustomElementBuilder extends ElementBuilder
{
    /**
     * <?xml> with <VAST> inside
     *
     * @param \DomDocument $xmlDocument
     *
     * @return CustomDocument
     */
    public function createDocument(\DomDocument $xmlDocument)
    {
        return new CustomDocument(
            $xmlDocument,
            $this
        );
    }

    /**
     * <Ad> with <InLine> inside
     *
     * @param \DomElement $adElement
     *
     * @return CustomInLine
     */
    public function createInLineAdNode(\DomElement $adElement)
    {
        return new CustomInLine($adElement, $this);
    }

    /**
     * <Ad> with <Wrapper> inside
     *
     * @param \DomElement $adElement
     *
     * @return CustomWrapper
     */
    public function createWrapperAdNode(\DomElement $adElement)
    {
        return new CustomWrapper($adElement, $this);
    }

    /**
     * <Ad><InLine><Creatives><Creative> with <Linear> inside
     *
     * @param \DOMElement $creativeDomElement
     *
     * @return CustomInLineAdLinearCreative
     */
    public function createInLineAdLinearCreative(\DOMElement $creativeDomElement)
    {
        return new CustomInLineAdLinearCreative($creativeDomElement, $this);
    }

    /**
     * <Ad><Wrapper><Creatives><Creative> with <Linear> inside
     *
     * @param \DOMElement $creativeDomElement
     *
     * @return CustomWrapperAdLinearCreative
     */
    public function createWrapperAdLinearCreative(\DOMElement $creativeDomElement)
    {
        return new CustomWrapperAdLinearCreative($creativeDomElement, $this);
    }

    /**
     * <Ad><InLine><Creatives><Creative><Linear><MediaFile>
     *
     * @param \DOMElement $mediaFileDomElement
     *
     * @return CustomMediaFile
     */
    public function createInLineAdLinearCreativeMediaFile(\DOMElement $mediaFileDomElement)
    {
        return new CustomMediaFile($mediaFileDomElement);
    }

}