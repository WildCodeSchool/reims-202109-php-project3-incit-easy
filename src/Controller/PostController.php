<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Entity\Post;
use App\Entity\User;
use App\Form\PostType;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use App\Service\UserManager;
use DateTimeImmutable;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use DoctrineExtensions\Query\Mysql\Date;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

#[Route('/post')]
class PostController extends AbstractController
{
    #[Route('/', name: 'post_index', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
        PostRepository $postRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $date = new DateTimeImmutable();

            /** @var \App\Entity\User $user */
            $user = $this->getUser();
            $post->setCreatedAt($date)->setUser($user);
            $entityManager->persist($post);
            $entityManager->flush();

            $this->addFlash('success', 'Post envoyé !');

            return $this->redirectToRoute('post_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('post/index.html.twig', [
            'posts' => $postRepository->findBy([], ['createdAt' => 'DESC']),
            'postForm' => $form,
        ]);
    }

    #[Route('/{id}/comment', name: 'post_comment_new', methods: ['POST'])]
    public function addComment(Post $post, Request $request, EntityManagerInterface $entityManager): Response
    {
        $comment = new Comment();
        $comment->setMessage((string)$request->request->get('message'));

        $date = new DateTimeImmutable();

        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        $comment->setCreatedAt($date)->setUser($user)->setPost($post);
        $entityManager->persist($comment);
        $entityManager->flush();

        return $this->redirectToRoute('post_index');
    }

    #[Route('/{id}', name: 'post_show', methods: ['GET'])]
    public function show(Post $post): Response
    {
        return $this->render('post/show.html.twig', [
            'post' => $post,
        ]);
    }

    #[Route('/{id}/edit', name: 'post_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Post $post, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('post/edit.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'post_delete', methods: ['POST'])]
    public function delete(Request $request, Post $post, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $post->getId(), (string)$request->request->get('_token'))) {
            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('post_index', [], Response::HTTP_SEE_OTHER);
    }
}
