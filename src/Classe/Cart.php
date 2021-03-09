<?php


namespace App\Classe;


use App\Entity\Recipe;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart
{
    private $session;
    private $entityManager;


    public function __construct(SessionInterface $session, EntityManagerInterface $entityManager){
        $this->session = $session;
        $this->entityManager = $entityManager;
    }

    public function add($id){
        $cart = $this->session->get('cart', []);

        if (!empty($cart[$id])){
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }

        $this->session->set('cart', $cart);
    }

    public function decrease($id){
        $cart = $this->session->get('cart', []);

        if ($cart[$id] > 1){
            $cart[$id]--;
        } else {
            unset($cart[$id]);
        }

        $this->session->set('cart', $cart);
    }

    public function get(){
        return $this->session->get('cart');
    }

    public function remove(){
        return $this->session->remove('cart');
    }

    public function delete($id){
        $cart = $this->session->get('cart', []);

        unset($cart[$id]);
        return $this->session->set('cart', $cart);
    }

    public function getFull(){
        $cartComplete = [];
        if ($this->get()){
            foreach ($this->get() as $id => $quantity){
                $recipe_object = $this->entityManager->getRepository(Recipe::class)->findOneById($id);

                if (!$recipe_object) {
                    $this->delete($id);
                    continue;
                }

                $cartComplete[] = [
                    'recipe'=> $recipe_object,
                    'quantity'=> $quantity
                ];
            }
        }
        return $cartComplete;
    }
}