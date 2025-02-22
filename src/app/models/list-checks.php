<?php //include $_SERVER["DOCUMENT_ROOT"] . "/app/controllers/check.php"; 
tt($_SESSION['check_list']);
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
                        <th scope="col" class="col"> </th>
                    </tr>
                </thead>
                <tbody id="catalogRows">
                    <?php if (isset($_SESSION['check_list'])): ?>
                        <?php for ($i = 0; $i < count($_SESSION['check_list']); $i++):  ?>
                            <tr>
                                <td><?= $_SESSION['check_list'][$i]['cheсk_number'] ?></td>
                                <td><?= substr($_SESSION['check_list'][$i]['cheсk_data'], 11) ?></td>
                                <td>+380<?= $_SESSION['check_list'][$i]['phone_number'] ?></td>
                                <td><?= $_SESSION['check_list'][$i]['name'] ?></td>
                                <td><?= $_SESSION['check_list'][$i]['doc_sum'] ?> грн.</td>
                                <td>
                                    <a class="navbar-item nav-link active" href="#" data-bs-dismiss="modal" aria-label="Close"
                                        onclick="sendData({check_deffered_id: '<?= isset($_SESSION['check_list'][$i]['id']) ? addslashes($_SESSION['check_deffered'][$i]['id']) :  null ?>'})()">
                                        <span>Відкрити</span>
                                    </a>
                                </td>
                            </tr>
                        <?php endfor; ?>
                    <?php endif; ?>
                </tbody>
            </table>
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