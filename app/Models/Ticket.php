<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
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
        'used_at' => 'datetime',
    ];

    /**
     * Get the order associated with the tickets.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
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
