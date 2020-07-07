let paymentMethod = document.querySelectorAll('[data-scrut="payment-method"]');
paymentMethod.forEach((doc) => {
  doc.addEventListener('click', (e) => {
    document.querySelectorAll('[class="scrut-paymnet-method-description"]').forEach((item) => {
      item.style.display = 'none';
    });
    let val = e.target.value;
    let desc = document.querySelector(`[data-scrut="payment-method-description-${val}"]`);
    desc.style.display = 'block';
    
  });
})