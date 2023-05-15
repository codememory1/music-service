<?php

namespace App\Dto\Transfer;

use Codememory\Dto\Constraints as DC;
use App\Entity\MultimediaTimeCode;
use App\Validator\Constraints as AppAssert;
use Codememory\Dto\DataTransfer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @template-extends DataTransfer<MultimediaTimeCode>
 */
final class MultimediaTimeCodeDto extends DataTransfer
{
    #[DC\ToType]
    #[DC\Validation([
        new Assert\NotBlank(message: 'multimediaTimeCode@rangeTimeIsRequired'),
        new Assert\Type('integer', message: 'multimediaTimeCode@invalidFromTime'),
        new Assert\Range(minMessage: 'multimediaTimeCode@minFromTime', min: 0),
        new AppAssert\MinMaxBetweenProperty('toTime', max: true, message: 'multimediaTimeCode@fromTimeMoreToTime')
    ])]
    public ?int $fromTime = null;

    #[DC\ToType]
    #[DC\Validation([
        new Assert\NotBlank(message: 'multimediaTimeCode@rangeTimeIsRequired'),
        new Assert\Type('integer', message: 'multimediaTimeCode@invalidToTime'),
        new AppAssert\MinMaxBetweenProperty('fromTime', min: true, message: 'multimediaTimeCode@toTimeLessFromTime')
    ])]
    public ?int $toTime = null;

    #[DC\ToType]
    #[DC\Validation([
        new Assert\NotBlank(message: 'multimediaTimeCode@titleIsRequired'),
        new Assert\Length(max: 50, maxMessage: 'multimediaTimeCode@titleMaxLength')
    ])]
    public ?string $title = null;
}