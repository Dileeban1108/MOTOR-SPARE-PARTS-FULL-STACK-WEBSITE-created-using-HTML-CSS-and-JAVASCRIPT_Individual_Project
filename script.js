let menu = document.querySelector('#menu-bar');
let navbar = document.querySelector('.navbar');
menu.onclick = () => {
    menu.classList.toggle('fa-times');
    navbar.classList.toggle('active');
};

let sub2=document.getElementById('subMenu2');
function toggleMenu() {
    sub2.style.display='initial';
}

// Additional functions and code here
let sub = document.getElementById('subMenu3');

function openMenu() {
    sub.style.display = 'initial';
}

function cancelMenu() {
    sub.style.display = 'none';
}
function closeSubMenu(){
    sub2.style.display = 'none';
}
