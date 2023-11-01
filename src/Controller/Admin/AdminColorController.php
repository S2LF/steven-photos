<?php

namespace App\Controller\Admin;

use App\Controller\BaseController;
use App\Entity\ColorThemes;
use App\Form\ColorThemeType;
use App\Repository\BaseRepository;
use App\Repository\ColorThemesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/admin')]
#[IsGranted('ROLE_ADMIN')]
class AdminColorController extends BaseController
{
    #[Route(path: '/colors', name: 'admin_colors')]
    public function index(BaseRepository $grepo, ColorThemesRepository $ctrepo, Request $request, EntityManagerInterface $em)
    {


        $themes = $ctrepo->findAll();

        $form = $this->createForm(ColorThemeType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $colorTheme = new ColorThemes();
            $colorTheme->setBgColor($form->get('bgColor')->getData());
            $colorTheme->setSecondaryColor($form->get('secondaryColor')->getData());
            $colorTheme->setTextColor($form->get('textColor')->getData());

            if($form->get('active')->getData() == true) {
                $activeTheme = $em->getRepository(ColorThemes::class)->findOneBy(['active' => true]);
                if ($activeTheme) {
                    $activeTheme->setActive(false);
                    $em->persist($activeTheme);
                }
                $colorTheme->setActive($form->get('active')->getData() ?? false);
            }

            $em->persist($colorTheme);
            $em->flush();

            $this->addFlash("success", "Le thème a bien été ajouté");
            return $this->redirectToRoute('admin_colors');
        }

        return $this->render('admin/colors/index.html.twig', [
            'base' => $this->base,
            'theme' => $this->theme,
            'categoriesCount' => $this->categoriesCount,
            "form" => $form->createView(),
            'themes' => $themes,
        ]);
    }

    #[Route(path: '/colors/delete/{id}', name: 'admin_theme_delete')]
    public function delete(ColorThemes $colorTheme, EntityManagerInterface $em)
    {
        $em->remove($colorTheme);
        $em->flush();

        $this->addFlash("success", "Le thème à bien été supprimé");
        return $this->redirectToRoute('admin_colors');
    }

    #[Route(path: '/colors/active/{id}', name: 'admin_theme_activate')]
    public function active(ColorThemes $colorTheme, EntityManagerInterface $em)
    {
        $activeTheme = $em->getRepository(ColorThemes::class)->findOneBy(['active' => true]);
        if ($activeTheme) {
            $activeTheme->setActive(false);
            $em->persist($activeTheme);
        }

        $colorTheme->setActive(true);
        $em->persist($colorTheme);
        $em->flush();

        $this->addFlash("success", "Le thème à bien été activé");
        return $this->redirectToRoute('admin_colors');
    }
}
