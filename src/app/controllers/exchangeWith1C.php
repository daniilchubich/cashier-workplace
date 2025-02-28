<?php

include $_SERVER["DOCUMENT_ROOT"] . "/app/controllers/functions.php";
getAddProducts();
getAddDiscounts();
getAddClassifier();
getAddPrices();
getAddBarcode();
//tt($response->ref_products);

// var_dump(count($response->ref_discounts));
// // for ($i = 0; $i < 1000; $i++) {
// //     if ($response->ref_products[$i]->is_group == 1) {
// //         tt($response->ref_products[$i]);
// //     }
// // }
// tt($response->ref_discounts);
