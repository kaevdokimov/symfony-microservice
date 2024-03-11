<?php

namespace App\Controller;

use App\Cache\ProductsCache;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    /**
     * @throws InvalidArgumentException
     */
    #[Route('/', name: 'app_main')]
    public function index(Request $request, ProductsCache $productsCache): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'products' => $productsCache->findProducts()
        ]);
    }
}
