<?php

namespace App\Http\Controllers\frontoffice;


use App\Http\Controllers\Controller;
use App\Models\AdSlide;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use stdClass;

class HomeController extends Controller
{
    public function mainContent(Request $request)
    {
        $infos = $this->getWebInfo('', $request->session()->get('language'));
        $webInfo = $this->infoSetting($infos);

        return view('pages.page', [
            'web_info' => $webInfo,
            'content_home' => $this->sectionHome($request->session()->get('language')),
            'content_procedure' => $this->mainPostGallery(2),
            'icons_procedure' => $this->content_article(13),
            'article_procedure' => $this->content_article(2),
            'content_product' => $this->is_mainContent(3),
            'article_product' => $this->subPostGallery(3),
            'certificate' => $this->mainPostGallery(12),
            'content_service'=>$this->is_mainContent(4),
            'article_service' => $this->subPostGallery(4),
            'content_reference' => $this->is_mainContent(5),
            'article_reference' => $this->content_article(5),
            'content_about' => $this->is_mainContent(6),
            'content_contact' => $this->is_mainContent(7),
        ]);
    }

    public function sectionHome($language)
    {
        $id = 1;
        $banner = AdSlide::where(
            [
                'page_id' => $id, 'language' => $language,
                'ad_status_display' => true
            ]
        )->orderBy('ad_priority', 'ASC')->get();
        return $banner;
    }

    // function content
    public function is_mainContent($id)
    {
        $queryData = Post::where(['status_display' => true, 'is_mainContent' => true])
            ->where('category', 'LIKE', "%,{$id},%")->orderBy('priority', 'ASC')->first();
        return $queryData;
    }

    public function content_article($id)
    {

        $queryData = Post::where(['status_display' => true, 'is_mainContent' => false])
            ->where('category', 'LIKE', "%,{$id},%")->orderBy('priority', 'ASC')->get();
        return $queryData;
    }

    //function gallery
    public function mainPostGallery($id)
    {
        $queryData = DB::select("SELECT posts.*,
                        GROUP_CONCAT(post_images.image_link) as gallery_image,
                        GROUP_CONCAT(post_images.title) as title_image,
                        GROUP_CONCAT(post_images.alt) as alt_image
                        FROM posts
                        LEFT JOIN post_images ON posts.id = post_images.post_id
                        WHERE posts.category LIKE '%,$id,%' and posts.is_maincontent = true and posts.status_display = true
                        GROUP BY posts.id", []);

        if ($queryData) {
            foreach ($queryData as $data) {
                $gallery_image = explode(',', $data->gallery_image);
                $title_image = explode(',', $data->title_image);
                $alt_image = explode(',', $data->alt_image);

                $gallery = array();
                foreach ($gallery_image as $key => $val) {
                    $obj = new stdClass();
                    $obj->image = $val;
                    $obj->title = $title_image[$key];
                    $obj->alt = $alt_image[$key];
                    array_push($gallery, $obj);
                }

                $data->gallery = $gallery;
            }
        }
        return $queryData;
    }
    
    public function subPostGallery($id)
    {
        $queryData = DB::select("SELECT posts.*,
                        GROUP_CONCAT(post_images.image_link) as gallery_image,
                        GROUP_CONCAT(post_images.title) as title_image,
                        GROUP_CONCAT(post_images.alt) as alt_image
                        FROM posts
                        LEFT JOIN post_images ON posts.id = post_images.post_id
                        WHERE posts.category LIKE '%,$id,%' and posts.is_maincontent = false and posts.status_display = true
                        GROUP BY posts.id", []);

        if ($queryData) {
            foreach ($queryData as $data) {
                $gallery_image = explode(',', $data->gallery_image);
                $title_image = explode(',', $data->title_image);
                $alt_image = explode(',', $data->alt_image);

                $gallery = array();
                foreach ($gallery_image as $key => $val) {
                    $obj = new stdClass();
                    $obj->image = $val;
                    $obj->title = $title_image[$key];
                    $obj->alt = $alt_image[$key];
                    array_push($gallery, $obj);
                }

                $data->gallery = $gallery;
            }
        }
        return $queryData;
    }
}
