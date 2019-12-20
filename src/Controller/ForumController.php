<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\Thread;
use App\Form\MessageType;
use App\Repository\MessageRepository;
use App\Repository\ThreadRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ForumController extends AbstractController
{
    /**
     * @Route("/forum", name="forum")
     */
    public function index()
    {
        return $this->render('forum/index.html.twig', [
            'controller_name' => 'ForumController',
        ]);
    }

    /**
     * @Route("/forum/Messages", name="messages")
     */
    public function messagesshow(ThreadRepository $repo) {
        $repo = $this->getDoctrine()->getRepository(Thread::class);
        $threads = $repo->findAll();

        return $this->render('forum/messages.html.twig', [
            'threads' => $threads,
        ]);
    }

    /**
     * @Route("/commentaires/{id}", name="commentaires")
     */
    public function details(MessageRepository $repo, Thread $thread, Request $request, EntityManagerInterface $manager)
    {
        $messages = $repo->findBy(array('thread' => $thread));
        $commentaire = new Message();

        $form = $this->createForm(MessageType::class, $commentaire);
        $commentaire->setCreatedAt(new \DateTime());
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
                $commentaire->setThread($thread);
                $commentaire-> setCreatedAt(new \DateTime());


            $manager->persist($commentaire);
            $manager->flush();
        }

        return $this->render('forum/commentaires.html.twig', [
            'messages' => $messages,
            'thread' => $thread,
            'formCommentaire'=>$form->createView()
        ]);
    }
//    public function details(Message $message) {
//        $repo = $this->getDoctrine()->getRepository(Message::class);
//        $message = $repo->find($message);
//        return $this->render('forum/commentaires.html.twig', [
//            'message' => $message,
//        ]);


}
