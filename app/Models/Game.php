<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model {
    protected $table = 'api_game';
    use HasFactory;

    protected $guarded = ['id'];
    public $timestamps = false;

    public function reports() {
        return $this->hasMany(Reports::class);
    }
}
