<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;

class HomeController extends BaseController
{
    #[Route(path: '/', name: 'home')]
    public function index()
    {
        return $this->render('home/index.html.twig', [
          'base' => $this->base,
          'categoriesCount' => $this->categoriesCount
        ]);
    }
}
