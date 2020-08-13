<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CeratePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->foreignId('user_id')->references('id')->on('users');

            $table->text('content');
            $table->integer('comment_count')->default(0);
            $table->integer('image_count')->default(0);
            $table->integer('like_count')->default(0);
            $table->string('preview_link', 2083)->nullable($value = true)->default(null);
            $table->ipAddress('ip')->nullable($value = true)->default(null);

            $table->timestamps();

            //相當於為軟刪除添加一個可空的 deleted_at 字段
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
