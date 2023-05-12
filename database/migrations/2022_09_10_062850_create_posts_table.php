<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('language');
            $table->string('slug');
            $table->string('title');
            $table->string('keyword');
            $table->string('description');
            $table->text('freetag')->nullable();
            $table->string('h1')->nullable();
            $table->string('h2')->nullable()->nullable();
            $table->text('short_url')->nullable()->nullable();
            $table->string('thumbnail_title')->nullable();
            $table->string('thumbnail_link')->nullable();
            $table->string('thumbnail_size')->nullable();
            $table->string('thumbnail_alt')->nullable();
            $table->string('topic')->nullable();
            $table->text('content')->nullable();
            $table->text('iframe')->nullable();
            $table->text('category');
            $table->text('tags')->nullable();
            $table->text('redirect')->nullable();
            $table->text('link_facebook')->nullable();
            $table->text('link_twitter')->nullable();
            $table->text('link_instagram')->nullable();
            $table->text('link_youtube')->nullable();
            $table->text('link_line')->nullable();
            $table->dateTime('date_begin_display')->nullable();
            $table->dateTime('date_end_display')->nullable();
            $table->boolean('status_display')->default(false);
            $table->boolean('pin')->default(false);
            $table->boolean('defaults')->default(false);
            $table->integer('post_view')->default(0);
            $table->integer('priority')->default(1);
            $table->string('pricetag')->nullable();
            $table->string('meta_tag')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->boolean('allow_delete')->default(false)->comment("ถ้าเป็น true ลบได้เฉพาะ SuperAdmin");
            $table->boolean('is_maincontent')->default(false)->comment("ถ้าเป็น false = dynamic content");
            $table->integer('last_update_by')->nullable();
            $table->timestamps();
            $table->unique(['language', 'slug']);
        });
        DB::statement('ALTER TABLE `posts` DROP PRIMARY KEY, ADD PRIMARY KEY (`id`, `language`) USING BTREE');
        DB::table('posts')->insert([
            [
                'id' => 1,
                'language' => 'th',
                'slug' => 'termofservice',
                'title' => 'Terms of Service',
                'keyword' => '',
                'description' => 'Manami Terms of Service',
                'thumbnail_link' => "img/term_of_service/headericon.png",
                'content' => ' <p>Lorem ipsum dolor sit nsectetur. Ultrices interdum mi sagittis lacus nec urnaposuere accumsan.Donec eu cursus vestibulum duis habitant amet platea dictum. Ipsum lobortis dictum est at ut enim nunc nisl.Proin lacus orci diam nulla et laorsagittis. Nisl tellus quis id urna acmalesuada sit. Vitae est aliquet mollis nemauris quisque. In orci facilisi quam sit. Viverra elementum lectus nunc eu interdum vitae tellus nam. Vitae porta enim massa gravida amet faucibus. Dui fermentum elit ligula massa vulputate tristique ut. Lectus et sit libero interdum dui mi nullam. Ut egestas urna condimentum faucibus. Tempus ipsum quis magna vitae et libero. Nisi in risus sagittis interdum odio tellus etiam aliquet risus. Rhoncus condimentum urna odipellentesque quis eget velit in. Dictum vitae ultrices diam enim enim vel proin. Commodo at tristique amet donec viverra laoreet molestie. Viverra aliquet volutpat id posueredictumst. Et vitae nibh vestibulum dui dolor eget mauris. Scelerisque fringilla at molestie faucibus purus commodo auctor aliquet aliquam. Vel rhoncus sit sit urna varius amet turpis elementum.</p>',
                'category' => '',
                'status_display' => true,
                'defaults' => true,
                'is_maincontent' => true,
                'priority' => 1,
            ],
            [
                'id' => 2,
                'language' => 'th',
                'slug' => 'privacypolicy',
                'title' => 'Privacy Policy',
                'keyword' => '',
                'description' => 'Privacy Policy',
                'thumbnail_link' => "img/privacy_policy/headericon.png",
                'content' => '
                    <p>
                        Lorem ipsum dolor sit nsectetur. Ultrices interdum mi sagittis lacus nec urna
                        posuere accumsan.Donec eu cursus vestibulum duis habitant amet platea dictum. Ipsum
                        lobortis dictum est at ut enim nunc nisl.Proin lacus orci diam nulla et
                        laorsagittis. Nisl tellus quis id urna acmalesuada sit. Vitae est aliquet mollis
                        nemauris quisque. In orci facilisi quam sit. Viverra elementum lectus nunc eu
                        interdum vitae tellus nam. Vitae porta enim massa gravida amet faucibus. Dui
                        fermentum elit ligula massa vulputate tristique ut. Lectus et sit libero interdum
                        dui mi nullam. Ut egestas urna condimentum faucibus. Tempus ipsum quis magna vitae
                        et libero. Nisi in risus sagittis interdum odio tellus etiam aliquet risus. Rhoncus
                        condimentum urna odipellentesque quis eget velit in. Dictum vitae ultrices diam enim
                        enim vel proin. Commodo at tristique amet donec viverra laoreet molestie. Viverra
                        aliquet volutpat id posueredictumst. Et vitae nibh vestibulum dui dolor eget mauris.
                        Scelerisque fringilla at molestie faucibus purus commodo auctor aliquet aliquam. Vel
                        rhoncus sit sit urna varius amet turpis elementum.
                    </p>
                    <p>
                        Lorem ipsum dolor sit nsectetur. Ultrices interdum mi sagittis lacus nec urna
                        posuere accumsan.Donec eu cursus vestibulum duis habitant amet platea dictum. Ipsum
                        lobortis dictum est at ut enim nunc nisl.Proin lacus orci diam nulla et
                        laorsagittis. Nisl tellus quis id urna acmalesuada sit. Vitae est aliquet mollis
                        nemauris quisque. In orci facilisi quam sit. Viverra elementum lectus nunc eu
                        interdum vitae tellus nam. Vitae porta enim massa gravida amet faucibus. Dui
                        fermentum elit ligula massa vulputate tristique ut. Lectus et sit libero interdum
                        dui mi nullam. Ut egestas urna condimentum faucibus. Tempus ipsum quis magna vitae
                        et libero. Nisi in risus sagittis interdum odio tellus etiam aliquet risus. Rhoncus
                        condimentum urna odipellentesque quis eget velit in. Dictum vitae ultrices diam enim
                        enim vel proin. Commodo at tristique amet donec viverra laoreet molestie. Viverra
                        aliquet volutpat id posueredictumst. Et vitae nibh vestibulum dui dolor eget mauris.
                        Scelerisque fringilla at molestie faucibus purus commodo auctor aliquet aliquam. Vel
                        rhoncus sit sit urna varius amet turpis elementum.
                    </p>',
                'category' => '',
                'status_display' => true,
                'defaults' => true,
                'is_maincontent' => true,
                'priority' => 1,
            ],
        ]);
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
};
