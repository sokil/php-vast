<?php

/**
 * This file is part of the PHP-VAST package.
 *
 * (c) Dmytro Sokil <dmytro.sokil@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sokil\Vast\Ad;

use Sokil\Vast\Creative\AbstractCreative;
use Sokil\Vast\Creative\Wrapper\Linear as WrapperAdLinearCreative;

class Wrapper extends AbstractAdNode
{
    /**
     * @private
     */
    const CREATIVE_TYPE_LINEAR = 'Linear';

    /**
     * URI of ad tag of downstream Secondary Ad Server
     *
     * @param string $uri
     * @return $this
     */
    public function setVASTAdTagURI($uri)
    {
        $this->setScalarNodeCdata('VASTAdTagURI', $uri);
        return $this;
    }

    /**
     * @return string[]
     */
    protected function getAvailableCreativeTypes()
    {
        return array(
            self::CREATIVE_TYPE_LINEAR,
        );
    }

    /**
     * @param string $type
     * @param \DOMElement $creativeDomElement
     *
     * @return AbstractCreative|WrapperAdLinearCreative
     */
    protected function buildCreativeElement($type, \DOMElement $creativeDomElement)
    {
        switch ($type) {
            case self::CREATIVE_TYPE_LINEAR:
                $creative = $this->vastElementBuilder->createWrapperAdLinearCreative($creativeDomElement);
                break;
            default:
                throw new \RuntimeException(sprintf('Unknown Wrapper creative type %s', $type));
        }

        return $creative;
    }

    /**
     * Create Linear creative
     *
     * @return WrapperAdLinearCreative
     */
    public function createLinearCreative()
    {
        /** @var WrapperAdLinearCreative $creative */
        $creative = $this->buildCreative(self::CREATIVE_TYPE_LINEAR);

        return $creative;
    }
}
