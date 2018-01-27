<?php

namespace Soft;

use Illuminate\Database\Eloquent\Model;
use Soft\Blog_post;
use Soft\Blog_tag;

class Blog_tag extends Model
{
     protected $fillable = [
        	'id',
        	'nombre',
        	'slug',   
    ];



    public function post(){
        return $this->belongsToMany(Blog_post::class,'blog_post_tags')
            ->withPivot('blog_tag_id');
    }
 



}
