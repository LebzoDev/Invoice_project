<?php

namespace App\Form;

use App\Entity\Invoice;
use App\Entity\InvoiceLines;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InvoiceLinesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
                ->add('description',TextType::class, [
            'label' => 'Description',
            'required' => false,
            'attr' => [
                'placeholder' => 'Give a little description',
                'class' => 'form-control col-auto',
            ],
            ])
            ->add('quantity',IntegerType::class, [
                'label' => 'Quantity',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Ex: 1',
                    'class' => 'form-control col-auto',
                ],
            ])
            ->add('amount',NumberType::class, [
                'label' => 'Amount',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Ex: 1300',
                    'class' => 'form-control col-auto',
                ],
            ])
            
            ->add('vatAmount',NumberType::class, [
                'label' => 'VAT Amount',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Ex: 100.00',
                    'class' => 'form-control col-auto',
                ],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => InvoiceLines::class,
        ]);
    }
}
