var swiperBanner = new Swiper(".bannerSwiper", {
    // spaceBetween: 30,
    centeredSlides: true,
    allowSlidePrev: true,
    allowSlideNext: true,
    slidesPerView: 1,
    loop: true,
    autoplay: {
        delay: 5000,
        disableOnInteraction: false,
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
});
//procedure
var swiper = new Swiper(".infiniteSwiper", {
    centeredSlides: true,
    // loop: true,
    centeredSlidesBounds: true,

    spaceBetween: 45,
    pagination: {
        el: ".swiper-pagination",
        type: "fraction",
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    breakpoints: {
        778: {
            // loop: true,
            slidesPerView: 2,
            spaceBetween: 20,
        },
        996: {
            slidesPerView: 3,
            spaceBetween: 20,
        },
        1280: {
            slidesPerView: 4,
            spaceBetween: 45,
        },
    },
});
//modal post
let modal_procedure = document.querySelector("#procedure .post-modal");
let images_procedure = document.querySelectorAll(
    "#procedure .post-blog .infiniteSwiper .swiper-wrapper .swiper-slide .col-items .col-image img"
);
let captions_procedure = document.querySelectorAll(
    "#procedure .post-blog .infiniteSwiper .swiper-wrapper .swiper-slide .col-items .description"
);
let modalImg_procedure = document.getElementById("img01");
let captionText_procedure = document.getElementById("caption");
for (let i = 0; i < images_procedure.length; i++) {
    let img = images_procedure[i];
    img.onclick = function (evt) {
        modal_procedure.style.display = "block";
        modalImg_procedure.src = this.src;
        captionText_procedure.innerHTML = captions_procedure[i].innerHTML;
    };
}
let span_procedure = document.getElementsByClassName("close")[0];

span_procedure.onclick = function () {
    modal_procedure.style.display = "none";
};

//project reference
var projectSwiper = new Swiper(".projectSwiper", {
    centeredSlides: true,
    centeredSlidesBounds: true,
    spaceBetween: 45,
    pagination: {
        el: ".swiper-pagination",
        // type: "fraction",
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    breakpoints: {
        724: {
            // loop: true,
            slidesPerView: 2,
            spaceBetween: 45,
        },
        996: {
            slidesPerView: 2,
            spaceBetween: 45,
        },
        1280: {
            slidesPerView: 3,
            spaceBetween: 45,
        },
    },
});
//modal post
let modal_project = document.querySelector("#project-reference .post-modal");
let images_project = document.querySelectorAll(
    "#project-reference .post-blog .projectSwiper .swiper-wrapper .swiper-slide .col-items .col-image img"
);
let captions_project = document.querySelectorAll(
    "#project-reference .post-blog .projectSwiper .swiper-wrapper .swiper-slide .col-items .description"
);
let modalImg_project = document.getElementById("img02");
let captionText_project = document.getElementById("caption2");
for (let i = 0; i < images_project.length; i++) {
    let img = images_project[i];
    img.onclick = function (evt) {
        modal_project.style.display = "block";
        modalImg_project.src = this.src;
        captionText_project.innerHTML = captions_project[i].innerHTML;
    };
}
let span_project = document.querySelector(
    "#project-reference .post-modal .close"
);

span_project.onclick = function () {
    modal_project.style.display = "none";
};
//end project reference

var cer_swiper = new Swiper(".cerSwiper", {
    centeredSlides: true,
    loop: true,
    speed:1000,
    // slidesPerView: 3,
    pagination: {
        el: ".swiper-pagination",
        type: "fraction",
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    breakpoints: {
        600: {
            slidesPerView: 1,
        },
        760: {
            slidesPerView: 1,
        },
        970: {
            slidesPerView: 3,
        },
        1280: {
            slidesPerView: 3,
        },
    },
});
