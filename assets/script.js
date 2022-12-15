let navbar = document.querySelector(".header .navbar");
let accountBox = document.querySelector(".header .account-box");
let question = document.querySelector(".question_1");
let reponse = document.querySelector(".reponse_1");
let question2 = document.querySelector(".question_2");
let reponse2 = document.querySelector(".reponse_2");

question.onclick = () => {
  reponse.classList.toggle("hidden");
  
};

question2.onclick = () => {
  reponse2.classList.toggle("hidden");
  
};



document.querySelector("#menu-btn").onclick = () => {
  navbar.classList.toggle("active");
  accountBox.classList.remove("active");
};

document.querySelector("#user-btn").onclick = () => {
  accountBox.classList.toggle("active");
  navbar.classList.remove("active");
};

window.onscroll = () => {
  navbar.classList.remove("active");
  accountBox.classList.remove("active");
};


let slideIndex = 1;
showSlides(slideIndex);


function nextSlide() {
    showSlides(slideIndex += 1);
}


function previousSlide() {
    showSlides(slideIndex -= 1);  
}


function currentSlide(n) {
    showSlides(slideIndex = n);
}


function showSlides(n) {
    let i;
    let slides = document.getElementsByClassName("item");
    
    if (n > slides.length) {
      slideIndex = 1
    }
    if (n < 1) {
        slideIndex = slides.length
    }
  

    for (let slide of slides) {
        slide.style.display = "none";
    }   
    slides[slideIndex - 1].style.display = "block"; 
}