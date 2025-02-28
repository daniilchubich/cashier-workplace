<?php

include $_SERVER["DOCUMENT_ROOT"] . "/app/controllers/check.php";

$products = selectAll('ref_products'); // Получаем все продукты
$discounts = selectAll('ref_discounts'); // Получаем все скидки
$info_prices = selectAll('info_prices'); // Получаем все цены
$shops = selectAll('ref_shops'); // Получаем все магазины

$totalProducts = count($products);
$totalDiscounts = count($discounts);
$totalPrices = count($info_prices);
$totalShops = count($shops);

if ($totalShops === 0) {
    die("❌ Ошибка: В таблице ref_shops нет магазинов!");
}

$batchSize = 500; // Размер пакета для вставки
$checkCount = 10000; // Количество чеков
$productsPerCheck = 5; // Продуктов в чеке

$pdo->beginTransaction(); // Начинаем транзакцию

try {
    for ($i = 0; $i < $checkCount; $i++) {
        // Генерируем номер чека
        $check_number = str_pad(countStringInTable('doc_check_main') + 1, 7, "0", STR_PAD_LEFT);

        // Определяем, будет ли у чека скидка (каждый 5-й без скидки)
        $discount_id_bas = ($i % 5 === 0 || $totalDiscounts === 0) ? null : $discounts[$i % $totalDiscounts]['id_bas'];
        //echo "$i</br>";
        // Выбираем магазин (циклично)
        $shop = $shops[$i % $totalShops];
        //var_dump($shop);
        // if (!isset($shop['id_bas']) || !isset($shop['price_type_id_bas'])) {
        //     error_log("❌ Ошибка: В магазине отсутствуют id_bas или price_type_id_bas. Магазин: " . json_encode($shop));
        //     continue;
        // }

        $shop_id_bas = $shop['id_bas'];
        $price_type_id_bas = $shop['price_type_id_bas'];

        // Вставляем чек
        $params_check_main = [
            'cheсk_number' => $check_number,
            'check_status_id' => 1,
            'user_id' => 1,
            'shop_id_bas' => $shop_id_bas,
            'price_type_id_bas' => $price_type_id_bas,
            'discount_id_bas' => $discount_id_bas,
            'doc_sum' => 0 // Временно 0, обновим позже
        ];

        $id_check_name = insert('doc_check_main', $params_check_main); // Вставляем чек
        //echo "$i</br>";
        // Вставляем 5 продуктов
        $values = [];
        $sum_without_discount_total = 0; // Общая сумма без скидки

        for ($j = 0; $j < $productsPerCheck; $j++) {
            $productIndex = ($i * $productsPerCheck + $j) % $totalProducts;
            $product = $products[$productIndex];
            //echo "$i</br>";
            // Ищем цену в info_prices по product_id_bas и price_type_id_bas
            $price = null;
            foreach ($info_prices as $info_price) {
                if ($info_price['product_id_bas'] === $product['id_bas'] && $info_price['price_type_id_bas'] === $price_type_id_bas) {
                    $price = $info_price['price'];
                    break;
                }
            }

            // Если цена не найдена, задаем случайную
            if ($price === null) {
                error_log("⚠️ Предупреждение: Не найдена цена для товара {$product['id_bas']} с типом цены $price_type_id_bas");
                $price = rand(100, 500);
            }

            $quantity = rand(1, 10);
            $sum = $price * $quantity;

            // Если у чека есть скидка, вычисляем её
            $discount_percent = $discount_id_bas ? 3 : 0;
            $sum_discount = round($sum * ($discount_percent / 100), 2);
            $sum_without_discount = $sum - $sum_discount;

            $sum_without_discount_total += $sum_without_discount; // Добавляем в общую сумму

            $values[] = "(
                '$id_check_name',
                '{$product['id_bas']}',
                '$price',
                '$quantity',
                '$sum',
                '$sum_discount',
                '$sum_without_discount'
            )";
        }

        // Пакетная вставка продуктов
        if (!empty($values)) {
            $sql = "INSERT INTO doc_check_products 
                    (check_id, product_id_bas, price, quantity, sum, sum_discount, sum_without_discount) 
                    VALUES " . implode(',', $values);
            $pdo->exec($sql);
        }

        // Обновляем doc_sum в чеке
        $sql = "UPDATE doc_check_main 
        SET doc_sum = :doc_sum 
        WHERE id = :id_bas";
        $stmt = $pdo->prepare($sql);

        // Привязываем параметры с указанием типа данных
        $stmt->bindParam(':doc_sum', $sum_without_discount_total, PDO::PARAM_STR);
        $stmt->bindParam(':id_bas', $id_check_name, PDO::PARAM_STR);

        $stmt->execute();

        // Фиксируем каждые $batchSize чеков
        if ($i % $batchSize === 0) {
            $pdo->commit();
            $pdo->beginTransaction();
        }
        //echo "$i</br>";
    }

    $pdo->commit(); // Финальная фиксация
    echo "✅ Успешно создано $checkCount чеков!";
} catch (Exception $e) {
    $pdo->rollBack();
    echo "❌ Ошибка: " . $e->getMessage();
}
