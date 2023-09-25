<?php

declare(strict_types=1);

namespace App\University\Entry\Http\Admin\Sylius\AdminMenu;

use App\Common\Entry\Http\Admin\Menu\SectionBuilderInterface;
use Knp\Menu\ItemInterface;

class UniversitySectionBuilder implements SectionBuilderInterface
{
    public function build(ItemInterface $menu): void
    {
        $settings = $menu
            ->addChild('university')
            ->setLabel('app.admin.ui.menu.university.label');

        $settings
            ->addChild('student', ['route' => 'app_university.student_index'])
            ->setLabel('app.admin.ui.menu.university.student.list')
            ->setLabelAttribute('icon', 'list');

        $settings
            ->addChild('university', ['route' => 'app_university.university_index'])
            ->setLabel('app.admin.ui.menu.university.university.list')
            ->setLabelAttribute('icon', 'list');
    }

    public function getOrder(): int
    {
        return 20;
    }
}
