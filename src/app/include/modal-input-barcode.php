<form action="" method="POST" id="barcodeForm">
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                        Введіть код самостійно
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" name="barcode" value="" autocomplete="off" placeholder="Ввести код" id="barcode">
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Відмінити
                </button> -->
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="getBarcodeInput()">
                        Продовжити
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>