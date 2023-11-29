let menu=document.querySelector('#menu-bar');
let navbar=document.querySelector('.navbar');
menu.onclick = () =>{
    menu.classList.toggle('fa-times');
    navbar.classList.toggle('active');
}
window.onscroll = () =>{
    menu.classList.remove('fa-times');
    navbar.classList.remove('active');

    if(window.scrollY > 60){
        document.querySelector('#scroll-top').classList.add('active');
    }else{
        document.querySelector('#scroll-top').classList.remove('active');
    }
} 
function loader(){
    document.querySelector('.loader-container').classList.add('fade-out');
}
function fadeout(){
    setInterval(loader, 1000);
}
window.onload=fadeout();

document.addEventListener('DOMContentLoaded',function(){
    const subtitles =document.querySelectorAll('.speaciality .box-container .box');
    
    subtitles.forEach((subtitle,index) =>{
        const delay = index*4000;

        setTimeout(()=>{
            subtitle.style.animationDelay=`${delay}ms`;
            subtitle.style.animationDuration='3s';
            subtitle.style.animationName='movesubtitle';
        })
    })
})

let currentIndex=0;

   const carousel =document.getElementById('box-container');
   const items =document.querySelectorAll('.speaciality .box-container .box')



   function nextSlide(){
    currentIndex= (currentIndex-1+items.length)%items.length; 
    const newTransformvalue= -currentIndex*1000+'%';
    items[currentIndex].style.transform='translatex(' +newTransformvalue+')';
    items[!(currentIndex+1)].style.diplay='none';
    items[currentIndex+1].style.transform='translatex(' +newTransformvalue+')';
    const subtitles =document.querySelectorAll('.speaciality .box-container .box');
    subtitles.style.animationName ='none';
   }
   function preSlide(){
    currentIndex= (currentIndex+1)%items.length;
    const newTransformvalue= currentIndex*1000+'%';
    items[currentIndex].style.transform='translatex(' +newTransformvalue+')';
    items[currentIndex].style.diplay='none';
    items[currentIndex-1].style.transform='translatex(' +0+')';
    const subtitles =document.querySelectorAll('.speaciality .box-container .box');
    subtitles.style.animationName ='none';
   }
