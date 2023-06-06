<?php

namespace App\Http\Controllers\frontoffice;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\LanguageAvailable;
use App\Models\LanguageConfig;
use App\Models\OrderItem;
use App\Models\Post;
use App\Models\WebInfo;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function getPage(Request $request)
    {
        $orderNumber = $request->session()->get('orders_number');
        $orderItem = OrderItem::where(['orders_number' => $orderNumber])->get();

        $lang_default = LanguageAvailable::where(['defaults' => 1])->first();
        $lang = $request->session()->get('language')?$request->session()->get('language'):$lang_default->abbv_name;
        $infos = $this->getWebInfo('', $lang);
        $webInfo = $this->infoSetting($infos);
        $language_available = LanguageAvailable::orderBy('defaults', 'desc')->get();
        $lang_active = LanguageAvailable::where(['abbv_name' => $lang])->first();
        $request->session()->put('language', $lang);
        $language = LanguageConfig::where(['language' => $lang])->get();
        $content_language = array();
        foreach($language as $lang){
            $content_language[$lang->param] = $lang->title;
        }

        $slug = $request->slug;
        $page = Category::where('cate_url', $slug)->first();
        if(!$slug || !$page){
            return view('pages.auth.auth', [
                'content_language' => $this->getContentLanguage($request->session()->get('language')),
                'language_available' => $language_available,
                'language_active' => $lang_active,
                'cart_notify' => count($orderItem),
            ]);
        }

        return view('pages.auth.'.$page->cate_url, [
            'content' => $page,
            'content_language' => $this->getContentLanguage($request->session()->get('language')),
            'language_available' => $language_available,
            'language_active' => $lang_active
        ]);
    }

    public function getContent(Request $request)
    {
        $infos = $this->getWebInfo('', $request->session()->get('language'));
        $webInfo = $this->infoSetting($infos);

        $slug = $request->slug;
        if ($slug == "") {
            return view('pages.auth.auth');
        }

        if ($slug == "privacypolicy") {
            $category = $this->queryCategory(23);
        } else if ($slug == "termofservice") {
            $category = $this->queryCategory(22);
        } else {
            return redirect('/');
        }

        $content = Post::where('slug', $slug)->first();
        if (!$content) {
            return view('pages.auth.auth');
        }
        return view('pages.policy.content', [
            'content' => $content,
            'category' => $category,
            'content_language' => $this->getContentLanguage($request->session()->get('language')),
        ]);
    }

    public function getPageLogin(Request $request)
    {
        $lang_default = LanguageAvailable::where(['defaults' => 1])->first();
        $language = $request->session()->get('language') ? $request->session()->get('language') : $lang_default->abbv_name;
        $infos = $this->getWebInfo('', $request->session()->get('language'));
        $webInfo = $this->infoSetting($infos);

        $page = Category::where('cate_url', 'auth-login')->first();
        if (!$page) {
            return view('pages.auth.auth');
        }
        $user = auth()->guard('member')->user();
        return view('pages.auth.auth-login', [
            'member' => $user,
            'content' => $page,
            'content_language' => $this->getContentLanguage($language),
        ]);
    }

    public function changeLanguage(Request $request)
    {
        $request->session()->put('language', $request->lang);
        return redirect('/');
    }
}
