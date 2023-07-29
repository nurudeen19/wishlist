<?php

namespace App\Http\Controllers;

use App\Models\WishList;
use Illuminate\Http\Request;

class WishListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wishlists = WishList::get();
        return view('wishlists.index', compact('wishlists'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        WishList::create($request->all());

        return back()->with('success', 'Wishlist created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(WishList $wishlist)
    {
        if(request()->wantsJson()){
            $items = $wishlist->items;
            return response()->json(['items'=> $items]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WishList $wishlist)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $wishlist->update($request->all());

        return back()->with('success', 'Wishlist updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WishList $wishlist)
    {
        $wishlist->delete();
        return back()->with('success', 'Wishlist removed successfully!');
    }
}
