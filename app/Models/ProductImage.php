<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;


class ProductImage extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected static $logName = 'product-images';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    protected $fillable = ['product_id', 'image_path', 'is_primary'];

    public function product()
    {
        return $this->belongsTo(Product::class);
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
