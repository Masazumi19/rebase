<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // ステータス
    const STATUS_CLOSE = 0;
    const STATUS_OPEN = 1;
    const STATUS_LIST = [
        self::STATUS_CLOSE => '未公開',
        self::STATUS_OPEN => '公開',
    ];
    protected $fillable = [
        'product_name',
        'category_id',
        'price',
        'due_date',
        'description',
        'is_published',
    ];
    public function scopePublished(Builder $query)
    {
        $query->where('is_published', true)
            ->where('due_date', '>=', now());
        return $query;
    }

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
}
