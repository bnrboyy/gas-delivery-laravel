<?php

namespace App\Http\Controllers;

use App\Models\AdSlide;
use App\Models\Category;
use App\Models\LanguageAvailable;
use App\Models\LanguageConfig;
use App\Models\MemberAccount;
use App\Models\WebInfo;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use stdClass;
use Phattarachai\LineNotify\Facade\Line;
use Phattarachai\LineNotify\Line as LineNotifyLine;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getWebInfo($typeIdIn = "", $language = "")
    {
        /* custom select by infoTypeId */
        if ($typeIdIn !== "") $typeIdIn = " WHERE i.info_type IN ($typeIdIn) ";
        if ($language !== "") $language = " AND i.language = '$language'";

        $webInfos = DB::select("SELECT
            i.admin_level,
            i.created_at,
            i.defaults,
            i.info_attribute as attribute,
            i.info_display as display,
            i.info_id as id,
            i.info_link as link,
            i.info_iframe as iframe,
            i.info_param as param,
            i.info_priority as priority,
            i.info_title as description,
            i.info_value as value,
            i.language as language,
            i.updated_at,
            i.info_type as infoTypeId,
            t.type_name as infoTypeName,
            t.title as infoTypeTitle
         FROM `web_infos` as i
         INNER JOIN web_info_types as t on i.info_type = t.id AND i.language = t.language
         $typeIdIn
         $language
         ORDER BY infoTypeId ASC, priority ASC ");
        return $webInfos;
    }

    /**
     *  @infos = ข้อมูลที่นำมันจัดกรุ๊ป
     *  @skips = true จะไม่นำข้อมูลที่ไม่มีค่าใน value , link ออกจาก objects
     */
    public function infoSetting($infos, $skips = false,  $backoffice = false)
    {
        $infoSetting = new stdClass();
        if (!empty($infos)) {
            foreach ($infos as $val) {
                if ($skips && $val->value == "" && $val->link == "") continue;
                $type = $val->infoTypeName;
                $param = $val->param;
                if (!isset($infoSetting->$type)) $infoSetting->$type = new stdClass();
                if (!isset($infoSetting->$type->$param)) $infoSetting->$type->$param = new stdClass();
                $infoSetting->$type->$param->token = base64_encode($val->id);
                $infoSetting->$type->$param->value = ($val->value) ? $val->value : "";
                $infoSetting->$type->$param->link = ($val->link) ? $val->link : "";
                $infoSetting->$type->$param->iframe = ($val->iframe) ? $val->iframe : "";
                $infoSetting->$type->$param->attribute = ($val->attribute) ? $val->attribute : "";
                $infoSetting->$type->$param->priority = (int)$val->priority;
                $infoSetting->$type->$param->language = strtolower($val->language);
                $infoSetting->$type->$param->description = $val->description;
                $infoSetting->$type->$param->display = ($val->display) ? true : false;
                if ($backoffice) {
                    $infoSetting->$type->$param->id = ($val->display) ? true : false;
                    $infoSetting->$type->$param->infoType = ($val->display) ? true : false;
                    $infoSetting->$type->$param->infoTypeId = ($val->display) ? true : false;
                    $infoSetting->$type->$param->isDetail = ($val->display) ? true : false;
                    $infoSetting->$type->$param->param = ($val->display) ? true : false;
                }
            }
        }
        return $infoSetting;
    }

    public function uploadImage($folderPath = "upload/", $image = NULL, $preName = "", $postName = "", $customName = NULL)
    {
        if ($image) {
            /* Checking folder */
            if (!file_exists($folderPath)) {
                File::makeDirectory($folderPath, $mode = 0777, true, true);
            }
            $extName = "." . $image->extension();
            $name = ($customName !== NULL) ? str_replace($extName, "", $customName) : time();
            $fullName = $preName . $name . $postName;
            $newImageName = $fullName . $extName;
            if (file_exists($folderPath . $newImageName)) {
                for ($ii = 1; true; $ii++) {
                    $editNameDuplicate = $fullName . "({$ii})" . $extName;
                    if (!file_exists($folderPath . $editNameDuplicate)) {
                        $newImageName = $editNameDuplicate;
                        break;
                    }
                }
            }
            if ($image->move($folderPath, $newImageName)) {
                return $folderPath . $newImageName;
            }
        }
        return false;
    }

    public function deleteFile($path)
    {
        if (File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
        return File::exists(public_path($path)); // false
    }

    public function categoryCreateList($language)
    {
        /* ถ้าอยากได้ ROOT ให้เพิ่ม `rootCategory` subquery ลงไป
       *  (SELECT GROUP_CONCAT(id) FROM categories as cg WHERE cg.cate_root_id = categories.cate_root_id GROUP BY cate_root_id ) as `rootCategory`
       * */
        $sql = "SELECT
                    c.id,
                    c.cate_title as title,
                    c.cate_url as slug,
                    c.cate_parent_id as parentId,
                    c.cate_root_id as rootId,
                    c.cate_level as cateLevel,
                    c.cate_priority as priority,
                    c.language,
                    c.is_menu as isMenu,
                    c.is_leftside as leftSide,
                    c.is_topside as topSide,
                    c.is_rightside as rightSide,
                    c.is_bottomside as bottomSide,
                    c.defaults
                FROM categories as c
                INNER JOIN (
                    SELECT id as cateId, language as cateLang
                    FROM categories as g
                    WHERE g.language = :lang OR g.defaults = 1
                    GROUP BY g.id
                ) as cate ON cate.cateId = c.id AND cate.cateLang = c.language
                WHERE c.is_menu = 1
                ORDER BY cateLevel DESC ,  priority ASC";
        $result = DB::select($sql, [":lang" => $language]);
        return $this->categoryConvertGroup($result);
    }

    public function queryProduct($page_id, $cate_display = true, $is_food = 0, $product_dis = true)
    {
        $sql = "SELECT pc.*,
                    GROUP_CONCAT(p.id ORDER BY p.priority ASC) AS product_id,
                    GROUP_CONCAT(p.title ORDER BY p.priority ASC) AS product_title,
                    GROUP_CONCAT(p.price ORDER BY p.priority ASC) AS product_price,
                    GROUP_CONCAT(p.thumbnail_link ORDER BY p.priority ASC) AS product_image_link,
                    GROUP_CONCAT(p.thumbnail_title ORDER BY p.priority ASC) AS product_image_title,
                    GROUP_CONCAT(p.thumbnail_alt ORDER BY p.priority ASC) AS product_image_alt,
                    GROUP_CONCAT(p.defaults ORDER BY p.priority ASC) AS defaults,
                    GROUP_CONCAT(p.can_wave ORDER BY p.priority ASC) AS can_wave,
                    GROUP_CONCAT(p.can_sweet ORDER BY p.priority ASC) AS can_sweet
                FROM product_categories AS pc
                LEFT JOIN products AS p ON p.cate_id = pc.id
                LEFT JOIN categories AS c ON c.id = p.page_id
                WHERE c.id = $page_id
                AND pc.display = $cate_display
                AND pc.is_food = $is_food
                AND p.display = $product_dis
                GROUP BY pc.title
                ORDER BY pc.id";

        $data = DB::select($sql, []);

        $productDetailArr = array();
        foreach ($data as $key => $value) {
            $productObj = new stdClass;
            $productObj->cate_id = $value->id;
            $productObj->cate_title = $value->title;
            $productObj->cate_detail = $value->details;
            $productObj->cate_iamge_link = $value->thumbnail_link;
            $productObj->product_id = $value->product_id;
            $productObj->product_title = $value->product_title;
            $productObj->product_price = $value->product_price;
            $productObj->product_image_link = $value->product_image_link;
            $productObj->product_image_title = $value->product_image_title;
            $productObj->product_image_alt = $value->product_image_alt;
            $productObj->can_wave = $value->can_wave;
            $productObj->can_sweet = $value->can_sweet;
            $productObj->default = $value->defaults;

            array_push($productDetailArr, $productObj);
        }
        return $productDetailArr;
    }

    public function queryCategory($id)
    {
        $categoryData = DB::table('categories')
            ->select(
                'categories.id',
                'categories.cate_title as title',
                'categories.cate_thumbnail as icon',
                'categories.cate_h1',
                'categories.cate_h2',
                'ad_slides.ad_image as banner',
                'ad_slides.ad_image_alt as banner_alt'
            )
            ->leftJoin('ad_slides', 'categories.id', 'ad_slides.page_id')
            ->where('categories.id', $id)
            ->first();
        return $categoryData;
    }


    public function queryBanner($id)
    {
        $banner = AdSlide::where('page_id', $id)->get();
        if (count($banner) == 0) {
            return null;
        }
        foreach ($banner as $key => $value) {
            $bannerObj = new StdClass;
            $bannerObj->id = $value->id;
            $bannerObj->page_id = $value->page_id;
            $bannerObj->title = $value->ad_title;
            $bannerObj->image = $value->ad_image;
            $bannerObj->link = $value->ad_link;
        }
        return $bannerObj;
    }

    public function sendErrorValidators($message, $errorMessages)
    {
        return response()->json([
            'status' => false,
            'description' => $message,
            'message' => $message,
            'errorMessage' => $errorMessages
        ], 422);
    }

    /*Private Function */

    private function categoryConvertGroup($query)
    {
        $resultData = [];
        if (!empty($query)) {
            foreach ($query as $val) {
                $checked = (isset($resultData[$val->id])) ? true : false;
                $val->hasChildren = ($checked) ? 1 : 0;
                $val->childrenData = ($checked) ? $resultData[$val->id] : [];
                if ($val->cateLevel > 0) {
                    $resultData[$val->parentId][] = $val;
                } else {
                    $resultData[$val->parentId][] = $val;
                }
            }
        }
        return ($resultData) ? $resultData[0] : null;
    }

    public function getOrderWashTemp($ip, $language)
    {
        $orderTemp = DB::select(
            "SELECT temps.id,
                            order_temps.ip_address,
                            order_temps.details,
                            temps.orders_number,
                            temps.page_id,
                            temps.minutes_add,
                            order_temps.type_order,
                            temps.price_per_minutes,
                            temps.round_minutes,
                            temps.default_minutes,
                            temps.cart_number,
                            SUM(temps.price) as totalPrice,
                            GROUP_CONCAT(temps.product_title) as title
                    FROM order_temps
                    JOIN
                        (SELECT order_cart_temps .*,
                                products.price,
                                products.price_per_minutes,
                                products.round_minutes,
                                products.default_minutes
                        FROM order_cart_temps
                        JOIN products
                        ON (order_cart_temps.product_id = products.id AND products.language = :language)
                        ) as temps
                    ON (order_temps.orders_number = temps.orders_number)
                    WHERE order_temps.ip_address = :ip_address AND order_temps.type_order = 'washing'
                    GROUP BY temps.page_id, temps.orders_number, temps.cart_number",
            [":ip_address" => $ip, ":language" => $language]
        );
        return $orderTemp;
    }

    public function getOrderFoodsTemp($ip, $orders_number, $language)
    {
        $orderTemp = DB::select(
            "SELECT temps.*
                    FROM order_temps
                    JOIN
                        (SELECT order_cart_temps .*,
                                    product_categories.title as cate_title,
                                    products.price,
                                    products.thumbnail_link,
                                    microwave.name as microwave_name,
                                    sweetness.name as sweetness_name
                            FROM order_cart_temps
                            JOIN products ON (order_cart_temps.product_id = products.id)
                            JOIN product_categories ON (product_categories.id = products.cate_id)
                            LEFT JOIN product_more_details AS microwave ON (microwave.id = order_cart_temps.microwave_id)
                            LEFT JOIN product_more_details AS sweetness ON (sweetness.id = order_cart_temps.sweetness_id)
                            WHERE products.language = '$language' AND product_categories.language = '$language'
                        ) as temps
                    ON (order_temps.orders_number = temps.orders_number)
                    WHERE order_temps.ip_address = :ip_address AND order_temps.type_order = 'foods' AND order_temps.orders_number = :orders_number",
            [":ip_address" => $ip, ":orders_number" => $orders_number]
        );
        return $orderTemp;
    }

    public function getOrderFoodsItem($order_number, $language)
    {
        $member_id = auth()->guard('member')->id();
        $orderTemp = DB::select(
            "SELECT temps.*
                    FROM orders
                    JOIN
                        (SELECT order_items.*,
                                    product_categories.title as cate_title,
                                    products.price,
                                    products.thumbnail_link,
                                    microwave.name as microwave_name,
                                    sweetness.name as sweetness_name
                        FROM order_items
                        JOIN products ON (order_items.product_id = products.id)
                        JOIN product_categories ON (product_categories.id = products.cate_id)
                        LEFT JOIN product_more_details AS microwave ON (microwave.id = order_items.microwave_id)
                        LEFT JOIN product_more_details AS sweetness ON (sweetness.id = order_items.sweetness_id)
                        WHERE products.language = '$language' AND product_categories.language = '$language'
                        ) as temps
                    ON (orders.orders_number = temps.orders_number)
                    WHERE orders.type_order = 'foods' AND orders.status_id = 1 AND orders.member_id = :member_id AND orders.orders_number = :orders_number",
            ['member_id' => $member_id, ':orders_number' => $order_number]
        );
        return $orderTemp;
    }

    public function getOrderWashItem($order_number, $language)
    {
        $member_id = auth()->guard('member')->id();
        $orderTemp = DB::select(
            "SELECT temps.id,
                            orders.details,
                            temps.orders_number,
                            temps.page_id,
                            temps.minutes_add,
                            orders.type_order,
                            temps.price_per_minutes,
                            temps.round_minutes,
                            temps.default_minutes,
                            temps.cart_number,
                            SUM(temps.price) as totalPrice,
                            GROUP_CONCAT(temps.product_title) as title
                    FROM orders
                    JOIN
                        (SELECT order_items .*,
                                products.price,
                                products.price_per_minutes,
                                products.round_minutes,
                                products.default_minutes,
                                products.title as product_title
                        FROM order_items
                        JOIN products
                        ON (order_items.product_id = products.id) AND products.language = :language
                        ) as temps
                    ON (orders.orders_number = temps.orders_number)
                    WHERE orders.type_order = 'washing' AND orders.status_id = 1 AND orders.member_id = :member_id AND orders.orders_number = :orders_number
                    GROUP BY temps.page_id, temps.orders_number, temps.cart_number",
            ['member_id' => $member_id, ':orders_number' => $order_number, ':language' => $language]
        );
        return $orderTemp;
    }

    public function getOrderFoodsItemAdmin($order_number)
    {
        $language = session()->get('language');
        $orderTemp = DB::select(
            "SELECT temps.*
                    FROM orders
                    JOIN
                        (SELECT order_items.*,
                                    product_categories.title as cate_title,
                                    products.price,
                                    products.thumbnail_link,
                                    microwave.name as microwave_name,
                                    sweetness.name as sweetness_name
                        FROM order_items
                        JOIN products ON (order_items.product_id = products.id)
                        JOIN product_categories ON (product_categories.id = products.cate_id)
                        LEFT JOIN product_more_details AS microwave ON (microwave.id = order_items.microwave_id)
                        LEFT JOIN product_more_details AS sweetness ON (sweetness.id = order_items.sweetness_id)
                        WHERE products.language = '$language' AND product_categories.language = '$language'
                        ) as temps
                    ON (orders.orders_number = temps.orders_number)
                    WHERE orders.type_order = 'foods' AND orders.orders_number = :orders_number",
            [':orders_number' => $order_number]
        );
        return $orderTemp;
    }

    public function getOrderWashItemAdmin($order_number)
    {
        $language = session()->get('language');
        $orderTemp = DB::select(
            "SELECT temps.id,
                            temps.product_id,
                            orders.details,
                            orders.language,
                            temps.orders_number,
                            temps.page_id,
                            temps.minutes_add,
                            orders.type_order,
                            temps.price_per_minutes,
                            temps.round_minutes,
                            temps.default_minutes,
                            temps.cart_number,
                            temps.verified,
                            SUM(temps.price) as totalPrice,
                            GROUP_CONCAT(temps.product_title) as title
                    FROM orders
                    JOIN
                        (SELECT order_items .*,
                                products.price,
                                products.price_per_minutes,
                                products.round_minutes,
                                products.default_minutes,
                                products.title as product_title
                        FROM order_items
                        JOIN products
                        ON (order_items.product_id = products.id)
                        WHERE products.language = '$language'
                        ) as temps
                    ON (orders.orders_number = temps.orders_number)
                    WHERE orders.type_order = 'washing' AND orders.orders_number = :orders_number
                    GROUP BY temps.page_id, temps.orders_number, temps.cart_number",
            [':orders_number' => $order_number]
        );
        return $orderTemp;
    }

    public function getCurrentOrderWashItemAdmin($order_number, $productId, $pageId, $cartNumber)
    {
        $orderTemp = DB::select(
            "SELECT temps.id,
                            temps.product_id,
                            orders.details,
                            orders.language,
                            temps.orders_number,
                            temps.page_id,
                            temps.minutes_add,
                            orders.type_order,
                            temps.price_per_minutes,
                            temps.round_minutes,
                            temps.default_minutes,
                            temps.cart_number,
                            temps.verified,
                            temps.price as totalPrice
                    FROM orders
                    JOIN
                        (SELECT order_items .*,
                                products.price,
                                products.price_per_minutes,
                                products.round_minutes,
                                products.default_minutes,
                                products.title as product_title
                        FROM order_items
                        JOIN products
                        ON (order_items.product_id = products.id)
                        ) as temps
                    ON (orders.orders_number = temps.orders_number)
                    WHERE orders.type_order = 'washing'
                    AND orders.orders_number = :orders_number
                    AND temps.product_id = :product_id
                    AND temps.page_id = :page_id
                    AND temps.cart_number = :cart_number
                    LIMIT 1",
            [':orders_number' => $order_number, ':product_id' => $productId, ':page_id' => $pageId, ':cart_number' => $cartNumber]
        );
        return $orderTemp;
    }

    public function getContentLanguage($language)
    {
        $language = LanguageConfig::where(['language' => $language])->get();
        $content_language = array();
        foreach ($language as $lang) {
            $content_language[$lang->param] = $lang->title;
        }

        return $content_language;
    }

    public function sendLineMessage($order)
    {
        $message = "Order is incoming 👇👇 \n\n"
            . "No. ⏩ " . $order->orders_number . "\n"
            . "Type Order ⏩ " . $order->type_order . "\n"
            . "Link-Order ⏩ " . "www.facebook.com \n";

        Line::send($message);
    }

    public function notify_message($order)
    {
        $infos = $this->getWebInfo('', 'th');
        $webInfo = $this->infoSetting($infos);
        $member = MemberAccount::where('id', $order->member_id)->first();

        $message = "Order is incoming 👇👇 \n\n"
            . "No. ⏩ " . $order->orders_number . "\n"
            . "Member Name ⏩ " . $member->member_name . "\n"
            . "Phone Number ⏩ " . $order->phone_number . "\n"
            . "Type Order ⏩ " . $order->type_order . "\n"
            . "Link-Order ⏩ " . env("APP_BACKOFFICE_URL", "") . "orders?search=" . $order->orders_number . "\n";
        $LINE_API = "https://notify-api.line.me/api/notify";
        $LINE_TOKEN = $webInfo->settings->line_token->value;
        $queryData = array('message' => $message);
        $queryData = http_build_query($queryData, '', '&');
        $headerOptions = array(
            'http' => array(
                'method' => 'POST',
                'header' => "Content-Type: application/x-www-form-urlencoded\r\n"
                    . "Authorization: Bearer " . $LINE_TOKEN . "\r\n"
                    . "Content-Length: " . strlen($queryData) . "\r\n",
                'content' => $queryData
            )
        );
        $context = stream_context_create($headerOptions);
        $result = file_get_contents($LINE_API, FALSE, $context);
        $res = json_decode($result);
        return $res;
    }

    public function getCurrentLanguage($lang) {
        $lang_default = LanguageAvailable::where(['defaults' => 1])->first();
        $language = $lang ? $lang : $lang_default->abbv_name;
        return $language;
    }
}
