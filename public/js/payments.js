updateTotalReceiptAmount();
let fees = document.querySelectorAll('.fees');

fees.forEach(function (fee) {
  fee.addEventListener('change', function () {
    updateTotalReceiptAmount();
  });
});

function updateTotalReceiptAmount() {
  let displayTotalReceiptAmount = document.getElementById(
    'displayTotalReceiptAmount'
  );

  let totalReceiptAmount = 0;

  let fees = document.querySelectorAll('.fees');

  fees.forEach(function (fee) {
    totalReceiptAmount += parseFloat(fee.value);
  });

  displayTotalReceiptAmount.value = parseFloat(totalReceiptAmount);

  checkIfReceiptAmountIsCorrect(parseFloat(totalReceiptAmount));

  let receiptAmount = document.getElementById('receipt_amount');

  receiptAmount.addEventListener('change', function () {
    checkIfReceiptAmountIsCorrect(parseFloat(totalReceiptAmount));
  });
}

function checkIfReceiptAmountIsCorrect(displayTotalReceiptAmount) {
  let receiptAmount = parseFloat(
    document.getElementById('receipt_amount').value
  );

  let errorMessage = document.getElementById('error-message');

  let disableSubmitBtn = false;

  if (displayTotalReceiptAmount != receiptAmount) {
    disableSubmitBtn = true;
    errorMessage.classList.remove('d-none');
  } else {
    disableSubmitBtn = false;
    errorMessage.classList.add('d-none');
  }

  disableEnableSubmitBtn(disableSubmitBtn);
}

function disableEnableSubmitBtn(disableSubmitBtn) {
  const submitButton = document.getElementById('submit-btn');
  console.log(disableSubmitBtn);
  if (disableSubmitBtn) {
    submitButton.disabled = true;
  } else {
    submitButton.disabled = false;
  }
}
