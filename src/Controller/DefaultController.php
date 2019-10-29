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
                    ->setCategory(reset($jokeResponse->value->categories));

                $jokeStorage->saveJoke($joke);

                $jokeMailer->sendConfirmationMessage($joke, $data['email']);

                $this->addFlash('success', 'Joke successfully');
            } catch (Exception $e) {
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('default/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

}