<?php

namespace App\Form;

use App\Entity\Crypto;
use App\Entity\Transaction;
use App\Entity\User;
use App\Entity\Wallet;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransactionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('amount')
            ->add('date', null, [
                'widget' => 'single_text',
            ])
            ->add('crypto', EntityType::class, [
                'class' => Crypto::class,
                'choice_label' => 'id',
            ])
            ->add('wallet', EntityType::class, [
                'class' => Wallet::class,
                'choice_label' => 'id',
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Transaction::class,
        ]);
    }
}
