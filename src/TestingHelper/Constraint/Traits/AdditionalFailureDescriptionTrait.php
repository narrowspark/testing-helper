<?php

declare(strict_types=1);

namespace Narrowspark\TestingHelper\Constraint\Traits;

trait AdditionalFailureDescriptionTrait
{
    /**
     * {@inheritdoc}
     */
    protected function additionalFailureDescription($other): string
    {
        $info = '';

        foreach ($this->result as $key => $valid) {
            $info .= \sprintf("\n %s %s", $valid === true ? '+' : '-', $key);
        }

        return $info;
    }
}
