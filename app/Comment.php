<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    protected $fillable = ['referral_id', 'comment', 'user_id'];

    public function referral() {
        return $this->belongsTo(Referral::class);
    }
}
