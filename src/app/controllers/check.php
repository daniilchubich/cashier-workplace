<?php include $_SERVER["DOCUMENT_ROOT"] . "/app/database/db.php"; ?>

<?php
//Додавання товару через Штріх-код
if (isset($_POST['barcode'])) {
    // Отримуємо код із POST-запиту
    $bar = trim($_POST['barcode']); // Прибираємо зайві пробіли

    // Перевіряємо, чи існує штрих-код у базі
    $barcode = selectOne('info_barcode', ['barcode' => $bar]);
    if (!$barcode) {
        echo "Штрих-код не знайдено.";
        return; // Завершуємо, якщо штрих-код не знайдено
    }
    //$_POST['barcode'] = '';
    // Отримуємо інформацію про продукт за його ID
    $product = selectOne('ref_products', ['id' => $barcode["product_id"]]);
    if (!$product) {
        echo "Продукт із цим штрих-кодом не знайдено.";
        return; // Завершуємо, якщо продукт не знайдено
    }

    // Отримуємо ціну продукту
    $price = selectOne('info_prices', ['product_id' => $barcode["product_id"], 'price_type_id' => $_SESSION['work_shift']["price_type_id"]]);
    if (!$price) {
        echo "Ціна для цього продукту не знайдена.";
        return; // Завершуємо, якщо ціна не знайдена
    }

    // Об'єднуємо всі дані про продукт
    if (is_array($product) && is_array($price)) {

        $product = [
            "id" => $product["id"],           // Общий ID
            "name" => $product["name"],
            "full_name" => $product["full_name"],
            "price" => $price["price"],     // Цена из первого массива
            "description" => $product["description"], // Описание из второго массива
            "quantity" => 1,     // Остаток из второго массива
            "sum" => ''
        ];
    }
    // Ініціалізуємо кошик у сесії, якщо ще не ініціалізовано
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Додаємо продукт до кошика
    $string_id = updateOrAddSessionCart($_SESSION['cart'], $product);
}

//Обробка обраного товару у чеку
if (isset($_POST['string_id'])) {

    $string_id = isset($_POST['string_id']) ? $_POST['string_id'] : '';
    $product_active = isset($_SESSION['cart'][$string_id]) ? $_SESSION['cart'][$string_id] : '';
    $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 0;
    if ($quantity > 0) {
        $_SESSION['cart'][$string_id]['quantity'] = $quantity;
    }
}

//Видалення обраного товару
if (isset($_POST['deleteStringInCheck'])) {
    //tt($_SESSION['cart']);
    unset($_SESSION['cart'][$_POST['deleteStringInCheck']]);
    $_SESSION['cart'] = array_values($_SESSION['cart']);
}

//Пошук дисконту
if (isset($_POST['phoneForDiscont'])) {
    //$phone_number = $_POST['phoneForDiscont'];
    $phone_number = preg_replace("/\D/", "", $_POST['phoneForDiscont']);

    // Убираем код страны "380"
    if (strpos($phone_number, "380") === 0) {
        $phone_number = substr($phone_number, 3);
    }
    //tt($phone_number);
    $discount = selectOne('ref_discounts', ['phone_number' => $phone_number]);
    $_SESSION['discount'] = isset($discount) ? $discount : '';

    if (isset($_SESSION['cart'])) {
        $_SESSION['total_amount'] = 0;
        $_SESSION['total_sale'] = 0;
        for ($i = 0; $i < count($_SESSION['cart']); $i++) {
            $_SESSION['total_amount'] =  $_SESSION['total_amount'] + $_SESSION['cart'][$i]['price'] * $_SESSION['cart'][$i]['quantity'];
            $_SESSION['total_sale'] = isset($_SESSION['discount']) ? $_SESSION['total_sale'] + round($_SESSION['cart'][$i]['price'] * $_SESSION['cart'][$i]['quantity'] / 100 * $_SESSION['discount']['percent_discount'], 2) : '';
        }
    }
}

//Провести чек

if (isset($_POST['check_action'])) {
    //echo "123";
    if (isset($_SESSION['cart'])) {
        $cheсk_status_id = isset($_POST['otlozhen']) ? 1 : (isset($_POST['proveden']) ? 2 : 0);
        //$count_string =  countStringInTable('doc_check_main');
        $cheсk_number = str_pad(countStringInTable('doc_check_main') + 1, 7, "0", STR_PAD_LEFT);

        $params_check_main = [
            'cheсk_number' => $cheсk_number,
            'check_status_id' => $cheсk_status_id,
            'user_id' => $_SESSION['work_shift']['user_id'],
            'shop_id' => $_SESSION['work_shift']['shop_id'],
            'price_type_id' => $_SESSION['work_shift']['price_type_id'],
            'discount_id' => isset($_SESSION['discount']['id']) ? $_SESSION['discount']['id'] : 0,
            'doc_sum' => isset($_SESSION['total_amount']) ? $_SESSION['total_amount'] : 0
        ];

        $id_check_name = insert('doc_check_main', $params_check_main);
        $_SESSION['check_deffered'] = selectAllCheck(['check_status_id' => 1]);
        if (isset($_SESSION['cart'])) {
            for ($i = 0; $i < count($_SESSION['cart']); $i++) {
                $sum = $_SESSION['cart'][$i]['price'] * $_SESSION['cart'][$i]['quantity'];
                $sum_discount = round($_SESSION['cart'][$i]['price'] * $_SESSION['cart'][$i]['quantity'] * 3 / 100, 2);
                $sum_without_discount =  $sum - $sum_discount;

                $params_check_product = [
                    'check_id' => $id_check_name,
                    'product_id' => $_SESSION['cart'][$i]['id'],
                    //'characteristic_id' => $_SESSION['cart']['characteristic_id'],
                    'price' => $_SESSION['cart'][$i]['price'],
                    'quantity' => $_SESSION['cart'][$i]['quantity'],
                    'sum' => $sum,
                    'sum_discount' => $sum_discount,
                    'sum_without_discount' => $sum_without_discount,
                ];
                insert('doc_check_products', $params_check_product);
                $_SESSION['check_list'] = selectAllCheck();
                //tt($_SESSION['check_list']);
            }
        }
        unset($_SESSION['cart']);
        unset($_SESSION['discount']);
        unset($_SESSION['total_amount']);
        unset($_SESSION['total_sale']);
    } else {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Корзина пустая!</strong> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
}
//Open Deffered check

if (isset($_POST['check_deffered_id'])) {
    $check_deffered = selectOne('doc_check_main', ['id' => $_POST['check_deffered_id']]);
    tt($check_deffered);
    $discount = selectOne('ref_discounts', ['id' => $check_deffered['discount_id']]);
    $_SESSION['discount'] = isset($discount) ? $discount : null;
    $_SESSION['cart'] = selectAllCheckProducts($_POST['check_deffered_id']);
    tt($_SESSION['cart']);
    // Додаємо продукт до кошика
    //$string_id = updateOrAddSessionCart($_SESSION['cart'], $product);
    echo "123";
}
