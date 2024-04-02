function toggleFullScreen(element) {
  element.classList.toggle('full-screen');
}

document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('contactForm');
  const emailInput = document.getElementById('email');
  const consentCheckbox = document.getElementById('consent');

  form.addEventListener('submit', function(event) {
    let isValid = true;

    // Проверка электронной почты
    if (!validateEmail(emailInput.value)) {
      isValid = false;
      alert('Please enter a correct E-mail!');
    }

    // Проверка чекбокса согласия
    if (!consentCheckbox.checked) {
      isValid = false;
      alert('Пожалуйста, отметьте согласие с обработкой персональных данных!');
    }

    if (!isValid) {
      event.preventDefault(); // Предотвратить отправку формы, если есть ошибки
    } 
  });

  // Функция проверки электронной почты
  function validateEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
  }
});
