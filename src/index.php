<?php
$isConditionMet = true;
$users = 'Log';
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
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/app/include/modal-input-barcode.php";
    ?>
    <div id="result"></div>


    <!-- CUSTOM SCRIPT -->
    <script src="./assets/js/main.js"></script>
    <?php if ($isConditionMet): ?>
        <script>
            sendData({
                users: "<?= addslashes($users) ?>"
            });
        </script>
    <?php endif; ?>
</body>


</html>