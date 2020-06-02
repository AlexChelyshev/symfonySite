<?php


namespace App\Controller\Admin;


use Symfony\Component\Routing\Annotation\Route;

class AdminHomeController extends AdminBaseController
{
    /**
     * @Route("/admin", name="admin home")
     */
    public function index(){

        $defaultData = parent::renderDefault();

        return $this->render("admin/index.html.twig", $defaultData);
    }

}