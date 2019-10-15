<?php

declare(strict_types=1);

/**
 * This file is part of Narrowspark Framework.
 *
 * (c) Daniel Bannert <d.bannert@anolilab.de>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

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
