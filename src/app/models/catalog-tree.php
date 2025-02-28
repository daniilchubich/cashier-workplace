<?php

include $_SERVER["DOCUMENT_ROOT"] . "/app/database/db.php";
//$test = "123";
// Проверка входных данных
//unset($_SESSION['catalog_tree']);
if (isset($_POST['id_bas']) && isset($_POST['level']) && $_POST['level'] >= 0) {
    $nextLevel = $_POST['level'] + 1;
    $_SESSION['catalog_tree'][$nextLevel] = selectAll('ref_products', [
        'is_group' => 1,
        'level' => $nextLevel,
        'parent_id_bas' => $_POST['id_bas']
    ]);
} else {
    unset($_SESSION['catalog_tree']);
    $_SESSION['catalog_tree'][0] = selectAll('ref_products', ['is_group' => 1, 'level' => 0]);
    //$_SESSION['catalog'][0] = selectAll('ref_products', ['is_group' => 0]);
}

function renderCatalog($level = 0, $parentId = null)
{
    if (empty($_SESSION['catalog_tree'][$level])) {
        return;
    }
    echo "<ul>";

    foreach ($_SESSION['catalog_tree'][$level] as $category) {
        if ($parentId !== null && $category['parent_id_bas'] != $parentId) {
            continue;
        }
        echo "<li style='font-size: small;' onclick=\"openCatalog('{$category['id_bas']}', {$category['level']})\">";
        echo htmlspecialchars($category['name']);
        echo "</li>";

        // Рекурсивный вызов для вложенных уровней
        renderCatalog($level + 1, $category['id_bas']);
    }

    echo "</ul>";
}

if (!empty($_SESSION['catalog_tree'])) {
    renderCatalog();
}
