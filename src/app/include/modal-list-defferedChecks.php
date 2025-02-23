<?php //include $_SERVER["DOCUMENT_ROOT"] . "/app/controllers/check.php";
//$check_deffered = selectAllCheckDeffered(['check_status_id' => 1]);
//tt($_SESSION['check_deffered']);
?>
<style>
.catalog-modal .modal-dialog {
    max-width: 80%;
}

.catalog-modal .search-box {
    margin: 20px 0;
}

.catalog-modal .catalog {
    height: 50vh;
    max-height: 50vh;
    overflow-y: scroll;
}

.catalog-modal .catalog thead {
    position: sticky;
    top: 0;
}
</style>

<div class="catalog-modal modal fade" id="ModalDefferedChecks" tabindex="-1" aria-labelledby="ModalLabelDefferedChecks"
    aria-hidden="true">
    <div class="modal-dialog catalog-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="ModalLabelDefferedChecks">
                    Відкладені чеки
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <?php //include $_SERVER['DOCUMENT_ROOT'] . "/app/models/list-defferedChecks.php"
                ?>
                <div class="wrapper">
                    <div class="content">
                        <!-- <div class="search-box">
                            <input type="text" placeholder="Search" class="form-control">
                        </div> -->
                        <div class="catalog">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col" class="col">Номер чеку</th>
                                        <th scope="col" class="col">Час відкритття</th>
                                        <th scope="col" class="col">Дисконт</th>
                                        <th scope="col" class="col">Магазин</th>
                                        <th scope="col" class="col">Сума</th>
                                        <th scope="col" class="col">
                                            <?= isset($_SESSION['cart']) ? '<span class="alert alert-danger">Вже є відкритий чек</span>' : '' ?>

                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="catalogRows">
                                    <?php if (isset($_SESSION['check_deffered'])): ?>
                                    <?php for ($i = 0; $i < count($_SESSION['check_deffered']); $i++):  ?>
                                    <tr>
                                        <td><?= $_SESSION['check_deffered'][$i]['cheсk_number'] ?></td>
                                        <td><?= substr($_SESSION['check_deffered'][$i]['cheсk_data'], 11) ?></td>
                                        <td><?= isset($_SESSION['check_deffered'][$i]['phone_number']) ? '+380' . $_SESSION['check_deffered'][$i]['phone_number'] : '' ?>
                                        </td>
                                        <td><?= $_SESSION['check_deffered'][$i]['name'] ?></td>
                                        <td><?= $_SESSION['check_deffered'][$i]['doc_sum'] ?> грн.</td>
                                        <td><?php if (empty($_SESSION['cart'])): ?>
                                            <a class="navbar-item nav-link active" href="#" data-bs-dismiss="modal"
                                                aria-label="Close"
                                                onclick="sendData({check_deffered_id: '<?= isset($_SESSION['check_deffered'][$i]['id']) ? addslashes($_SESSION['check_deffered'][$i]['id']) :  null ?>'})()">
                                                <span>Відкрити</span>
                                            </a>

                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endfor; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>

            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Відмінити
                </button> -->
                <!-- <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="getBarcodeInput()">
                        Продовжити
                    </button> -->
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    let tableBody = document.getElementById("catalogRows");
    //console.log(tableBody);

    if (tableBody) {
        let rows = tableBody.querySelectorAll("tr");

        rows.forEach((el, i) => el.addEventListener("click", () => {
            rows.forEach(row => row.classList.remove("active"));
            el.setAttribute("id", `row-${i}`);

            el.classList.add("active");

            el.scrollIntoView({
                behavior: "smooth",
                block: "center"
            });

            if (el.classList.contains("active")) {
                el.setAttribute('tabindex', '-1');
                el.focus();
                el.removeAttribute('tabindex');
            }
        }));



        function autoClickRandomRow() {
            if (rows.length === 0) return;

            let randomIndex = Math.floor(Math.random() * rows.length);
            rows[randomIndex].click();

            //console.log(`Auto-clicked row index: ${randomIndex}`);
        }

        //setInterval(autoClickRandomRow, 2000);
    }

})
</script>