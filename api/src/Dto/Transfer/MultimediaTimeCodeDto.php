<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Entity\MultimediaTimeCode;
use App\Infrastructure\Dto\AbstractDataTransfer;
use App\Validator\Constraints as AppAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @template-extends AbstractDataTransfer<MultimediaTimeCode>
 */
final class MultimediaTimeCodeDto extends AbstractDataTransfer
{
    #[DtoConstraints\ToTypeConstraint]
    #[DtoConstraints\ValidationConstraint([
        new Assert\NotBlank(message: 'multimediaTimeCode@rangeTimeIsRequired'),
        new Assert\Type('integer', message: 'multimediaTimeCode@invalidFromTime'),
        new Assert\Range(minMessage: 'multimediaTimeCode@minFromTime', min: 0),
        new AppAssert\MinMaxBetweenProperty('toTime', max: true, message: 'multimediaTimeCode@fromTimeMoreToTime')
    ])]
    public ?int $fromTime = null;

    #[DtoConstraints\ToTypeConstraint]
    #[DtoConstraints\ValidationConstraint([
        new Assert\NotBlank(message: 'multimediaTimeCode@rangeTimeIsRequired'),
        new Assert\Type('integer', message: 'multimediaTimeCode@invalidToTime'),
        new AppAssert\MinMaxBetweenProperty('fromTime', min: true, message: 'multimediaTimeCode@toTimeLessFromTime')
    ])]
    public ?int $toTime = null;

    #[DtoConstraints\ToTypeConstraint]
    #[DtoConstraints\ValidationConstraint([
        new Assert\NotBlank(message: 'multimediaTimeCode@titleIsRequired'),
        new Assert\Length(max: 50, maxMessage: 'multimediaTimeCode@titleMaxLength')
    ])]
    public ?string $title = null;
}