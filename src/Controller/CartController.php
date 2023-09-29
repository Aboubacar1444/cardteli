<?php

namespace App\Controller;

use App\Services\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cart')]
class CartController extends AbstractController
{
    #[Route('', name: 'app_cart')]
    public function index(Request $request, CartService $cartService): Response
    {   
        if(!$cartService->getCartDatas()) return $this->redirectToRoute('app_modeles');
        
        $total = 0;
        $cart = $cartService->getFull();
        $productType = $cartService->getProductType(); 
        
        if($productType == 'cardonly' ) {
            foreach($cart as $product){
                
                $productTotal = $product['product']->getPrice() * $product['quantity'];
                $total += $productTotal;
            }
            
        }else{
            foreach($cart as $product){
                
                $productTotal = $product['product']->getMontants() * $product['quantity'];
                $total += $productTotal;
            }
        }
        return $this->render('cart/index.html.twig', [
            'cart' => $cart,
            'total'=>$total
        ]);
    }

    #[Route('/add/{id}/{product}', name: 'app_cart_add')]
    public function add(Request $request, CartService $cartService, $id, $product)
    {
        $request->get('value') ? $value = $request->get('value') : $value = null;
        $cartService->addToCart($id, $product, $value);

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/remove', name: 'app_cart_remove')]
    public function remove(CartService $cartService)
    {
        $cartService->removeCart();

        return $this->redirectToRoute('app_modeles');
    }

    #[Route('/delete/{id}', name: 'app_cart_delete')]
    public function delete(Request $request, CartService $cartService, $id)
    {
        
        $cartService->deleteCartItem($id);
        return $this->redirectToRoute('app_cart');
    }

    #[Route('/decrease/{id}/{product}', name: 'app_cart_decrease')]
    public function decrease(Request $request, CartService $cartService, $id, $product,)
    {
        $request->get('value') ? $value = $request->get('value') : $value = null;

        $cartService->decreaseCarteItem($id, $product, $value);
        return $this->redirectToRoute('app_cart');
    }
}
