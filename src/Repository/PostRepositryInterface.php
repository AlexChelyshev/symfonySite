<?php


namespace App\Repository;


use App\Entity\Post;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface PostRepositryInterface
{
    /**
     * @return Post[]
     */
    public function getAllPost(): array;

    /**
     * @param int $postId
     * @return Post
     */
    public function getOnePost(int $postId): object;

    /**
     * @param Post $post
     * @param UploadedFile $file
     * @return Post
     */
    public function  setCreatePost(Post $post, UploadedFile $file): object ;

    /**
     * @param Post $post
     * @param UploadedFile $file
     * @return Post
     */
    public function setUpdatePost(Post $post, UploadedFile $file): object;

    /**
     * @param Post $post
     * @return Post
     */
    public function setDeletePost(Post $post);

}