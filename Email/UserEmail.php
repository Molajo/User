<?php

namespace User\Classes;

use User\Entity\User as UserEntity;

class Email
{

    public function __construct($parameters)
    {

    }

    /**
     * Send the activation email
     *
     * @param \User\Entity\User $from
     * @param \User\Entity\User $to
     * @param string            $subject
     * @param string            $emailContent
     *
     * @return mixed
     */
    public function sendEmail(UserEntity $from, UserEntity $to, $subject, $emailContent)
    {

        $transport = \Swift_MailTransport::newInstance();
        $mailer    = \Swift_Mailer::newInstance($transport);
        $message   = \Swift_Message::newInstance($subject)
            ->setFrom(array($from->getEmail() => $from->getFullName()))
            ->setTo(array($to->getEmail() => $to->getFullName()))
            ->setBody($emailContent, 'text/html');

        return $mailer->send($message);

    }

    /**
     * Set parameter Value
     *
     * @param   string  $key
     * @param   null    $value
     *
     * @return  mixed
     * @throws  AuthorisationException
     * @since   1.0
     */
    public function set($key, $value = null)
    {

    }

    /**
     * Get parameters value
     *
     * @param   string  $key
     * @param   null    $value
     *
     * @return  mixed
     * @throws  AuthorisationException
     * @since   1.0
     */
    public function get($key, $default = null)
    {

    }

    /**
     * Send email
     *
     * @return  mixed
     * @throws  AuthorisationException
     * @since   1.0
     */
    public function send()
    {

    }

}
