<?php include $_SERVER["DOCUMENT_ROOT"] . "/app/database/db.php"; ?>


<?php
//Додавання товару через Штріх-код
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
    if (isset($_SESSION['cart'])) {
        $string_id = count($_SESSION['cart']) - 1;
        //$product_active = isset($_SESSION['cart'][$string_id]) ? $_SESSION['cart'][$string_id] : '';
    }

    // var_dump($_SESSION['cart']);
    // Виводимо вміст кошика для перевірки
    //tt($_SESSION['cart']);
}

//Обробка обраного товару у чеку
if (isset($_POST['string_id'])) {

    $string_id = isset($_POST['string_id']) ? $_POST['string_id'] : '';
    $product_active = isset($_SESSION['cart'][$string_id]) ? $_SESSION['cart'][$string_id] : '';
    $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 0;
    if ($quantity > 0) {
        $_SESSION['cart'][$string_id]['quantity'] = $quantity;
    }
} else {
    //echo "POST undefined";
}

//Видалення обраного товару
if (isset($_POST['deleteStringInCheck'])) {
    //tt($_SESSION['cart']);
    unset($_SESSION['cart'][$_POST['deleteStringInCheck']]);
    $_SESSION['cart'] = array_values($_SESSION['cart']);
}
