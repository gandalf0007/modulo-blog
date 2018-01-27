<?php

namespace Soft;

use Illuminate\Database\Eloquent\Model;
use Soft\Blog_post;

class Blog_categoria extends Model
{
    protected $fillable = [
        	'id',
        	'nombre',
        	'slug',
    ];





    public function post()
    {
        //una categoria puede tener muchos post
        return $this->hasMany(Blog_post::class);
    }
}
