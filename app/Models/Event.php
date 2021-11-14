<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    /**
     * Get the orders that owns the event.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Bootstrap the model and its traits.
     * 
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            while (true) {
                $id = bin2hex(random_bytes(12));
                if (!self::find($id))
                {
                    $model->id = $id;
                    break;
                }
            }
        });
    }

    /**
     * Scope a query to only include events that still available to purchase.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    public function scopeAvailable($query)
    {
        $query->where('start_date', '>', now())->where('remaining_tickets', '>', 0);
    }
}
