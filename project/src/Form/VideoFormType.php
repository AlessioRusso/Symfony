<?php

namespace App\Form;

use App\Entity\Video;
use Doctrine\DBAL\Types\TextType as TypesTextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Zend\Form\Element\Submit;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class VideoFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Set video title',
                'data' => 'Example title',
                'required' => false,
            ])
            ->add('created_at', DateType::class, [
                'label' => 'Set date',
                'widget' => 'single_text',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Add a video'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Video::class,
        ]);
    }
}
