<?php

namespace App\ValidatorConstraints;

use Attribute;
use Symfony\Component\Validator\Constraint;

/**
 * Class CronTime
 *
 * @package App\ValidatorConstraints
 *
 * @author  Codememory
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class CronTime extends Constraint
{

    /**
     * @var string
     */
    public string $message = 'Incorrect cron time format. Possible formats: {{ formats }}';

    /**
     * @param string|null $message
     * @param mixed|null  $payload
     */
    public function __construct(string $message = null, mixed $payload = null)
    {

        parent::__construct($payload);

        $this->message = $message;

    }

}