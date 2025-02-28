<?php
//$_SESSION['check_list'] = selectAllCheck();
//$_SESSION['check_list'] = selectAllCheck('', $offset);
?>
<style>
    .catalog-modal .modal-dialog {
        max-width: 80%;
    }

    .catalog-modal .search-box {
        margin: 20px 0;
    }

    .catalog-modal .catalog {
        height: 60vh;
        max-height: 60vh;
        overflow-y: scroll;
    }

    .catalog-modal .catalog thead {
        position: sticky;
        top: 0;
    }
</style>

<div class="catalog-modal modal fade" id="ModalChecks" tabindex="-1" aria-labelledby="ModalLabelChecks"
    aria-hidden="true">
    <div class="modal-dialog catalog-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="ModalLabelChecks">
                    Список Чеків
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
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
                                        <th scope="col" class="col">Статус Чека </th>
                                        <th scope="col" class="col">Сума</th>
                                    </tr>
                                </thead>
                                <tbody id="catalogRows">
                                    <?php if (isset($_SESSION['check_list'])): ?>
                                        <?php for ($i = 0; $i < count($_SESSION['check_list']); $i++):  ?>
                                            <tr>
                                                <td><?= $_SESSION['check_list'][$i]['cheсk_number'] ?></td>
                                                <td><?= substr($_SESSION['check_list'][$i]['cheсk_data'], 11) ?></td>
                                                <td><?= isset($_SESSION['check_list'][$i]['phone_number']) ? '+380' . $_SESSION['check_list'][$i]['phone_number'] : '' ?>
                                                </td>
                                                <td><?= $_SESSION['check_list'][$i]['name'] ?></td>
                                                <td><?= $_SESSION['check_list'][$i]['check_status_id'] == 1 ? 'Відкладений' :  'Пробитий' ?>
                                                </td>
                                                <td><?= $_SESSION['check_list'][$i]['doc_sum'] ?> грн.</td>
                                            </tr>
                                        <?php endfor; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- <div class="pagination">
                        <button id="prevPage" class="btn btn-secondary">← Назад</button>
                        <span id="currentPage">1</span>
                        <button id="nextPage" class="btn btn-secondary">Вперед →</button>
                    </div> -->
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <div class="col-3">К-во Сторінок:<span id="quantityPagesListChecks"></span></div>
                <div class="pagination col-5 justify-content-center">
                    <button id="prevPage" class="btn btn-secondary">← Назад</button>
                    <input type="text" id="currentPage" placeholder="1" onclick="this.select()"
                        value="<?= isset($page) ? $page : 1 ?>">
                    <button id="nextPage" class="btn btn-secondary">Вперед →</button>
                </div>
                <div class="col-3 d-flex justify-content-end" id="errorLoadPage"></div>
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


    });
</script>