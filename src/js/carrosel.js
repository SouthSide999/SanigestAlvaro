document.addEventListener("DOMContentLoaded", function () {
let next = document.querySelector('.nextCarrusel');
let prev = document.querySelector('.prevCarrusel');

next.addEventListener('click', function() {
    let items = document.querySelectorAll('.item');
    document.querySelector('.slide').appendChild(items[0]);
})

prev.addEventListener('click', function() {
    let items = document.querySelectorAll('.item');
    document.querySelector('.slide').prepend(items[items.length - 1]);
})
})

