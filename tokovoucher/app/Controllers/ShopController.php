<?php

namespace App\Controllers;

use App\Models\DiscountModel;
use App\Models\ProductModel;
use App\Models\BalanceModel;

class ShopController extends BaseController
{
    public function index()
    {
        $balanceModel = new BalanceModel();
        $data['balance'] = $balanceModel->getCurrentBalance();

        $voucherAmount = session()->get('voucher', 0);
        $voucherExpiration = session()->get('voucher_expiration', null);
    
        $data['voucherAmount'] = $voucherAmount;
        $data['voucherExpiration'] = $voucherExpiration;
    
        $productModel = new ProductModel();
        $data['products'] = $productModel->findAll();
    
        return view('shop/index', $data);
    }  

    public function addProductToCart($productId)
    {
        $productModel = new ProductModel();
        $product = $productModel->find($productId);

        if (!$product) {
            return redirect()->to('/')->with('error', 'Product not found.');
        }

        $cart = session()->get('cart') ?? [];
        $cart[$productId]['name'] = $product['name'];
        $cart[$productId]['price'] = $product['price'];
        $cart[$productId]['qty'] = isset($cart[$productId]['qty']) ? $cart[$productId]['qty'] + 1 : 1;

        session()->set('cart', $cart);

        return redirect()->to('/')->with('success', 'Product added to cart.');
    }

    public function removeProductFromCart($productId)
    {
        $cart = session()->get('cart') ?? [];
        unset($cart[$productId]);
        session()->set('cart', $cart);
    
        return redirect()->to('/shop/viewCart')->with('success', 'Product removed from cart.');
    }

    public function viewCart()
    {
        $cart = session()->get('cart') ?? [];

        return view('shop/cart', ['cart' => $cart]);
    }

    public function checkout()
    {
        $cart = session()->get('cart') ?? [];
    
        $totalTransaction = 0;
        foreach ($cart as $item) {
            $totalTransaction += $item['price'] * $item['qty'];
        }
    
        $balanceModel = new BalanceModel();
        $balance = $balanceModel->getCurrentBalance();
    
        if ($totalTransaction > $balance) {
            return redirect()->to('/shop/cart')->with('error', 'Insufficient balance. Cannot checkout.');
        }
    
        $balanceModel->decreaseBalance($totalTransaction);
        $productModel = new ProductModel();
        foreach ($cart as $productId => $item) {
            $product = $productModel->find($productId);
            $productModel->update($productId, ['qty' => $product['qty'] - $item['qty']]);
        }

        $voucherAmount = ($totalTransaction >= 2000000) ? 10000 : 0;
        $voucherExpiration = date('Y-m-d H:i:s', strtotime('+3 days'));
        session()->set('voucher', $voucherAmount);
        session()->set('voucher_expiration', $voucherExpiration);
        session()->remove('cart');
        return redirect()->to('/shop/cart')->with('success', 'Checkout successful!');
    }
    
    public function useVoucher()
    {
        $voucherAmount = session()->get('voucher', 0);
        if ($voucherAmount > 0) {
            $total = session()->get('total', 0);
            $totalAfterVoucher = max(0, $total - $voucherAmount);
            session()->set('total', $totalAfterVoucher);
            session()->remove('voucher');
            session()->remove('voucher_expiration');
    
            return redirect()->to('/shop/cart')->with('success', 'Voucher successfully used!');
        }
    
        return redirect()->to('/shop/cart')->with('warning', 'No available voucher.');
    }

    public function cart()
    {
        $total = session()->get('total', 0);
        return view('shop/cart', ['total' => $total]);
    }
}