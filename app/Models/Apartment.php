<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Image;

class Apartment extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',
        'city',
        'meters',
        'metro',
        'price',
        'rooms',
        'user_id',
    ];

    protected $hidden = [
        'user_id',
        'created_at',
        'updated_at'
    ];

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function SaveDataApartment($apartment)
    {
        $data = [
            'data' => [
                'address' => $apartment->address,
                'city' => $apartment->city,
                'id' => $apartment->id,
                'meters' => $apartment->meters,
                'metro' => $apartment->metro,
                'price' => $apartment->price,
                'rooms' => $apartment->rooms,
            ],
        ];

        return $data;
    }
}
