<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderCancelController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    #[Route('/commande/erreur/{stripeSessionId}', name: 'order_cancel')]
    public function index($stripeSessionId): Response
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);

        if (!$order || $order->getUser() != $this->getUser()){
            return $this->redirectToRoute('home');
        }

        $mail = new Mail();
        $content = "Bonjour ".$order->getUser()->getFirstname()."<br>Votre commande n'a pas aboutie.<br><br>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A, adipisci, assumenda at dolorem, doloribus error harum itaque labore laborum laudantium molestiae nam necessitatibus quis recusandae repudiandae sunt unde velit voluptates?";
        $mail->send($order->getUser()->getEmail(),$order->getUser()->getFirstname(),'Votre commande Les Magiciens du Fouet a été annulée.', $content);

        return $this->render('order_cancel/index.html.twig', [
            'order'=>$order
        ]);
    }
}
