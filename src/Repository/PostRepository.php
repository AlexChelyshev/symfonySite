<?php

namespace App\Repository;

use App\Entity\Post;
use App\Service\FileManagerService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository implements PostRepositryInterface
{
    private $em;
    private $fm;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager, FileManagerService $service)
    {
        $this->em = $manager;
        $this->fm = $service;
        parent::__construct($registry, Post::class);
    }

    /**
     * @inheritDoc
     */
    public function getAllPost(): array
    {
        return  parent::findAll();
    }

    /**
     * @inheritDoc
     */
    public function getOnePost(int $postId): object
    {
        return  parent::find($postId);
    }

    /**
     * @inheritDoc
     */
    public function setCreatePost(Post $post, UploadedFile $file): object
    {
        if($file){
            $fileName = $this->fm->imagePostUpload($file);
            $post->setImage($fileName);
        }
        $post->setCreateAtValue();
        $post->setUpdateAtValue();
        $post->setIsPublished();
        $this->em->persist($post);
        $this->em->flush();

        return $post;
    }

    /**
     * @inheritDoc
     */
    public function setUpdatePost(Post $post, UploadedFile $file): object
    {
        $fileName = $post->getImage();
        if($file){
            if($fileName){
                $this->fm->removePostImage($fileName);
            }
            $fileName = $this->fm->imagePostUpload($file);
            $post->setImage($fileName);
        }
        $post->setUpdateAtValue();
        $this->em->flush();
        return $post;
    }

    /**
     * @inheritDoc
     */
    public function setDeletePost(Post $post)
    {
       $fileName = $post->getImage();
       if($fileName){
           $this->fm->removePostImage($fileName);
       }
       $this->em->remove($post);
       $this->em->flush();
    }
}
