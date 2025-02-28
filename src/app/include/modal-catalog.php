<style>
.catalog-modal .modal-dialog {
    max-width: 90%;
}

.catalog-modal .search-box {
    margin: 10px 0;
}

.catalog-modal .tree {
    display: flex;
    column-gap: 1rem;
    height: 60vh;
    max-height: 60vh;
    /* overflow-y: scroll; */
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

<div class="catalog-modal modal fade" id="ModalCatalog" tabindex="-1" aria-labelledby="exampleModalLabelCatalog"
    aria-hidden="true">
    <div class="modal-dialog catalog-dialog" style="max-width: 95%;">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabelCatalog">
                    Каталог
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="wrapper">
                    <div class="content">
                        <div class="search-box">
                            <input type="text" placeholder="Search" class="form-control">
                        </div>

                        <div style="display: flex; column-gap: 1rem">
                            <div id="catalogTree" class="col-4">1</div>
                            <div class="col-8 catalog">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Артикул</th>
                                            <th>Назва</th>
                                            <th>Вартість</th>
                                            <th> ... </th>
                                        </tr>
                                    </thead>
                                    <tbody id="catalogRows">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
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