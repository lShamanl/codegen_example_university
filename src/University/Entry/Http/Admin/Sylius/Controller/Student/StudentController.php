<?php

declare(strict_types=1);

namespace App\University\Entry\Http\Admin\Sylius\Controller\Student;

use App\University\Application\Student\UseCase\Create\Command as CreateCommand;
use App\University\Application\Student\UseCase\Create\Handler as CreateHandler;
use App\University\Application\Student\UseCase\Edit\Command as EditCommand;
use App\University\Application\Student\UseCase\Edit\Handler as EditHandler;
use App\University\Application\Student\UseCase\Remove\Command as DeleteCommand;
use App\University\Application\Student\UseCase\Remove\Handler as DeleteHandler;
use App\University\Domain\Student\Student;
use App\University\Domain\Student\ValueObject\StudentId;
use App\University\Domain\University\University;
use App\University\Domain\University\UniversityRepository;
use App\University\Domain\University\ValueObject\UniversityId;
use App\University\Entry\Http\Admin\Sylius\Controller\Student\Form\CreateType;
use App\University\Entry\Http\Admin\Sylius\Controller\Student\Form\EditType;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route(
    path: 'university/students',
    name: 'app_university.student_',
)]
class StudentController extends ResourceController
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
        UniversityRepository $universityRepository,
    ): Response {
        $relationIds = [
            'university_id' => $request->query->get('university_id'),
        ];
        if (empty(array_filter($relationIds))) {
            $formData = null;
        } else {
            $formData = array_filter([
                'university' => !empty($relationIds['university_id']) ? $universityRepository->findById(new UniversityId((string) $relationIds['university_id'])) : null,
            ]);
        }

        $configuration = $this->requestConfigurationFactory->create($this->metadata, $request);
        $form = $this->createForm(CreateType::class, $formData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $payload = $form->getData();
            /** @var University $university */
            $university = $payload['university'];
            $result = $handler->handle(
                new CreateCommand(
                    universityId: $university->getId(),
                    birthDay: $payload['birthDay'],
                    firstName: $payload['firstName'],
                    lastName: $payload['lastName'],
                    middleName: $payload['middleName'],
                )
            );
            if ($result->isSuccess()) {
                $this->addFlash('success', $translator->trans('app.admin.ui.modules.university.student.flash.success'));

                return $this->redirectToRoute('app_university.student_show', ['id' => $result->student?->getId()->getValue()]);
            }
            if ($result->isUniversityNotExists()) {
                $this->addFlash('error', $translator->trans('app.admin.ui.modules.university.student.flash.university_not_exists'));
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

        /** @var Student $student */
        $student = $this->findOr404($configuration);
        if (Request::METHOD_GET === $request->getMethod()) {
            $form = $this->createForm(EditType::class, $student);
        } else {
            $form = $this->createForm(EditType::class);
        }

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $payload = $form->getData();
            $result = $handler->handle(
                new EditCommand(
                    id: $student->getId(),
                    birthDay: $payload['birthDay'],
                    firstName: $payload['firstName'],
                    lastName: $payload['lastName'],
                    middleName: $payload['middleName'],
                )
            );
            if ($result->isSuccess()) {
                $this->addFlash('success', $translator->trans('app.admin.ui.modules.university.student.flash.success'));

                return $this->redirectToRoute('app_university.student_show', ['id' => $result->student?->getId()->getValue()]);
            }
            if ($result->isStudentNotExists()) {
                $this->addFlash('error', $translator->trans('app.admin.ui.modules.university.student.flash.student_not_exists'));
            }
        }

        return $this->render(
            '@university/admin/student/update.html.twig',
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
                id: new StudentId($id)
            )
        );
        if ($result->isSuccess()) {
            $this->addFlash('success', $translator->trans('app.admin.ui.modules.university.student.flash.success'));
        }
        if ($result->isStudentNotExists()) {
            $this->addFlash('error', $translator->trans('app.admin.ui.modules.university.student.flash.student_not_exists'));
        }

        return $this->redirectToRoute('app_university.student_index');
    }
}
