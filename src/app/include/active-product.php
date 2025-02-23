<?php include $_SERVER["DOCUMENT_ROOT"] .  "/app/database/db.php";
//tt($_POST);
if (isset($_POST['string_id'])) {

    $string_id = isset($_POST['string_id']) ? $_POST['string_id'] : '';
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
        <span class="name"><?= isset($product_active['full_name']) ? $product_active['full_name'] : 0 ?></span>
        <span class="btn-trash-wrapper">
            <i class="bi bi-trash"></i>
        </span>
    </div>
    <div class="single-bottom">
        <div class="cost">
            <input type="text" placeholder="<?= isset($product_active['price']) ? $product_active['price'] : 0 ?>"
                value="<?= isset($product_active['price']) ? $product_active['price'] : 0 ?>">
            <span>грн.</span>
        </div>
        <div class="weight">
            <span class="weight-minus"
                onclick="adjustCounter('minus', <?= isset($product_active['price']) ? $product_active['id'] : 0 ?>)">-</span>
            <input type="text" placeholder="1" value="<?php if (isset($string_id)) {

                echo isset($_SESSION['cart'][$string_id]['quantity']) ? $_SESSION['cart'][$string_id]['quantity'] : 1;
            } ?>">
            <span class="weight-plus"
                onclick="adjustCounter('plus',<?= isset($product_active['price']) ? $product_active['id'] : 0 ?>)">+</span>
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
            <b><?php if (isset($string_id)) {
                echo $_SESSION['cart'][$string_id]['price'] * $_SESSION['cart'][$string_id]['quantity'];
            } ?>
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
                    <span id="total_amount"
                        style="display:none"><?= isset($_SESSION['total_amount']) ? $_SESSION['total_amount'] : '' ?></span>
                    <?php if (isset($string_id) && $i == $string_id) {
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