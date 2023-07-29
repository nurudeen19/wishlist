<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WishListItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image_url',
        'description',
        'quantity',
        'price',
        'shop',
        'is_desired',
        'wish_list_id',
    ];

    // relation to parent model
    public function wishlist(){
        return $this->belongsTo(WishList::class);
    }
}
