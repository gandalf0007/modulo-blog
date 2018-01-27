<?php

namespace Soft;

use Illuminate\Database\Eloquent\Model;

class Blog_post_tag extends Model
{
     protected $fillable = [
        	'id',
        	'blog_post_id',
        	'blog_tag_id',   
    ];


}
