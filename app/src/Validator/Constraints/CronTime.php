<?php

namespace App\Validator\Constraints;

use Attribute;
use Symfony\Component\Validator\Constraint;

/**
 * Class CronTime
 *
 * @package App\Validator\Constraints
 *
 * @author  Codememory
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
final class CronTime extends Constraint
{

    /**
     * @var string
     */
    public string $message = 'Incorrect cron time format. Possible formats: {{ formats }}';

    /**
     * @param string|null $message
     * @param mixed|null  $payload
     */
    public function __construct(string $message = null, mixed $options = null, array $groups = null, mixed $payload = null)
    {

        parent::__construct($options, $groups, $payload);

        $this->message = $message;

    }

}