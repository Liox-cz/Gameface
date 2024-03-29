<?php
declare(strict_types=1);

namespace Liox\Shop\FormType;

use Liox\Shop\FormData\SubscribeNewsletterFormData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @extends AbstractType<SubscribeNewsletterFormType>
 */
final class SubscribeNewsletterFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('email', EmailType::class);
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SubscribeNewsletterFormData::class,
        ]);
    }
}
