<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Directory;


class Client extends Model
{
    protected $table = "client";
    public function directory(){
        return $this->hasMany(Directory::class)->select('clientId');
    }

}
