<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Product extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected static $logName = 'products';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    protected $fillable = [
        'name',
        'category_id',
        'brand_id',
        'description',
        'price',
        'discount_price',
        'is_featured',
        'is_hot_trend',
        'is_new_arrival',
        'stock',
    ];

    public function brand() {
        return $this->belongsTo(Brand::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function variants() {
        return $this->hasMany(ProductVariant::class);
    }

    public function reviews() {
        return $this->hasMany(ProductReview::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

     /**
     * Get the options for the activity log.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(self::$logAttributes)
            ->useLogName(self::$logName)
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}