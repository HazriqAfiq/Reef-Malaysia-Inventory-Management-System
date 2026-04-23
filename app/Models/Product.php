<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'sku',
        'name',
        'slug',
        'product_type_id',
        'category_id',
        'volume_ml',
        'description',
        'top_note',
        'heart_note',
        'base_note',
        'wholesale_price',
        'retail_price',
        'stock',
        'release_date',
        'is_active',
        'promotion_type',
        'promotion_value',
        'promotion_badge',
        'promotion_starts_at',
        'promotion_ends_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'release_date' => 'date',
        'wholesale_price' => 'decimal:2',
        'retail_price' => 'decimal:2',
        'promotion_starts_at' => 'datetime',
        'promotion_ends_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });

        static::updating(function ($product) {
            if ($product->isDirty('name') && !$product->isDirty('slug')) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function resellerStocks()
    {
        return $this->hasMany(ResellerStock::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function productType()
    {
        return $this->belongsTo(ProductType::class, 'product_type_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeNewArrivals($query)
    {
        return $query->where('release_date', '>=', now()->subMonths(3))
                     ->orderBy('release_date', 'desc');
    }

    public function isPromotionActive()
    {
        if (empty($this->promotion_type)) {
            return false;
        }

        $now = now();
        
        if ($this->promotion_starts_at && $this->promotion_starts_at > $now) {
            return false;
        }

        if ($this->promotion_ends_at && $this->promotion_ends_at < $now) {
            return false;
        }

        return true;
    }

    public function getDiscountedPriceAttribute()
    {
        if (!$this->isPromotionActive() || $this->promotion_type !== 'discount_percent') {
            return $this->retail_price;
        }

        $discount = $this->retail_price * ($this->promotion_value / 100);
        return max(0, $this->retail_price - $discount);
    }
}
