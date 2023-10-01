document.addEventListener('DOMContentLoaded', () => {

    const followCursor = () => { // объявляем функцию followCursor
      const el = document.querySelector('.follow-cursor') // ищем элемент, который будет следовать за курсором
  
      window.addEventListener('mousemove', e => { // при движении курсора
        const target = e.target // определяем, где находится курсор
        if (!target) return
  
        if (target.closest('a') || target.closest('button') || target.closest('input')) { // если курсор наведён на ссылку
          el.classList.add('follow-cursor_active') // элементу добавляем активный класс
        } else { // иначе
          el.classList.remove('follow-cursor_active') // удаляем активный класс
        }
  
        el.style.left = e.pageX + 'px' // задаём элементу позиционирование слева
        el.style.top = e.pageY + 'px' // задаём элементу позиционирование сверху
      })
    }
  
    followCursor() // вызываем функцию followCursor
  
})

document.addEventListener("mousemove", function(event) {
    var followCursor = document.querySelector(".follow-cursor");
    followCursor.style.display = "block"; // Показываем блок при появлении курсора
    followCursor.style.left = event.clientX + "px"; // Устанавливаем позицию блока по горизонтали
    followCursor.style.top = event.clientY + "px"; // Устанавливаем позицию блока по вертикали
});
  