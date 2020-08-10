<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = ['author', 'content', 'comment_count', 'image_count', 'like_count', 'preview_link', 'ip'];



}
