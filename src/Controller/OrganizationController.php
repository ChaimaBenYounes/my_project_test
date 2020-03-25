<?php

namespace App\Controller;

use App\Entity\Organization;
use App\Service\OrganizationParser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class OrganizationController extends AbstractController
{
    /** @var OrganizationParser $organizationService */
    protected $organizationService;

    /**
     * OrganizationController constructor.
     * @param OrganizationParser $organizationService
     */
    public function __construct(OrganizationParser $organizationService)
    {
        $this->organizationService = $organizationService;
    }

    /**
     * @Route("/organization", name="organization")
     */
    public function list()
    {
        return $this->render('organization/list.html.twig', [
            'data' => $this->organizationService->loadYmlContent()
        ]);
    }

    /**
     * @Route("/organization/add_action", name="organization_add_action")
     */
    public function addAction(Request $request)
    {

        $organization = new Organization();
        $form = $this->createFormBuilder($organization)
            ->add('name', TextType::class)
            ->add('description', TextType::class)
            ->add('users', TextType::class, ['attr' => ['class' => 'input-tags']])
            ->add('save', SubmitType::class, ['label' => 'Create Organization'])
            ->setAction($this->generateUrl('organization_add_action'))
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var Organization $organization */
            $organization = $form->getData();

            $this->organizationService->addOrganisation($organization->normalize());

            //$this->addFlash('success', 'Article Created! Knowledge is power!');
            return $this->redirectToRoute('organization');
        }

        return $this->render('organization/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/organization/edit_action/{id}", name="organization_edit_action")
     */
    public function editAction($id, Request $request)
    {

        $organisation = $this->organizationService->loadYmlContent()['organizations'][$id];
        if (!$organisation) {
            return null;
            //message not existe
        }
        $oOrganization = new Organization();
        $oOrganization->denormalize($organisation);

        $form = $this->createFormBuilder($oOrganization)
            ->add('name', TextType::class)
            ->add('description', TextType::class)
            ->add('users', TextType::class, ['attr' => ['class' => 'input-tags']])
            ->add('save', SubmitType::class, ['label' => 'Create Organization'])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var Organization $organization */
            $organization = $form->getData();

            $this->organizationService->addOrganisationById($organization->normalize(), $id);

            $this->addFlash('success', 'Organisation edited!');
            return $this->redirectToRoute('organization');
        }

        return $this->render('organization/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/organization/delete_action/{id}", name="organization_delete_action")
     */
    public function deleteAction($id, Request $request)
    {
        $organizations = $this->organizationService->loadYmlContent()['organizations'];

        if (array_key_exists($id, $organizations) === false) {

            $this->addFlash('error', 'Organisation not exist');
            return $this->redirectToRoute('organization');
        }

        $this->organizationService->deleteOrganisationById($id);

        $this->addFlash('success', 'Organisation deleted!');
        return $this->redirectToRoute('organization');

    }
}
