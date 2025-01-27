<?php
include $_SERVER["DOCUMENT_ROOT"] . "/app/database/db.php";
//session_start();
//var_dump($_POST);
if (isset($_SESSION['id_active_product'])) {
    $product_edit = selectOne('products', ['id' => $_SESSION['id_active_product']]);
    // tt($product_edit);
}


if (isset($_POST['barcode'])) {
    // Отримуємо код із POST-запиту
    $bar = trim($_POST['barcode']); // Прибираємо зайві пробіли

    // Перевіряємо, чи існує штрих-код у базі
    $barcode = selectOne('barcode', ['code' => $bar]);
    if (!$barcode) {
        echo "Штрих-код не знайдено.";
        return; // Завершуємо, якщо штрих-код не знайдено
    }
    //$_POST['barcode'] = '';
    // Отримуємо інформацію про продукт за його ID
    $product = selectOne('products', ['id' => $barcode["product_id"]]);
    if (!$product) {
        echo "Продукт із цим штрих-кодом не знайдено.";
        return; // Завершуємо, якщо продукт не знайдено
    }

    // Отримуємо ціну продукту
    $price = selectOne('prices', ['product_id' => $barcode["product_id"]]);
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
    $_SESSION['cart'][] = $product;
    // var_dump($_SESSION['cart']);
    // Виводимо вміст кошика для перевірки
    //tt($_SESSION['cart']);
}
