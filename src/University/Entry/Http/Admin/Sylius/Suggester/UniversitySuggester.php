<?php

declare(strict_types=1);

namespace App\University\Entry\Http\Admin\Sylius\Suggester;

use App\Common\Service\Suggester\SuggesterInterface;
use App\University\Domain\University\University;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Autocomplete\Form\AsEntityAutocompleteField;
use Symfony\UX\Autocomplete\Form\ParentEntityAutocompleteType;

#[AsEntityAutocompleteField(alias: self::SUGGESTER_NAME)]
class UniversitySuggester extends AbstractType implements SuggesterInterface
{
    private const SUGGESTER_NAME = 'university_university';

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'class' => University::class,
            'choice_label' => 'name',
        ]);
    }

    public function getParent(): string
    {
        return ParentEntityAutocompleteType::class;
    }

    public function getSuggesterName(): string
    {
        return self::SUGGESTER_NAME;
    }
}
