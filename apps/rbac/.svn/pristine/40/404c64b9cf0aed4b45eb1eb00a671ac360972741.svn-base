<?php
// +----------------------------------------------------------------------
// | API访问首页
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.jeoshi.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: kevin
// +----------------------------------------------------------------------

namespace app\api\controller;

use think\Config;
use think\Cookie;
use plugin\Crypt;
use app\common\controller\ApiController;

/**
 * 首页接口
 * Class Index
 * @package app\api\controller
 */
class Index extends ApiController
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];

    /**
     * 首页
     */
    public function index()
    {
        $string = '{"errors": [], "orders": [{"estimated_shipping_fee": "10000", "payment_method": "Cash on Delivery", "update_time": 1553694852, "message_to_seller": "", "shipping_carrier": "Standar Ekspres", "currency": "IDR", "create_time": 1553694837, "pay_time": null, "recipient_address": {"town": "", "city": "KOTA BEKASI", "name": "Najwa Amelia", "district": "BEKASI TIMUR", "country": "ID", "zipcode": "17111", "full_address": "Jl pulau irian jaya koperku 8 no.42 RT 09/18 kelurahan aren jaya kecamatan Bekasi timur, KOTA BEKASI, BEKASI TIMUR, JAWA BARAT, ID, 17111", "phone": "6281290307835", "state": "JAWA BARAT"}, "credit_card_number": "", "note": "", "ship_by_date": 1553867652, "tracking_no": "", "order_status": "READY_TO_SHIP", "note_update_time": 0, "dropshipper_phone": "(+62) 812-9030-7835", "escrow_amount": "30065", "days_to_ship": 2, "goods_to_declare": false, "total_amount": "31791", "service_code": "", "country": "ID", "actual_shipping_cost": "", "cod": true, "items": [{"weight": 0.06, "item_name": "Papjk Jam Tangan Quartz Casual Motif Unicorn Strap Kulit Kecil untuk Wanita", "is_wholesale": false, "item_sku": "SHLKBX0A03ZCATA7C07033V7S-H01MZMZY8OS8V0", "variation_discounted_price": "21791", "variation_id": 2602652152, "variation_name": "pink", "is_add_on_deal": false, "item_id": 1650804874, "add_on_deal_id": 0, "variation_quantity_purchased": 1, "variation_sku": "SHOYCB62SUfCFTZ700D0Q307W_90243-X0RITF9787R", "variation_original_price": "50677", "is_main_item": false}], "ordersn": "1903272153642KT", "dropshipper": "Najwa amelia", "buyer_username": "najwaamelia337"}, {"estimated_shipping_fee": "30000", "payment_method": "Bank BCA (SIPP Virtual Account)", "update_time": 1553696369, "message_to_seller": "", "shipping_carrier": "Standar Ekspres", "currency": "IDR", "create_time": 1553696272, "pay_time": 1553696369, "recipient_address": {"town": "", "city": "KOTA DENPASAR", "name": "Velia Victory", "district": "DENPASAR UTARA", "country": "ID", "zipcode": "80116", "full_address": "Jalan Cargo Indah no 9 depan hotel Tari JW Menuh, KOTA DENPASAR, DENPASAR UTARA, BALI, ID, 80116", "phone": "6281237860448", "state": "BALI"}, "credit_card_number": "", "note": "", "ship_by_date": 1553869169, "tracking_no": "", "order_status": "READY_TO_SHIP", "note_update_time": 0, "dropshipper_phone": "", "escrow_amount": "127152", "days_to_ship": 2, "goods_to_declare": false, "total_amount": "135109", "service_code": "", "country": "ID", "actual_shipping_cost": "", "cod": false, "items": [{"weight": 0.04, "item_name": "\u2728Rp199\u2728 Alat Bantu Memasukkan Benang ke Jarum Otomatis, Mudah Digunakan, Warna Acak", "is_wholesale": false, "item_sku": "SH522RRSCUNS7G48M132I5B8YZM7CQLAUW4NGCEX", "variation_discounted_price": "199", "variation_id": 0, "variation_name": "", "is_add_on_deal": false, "item_id": 1541727866, "add_on_deal_id": 0, "variation_quantity_purchased": 1, "variation_sku": "", "variation_original_price": "16863", "is_main_item": false}, {"weight": 0.03, "item_name": "ALID Soft Case Charger Earphone Wireless Bahan Silikon Anti Jatuh Multi Warna untuk Airpods", "is_wholesale": false, "item_sku": "SHRS4AW8DINBZXT887N5F8K9IV478P36FUUDVABG", "variation_discounted_price": "15005", "variation_id": 2524683237, "variation_name": "Gray", "is_add_on_deal": false, "item_id": 1625116787, "add_on_deal_id": 0, "variation_quantity_purchased": 1, "variation_sku": "SH09W20CIOTB1X88G7A5U8X9F_U1J03CGJLCNURB", "variation_original_price": "27282", "is_main_item": false}, {"weight": 0.03, "item_name": "ALID Soft Case Charger Earphone Wireless Bahan Silikon Anti Jatuh Multi Warna untuk Airpods", "is_wholesale": false, "item_sku": "SHRS4AW8DINBZXT887N5F8K9IV478P36FUUDVABG", "variation_discounted_price": "15005", "variation_id": 2524683239, "variation_name": "Black", "is_add_on_deal": false, "item_id": 1625116787, "add_on_deal_id": 0, "variation_quantity_purchased": 1, "variation_sku": "SH03GUE5ZITB4X08G765S8T9S_T1Y5CK29SW295X", "variation_original_price": "27282", "is_main_item": false}, {"weight": 0.21, "item_name": "Korset Postur Punggung untuk Memperbaiki Postur Punggung alid", "is_wholesale": false, "item_sku": "SHO08U7SZVNYPQW879P4L9R7398ON5Z0WIJCRIX7", "variation_discounted_price": "74900", "variation_id": 3665670495, "variation_name": "Black,L", "is_add_on_deal": false, "item_id": 1647654923, "add_on_deal_id": 0, "variation_quantity_purchased": 1, "variation_sku": "YQ89497_03", "variation_original_price": "140000", "is_main_item": false}], "ordersn": "19032722176737U", "dropshipper": "", "buyer_username": "velia_victory"}, {"estimated_shipping_fee": "10000", "payment_method": "Bank Mandiri (SIPP Virtual Account)", "update_time": 1553696329, "message_to_seller": "", "shipping_carrier": "Standar Ekspres", "currency": "IDR", "create_time": 1553696176, "pay_time": 1553696329, "recipient_address": {"town": "", "city": "KAB. KARAWANG", "name": "Faturohman Noor Sidik", "district": "TELUKJAMBE BARAT", "country": "ID", "zipcode": "41343", "full_address": "PT. GLICO WINGS JL. RAYA KALIGANDU  DS. WANAJAYA KEC. TELUKJAMBE BARAT-KARAWANG, KAB. KARAWANG, TELUKJAMBE BARAT, JAWA BARAT, ID, 41343", "phone": "628980104240", "state": "JAWA BARAT"}, "credit_card_number": "", "note": "", "ship_by_date": 1553869129, "tracking_no": "", "order_status": "READY_TO_SHIP", "note_update_time": 0, "dropshipper_phone": "", "escrow_amount": "79457", "days_to_ship": 2, "goods_to_declare": false, "total_amount": "84900", "service_code": "", "country": "ID", "actual_shipping_cost": "", "cod": false, "items": [{"weight": 0.21, "item_name": "Korset Postur Punggung untuk Memperbaiki Postur Punggung alid", "is_wholesale": false, "item_sku": "SHO08U7SZVNYPQW879P4L9R7398ON5Z0WIJCRIX7", "variation_discounted_price": "74900", "variation_id": 3665670493, "variation_name": "Black,S", "is_add_on_deal": false, "item_id": 1647654923, "add_on_deal_id": 0, "variation_quantity_purchased": 1, "variation_sku": "YQ89497_01", "variation_original_price": "140000", "is_main_item": false}], "ordersn": "190327221666VD5", "dropshipper": "", "buyer_username": "faturohman19"}], "request_id": "4fW15z4TSN0pBEWHuWtngX"}';
        $result = Crypt::encrypt($string);

        $arr = Crypt::decrypt($result);


        $this->success('Success', $result);
    }

    public function test()
    {
        //echo md5(md5('123456'));exit;
        $result = json_encode(['username' => '测试人员李彬双', 'password' => 'w44qoI', 'loginIp' => '123.1.1.2', 'module_id' => 2]);
        $arr = Crypt::encrypt($result);
        echo json_encode(['crypt_data' => $arr]);
       // $this->success('Success', $arr);
    }
}
