function allRows() {
  const allRowsTbody = document.querySelector("tbody"); // Получаем актуальные строки
  console.log(allRowsTbody);
  const allRows = allRowsTbody.querySelectorAll("tr");
  let totalSum = 0; // Обнуляем сумму при каждом вызове функции

  allRows.forEach((row) => {
    const sumElement = row.querySelector("#sum"); // Ищем элемент с id="sum" внутри строки
    if (sumElement) {
      const value = parseFloat(sumElement.textContent); // Преобразуем текст в число
      if (!isNaN(value)) {
        console.log(value);
        totalSum += value; // Добавляем значение к общей сумме
      }
    }
  });

  console.log("Общая сумма:", totalSum);
  document.getElementById("no_discount").textContent = totalSum.toFixed(2);
  document.getElementById("total_pay").textContent = totalSum.toFixed(2);
}

function getBarcodeInput() {
  const barcodeInput = document.getElementById("barcode");
  const valueBarcodeInput = barcodeInput.value;
  barcodeInput.value = "";
  sendData({
    barcode: valueBarcodeInput,
  });
}

function getPhoneForDiscont() {
  const barcodeInput = document.getElementById("phoneForDiscont");
  const valueBarcodeInput = barcodeInput.value;
  barcodeInput.value = "";
  sendData({
    phoneForDiscont: valueBarcodeInput,
  });
}

document.addEventListener("DOMContentLoaded", () => {
  const barcodeInput = document.getElementById("barcode");

  //console.log(valueBarcodeInput);
  // Событие Enter
  const enterEvent = new KeyboardEvent("keydown", {
    key: "Enter",
    keyCode: 13, // Код клавиши Enter
    code: "Enter",
    which: 13,
    bubbles: true, // Важно для передачи события
  });

  let barcodeData = ""; // Для накопления данных
  let timer;

  // Глобальный обработчик события `keydown`
  document.addEventListener("keydown", (event) => {
    clearTimeout(timer); // Сбрасываем таймер

    // Проверяем, что это обычный символ (не управляющая клавиша)
    if (event.key.length === 1) {
      barcodeData += event.key; // Добавляем символ в строку
    }

    // Если сканер завершил ввод (Enter)
    if (event.key === "Enter") {
      event.preventDefault(); // Останавливаем стандартное поведение

      if (barcodeData.trim()) {
        // Если данные не пусты, помещаем их в input
        //barcodeInput.value = barcodeData;
        sendData({
          barcode: barcodeData,
        });
        allRows();
        console.log(`Получены данные: ${barcodeData}`);

        //barcodeForm.submit();
      }

      // Сбрасываем данные
      barcodeData = "";
    }

    // Таймер сброса данных при отсутствии активности
    timer = setTimeout(() => {
      barcodeData = ""; // Очищаем строку, если прошло больше 500 мс
    }, 1000);
  });
});

function sendActiveProduct(string_id) {
  //document.getElementById("index").style.display = "none";
  //document.getElementById("content-single").style.display = "none";
  // document.getElementById("result1").innerHTML = "";
  var xhr = new XMLHttpRequest();
  //var url = "app/include/active-product.php"; // Замените на ваш серверный скрипт
  var url = "app/models/check.php";
  xhr.open("POST", url, true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  //console.log(url);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      // Обработка ответа от сервера
      document.getElementById("result").innerHTML = xhr.responseText;
    }
  };

  // Подготовка данных для отправки

  var data = `string_id=${encodeURIComponent(string_id)}`; // Подставьте свои данные
  console.log(data);
  xhr.send(data);
  //allRows();
}

function updateProduct(string_id, quantity, sum, id_active_product) {
  var xhr = new XMLHttpRequest();
  var url = "app/models/check.php"; // Замените на ваш серверный скрипт
  xhr.open("POST", url, true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  //console.log(url);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      // Обработка ответа от сервера
      document.getElementById("result").innerHTML = xhr.responseText;
    }
  };

  // Подготовка данных для отправки

  var data = `id_active_product=${encodeURIComponent(
    id_active_product
  )}&sum=${encodeURIComponent(sum)}&quantity=${encodeURIComponent(
    quantity
  )}&string_id=${encodeURIComponent(string_id)}&`; // Подставьте свои данные
  console.log(data);
  xhr.send(data);
}

function adjustCounter(operator, product_id) {
  const inputField = document.querySelector(".weight input");
  const activProductTr = document.querySelector("tr.active");

  if (activProductTr) {
    const idElement = activProductTr.querySelector("#id");
    console.log(idElement);
    const idValue = parseFloat(idElement.textContent.trim());
    const priceElement = activProductTr.querySelector("#price");
    const priceValue = parseFloat(priceElement.textContent.trim());
    const quantityElement = activProductTr.querySelector("#quantity span");
    const sumElement = activProductTr.querySelector("#sum");

    if (operator == "minus") {
      let currentValue = parseFloat(quantityElement.textContent.trim());
      if (currentValue > 0) {
        currentValue--;
        inputField.value = currentValue.toLocaleString("en-US");
        quantityElement.textContent = currentValue.toFixed(2);
        let sum = priceValue * currentValue;
        sumElement.textContent = sum.toFixed(2);
        updateProduct(idValue - 1, currentValue, sum, product_id);
        allRows();
      }
    }
    if (operator == "plus") {
      let currentValue = parseFloat(quantityElement.textContent.trim());
      currentValue++;
      inputField.value = currentValue.toLocaleString("en-US");
      quantityElement.textContent = currentValue.toFixed(2);
      let sum = priceValue * currentValue;
      sumElement.textContent = sum.toFixed(2);
      updateProduct(idValue - 1, currentValue, sum, product_id);
      allRows();
    }
    if (operator == "input") {
      let quantyti = inputField.value;
      let sum = priceValue * quantyti;
      updateProduct(idValue - 1, quantyti, sum, product_id);
      allRows();
    }
  }
}
function sendData(params) {
  var xhr = new XMLHttpRequest();
  let data = new URLSearchParams(params).toString();
  var url = "app/models/check.php";

  xhr.open("POST", url, true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      // Обработка ответа от сервера
      document.getElementById("result").innerHTML = xhr.responseText;
    }
  };

  // Подготовка данных для отправки
  console.log(data);
  xhr.send(data);
}

// function sendData(params) {
//   var xhr = new XMLHttpRequest();
//   let data = new URLSearchParams(params).toString();
//   var url = "app/models/check.php";

//   xhr.open("POST", url, true);
//   xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

//   xhr.onreadystatechange = function () {
//     if (xhr.readyState === 4 && xhr.status === 200) {
//       // Обработка ответа от сервера
//       document.getElementById("result").innerHTML = xhr.responseText;
//     }
//   };

//   // Подготовка данных для отправки
//   console.log(data);
//   xhr.send(data);
// }
//alert(Корзіна пустая);
function openCatalog() {
  var xhr = new XMLHttpRequest();
  var url = "app/models/catalog.php";
  xhr.open("POST", url, true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  //console.log(url);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      // Обработка ответа от сервера
      document.getElementById("result").innerHTML = xhr.responseText;
    }
  };

  // Подготовка данных для отправки

  //var data = `string_id=${encodeURIComponent(string_id)}`; // Подставьте свои данные
  //console.log(data);
  xhr.send();
  //allRows();
}

function checkAction(check_status) {
  var xhr = new XMLHttpRequest();

  var url = "app/models/check.php";
  xhr.open("POST", url, true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      // Обработка ответа от сервера
      document.getElementById("result").innerHTML = xhr.responseText;
    }
  };

  // Подготовка данных для отправки
  var data = `check_action=1&${check_status}=1`; // Подставьте свои данные
  xhr.send(data);
}
