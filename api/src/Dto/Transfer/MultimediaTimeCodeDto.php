<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Entity\MultimediaTimeCode;
use App\Validator\Constraints as AppAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @template-extends AbstractDataTransfer<MultimediaTimeCode>
 */
final class MultimediaTimeCodeDto extends AbstractDataTransfer
{
    #[Assert\NotBlank(message: 'multimediaTimeCode@rangeTimeIsRequired')]
    #[Assert\Type('integer', message: 'multimediaTimeCode@invalidFromTime')]
    #[Assert\Range(minMessage: 'multimediaTimeCode@minFromTime', min: 0)]
    #[AppAssert\MinMaxBetweenProperty('toTime', max: true, message: 'multimediaTimeCode@fromTimeMoreToTime')]
    #[DtoConstraints\ToTypeConstraint]
    public ?int $fromTime = null;

    #[Assert\NotBlank(message: 'multimediaTimeCode@rangeTimeIsRequired')]
    #[Assert\Type('integer', message: 'multimediaTimeCode@invalidToTime')]
    #[AppAssert\MinMaxBetweenProperty('fromTime', min: true, message: 'multimediaTimeCode@toTimeLessFromTime')]
    #[DtoConstraints\ToTypeConstraint]
    public ?int $toTime = null;

    #[Assert\NotBlank(message: 'multimediaTimeCode@titleIsRequired')]
    #[Assert\Length(max: 50, maxMessage: 'multimediaTimeCode@titleMaxLength')]
    #[DtoConstraints\ToTypeConstraint]
    public ?string $title = null;
}