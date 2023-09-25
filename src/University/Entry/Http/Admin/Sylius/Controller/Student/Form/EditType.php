<?php

declare(strict_types=1);

namespace App\University\Entry\Http\Admin\Sylius\Controller\Student\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class EditType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options,
    ): void {
        $builder
            ->add('id', HiddenType::class, [
                'label' => 'app.admin.ui.modules.university.student.properties.id',
                'attr' => [
                    'readonly' => true,
                ],
                'required' => true,
                'constraints' => [
                    new NotBlank(allowNull: false),
                ],
            ])
            ->add('birthDay', DateTimeType::class, [
                'widget' => 'single_text',
                'input' => 'datetime_immutable',
                'empty_data' => '',
                'required' => true,
                'label' => 'app.admin.ui.modules.university.student.properties.birth_day',
                'constraints' => [
                    new NotBlank(allowNull: false),
                ],
            ])
            ->add('firstName', TextType::class, [
                'required' => true,
                'label' => 'app.admin.ui.modules.university.student.properties.first_name',
                'constraints' => [
                    new Length(max: 255),
                    new NotBlank(allowNull: false),
                ],
            ])
            ->add('lastName', TextType::class, [
                'required' => true,
                'label' => 'app.admin.ui.modules.university.student.properties.last_name',
                'constraints' => [
                    new Length(max: 255),
                    new NotBlank(allowNull: false),
                ],
            ])
            ->add('middleName', TextType::class, [
                'required' => true,
                'label' => 'app.admin.ui.modules.university.student.properties.middle_name',
                'constraints' => [
                    new Length(max: 255),
                    new NotBlank(allowNull: false),
                ],
            ]);
    }
}
