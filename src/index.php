<?php
include $_SERVER['DOCUMENT_ROOT'] . "/app/controllers/auth.php";
?>
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
    <?php
    include $_SERVER['DOCUMENT_ROOT'] . "/app/include/modal-input-barcode.php";
include $_SERVER['DOCUMENT_ROOT'] . "/app/include/modal-discont.php";
// include $_SERVER['DOCUMENT_ROOT'] . "/app/include/modal-catalog.php";
// include $_SERVER['DOCUMENT_ROOT'] . "/app/include/modal-list-checks.php";
// include $_SERVER['DOCUMENT_ROOT'] . "/app/include/modal-list-defferedChecks.php";
?>
    <?php if (empty($_SESSION['work_shift'])): ?>
        <form action="index.php" method="POST">
            <input type="text" name="username" placeholder="Ваш Логін" class="form-control">
            <button type="submit">Авторизуватись</button>
        </form>
    <?php endif; ?>
    <div id="result"></div>


    <!-- CUSTOM SCRIPT -->
    <script src="./assets/js/main.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#phoneForDiscont").inputmask("+38(999)-999-99-99"); // Устанавливаем маску ввода
        });
    </script>
    <?php if (isset($_SESSION['work_shift'])): ?>
        <script>
            sendData();
            let modal_barcode = document.getElementById("modalBarcode");
            if (modal_barcode) {
                modal_barcode.addEventListener("shown.bs.modal", function() {
                    let barcode = document.getElementById("barcode");
                    if (barcode) {
                        barcode.focus();
                    }
                });
            }
            let modal_discount = document.getElementById("modalDiscont");
            if (modal_discount) {
                modal_discount.addEventListener("shown.bs.modal", function() {
                    let discount = document.getElementById("phoneForDiscont");
                    if (discount) {
                        discount.focus();
                    }
                });
            }
        </script>
    <?php endif; ?>
</body>


</html>