<?php

namespace Soft;

use Illuminate\Database\Eloquent\Model;

class Blog_setting extends Model
{
    protected $fillable = [
        	'id',
        	'disqus_html',
        	'disqus_enable',
        	'image_defaul',   
        	'filename',   
    ];
}
