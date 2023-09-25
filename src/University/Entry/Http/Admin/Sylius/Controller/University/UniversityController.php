<?php

declare(strict_types=1);

namespace App\University\Entry\Http\Admin\Sylius\Controller\University;

use App\University\Application\University\UseCase\Create\Command as CreateCommand;
use App\University\Application\University\UseCase\Create\Handler as CreateHandler;
use App\University\Application\University\UseCase\Edit\Command as EditCommand;
use App\University\Application\University\UseCase\Edit\Handler as EditHandler;
use App\University\Application\University\UseCase\Remove\Command as DeleteCommand;
use App\University\Application\University\UseCase\Remove\Handler as DeleteHandler;
use App\University\Domain\University\University;
use App\University\Domain\University\ValueObject\UniversityId;
use App\University\Entry\Http\Admin\Sylius\Controller\University\Form\CreateType;
use App\University\Entry\Http\Admin\Sylius\Controller\University\Form\EditType;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route(
    path: 'university/universities',
    name: 'app_university.university_',
)]
class UniversityController extends ResourceController
{
    #[Route(
        path: '/create/new',
        name: 'create',
        methods: ['GET', 'POST'],
    )]
    public function create(
        Request $request,
        CreateHandler $handler,
        TranslatorInterface $translator,
    ): Response {
        $formData = null;

        $configuration = $this->requestConfigurationFactory->create($this->metadata, $request);
        $form = $this->createForm(CreateType::class, $formData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $payload = $form->getData();
            $result = $handler->handle(
                new CreateCommand(
                    description: $payload['description'],
                    maxStudents: (int) $payload['maxStudents'],
                    name: $payload['name'],
                )
            );
            if ($result->isSuccess()) {
                $this->addFlash('success', $translator->trans('app.admin.ui.modules.university.university.flash.success'));

                return $this->redirectToRoute('app_university.university_show', ['id' => $result->university?->getId()->getValue()]);
            }
        }

        return $this->render(
            '@app/admin/layout/crud/create.html.twig',
            [
                'metadata' => $this->metadata,
                'form' => $form->createView(),
                'resource' => $form->getData(),
                'configuration' => $configuration,
            ]
        );
    }

    #[Route(
        path: '/{id}/edit',
        name: 'update',
        methods: ['GET', 'POST'],
    )]
    public function update(
        Request $request,
        EditHandler $handler,
        TranslatorInterface $translator,
    ): Response {
        $configuration = $this->requestConfigurationFactory->create($this->metadata, $request);

        /** @var University $university */
        $university = $this->findOr404($configuration);
        if (Request::METHOD_GET === $request->getMethod()) {
            $form = $this->createForm(EditType::class, $university);
        } else {
            $form = $this->createForm(EditType::class);
        }

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $payload = $form->getData();
            $result = $handler->handle(
                new EditCommand(
                    id: $university->getId(),
                    description: $payload['description'],
                    maxStudents: (int) $payload['maxStudents'],
                    name: $payload['name'],
                )
            );
            if ($result->isSuccess()) {
                $this->addFlash('success', $translator->trans('app.admin.ui.modules.university.university.flash.success'));

                return $this->redirectToRoute('app_university.university_show', ['id' => $result->university?->getId()->getValue()]);
            }
            if ($result->isUniversityNotExists()) {
                $this->addFlash('error', $translator->trans('app.admin.ui.modules.university.university.flash.university_not_exists'));
            }
        }

        return $this->render(
            '@university/admin/university/update.html.twig',
            [
                'metadata' => $this->metadata,
                'form' => $form->createView(),
                'resource' => $form->getData(),
                'configuration' => $configuration,
            ]
        );
    }

    #[Route(
        path: '/{id}/delete',
        name: 'delete',
        methods: ['POST'],
    )]
    public function delete(
        string $id,
        DeleteHandler $handler,
        TranslatorInterface $translator,
    ): Response {
        $result = $handler->handle(
            new DeleteCommand(
                id: new UniversityId($id)
            )
        );
        if ($result->isSuccess()) {
            $this->addFlash('success', $translator->trans('app.admin.ui.modules.university.university.flash.success'));
        }
        if ($result->isUniversityNotExists()) {
            $this->addFlash('error', $translator->trans('app.admin.ui.modules.university.university.flash.university_not_exists'));
        }

        return $this->redirectToRoute('app_university.university_index');
    }
}
