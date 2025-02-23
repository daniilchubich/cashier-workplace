<?php

include $_SERVER["DOCUMENT_ROOT"] . "/app/database/db.php";
function getAddProducts()
{

    $url = "https://uztest.kraft.net.ua:8443/smile-test-bor/hs/rts/products";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPGET, true);
    //curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
    ]);

    $response = json_decode(curl_exec($ch))->ref_products;
    curl_close($ch);
    var_dump(count($response));
    for ($i = 0; $i < count($response); $i++) {

        $params_products = [
            'id_bas' => $response[$i]->id_bas,
            'name' => isset($response[$i]->name) ? $response[$i]->name : null,
            'full_name' => isset($response[$i]->full_name) ? $response[$i]->full_name : null,
            'is_group' => $response[$i]->is_group,
            'parent_id_bas' => isset($response[$i]->is_group) == 0 ? $response[$i]->parent_id_bas : null,
            'articul' => isset($response[$i]->articul) ? $response[$i]->articul : null,
            'description' => isset($response[$i]->description) ? $response[$i]->description : null
        ];
        //tt($params_products);
        insert('ref_products', $params_products);
    }
}
function getAddDiscounts()
{

    $url = "https://uztest.kraft.net.ua:8443/smile-test-bor/hs/rts/discounts";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPGET, true);
    //curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
    ]);

    $response = json_decode(curl_exec($ch))->ref_discounts;
    curl_close($ch);
    var_dump(count($response));
    for ($i = 0; $i < count($response); $i++) {

        $params_discounts = [
            'id_bas' => $response[$i]->id_bas,
            'first_name' => isset($response[$i]->first_name) ? $response[$i]->first_name : null,
            'second_name' => isset($response[$i]->second_name) ? $response[$i]->second_name : null,
            'phone_number' => isset($response[$i]->phone_number) ? normalizePhoneNumber($response[$i]->phone_number) : null,
            'percent_bonus' => isset($response[$i]->percent_bonus) ? (float)$response[$i]->percent_bonus : 0,
            'percent_discount' => isset($response[$i]->percent_discount) ? $response[$i]->percent_discount : 0
        ];
        //tt($params_discounts['id_bas']);
        insert('ref_discounts', $params_discounts);
        //tt($response);
    }
    //tt($response);
}

function getAddClassifier()
{

    $url = "https://uztest.kraft.net.ua:8443/smile-test-bor/hs/rts/ref_classifier";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPGET, true);
    //curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
    ]);

    $response = json_decode(curl_exec($ch));
    curl_close($ch);
    var_dump(count($response->ref_shops));
    for ($i = 0; $i < count($response->ref_shops); $i++) {

        $params_shops = [
            'id_bas' => $response->ref_shops[$i]->id_bas,
            'name' => isset($response->ref_shops[$i]->name) ? $response->ref_shops[$i]->name : null,
            'full_name' => isset($response->ref_shops[$i]->full_name) ? $response->ref_shops[$i]->full_name : null,
            'price_type_id_bas' => isset($response->ref_shops[$i]->price_type_id_bas) ? $response->ref_shops[$i]->price_type_id_bas : null,
            'organization_id_bas' => isset($response->ref_shops[$i]->organization_id_bas) ? $response->ref_shops[$i]->organization_id_bas : null,
        ];
        //tt($params_shops);
        insert('ref_shops', $params_shops);
    }
    var_dump(count($response->ref_price_types));
    for ($i = 0; $i < count($response->ref_price_types); $i++) {

        $params_ref_price_types = [
            'id_bas' => $response->ref_price_types[$i]->id_bas,
            'name' => isset($response->ref_price_types[$i]->name) ? $response->ref_price_types[$i]->name : null,
            'include_vat' => isset($response->ref_price_types[$i]->include_vat) ? $response->ref_price_types[$i]->include_vat : false,
        ];
        //tt($params_ref_price_types);
        insert('ref_price_types', $params_ref_price_types);
    }
    var_dump(count($response->ref_organization));
    for ($i = 0; $i < count($response->ref_organization); $i++) {
        $params_organization = [
            'id_bas' => $response->ref_organization[$i]->id_bas,
            'name' => isset($response->ref_organization[$i]->name) ? $response->ref_organization[$i]->name : null,
        ];
        //tt($params_organization);
        insert('ref_organization', $params_organization);
    }
    //tt($response);
}

function getAddPrices()
{

    $url = "https://uztest.kraft.net.ua:8443/smile-test-bor/hs/rts/price";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPGET, true);
    //curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
    ]);

    $response = json_decode(curl_exec($ch))->info_price;
    curl_close($ch);
    var_dump(count($response));
    for ($i = 0; $i < count($response); $i++) {

        $params_prices = [
            'product_id_bas' => isset($response[$i]->product_id_bas) ? $response[$i]->product_id_bas : null,
            'characteristic_id_bas' => isset($response[$i]->characteristic_id_bas) ? $response[$i]->characteristic_id_bas : null,
            'price_type_id_bas' => isset($response[$i]->price_type_id_bas) ? $response[$i]->price_type_id_bas : null,
            'price' => isset($response[$i]->price) ? (float)$response[$i]->price : 0,
        ];
        //tt($params_prices);
        insert('info_prices', $params_prices);
        //tt($response);
    }
    //tt($response);
}

function getAddBarcode()
{

    $url = "https://uztest.kraft.net.ua:8443/smile-test-bor/hs/rts/barcode";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPGET, true);
    //curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
    ]);

    $response = json_decode(curl_exec($ch))->info_barcode;
    curl_close($ch);
    var_dump(count($response));
    for ($i = 0; $i < count($response); $i++) {

        $params_barcode = [
            'product_id_bas' => isset($response[$i]->product_id_bas) ? $response[$i]->product_id_bas : null,
            'characteristic_id_bas' => isset($response[$i]->characteristic_id_bas) ? $response[$i]->characteristic_id_bas : null,
            'barcode' => isset($response[$i]->barcode) ? (float)$response[$i]->barcode : null,
        ];
        //tt($params_barcode);
        insert('info_barcode', $params_barcode);
        //tt($response);
    }
    //tt($response);
}
function normalizePhoneNumber($phone)
{
    // Удаляем все ненужные символы, кроме цифр
    $phone = preg_replace('/\D/', '', $phone);

    // Если номер начинается с "0", оставляем как есть (украинский формат)
    if (preg_match('/^0\d{9}$/', $phone)) {
        return $phone;
    }

    // Если номер начинается с "+380" или "380", убираем код страны
    if (preg_match('/^(?:380|0380)(\d{9})$/', $phone, $matches)) {
        return "0" . $matches[1]; // Добавляем "0" перед номером
    }

    return $phone; // Если не удалось распознать, возвращаем как есть
}
