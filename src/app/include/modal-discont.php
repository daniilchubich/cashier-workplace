<form action="" method="POST" id="barcodeForm">
    <div class="modal fade" id="modalDiscont" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                        Введіть номер телефону клієнта
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="phoneForDiscont" class="form-control" onkeydown="handleEnter(event)">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                        onclick="getPhoneForDiscont()">
                        Продовжити
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
// Функция для обработки нажатия Enter
function handleEnter(event) {
    if (event.keyCode === 13) { // Проверка на Enter (код клавиши 13)
        event.preventDefault(); // Предотвращаем стандартное поведение
        getPhoneForDiscont(); // Вызываем функцию для продолжения (отправка данных)
        $('#modalDiscont').modal('hide'); // Закрытие модалки
    }
}
</script>