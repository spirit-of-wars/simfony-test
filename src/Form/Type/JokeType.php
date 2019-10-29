<?php
/**
 * Created by PhpStorm.
 * User: viktor
 * Date: 29.10.2019
 * Time: 21:11
 */

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class JokeType extends AbstractType
{
    const JOKE_CATEGORY_NERDY = 'nerdy';
    const JOKE_CATEGORY_EXPLICIT = 'explicit';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // if you don't define field options, you can omit the second argument
            ->add('email', EmailType::class)
            ->add('category', ChoiceType::class, ['choices' => [
                self::JOKE_CATEGORY_NERDY => self::JOKE_CATEGORY_NERDY,
                self::JOKE_CATEGORY_EXPLICIT => self::JOKE_CATEGORY_EXPLICIT,
                ]
            ])
            // if you define field options, pass NULL as second argument
            ->add('save', SubmitType::class)
        ;
    }
}