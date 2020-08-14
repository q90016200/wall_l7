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
    protected $fillable = ['user_id', 'content', 'comment_count', 'image_count', 'like_count', 'preview_link', 'ip'];

    // 獲取文章的用戶
    public function user() {
        return $this->belongsTo('App\Models\User');
    }

}
