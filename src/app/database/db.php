<?php

session_start();
require_once('connect.php');
global $pdo;
if (empty($pdo)) {
    //die('Error');
}
function tt($value)
{
    echo '<pre>';
    print_r($value);
    echo '</pre>';
    //exit();
}
function dbCheckError($query)
{
    $errInfo = $query->errorInfo();
    if ($errInfo[0] !== PDO::ERR_NONE) {
        echo $errInfo[2];
        exit();
    }
    return true;
}

function updateOrAddSessionCart($array, $product)
{
    for ($i = 0; $i <= count($array); $i++) {

        if (isset($array[$i]['product_id_bas']) && $array[$i]['product_id_bas'] === $product['product_id_bas']) {

            $_SESSION['cart'][$i]['quantity']++;
            //$string_id = count($_SESSION['cart']) - 1;
            return $i;
        }
    }
    $_SESSION['cart'][] = $product; // Если не найден, добавляем новый элемент
    return count($_SESSION['cart']) - 1;
}

function countStringInTable($table)
{
    global $pdo;

    $stmt = $pdo->query("SELECT COUNT(*) FROM $table");
    $count = $stmt->fetchColumn();
    return $count;
}
function selectAll($table, $params = [])
{
    global $pdo;

    $sql = "SELECT * FROM $table";
    if (!empty($params)) {
        $i = 0;
        foreach ($params as $key => $value) {
            if (!is_numeric($value)) {
                $value = "'" . $value . "'";
            }
            if ($i === 0) {
                $sql = $sql . " WHERE $key=$value";
            } else {
                $sql = $sql . " AND  $key=$value";
            }
            $i++;
        }
    }
    $sql .= " ORDER BY is_group DESC, name ASC";
    $query = $pdo->prepare($sql);
    $query->execute();

    dbCheckError($query);

    return $query->fetchAll();
}


function selectOne($table, $params = [])
{
    global $pdo;
    $sql = "SELECT * FROM $table";
    if (!empty($params)) {
        $i = 0;
        foreach ($params as $key => $value) {
            if (!is_numeric($value)) {
                $value = "'" . $value . "'";
            }
            if ($i === 0) {
                $sql = $sql . " WHERE $key=$value";
            } else {
                $sql = $sql . " AND  $key=$value";
            }
            $i++;
        }
    }
    $query = $pdo->prepare($sql);
    $query->execute();

    dbCheckError($query);

    return $query->fetch();
}
function insert($table, $params)
{
    global $pdo;

    $i = 0;
    $coll = '';
    $mask = '';
    $update = '';
    foreach ($params as $key => $value) {
        if ($i === 0) {
            $coll = "$key";
            $mask = "'$value'";
            $update = "$key = '$value'";
        } else {
            $coll .= ", $key";
            $mask .= ", '$value'";
            $update .= ", $key = '$value'";
        }
        $i++;
    }

    $sql = "INSERT INTO $table ($coll) VALUES ($mask) ON DUPLICATE KEY UPDATE $update";

    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);

    return $pdo->lastInsertId();
}



function update($table, $id, $params)
{
    global $pdo;

    $i = 0;
    $str = '';
    foreach ($params as $key => $value) {
        if ($i === 0) {
            $str = $str . $key . " = '" . $value . "'";
        } else {
            $str = $str . ', ' . $key . " = '" . $value . "'";
        }


        $i++;
    }

    $sql = "UPDATE  $table SET $str WHERE id = $id";

    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
}

function delete($table, $id)
{
    global $pdo;

    $sql = "DELETE FROM $table WHERE id = $id";

    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
}

function selectAllCheck($limit, $offset, $params = [])
{
    global $pdo;

    $sql = "SELECT check_main.*, shop.name, discount.phone_number, discount.first_name, discount.second_name  
    FROM doc_check_main AS check_main 
    JOIN ref_shops AS shop ON check_main.shop_id_bas = shop.id_bas
    JOIN ref_check_statuses AS check_status ON check_main.check_status_id = check_status.id  
    LEFT JOIN ref_discounts AS discount ON check_main.discount_id_bas = discount.id_bas
    ";


    if (!empty($params)) {
        $i = 0;
        foreach ($params as $key => $value) {
            if (!is_numeric($value)) {
                $value = "'" . $value . "'";
            }
            if ($i === 0) {
                $sql = $sql . " WHERE check_main.$key=$value";
            } else {
                $sql = $sql . " AND check_main.$key=$value";
            }
            $i++;
        }
    }
    $sql .= " ORDER BY check_main.id DESC LIMIT $limit OFFSET $offset";
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetchAll();
}

function selectAllCheckProducts($id)
{
    global $pdo;

    $sql = "SELECT check_product.*, products.name FROM doc_check_products AS check_product JOIN ref_products AS products ON check_product.product_id_bas = products.id_bas WHERE check_product.check_id=$id";
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetchAll();
}
function selectAllProducts($price_type_id, $params = [])
{
    global $pdo;

    $sql = "SELECT product.*, price.price
    FROM ref_products AS product
    JOIN info_prices AS price ON product.id_bas = price.product_id_bas
    WHERE price.price_type_id_bas = '$price_type_id'
    ";



    if (!empty($params)) {
        $i = 0;
        foreach ($params as $key => $value) {
            if (!is_numeric($value)) {
                $value = "'" . $value . "'";
            }
            if ($i === 0) {
                $sql = $sql . " AND product.$key=$value";
            } else {
                $sql = $sql . " AND product.$key=$value";
            }
            $i++;
        }
    }
    $sql .= " ORDER BY product.name ASC";
    //tt($sql);
    //die();
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetchAll();
}
function selectAllFromPostsWithUsers($table1, $table2)
{
    global $pdo;
    $sql = "SELECT 
    t1.id,
    t1.title,
    t1.img,
    t1.content,
    t1.status,
    t1.id_topic,
    t1.created,
    t2.username
    FROM $table1 AS t1 JOIN $table2 AS t2 ON t1.id_user = t2.id";
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetchAll();
}

function selectAllFromPostsWithUsersOnIndex($table1, $table2, $limit, $offset)
{
    global $pdo;
    $sql = "SELECT p.*, u.username FROM $table1 AS p JOIN $table2 AS u ON p.id_user = u.id WHERE p.status=1 LIMIT $limit OFFSET $offset";
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetchAll();
}


function selectTopTopicFromPostsOnIndex($table1)
{
    global $pdo;
    $sql = "SELECT * FROM $table1 WHERE id_topic = 6";
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetchAll();
}

function seacrhInTitileAndContent($text, $table1, $table2)
{
    $text = trim(strip_tags(stripcslashes(htmlspecialchars($text))));

    global $pdo;
    $sql = "SELECT p.*, u.username 
    FROM $table1 AS p 
    JOIN $table2 AS u 
    ON p.id_user = u.id 
    WHERE p.status=1
    AND p.title LIKE '%$text%' OR p.content LIKE '%$text%'";
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetchAll();
}

function selectPostFromPostsWithUsersOnSingle($table1, $table2, $id)
{
    global $pdo;
    $sql = "SELECT p.*, u.username FROM $table1 AS p JOIN $table2 AS u ON p.id_user = u.id WHERE p.id=$id";
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetch();
}
function selectAllFromPostsWithUsersOnCategory($table1, $table2, $id_topic)
{
    global $pdo;
    $sql = "SELECT p.*, u.username FROM $table1 AS p JOIN $table2 AS u ON p.id_user = u.id WHERE p.status=1 AND p.id_topic = $id_topic";
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetchAll();
}


function countRow($table)
{
    global $pdo;
    $sql = "SELECT Count(*) FROM $table WHERE status = 1";
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetchColumn();
}
function selectAllFromCommentsWithUsers($table1, $table2, $params = [])
{
    global $pdo;
    if ($table2 !== null) {
        $sql = "SELECT t1.*, t2.username FROM $table1 AS t1 JOIN $table2 AS t2 ON t1.id_users = t2.id";
        if (!empty($params)) {
            $i = 0;
            foreach ($params as $key => $value) {
                if (!is_numeric($value)) {
                    $value = "'" . $value . "'";
                }
                if ($i === 0) {
                    $sql = $sql . " WHERE t1.$key=$value";
                } else {
                    $sql = $sql . " AND t1.$key=$value";
                }
                $i++;
            }
        }
    } else {
        $sql = "SELECT * FROM $table1";
        if (!empty($params)) {
            $i = 0;
            foreach ($params as $key => $value) {
                if (!is_numeric($value)) {
                    $value = "'" . $value . "'";
                }
                if ($i === 0) {
                    $sql = $sql . " WHERE $key=$value";
                } else {
                    $sql = $sql . " AND $key=$value";
                }
                $i++;
            }
        }
    }
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetchAll();
}
function selectAllFromCommentsWithUsersOnAdmin($table1, $table2, $table3, $params)
{
    global $pdo;

    $sql = "SELECT c.*, u.username, p.title 
    FROM $table1 AS c 
    JOIN $table2 AS u ON c.id_users = u.id 
    JOIN $table3 AS p ON c.id_posts = p.id";
    if (!empty($params)) {
        $i = 0;
        foreach ($params as $key => $value) {
            if (!is_numeric($value)) {
                $value = "'" . $value . "'";
            }
            if ($i === 0) {
                $sql = $sql . " WHERE c.$key=$value";
            } else {
                $sql = $sql . " AND c.$key=$value";
            }
            $i++;
        }
    }

    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetchAll();
}
