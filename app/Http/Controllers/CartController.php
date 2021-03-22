<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart;

class CartController extends Controller
{
	public function add()
	{
//		$rowId = Cart::add('293ad', 'Product 1', 1, 9.99);
//		$rowId = Cart::add('294ad', 'Product 2', 1, 9.99);
//		dump($rowId);
//		Cart::store('alex');
//		Cart::restore('username');

		$cart = Cart::content();
		dump($cart);

		/*
		$favourite  = Favorite::create([
			'user_id' => Auth::id(),
			'favoritable_id' => $id,
			'favoritable_type' => $type,
		]);
		return response()->json(['success' => $favourite, 'type' => $type]);
		*/
	}
}
