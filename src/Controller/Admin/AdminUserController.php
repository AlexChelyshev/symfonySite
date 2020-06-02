<?php


namespace App\Controller\Admin;


use App\Controller\Main\BaseController;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminUserController extends BaseController
{
    /**
     * @Route("/admin/user", name="admin_user")
     */
    public function index(){
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        $forRender = parent::renderDefault();
        $forRender['title'] = 'Пользователи';
        $forRender['users'] = $users;
        return $this->render('admin/user/index.html.twig', $forRender);
    }

    /**
     * @Route("/admin/user/create", name="admin_user_create")
     */
    public function create(Request $request, UserPasswordEncoderInterface $passwordEncoder){
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $em = $this->getDoctrine()->getManager();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $password = $passwordEncoder->encodePassword($user, $user->getPlanePassword());
            $user->setPassword($password);
            $user->setRoles(["ROLE_ADMIN" ]);
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('admin_user');
        }

        $forRender = parent::renderDefault();
        $forRender['title'] = "форма создания юзера";
        $forRender['form'] = $form->createView();

        return $this->render('admin/user/form.html.twig', $forRender);
    }
}