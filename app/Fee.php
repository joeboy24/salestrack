<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    //  

    protected $fillable = ['student_id', 'fullname', 'user_id', 'class', 'term', 'year'];

    public function student(){
        return $this->belongsTo('App\Student');
    }

}
 