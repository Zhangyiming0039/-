<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher_info extends Model
{
    use HasFactory;
    public function write(){
        $this->name='zhang';
        $this->save();
    }
}
