<?php
include $_SERVER["DOCUMENT_ROOT"] . "/app/database/db.php";
if (isset($_POST['id_bas'])) {
    $catalog = selectAllProducts($_SESSION['work_shift']['price_type_id_bas'], [
        'is_group' => 0,
        'parent_id_bas' => $_POST['id_bas']
    ]);
} else {
    $catalog = selectAllProducts($_SESSION['work_shift']['price_type_id_bas'], ['is_group' => 0]);
    //tt($catalog);
}
//tt($catalog);
//tt($_SESSION);
?>

<?php if (isset($catalog)): ?>
    <?php for ($i = 0; $i < count($catalog); $i++): ?>
        <tr>
            <td><?= $catalog[$i]['articul'] ?></td>
            <td><?= $catalog[$i]['name'] ?></td>
            <td>
                <?= $catalog[$i]['price']
        ?> грн.
            </td>
            <td> відкрити </td>
        </tr>
    <?php endfor; ?>
<?php endif; ?>