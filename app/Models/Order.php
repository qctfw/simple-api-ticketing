<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    const PAYMENT_STATUS_PENDING = 'pending';
    const PAYMENT_STATUS_DONE = 'done';
    const PAYMENT_STATUS_CANCELED = 'canceled';

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
     * Get the tickets that owns the event.
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * Get the event associated with the orders.
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Get the user associated with the orders.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
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
}
