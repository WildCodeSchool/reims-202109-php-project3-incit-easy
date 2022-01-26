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
use App\Entity\Like;
use App\Repository\LikeRepository;
use Doctrine\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Finder\Exception\AccessDeniedException;

#[Route('/post')]

class PostController extends AbstractController
{
    #[Route('/', name: 'post_index', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function index(
        Request $request,
        PostRepository $postRepository,
        EntityManagerInterface $entityManager
    ): Response {

        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        $address = $user->getAddress();
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $date = new DateTimeImmutable();

            $post->setCreatedAt($date)->setUser($user);
            $entityManager->persist($post);
            $entityManager->flush();

            $this->addFlash('success', 'Post envoyé !');

            return $this->redirectToRoute('post_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('post/index.html.twig', [
            'posts' => $postRepository->findByZipcode($address ? $address->getZipcode() : null),
            'postForm' => $form,
        ]);
    }

    #[Route('/{id}/comment', name: 'post_comment_new', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
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
    #[IsGranted('ROLE_USER')]
    public function show(Post $post): Response
    {
        return $this->render('post/show.html.twig', [
            'post' => $post,
        ]);
    }

    #[Route('/{id}/edit', name: 'post_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
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
    #[IsGranted('ROLE_USER')]
    public function delete(Request $request, Post $post, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $post->getId(), (string)$request->request->get('_token'))) {
            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('post_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/like', name: 'post_like', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function like(Post $post, EntityManagerInterface $manager, LikeRepository $likeRepository): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        if ($user == null) {
            return $this->redirectToRoute('login');
        }

        if ($post->isLikedByUser($user)) {
            $like = $likeRepository->findOneBy([
                'post' => $post,
                'user' => $user
            ]);

            if ($like != null) {
                $manager->remove($like);
            }
        } else {
            $like = new Like();
            $like->setPost($post)->setUser($user);

            $manager->persist($like);
        }

        $manager->flush();

        return $this->redirectToRoute('post_index');
    }

    #[Route('/{id}/like', name: 'post_like', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function likeUsingAPI(Post $post, EntityManagerInterface $manager, LikeRepository $likeRepository): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        if ($user == null) {
            return $this->json([
                'Message' => 'Unauthorized'
            ], 403);
        }

        if ($post->isLikedByUser($user)) {
            $like = $likeRepository->findOneBy([
                'post' => $post,
                'user' => $user
            ]);

            if ($like != null) {
                $manager->remove($like);
            }

            $message = 'Like supprimé !';
        } else {
            $like = new Like();
            $like->setPost($post)->setUser($user);

            $manager->persist($like);

            $message = 'Tout fonctionne !';
        }

        $manager->flush();

        return $this->json([
            'message' => $message,
            'likes' => $likeRepository->count(['post' => $post])
        ], 200);
    }
}
