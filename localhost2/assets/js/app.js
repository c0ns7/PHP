function toggleMenu() {
  var burger = document.querySelector('.burger');
  var menuList = document.querySelector('.menu-list');

  burger.addEventListener('click', function(e) {
    e.stopPropagation(); // блокируем всплытие события клика на .burger
    menuList.classList.toggle('active');
  });

  document.addEventListener('click', function(e) {
    if (menuList.classList.contains('active') && !menuList.contains(e.target) && !burger.contains(e.target)) {
      menuList.classList.remove('active');
    }
  });
}

toggleMenu();