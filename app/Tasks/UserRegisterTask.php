<?php

namespace App\Tasks;

use Codememory\Components\IndividualTasks\AbstractJob;
use Codememory\Components\Mail\Interfaces\MessageInterface;
use Codememory\Components\Mail\MailerPack;

/**
 * Class UserRegisterTask
 *
 * @package App\Tasks
 *
 * @author  Danil
 */
class UserRegisterTask extends AbstractJob
{

    /**
     * @inheritDoc
     */
    public function handler(array $parameters = []): bool
    {

        /** @var MailerPack $mailer */
        $mailer = $this->get('mailer');

        $mailer->getMailer()->createMessage(function (MessageInterface $message) use ($parameters) {
            $message
                ->setSubject($parameters['subject'])
                ->addRecipientAddress($parameters['email'])
                ->setBody($parameters['activation-token']);
        })->send();

        return true;

    }

}