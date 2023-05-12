// page product
const optionProduct = document.querySelector(".select-product");
if (optionProduct) {
    const selectBtn = optionProduct.querySelector(".select-btn");
    const options = optionProduct.querySelectorAll(".option");
    const sBtn_text = optionProduct.querySelector(".sBtn-text");

    selectBtn.addEventListener("click", () =>
        optionProduct.classList.toggle("active")
    );

    options.forEach((option) => {
        option.addEventListener("click", () => {
            let selectedOption = option.querySelector(".option-text").innerText;
            sBtn_text.innerText = selectedOption;

            optionProduct.classList.remove("active");
        });
    });
}

document.querySelector("#show-product0").style.display = "block";
document.querySelector("#products .col-category button").classList.add("active");

function categoryShow(showkey) {
    let btn = document.querySelectorAll("#products .col-category button.active");

    btn.forEach((el, index) => {
        el.classList.remove("active");
    });
    event.target.classList.add("active");

    let allBtn = document.querySelectorAll("#products .col-category button");
    allBtn.forEach((el, index) => {
        if ("show-product" + index == "show-product" + showkey) {
            document.querySelector("#show-product" + index).style.display = "block";
        } else {
            document.querySelector("#show-product" + index).style.display = "none";
        }
    });


    let btnPrice = document.querySelectorAll(
        `#products .product-blog .col-product #show-product${showkey} .col-description .col-size button`
    );
    btnPrice.forEach((el) => {
        el.classList.remove("active");
    });
    let loadPrice = document.querySelector(
        `#products .product-blog .col-product #show-product${showkey} .col-description .col-size button`
    ).value;
    document.querySelector(
        `#products .product-blog .col-product #show-product${showkey} .col-description .col-price .price-product`
    ).innerHTML = loadPrice;
    document.querySelector(
        `#products .product-blog .col-product #show-product${showkey} .col-description .col-size button`
    ).classList.add("active");
}

let gallery_product = document.querySelectorAll(".col-product .gallery");
gallery_product.forEach((element, index, arr) => {
    var sub_swiper_product = new Swiper(
        `#products .col-product #show-product${index}  .content-blog .subSwiper`,
        {
            // loop: true,
            spaceBetween: 24,
            freeMode: true,
            watchSlidesProgress: true,
            allowSlidePrev: true,
            allowSlideNext: true,
            navigation: {
                nextEl: `#products .col-product #show-product${index} .content-blog .swiper-button-next`,
                prevEl: `#products .col-product #show-product${index} .content-blog .swiper-button-prev`,
            },
            pagination: {
                el: ".swiper-pagination",
            },
            breakpoints: {
                600: {
                    slidesPerView: 2,
                },
                760: {
                    slidesPerView: 2,
                },
                970: {
                    slidesPerView: 3,
                },
                1280: {
                    slidesPerView: 4,
                },
            },
        }
    );
    new Swiper(`#products .col-product #show-product${index} .content-blog  .mainSwiper`, {
      loop: true,
      spaceBetween: 10,
      navigation: {
        nextEl: `#products .col-product #show-product${index} .content-blog .swiper-button-next`,
        prevEl: `#products .col-product #show-product${index} .content-blog .swiper-button-prev`,
      },
      pagination: {
        el: ".swiper-pagination",
      },
      thumbs: {
        swiper: sub_swiper_product,
      },
      autoplay: {
        delay: 5000,
        disableOnInteraction: false,
      },
    });
});

//section price
let loadPrice = document.querySelector("#products .product-blog .col-product #show-product0 .col-description .col-size button").value;
document.querySelector("#products .product-blog .col-product #show-product0 .col-description  .col-price .price-product").innerHTML = loadPrice;
document.querySelector("#products .product-blog .col-product #show-product0 .col-description .col-size button").classList.add("active");

function priceProductShow(price) {
    let cate = document.querySelectorAll("#products .col-category button");
    cate.forEach((el,index) => {
        document.querySelector(
            `#products .product-blog .col-product #show-product${index} .col-description .col-price .price-product`
        ).innerHTML = price;

        let btn = document.querySelectorAll(
            `#products .product-blog .col-product #show-product${index} .col-description .col-size button`
        );
        btn.forEach((el) => {
            el.classList.remove("active");
        });
    });
     event.target.classList.add("active");
   
}//end price
// end product

// page service
const optionService = document.querySelector(".select-service");
if (optionService) {
    const selectBtn = optionService.querySelector(".select-btn");
    const options = optionService.querySelectorAll(".option");
    const sBtn_text = optionService.querySelector(".sBtn-text");

    selectBtn.addEventListener("click", () =>
        optionService.classList.toggle("active")
    );

    options.forEach((option) => {
        option.addEventListener("click", () => {
            let selectedOption = option.querySelector(".option-text").innerText;
            sBtn_text.innerText = selectedOption;

            optionService.classList.remove("active");
        });
    });
}
document.querySelector("#show-service0").style.display = "block";
document.querySelector("#service .col-category button").classList.add("active");
function categoryService(showkey) {
    let btn = document.querySelectorAll("#service .col-category button.active");
    btn.forEach((el, index) => {
        el.classList.remove("active");
    });
    event.target.classList.add("active");

    let allBtn = document.querySelectorAll("#service .col-category button");
    allBtn.forEach((el, index) => {
        if ("show-product" + index == "show-product" + showkey) {
            document.querySelector("#show-service" + index).style.display =
                "block";
        } else {
            document.querySelector("#show-service" + index).style.display =
                "none";
        }
    });

    let btnPrice = document.querySelectorAll(
        `#products .col-content #show-service${showkey} .col-description .col-size button`
    );
    btnPrice.forEach((el) => {
        el.classList.remove("active");
    });
    let loadPrice = document.querySelector(
        `#service .col-content #show-service${showkey} .col-description .col-size button`
    ).value;
    document.querySelector(
        `#service .col-content #show-service${showkey} .col-description .col-price .price-product`
    ).innerHTML = loadPrice;
    document
        .querySelector(
            `#service .col-content #show-service${showkey} .col-description .col-size button`
        )
        .classList.add("active");
}
let gallery_service = document.querySelectorAll(".col-product .gallery");
gallery_service.forEach((element, index, arr) => {
    var sub_swiper_service = new Swiper(
        `#service .col-product #show-service${index}  .content-blog .subSwiper`,
        {
            // loop: true,
            spaceBetween: 24,
            freeMode: true,
            watchSlidesProgress: true,
            navigation: {
                nextEl: `#service .col-product #show-service${index} .content-blog .swiper-button-next`,
                prevEl: `#service .col-product #show-service${index} .content-blog .swiper-button-prev`,
            },
            pagination: {
                el: ".swiper-pagination",
            },
            breakpoints: {
                600: {
                    slidesPerView: 2,
                },
                760: {
                    slidesPerView: 2,
                },
                970: {
                    slidesPerView: 3,
                },
                1280: {
                    slidesPerView: 4,
                },
            },
        }
    );
    new Swiper(`#service .col-product #show-service${index} .content-blog  .mainSwiper`, {
      loop: true,
      spaceBetween: 10,
      navigation: {
        nextEl: `#service .col-product #show-service${index} .content-blog .swiper-button-next`,
        prevEl: `#service .col-product #show-service${index} .content-blog .swiper-button-prev`,
      },
      pagination: {
        el: ".swiper-pagination",
      },
      thumbs: {
        swiper: sub_swiper_service,
      },
      autoplay: {
        delay: 5000,
        disableOnInteraction: false,
      },
    });
});

//section price
let loadPriceService = document.querySelector("#service .col-content #show-service0 .col-description .col-size button").value;
document.querySelector(
    "#service .col-content #show-service0 .col-description  .col-price .price-product"
).innerHTML = loadPriceService;
document.querySelector("#service .col-content #show-service0 .col-description .col-size button").classList.add("active");

function priceServiceShow(price) {
    let cate = document.querySelectorAll("#service .col-category button");
    cate.forEach((el,index) => {
        document.querySelector(
            `#service .col-content #show-service${index} .col-description .col-price .price-product`
        ).innerHTML = price;

        let btn = document.querySelectorAll(
            `#service .col-content #show-service${index} .col-description .col-size button`
        );
        btn.forEach((el) => {
            el.classList.remove("active");
        });
    });
     event.target.classList.add("active");
   
}//end price
// end service
