<?php

namespace App\Controller;

use App\Entity\Commandes;
use App\Entity\User;
use App\Repository\CommandesRepository;
use App\Repository\UserRepository;
use App\Services\CartService;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

#[Route('/checkout')]
class CheckoutController extends AbstractController
{
    public function __construct(
        private UserPasswordHasherInterface $hasher,
        private  ManagerRegistry $em,
        private $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]),
    ) {
    }

    //checkoutCardonly

    #[Route('/cardonly', name: 'app_checkout_cardonly')]
    public function checkoutCardonly(Request $request, CartService $cartService, UserRepository $userRepository, CommandesRepository $commandesRepository): Response
    {
        $em = $this->em->getManager();
        if (!$cartService->getCartDatas()) return $this->redirectToRoute('app_modeles');

        $total = 0;
        $remise = 0;
        $cart = $cartService->getFull();
        $productType = $cartService->getProductType();

        
            foreach ($cart as $product) {
                $productCommande = $product['product']->getCommandes();
                $productTotal = $product['product']->getPrice() * $product['quantity'];
                $total += $productTotal;
                $request->request->all() ? $product['product']->setCommandes( $productCommande + 1 ) : false;
            }
        
        if ($request->request->all()) {
            $data = json_encode($request->request->all());

            $commande = new Commandes();
            $commande = $this->serializer->deserialize($data, Commandes::class, 'json');
            if ($productType == "cardonly") {
                $user = new User();
                $user = $this->serializer->deserialize($data, User::class, 'json');
                $user->setDateCreation(new \DateTime('now'));
                $user->setStatut(true);
                $user->setRoles(['ROLE_CLIENT']);
                $passwordEncoded = $this->hasher->hashPassword(new User(), '123456');
                $user->setPassword($passwordEncoded);
                
                $userRepository->save($user, true);
                $commande->setUser($user);
                
                
            }
            // commande
            $commande->setTotal($total);
            $commande->setRemise($remise);
            $commande->setProductType("cardonly");
            $commande->getRemise() != 0 ? $commande->setPromotions(true) : $commande->setPromotions(false);
            $commande->setTotalTcc($total - $remise);
            $commande->setDateCommandes(new \DateTime('now'));
            $commandesRepository->save($commande, true);
            $em->flush();
            // dd($commande);
            $this->addFlash(
               'success',
               'Votre Commande a été prise en compte, merci pour votre confiance!'
            );
            return $this->redirectToRoute('app_cart_remove');
        }
        return $this->render('cart/paymentcardonly.html.twig', [
            'cart' => $cart,
            'productType' => $productType,
            'total' => $total,
        ]);
    }

    //checkoutPack
    #[Route('/pack', name: 'app_checkout_pack',)]
    #[Security("is_granted('ROLE_CLIENT')")]
    public function checkoutPack(Request $request, CartService $cartService, UserRepository $userRepository, CommandesRepository $commandesRepository): Response
    {
        $em = $this->em->getManager();
        if (!$cartService->getCartDatas()) return $this->redirectToRoute('app_home');
        $commande = new Commandes();
        $total = 0;
        $remise = 0;
        $cart = $cartService->getFull();
        $productType = $cartService->getProductType();

        foreach($cart as $product) {
            
            $productCommande = $product['product']->getCommandes();
            $productTotal = $product['product']->getMontants() * $product['quantity'];
            $total += $productTotal;
            $request->request->all() ? $product['product']->setCommandes( $productCommande + 1 ) : false;
            $commande->setReference($product['product']->getNom());   
        }

        if ($request->request->all()) {
            $data = json_encode($request->request->all());

           
            $commande = $this->serializer->deserialize($data, Commandes::class, 'json');

            $user = $this->getUser();
            $currentPass = $user->getPassword();
            $user = $this->serializer->deserialize($data, User::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $user]);
            $user->setPassword($currentPass);
            $commande->setUser($user);
            $commande->setTotal($total);
            $commande->setRemise($remise);
            $commande->setProductType("pack");
            $commande->getRemise() != 0 ? $commande->setPromotions(true) : $commande->setPromotions(false);
            $commande->setTotalTcc($total - $remise);
            $commande->setDateCommandes(new \DateTime('now'));

            $commandesRepository->save($commande, true);
            $em->flush();

            $this->addFlash(
                'success',
                'Votre Commande a été prise en compte, merci pour votre confiance!'
             );
            $cartService->removeCart();
            return $this->redirectToRoute('app_comptes');
        }
        return $this->render('cart/paymentpack.html.twig', [
            'cart' => $cart,
            'productType' => $productType,
            'total' => $total,
        ]);
    }
}
