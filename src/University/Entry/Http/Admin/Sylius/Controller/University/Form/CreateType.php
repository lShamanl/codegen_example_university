<?php

declare(strict_types=1);

namespace App\University\Entry\Http\Admin\Sylius\Controller\University\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class CreateType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options,
    ): void {
        $builder
            ->add('description', TextareaType::class, [
                'required' => true,
                'label' => 'app.admin.ui.modules.university.university.properties.description',
                'constraints' => [
                    new NotBlank(allowNull: false),
                ],
            ])
            ->add('maxStudents', IntegerType::class, [
                'required' => true,
                'label' => 'app.admin.ui.modules.university.university.properties.max_students',
                'constraints' => [
                    new NotBlank(allowNull: false),
                ],
            ])
            ->add('name', TextType::class, [
                'required' => true,
                'label' => 'app.admin.ui.modules.university.university.properties.name',
                'constraints' => [
                    new Length(max: 255),
                    new NotBlank(allowNull: false),
                ],
            ]);
    }
}
