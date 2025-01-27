<?php include $_SERVER["DOCUMENT_ROOT"] .  "/app/database/db.php";
//tt($_POST);
if (isset($_POST['string_id'])) {

    $string_id = issetShort(isset($_POST['string_id']), '');
    // $product_id = $_POST['id_active_product'];
    $product_active = isset($_SESSION['cart'][$string_id]) ? $_SESSION['cart'][$string_id] : '';
    $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 0;
    if ($quantity > 0) {
        $_SESSION['cart'][$string_id]['quantity'] = $quantity;
    }
    //tt($product_active);
    //tt($_SESSION['cart'][$string_id]);
} else {
    echo "POST undefined";
}
?>
<div class="content-single">
    <div class="single-top">
        <span class="name"><?= issetShort(isset($_POST['full_name']), ''); ?></span>
        <span class="btn-trash-wrapper">
            <i class="bi bi-trash"></i>
        </span>
    </div>
    <div class="single-bottom">
        <div class="cost">
            <input type="text" placeholder="<?= issetShort(isset($product_active['price']), 0) ?>"
                value="<?= issetShort(isset($product_active['price']), 0) ?>">
            <span>грн.</span>
        </div>
        <div class="weight">
            <span class="weight-minus"
                onclick="adjustCounter('minus', <?= issetShort(isset($product_active['id']), 0) ?>)">-</span>
            <input type="text" placeholder="1"
                value="<?= issetShort(isset($_SESSION['cart'][isset($string_id)]['quantity']), 0) ?>">
            <span class="weight-plus"
                onclick="adjustCounter('plus',<?= issetShort(isset($product_active['id']), 0) ?>)">+</span>
            <!-- <span class="weight-basket">
                 <i class="bi bi-basket"></i> 
            </span> -->
        </div>
        <div class="discount">
            <span class="text">Знижка</span>
            <input type="text" placeholder="0,00" value="0,00">
            <i class="bi bi-percent discount-percent"></i>
            <span class="choose-btn">грн.</span>
        </div>
        <div class="sum">
            <span>Усього за товар:</span>
            <b><?= $_SESSION['cart'][isset($string_id)]['price'] * $_SESSION['cart'][isset($string_id)]['quantity'] ?>
                грн.</b>
        </div>
    </div>
</div>
<div class="content-items">
    <table class="table ">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Назва</th>
                <th scope="col">Вартість</th>
                <th scope="col">Кількість</th>
                <th scope="col" style="text-align: right;">Загальна вартість</th>
            </tr>
        </thead>

        <tbody>
            <?php if (isset($_SESSION['cart'])): ?>
                <?php $_SESSION['total_amount'] = 0; ?>
                <?php for ($i = 0; $i < count($_SESSION['cart']); $i++):  ?>
                    <?php $_SESSION['total_amount'] =  $_SESSION['total_amount'] + $_SESSION['cart'][$i]['price'] * $_SESSION['cart'][$i]['quantity']; ?>
                    <?php if ($i == isset($string_id)) {
                        $active = 'active';
                    } else {
                        $active = '';
                    } ?>
                    <tr class="<?= $active ?>" onclick="sendActiveProduct('<?= $_SESSION['cart'][$i]['id'] ?>',<?= $i ?>)">
                        <th id="id" scope="row"><?= $i + 1 ?></th>
                        <td id="name"><?= $_SESSION['cart'][$i]['name'] ?></td>
                        <td id="price"><?= $_SESSION['cart'][$i]['price'] ?></td>
                        <td id="quantity"><span><?= $_SESSION['cart'][$i]['quantity'] ?></span> шт.</td>
                        <td id="sum" style="font-weight: 600; text-align: right;">
                            <?= $_SESSION['cart'][$i]['price'] * $_SESSION['cart'][$i]['quantity'] ?>
                        </td>
                    </tr>
                <?php endfor ?>

            <?php
            endif ?>
        </tbody>
    </table>
</div>
<script src="./assets/js/main.js"></script>