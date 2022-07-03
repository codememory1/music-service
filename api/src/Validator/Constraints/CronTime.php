<?php

namespace App\Validator\Constraints;

use Attribute;
use Symfony\Component\Validator\Constraint;

/**
 * Class CronTime.
 *
 * @package App\Validator\Constraints
 *
 * @author  Codememory
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
final class CronTime extends Constraint
{
    public string $message = 'Incorrect cron time format. Possible formats: {{ formats }}';

    public function __construct(?string $message = null, mixed $options = null, ?array $groups = null, mixed $payload = null)
    {
        parent::__construct($options, $groups, $payload);

        $this->message = $message;
    }
}