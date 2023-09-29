<?php

namespace App\Services;

use App\Entity\Packs;
use App\Entity\TemplatesCarteVisites;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;


final class CartService
{

    public function __construct(private EntityManagerInterface $entityManager, private RequestStack $requestStack)
    {
    }

    public function addToCart($id, $productType, $value = null)
    {
        $cart = $this->requestStack->getSession()->get('cart', []);
        $productTypeInSession = $this->requestStack->getSession()->get('productType', '');

        if (!empty($card[$id]) && $productType == "pack") {
            $cart[$id] = 1;
        } elseif (!empty($cart[$id]) && $productType == 'cardonly') {
            $cart[$id] += $value;
        } else {
           
            if ($productType == "pack") {
                $cart[$id] = 1; 
                $productTypeInSession = "pack";
                 
            }
            else {
                $cart[$id] = $value;
                $productTypeInSession = "cardonly";

            }
        }

        $this->requestStack->getSession()->set('cart', $cart);
        $this->requestStack->getSession()->set('productType', $productTypeInSession);
    }

    public function getCartDatas()
    {
        return $this->requestStack->getSession()->get('cart');
    }

    public function getProductType()
    {
        return $this->requestStack->getSession()->get('productType');
    }


    public function removeCart()
    {
        return $this->requestStack->getSession()->remove('cart');
    }

    public function deleteCartItem($id)
    {
        $cart = $this->requestStack->getSession()->get('cart', []);

        unset($cart[$id]);
        return $this->requestStack->getSession()->set('cart', $cart);
    }

    public function decreaseCarteItem($id, $productType, $value = null)
    {
        $cart = $this->requestStack->getSession()->get('cart', []);
        if (!empty($card[$id]) && $productType == "pack") {
            unset($cart[$id]);
        } elseif (!empty($cart[$id]) && ($cart[$id] > 50) && $productType == 'cardonly') {
            $cart[$id] -= $value;
        } else unset($cart[$id]);
        return $this->requestStack->getSession()->set('cart', $cart);
    }
    public function getFull()
    {
        $fullCart = [];
        $product = $this->getProductType();
        if ($this->getCartDatas()) {
            foreach ($this->getCartDatas() as $id => $quantity) {
                if($product == "pack")
                    $product_object = $this->entityManager->getRepository(Packs::class)->findOneById($id);
                if ($product == "cardonly")
                    $product_object = $this->entityManager->getRepository(TemplatesCarteVisites::class)->findOneById($id);

                if (!$product_object) {
                    $this->deleteCartItem($id);
                    continue;
                }

                $fullCart[] = [
                    'product' => $product_object,
                    'quantity' => $quantity
                ];
            }
        }
        return $fullCart;
    }
}
