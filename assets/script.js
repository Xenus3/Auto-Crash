let navbar = document.querySelector(".header .navbar");
let accountBox = document.querySelector(".header .account-box");


if ($("body").data("title") === "faq") {

  let question = document.querySelector(".question_1");
  let reponse = document.querySelector(".reponse_1");
  let question2 = document.querySelector(".question_2");
  let reponse2 = document.querySelector(".reponse_2");
  let question3 = document.querySelector(".question_3");
  let reponse3 = document.querySelector(".reponse_3");

question.onclick = () => {
  reponse.classList.toggle("hidden");
  
};

question2.onclick = () => {
  reponse2.classList.toggle("hidden");
  
};

question3.onclick = () => {
  reponse3.classList.toggle("hidden");
  
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
}


if ($("body").data("title") === "accueil") {
  

let img__slider = document.getElementsByClassName("img__slider");

let etape = 0;

let nbr__img = img__slider.length;

let precedent = document.querySelector(".precedent");
let suivant = document.querySelector(".suivant");

function enleverActiveImages() {
  for (let i = 0; i < nbr__img; i++) {
    img__slider[i].classList.remove("active");
  }
}

suivant.addEventListener("click", function () {
  etape++;
  if (etape >= nbr__img) {
    etape = 0;
  }
  enleverActiveImages();
  img__slider[etape].classList.add("active");
});

precedent.addEventListener("click", function () {
  etape--;
  if (etape < 0) {
    etape = nbr__img - 1;
  }
  enleverActiveImages();
  img__slider[etape].classList.add("active");
});

setInterval(function () {
  etape++;
  if (etape >= nbr__img) {
    etape = 0;
  }
  enleverActiveImages();
  img__slider[etape].classList.add("active");
}, 3000);
}