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

class Wrapper extends AbstractAdNode
{
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
     * @inheritdoc
     */
    protected function buildCreativeClassName($type)
    {
        return '\\Sokil\\Vast\\Creative\\Wrapper\\' . $type;
    }

    /**
     * Create Linear creative
     *
     * @return \Sokil\Vast\Creative\Wrapper\Linear
     */
    public function createLinearCreative()
    {
        return $this->buildCreative('Linear');
    }
}
