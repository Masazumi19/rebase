<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    // ステータス
    const STATUS_DISPLAY = 0;
    const STATUS_PURCHASED = 1;
    const STATUS_LIST = [
        self::STATUS_DISPLAY => 'PURCHASE',
        self::STATUS_PURCHASED => 'SOLD',
    ];
    protected $fillable = [
        'product_name',
        'category_id',
        'price',
        'description',
        'image'

    ];
    // public function scopePublished(Builder $query)
    // {
    // }

    public function scopeSearch(Builder $query, $params)
    {
        if (!empty($params['category_id'])) {
            $query->where('category_id', $params['category_id']);
        }

        return $query;
    }


    public function masa()
    {
        return $this->belongsTo(Masa::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function messages()
    {
        return $this->morphMany(Message::class, 'messageable');
    }

    public function getImageUrlAttribute()
    {
        return Storage::url($this->image_path);
    }

    public function getImagePathAttribute()
    {
        return 'images/products/' . $this->image;
    }
}
