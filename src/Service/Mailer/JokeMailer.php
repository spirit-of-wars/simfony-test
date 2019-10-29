<?php

namespace App\Service\Mailer;

use App\Model\Joke;
use Swift_Mailer;
use Swift_Message;
use Twig\Environment;

class JokeMailer
{
    const FROM_ADDRESS = 'test@test.ru';

    /**
     * @var Swift_Mailer
     */
    private $mailer;

    /**
     * @var Environment
     */
    private $twig;

    public function __construct(
        Swift_Mailer $mailer,
        Environment $twig
    ){
        $this->mailer = $mailer;
        $this->twig = $twig;

    }

    /**
     * @param Joke $joke
     * @param $mail
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function sendConfirmationMessage(Joke $joke, $mail)
    {
        $messageBody = $this->twig->render('joke/mail.html.twig', [
            'joke' => $joke
        ]);

        $message = new Swift_Message();
        $message
            ->setSubject('Вы успешно прошли регистрацию!')
            ->setFrom(self::FROM_ADDRESS)
            ->setTo($mail)
            ->setBody($messageBody, 'text/html');

        $this->mailer->send($message);
    }
}