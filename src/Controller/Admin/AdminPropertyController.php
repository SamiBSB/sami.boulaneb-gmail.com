<?php


namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPropertyController extends AbstractController
{

    /**
     * @var PropertyRepository
     */
    private $repository;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(PropertyRepository $repository,EntityManagerInterface $em)
    {
        $this->repository=$repository;
        $this->em=$em;
    }

    /**
     * @Route("/admi", name="admin.property.index")
     *
     * @return Response
     */
    public function index():Response
    {
        $properties=$this->repository->findAll();

        return  $this->render('admin/property/index.html.twig',compact('properties'));
    }

    /**
     * @Route("admi/property/new", name="admin.property.new")
     *
     * @param Request $request
     * @return Response
     */
    public function create( Request $request):Response
    {
        $property=new Property();
        $form=$this->createForm(PropertyType::class,$property);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($property);
            $this->em->flush();
            $this->addFlash('success','Le bien a été crée avec succés');
            return $this->redirectToRoute('admin.property.index');
        }
        return  $this->render('admin/property/new.html.twig',[
            'property'=>$property,
            'form'=> $form->createView()
        ]);

    }

    /**
     * @Route("/admi/property/{id}", name="admin.property.edit", methods="GET|POST")
     * @param Property $property
     * @param Request $request
     * @return Response
     */
    public function edit(Property $property, Request $request):Response
    {
        $form=$this->createForm(PropertyType::class,$property);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success','Le bien a été edité avec succés');
            return $this->redirectToRoute('admin.property.index');
        }
        return  $this->render('admin/property/edit.html.twig',[
            'property'=>$property,
            'form'=> $form->createView()
        ]);
    }

    /**
     * @Route("/admi/property/{id}", name="admin.property.delete" , requirements={"id":"\d+"}, methods="DELETE")
     * @param Property $property
     * @param Request $request
     * @return RedirectResponse
     */
   public function delete(Property $property,Request $request){
if($this->isCsrfTokenValid('delete' . $property->getId() , $request->get('_token'))){

    $this->em->remove($property);

    $this->em->flush();

    $this->addFlash('success','Le bien a été supprimé avec succés');

}
        return $this->redirectToRoute('admin.property.index');

    }
}