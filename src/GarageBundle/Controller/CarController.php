<?php

namespace GarageBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use GarageBundle\Entity\Car;
use GarageBundle\Form\CarType;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Car controller.
 *
 */
class CarController extends Controller
{
    /**
     * Lists all Car entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cars = $em->getRepository('GarageBundle:Car')->findAll();

        return $this->render('car/index.html.twig', array(
            'cars' => $cars,
        ));
    }

    public function listOwnAction()
    {
        $tokenStorage = $this->get('security.token_storage');
        /**
         * @var User $user
         */
        $user = $tokenStorage->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        $cars = $em->getRepository('GarageBundle:Car')->findByUser($user->getId());
        
        return $this->render(':car:index.html.twig', array(
            'cars' => $cars
        ));
    }

    /**
     * Creates a new Car entity.
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function newAction(Request $request)
    {
        $car = new Car();
        $form = $this->createForm('GarageBundle\Form\CarType', $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tokenStorage = $this->get('security.token_storage');
            $user = $tokenStorage->getToken()->getUser();
            $car->setUser($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($car);
            $em->flush();

            // creating the ACL
            $aclProvider = $this->get('security.acl.provider');
            $objectIdentity = ObjectIdentity::fromDomainObject($car);
            $acl = $aclProvider->createAcl($objectIdentity);

            // retrieving the security identity of the currently logged-in user
            $securityIdentity = UserSecurityIdentity::fromAccount($user);

            // grant owner access
            $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
            $aclProvider->updateAcl($acl);

            return $this->redirectToRoute('car_show', array('id' => $car->getId()));
        }

        return $this->render('car/new.html.twig', array(
            'car' => $car,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Car entity.
     *
     */
    public function showAction(Car $car)
    {
        $deleteForm = $this->createDeleteForm($car);

        return $this->render('car/show.html.twig', array(
            'car' => $car,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Car entity.
     * @param Request $request
     * @param Car $car
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Car $car)
    {
        $authorizationChecker = $this->get('security.authorization_checker');

        // check for edit access
        if (false === $authorizationChecker->isGranted('EDIT', $car)) {
            throw new AccessDeniedException();
        }

        $deleteForm = $this->createDeleteForm($car);
        $editForm = $this->createForm('GarageBundle\Form\CarType', $car);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($car);
            $em->flush();

            return $this->redirectToRoute('car_edit', array('id' => $car->getId()));
        }

        return $this->render('car/edit.html.twig', array(
            'car' => $car,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Car entity.
     * @param Request $request
     * @param Car $car
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Car $car)
    {
        $authorizationChecker = $this->get('security.authorization_checker');

        // check for edit access
        if (false === $authorizationChecker->isGranted('DELETE', $car)) {
            throw new AccessDeniedException();
        }

        $form = $this->createDeleteForm($car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($car);
            $em->flush();
        }

        return $this->redirectToRoute('car_index');
    }

    /**
     * Creates a form to delete a Car entity.
     *
     * @param Car $car The Car entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Car $car)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('car_delete', array('id' => $car->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
