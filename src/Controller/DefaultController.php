<?php

namespace App\Controller;

use App\Form\Type\JokeType;
use App\Model\Joke;
use App\Service\Http\JokeHttp;
use App\Service\Mailer\JokeMailer;
use App\Service\Storage\JokeStorage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends AbstractController
{
    public function index(Request $request, JokeHttp $http, JokeStorage $jokeStorage, JokeMailer $jokeMailer)
    {
        $form = $this->createForm(JokeType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $data = $form->getData();
                $jokeResponse = $http->getRandomJokeFromCategory($data['category']);
                $joke = new Joke();
                $joke
                    ->setId($jokeResponse->value->id)
                    ->setText($jokeResponse->value->joke)
                    ->setCategory($jokeResponse->value->categories[0]);

                $jokeStorage->saveJoke($joke);

                $jokeMailer->sendConfirmationMessage($joke, $data['email']);

            } catch (Exception $e) {
                $this->addFlash('error', $e->getMessage());
            }
//            return $this->redirectToRoute('task_success');
        }

        return $this->render('default/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function send(Request $request, JokeHttp $http, JokeStorage $jokeStorage, JokeMailer $jokeMailer)
    {
        $jokeResponse = $http->getRandomJokeFromCategory($http->getJokeCategory()[0]);
        $joke = new Joke();
        $joke
            ->setId($jokeResponse->value->id)
            ->setText($jokeResponse->value->joke)
            ->setCategory($jokeResponse->value->categories[0]);

        $jokeStorage->saveJoke($joke);

        $jokeMailer->sendConfirmationMessage($joke);
    }

}