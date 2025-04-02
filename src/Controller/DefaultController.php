<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Repository\BlogRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class DefaultController extends AbstractController
{
    #[Route('/default', name: 'app_default')]
    public function index(BlogRepository $blogRepository, EntityManagerInterface $em)
    {
        $blog = $blogRepository->findOneBy(['id' => 1]);
        $blog->setTitle('Test');
        $blog = (new Blog())
            ->setTitle('Title')
            ->setText('Text');

        $em->persist($blog);
        $em->flush();
        
        return $this->render('default/index.html.twig', []);
    }
}
