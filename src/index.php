<?php //include "./path.php"; 
?>
<?php include $_SERVER["DOCUMENT_ROOT"] .  "/controllers/check.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- BOOTSTRAP ICONS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="./assets/css/style.css">
    <title>Project | Scan</title>

</head>

<body>
    <div class="wrapper">
        <!-- Navbar start -->
        <?php include "app/include/navbar.php" ?>

        <!-- Navbar end -->

        <div id="main-content">
            <!-- Content start -->
            <div id="content">
                <?php //include "app/include/active-product.php" 
                ?>
                <span id="result"></span>
                <div id="content-single" class="content-single">
                    <div class="single-top">
                        <span
                            class="name"><?= isset($product['full_name']) ? $product['full_name'] : 'Відскануйте товар' ?></span>
                        <span class="btn-trash-wrapper">
                            <i class="bi bi-trash"></i>
                        </span>
                    </div>
                    <div class="single-bottom">
                        <div class="cost">
                            <input type="text" value="<?= isset($product['price']) ? $product['price'] : '' ?>">
                            <span>грн.</span>
                        </div>
                        <div class="weight">
                            <span class="weight-minus" onclick="adjustCounter('minus', <?= $product['id'] ?>)">-</span>
                            <input type="text" placeholder="1"
                                value="<?= isset($product['quantity']) ? $product['quantity'] : '' ?>">
                            <span class="weight-plus" onclick="adjustCounter('plus',<?= $product['id'] ?>)">+</span>
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
                            <span class="text">Усього за товар:</span>
                            <b>
                                <?php if (isset($product['price'])): ?>
                                    <input type="text" value="<?= isset($product['price']) ? $product['price'] : '' ?>">
                                <?php endif ?>

                                грн
                            </b>
                        </div>
                    </div>
                </div>
                <div class="content-items" id="index">
                    <table class="table ">
                        <thead>
                            <tr>
                                <th scope="col" class="col">#</th>
                                <th scope="col" class="col">Назва</th>
                                <th scope="col" class="col">Вартість</th>
                                <th scope="col" class="col">Кількість</th>
                                <th scope="col" class="col" style="text-align: right;">Загальна вартість</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (isset($_SESSION['cart'])): ?>
                                <?php for ($i = 0; $i < count($_SESSION['cart']); $i++):  ?>
                                    <?php if ($i == count($_SESSION['cart']) - 1) {
                                        $active = 'active';
                                    } ?>
                                    <tr class="<?= isset($active) ? $active : '' ?>"
                                        onclick="sendActiveProduct(<?= $_SESSION['cart'][$i]['id'] ?>,<?= $i ?>)">
                                        <td id="id" class="col" scope="row"><?= $i + 1 ?></td>
                                        <td id="name" class="col"><?= $_SESSION['cart'][$i]['name'] ?></td>
                                        <td id="price" class="col"><?= $_SESSION['cart'][$i]['price'] ?></td>
                                        <td id="quantity" class="col"><span><?= $_SESSION['cart'][$i]['quantity'] ?></span> шт.
                                        </td>
                                        <td id="sum" class="col" style="font-weight: 600; text-align: right;">
                                            <?= $_SESSION['cart'][$i]['price'] * $_SESSION['cart'][$i]['quantity'] ?></td>
                                    </tr>
                                <?php endfor ?>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>

                <!-- Modal -->
                <?php include "app/include/modal-input-code.php" ?>
                <!-- Modal End-->


                <!-- Content end -->

                <!-- Sidebar start -->
                <div id="sidebar">
                    <div class="sidebar-top">
                        <div class="sidebar-row">
                            <span>Без знижки:</span>
                            <span class="text-end" id="no_discount"><?= isset($_SESSION['total_amount']) ?
                                                                        $_SESSION['total_amount'] : '' ?>
                                грн.</span>
                        </div>
                        <div class="sidebar-row">
                            <span>Знижка:</span>
                            <span class="text-end" id="discount">0,00
                                грн.</span>
                        </div>

                        <hr style="opacity: 0.2;">

                        <div class="sidebar-row top-2">
                            <span>Всього:</span>
                            <span class="text-end"
                                id="total_pay"><?= isset($_SESSION['total_amount']) ? $_SESSION['total_amount'] : '' ?>
                                грн.</span>
                        </div>
                        <div class="sidebar-row top-2">
                            <span>Здача:</span>
                            <span class="text-end" id="rest_money">0,00
                                грн.</span>
                        </div>

                        <hr style="opacity: 0.2;">

                        <div class="sidebar-btns">
                            <button>
                                <span>F7</span>
                                <span>Готівка</span>
                            </button>
                            <button>
                                <span>F6</span>
                                <span>Карта</span>
                            </button>
                        </div>

                        <div class="sidebar-inputs">
                            <div class="sidebar-row">
                                <span>Готівка:</span>
                                <div>
                                    <input type="text" placeholder="5 000,00" value="5 000,00">
                                    <i class="bi bi-trash"></i>
                                </div>
                            </div>
                            <div class="sidebar-row">
                                <span>Карта:</span>
                                <div>
                                    <input type="text" placeholder="18 648,00" value="18 648,00">
                                    <i class="bi bi-trash"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="sidebar-bottom">
                        <div class="sidebar-checkout-btns">
                            <div class="sidebar-user-btn">
                                <i class="bi bi-person-fill"></i>
                                <div class="sidebar-user-check-btn">
                                    <i class="bi bi-check"></i>
                                    <span></span>
                                </div>
                            </div>
                            <button>
                                Отримати чек
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Sidebar end -->
            </div>
        </div>
        <span id="result1"></span>
        <!--  -->


        <!-- CUSTOM SCRIPT -->
        <script src="./assets/js/main.js"></script>
</body>

</html>