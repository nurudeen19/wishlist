<?php

namespace App\Http\Controllers;

use App\Models\WishList;
use App\Models\WishListItem;
use Illuminate\Http\Request;

class WishlistItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // find or abort the the related record
        $wishlist = WishList::findOrFail($request->wish_list_id);

        $data = $request->except(['image', '_token']);
        
        if ($request->hasFile('image')) {
            $image = $request->image;
            $filename = time().$image->getClientOriginalName();
            $image->move('images/wishlist_items', $filename);
            $path = "images/wishlist_items/{$filename}";
            $data['image_url'] =  $path; 
        }

        $wishlist->items()->create($data);

        return back()->with('success', 'Item added to wishlist  successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(WishListItem $wishListItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WishListItem $wishListItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WishList $wishlist)
    {
        //
    }
}
