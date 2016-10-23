<?php

namespace AppBundle\Form\Type;

use Gregwar\CaptchaBundle\Type\CaptchaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\Comment;

class CommentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('captcha', CaptchaType::class)
            ->add('user', UserType::class, ['label' => false])
            ->add('text', TextareaType::class, ['attr' => ['class' => 'form-group']])
            ->add('submit', SubmitType::class, ['attr' => ['class' => 'btn btn-default center-block']]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class
        ]);
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'comment';
    }
}
