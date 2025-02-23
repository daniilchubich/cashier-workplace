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

<div class="catalog-modal modal fade" id="exampleModalCatalog" tabindex="-1" aria-labelledby="exampleModalLabelCatalog"
    aria-hidden="true">
    <div class="modal-dialog catalog-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabelCatalog">
                    Каталог
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <?php include $_SERVER['DOCUMENT_ROOT'] . "/app/models/catalog.php"
                ?>
                <!-- <div class="wrapper">
                    Navbar start
                    <?php //include $_SERVER['DOCUMENT_ROOT'] . "/cashier-workplace-master/src" . "/app/include/navbar.php"
                ?>
                    
                    Navbar end

                    Modal
                    <?php //include $_SERVER['DOCUMENT_ROOT'] . "/app/include/modal-input-barcode.php";
                ?>

                    <div class="content">
                        <div class="search-box">
                            <input type="text" placeholder="Search" class="form-control">
                        </div>
                        <div class="catalog">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col" class="col">Артикул</th>
                                        <th scope="col" class="col">Назва</th>
                                        <th scope="col" class="col">Категорія</th>
                                        <th scope="col" class="col">Характеристика</th>
                                        <th scope="col" class="col">Вартість</th>
                                    </tr>
                                </thead>
                                <tbody id="catalogRows">
                                    <tr>
                                        <td>ASD123</td>
                                        <td>Кофе</td>
                                        <td>Напій</td>
                                        <td>Мелена кава</td>
                                        <td>120 грн.</td>
                                    </tr>
                                    <tr>
                                        <td>ASD123</td>
                                        <td>Кофе</td>
                                        <td>Напій</td>
                                        <td>Мелена кава</td>
                                        <td>120 грн.</td>
                                    </tr>
                                    <tr>
                                        <td>ASD123</td>
                                        <td>Кофе</td>
                                        <td>Напій</td>
                                        <td>Мелена кава</td>
                                        <td>120 грн.</td>
                                    </tr>
                                    <tr>
                                        <td>ASD123</td>
                                        <td>Кофе</td>
                                        <td>Напій</td>
                                        <td>Мелена кава</td>
                                        <td>120 грн.</td>
                                    </tr>
                                    <tr>
                                        <td>ASD123</td>
                                        <td>Кофе</td>
                                        <td>Напій</td>
                                        <td>Мелена кава</td>
                                        <td>120 грн.</td>
                                    </tr>
                                    <tr>
                                        <td>ASD123</td>
                                        <td>Кофе</td>
                                        <td>Напій</td>
                                        <td>Мелена кава</td>
                                        <td>120 грн.</td>
                                    </tr>
                                    <tr>
                                        <td>ASD123</td>
                                        <td>Кофе</td>
                                        <td>Напій</td>
                                        <td>Мелена кава</td>
                                        <td>120 грн.</td>
                                    </tr>
                                    <tr>
                                        <td>ASD123</td>
                                        <td>Кофе</td>
                                        <td>Напій</td>
                                        <td>Мелена кава</td>
                                        <td>120 грн.</td>
                                    </tr>
                                    <tr>
                                        <td>ASD123</td>
                                        <td>Кофе</td>
                                        <td>Напій</td>
                                        <td>Мелена кава</td>
                                        <td>120 грн.</td>
                                    </tr>
                                    <tr>
                                        <td>ASD123</td>
                                        <td>Кофе</td>
                                        <td>Напій</td>
                                        <td>Мелена кава</td>
                                        <td>120 грн.</td>
                                    </tr>
                                    <tr>
                                        <td>ASD123</td>
                                        <td>Кофе</td>
                                        <td>Напій</td>
                                        <td>Мелена кава</td>
                                        <td>120 грн.</td>
                                    </tr>
                                    <tr>
                                        <td>ASD123</td>
                                        <td>Кофе</td>
                                        <td>Напій</td>
                                        <td>Мелена кава</td>
                                        <td>120 грн.</td>
                                    </tr>
                                    <tr>
                                        <td>ASD123</td>
                                        <td>Кофе</td>
                                        <td>Напій</td>
                                        <td>Мелена кава</td>
                                        <td>120 грн.</td>
                                    </tr>
                                    <tr>
                                        <td>ASD123</td>
                                        <td>Кофе</td>
                                        <td>Напій</td>
                                        <td>Мелена кава</td>
                                        <td>120 грн.</td>
                                    </tr>
                                    <tr>
                                        <td>ASD123</td>
                                        <td>Кофе</td>
                                        <td>Напій</td>
                                        <td>Мелена кава</td>
                                        <td>120 грн.</td>
                                    </tr>
                                    <tr>
                                        <td>ASD123</td>
                                        <td>Кофе</td>
                                        <td>Напій</td>
                                        <td>Мелена кава</td>
                                        <td>120 грн.</td>
                                    </tr>
                                    <tr>
                                        <td>ASD123</td>
                                        <td>Кофе</td>
                                        <td>Напій</td>
                                        <td>Мелена кава</td>
                                        <td>120 грн.</td>
                                    </tr>
                                    <tr>
                                        <td>ASD123</td>
                                        <td>Кофе</td>
                                        <td>Напій</td>
                                        <td>Мелена кава</td>
                                        <td>120 грн.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div> -->
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