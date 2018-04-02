<?php

namespace Sokil\Vast\Ad;

use Sokil\Vast\Creative\InLine\Linear;

class InLine extends AbstractAdNode
{
    /**
     * Set Ad title
     *
     * @param string $value
     *
     * @return \Sokil\Vast\Ad\InLine
     */
    public function setAdTitle($value)
    {
        $this->setScalarNodeCdata('AdTitle', $value);

        return $this;
    }

    /**
     * @inheritdoc
     */
    protected function buildCreativeClassName($type)
    {
        return '\\Sokil\\Vast\\Creative\\InLine\\' . $type;
    }

    /**
     * Create Linear creative
     *
     * @throws \Exception
     * @return Linear
     */
    public function createLinearCreative()
    {
        return $this->buildCreative('Linear');
    }
}
