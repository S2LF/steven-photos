<?php

namespace App\Controller;

use App\Repository\BaseRepository;
use App\Repository\CategoryPhotoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BaseController extends AbstractController
{
    protected $base;
    protected $expositionsCount;
    protected $linksCount;
    protected $actusCount;
    protected $categoriesCount;

    public function __construct(
        BaseRepository $baseRepository,
        CategoryPhotoRepository $categoryPhotoRepository
    ) {
        $base = $baseRepository->findOneBy(['id' => 1]);

        if ($base == null) {
            $base = [
              "siteTitle" => "Titre par défaut",
              "headerContent" => "Texte à écrire par défaut",
              "homepageWord" => "Mot page d'accueil par défaut",
              "homepageImagePath" => null,
              "textFooter" => "texte pied de page par défaut"
            ];
        }

        $this->base = $base;
        $this->categoriesCount = $categoryPhotoRepository->count(['deletedAt' => null]);
    }
}
