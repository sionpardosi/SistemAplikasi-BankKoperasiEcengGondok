<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'locality',
        'address',
        'city',
        'state',
        'country',
        'landmark',
        'zip',
        'type',
        'isdefault',
        'idstate',
        'idcity',
    ];

    /**
     * Get the user that owns the address.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Set this address as default and remove default status from other addresses of the user.
     */
    public function setAsDefault()
    {
        // Set all user addresses to non-default
        self::where('user_id', $this->user_id)
            ->update(['isdefault' => false]);

        // Set this address as default
        $this->isdefault = true;
        $this->save();

        return $this;
    }
}
