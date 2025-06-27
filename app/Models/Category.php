<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected static $logName = 'categories';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    protected $fillable = [
        'title','parent_id','description','meta_title', 'meta_keyword', 'meta_description', 'thumbnail'
    ];

    public function subcategories(): HasMany {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent(): BelongsTo {
        return $this->belongsTo(Category::class, 'parent_id');
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
