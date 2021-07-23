<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Policies extends Model
{
    use HasFactory;

    public function fetchPolicies($user_id)
    {
        return $this->where('user_id',$user_id)->get();
    }
}
