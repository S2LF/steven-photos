<?php

namespace App\Controller;

use App\Repository\BaseRepository;
use App\Repository\CategoryPhotoRepository;
use App\Repository\ColorThemesRepository;
use App\Repository\PhotoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BaseController extends AbstractController
{
    protected $base;
    protected $randomImagePath;
    protected $categoriesCount;
    protected $theme;

    public function __construct(
        BaseRepository $baseRepository,
        PhotoRepository $photoRepository,
        CategoryPhotoRepository $categoryPhotoRepository,
        ColorThemesRepository $colorThemeRepository
    ) {
        $base = $baseRepository->findOneBy(['id' => 1]);

        $activeTheme = $colorThemeRepository->findOneBy(['active' => true]);

        if ($base == null) {
            $base = [
                "siteTitle" => "Titre par défaut",
                "headerContent" => "Texte à écrire par défaut",
                "homepageWord" => "Mot page d'accueil par défaut",
                "homepageImagePath" => null,
                "textFooter" => "texte pied de page par défaut",
                "isRandomImage" => false
            ];
        }

        // Get random image for homepage
        $photos = $photoRepository->findAll();

        if($photos == null) {
            $randomPhoto = [
                "path" => null
            ];
            $this->randomImagePath = $randomPhoto['path'];
        } else {
            $randomPhoto = $photos[array_rand($photos)];
            $this->randomImagePath = $randomPhoto->getPath();
        }

        $theme = [
            "bgColor" => "#6a6a6a",
            "secondaryColor" => "#252525",
            "textColor" => "#ffffff"
        ];

        if ($activeTheme) {
            $theme["bgColor"] = $activeTheme->getBgColor();
            $theme["secondaryColor"] = $activeTheme->getSecondaryColor();
            $theme["textColor"] = $activeTheme->getTextColor();
        }

        $this->base = $base;
        $this->theme = $theme;
        $this->categoriesCount = $categoryPhotoRepository->count(['deletedAt' => null]);
    }
}
