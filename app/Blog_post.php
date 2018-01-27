<?php

namespace Soft;

use Illuminate\Database\Eloquent\Model;

use Soft\Blog_categoria;
use Soft\Blog_tag;
use Soft\User;

class Blog_post extends Model
{
    protected $fillable = [
        	'id',
        	'user_id',
        	'blog_categoria_id',
        	'titulo',
        	'descripcioncorta',
        	'descripcionlarga',
            'imagen',
            'portada',
        	'status',
            
    ];




    public function user()
    {
        //un post puede ser creado por un usuario
        return $this->belongsTo(User::class);
    }

    
    public function tags(){
        return $this->belongsToMany(Blog_tag::class,'blog_post_tags')
            ->withPivot('blog_post_id');
    }


    public function categoria()
    {
        //un post puede tener una categoria
        return $this->belongsTo(Blog_categoria::class,'blog_categoria_id');
    }
}
