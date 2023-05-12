scrollFunction();
window.onscroll = function () {
    scrollFunction();
};
function click_to(id) {
    const yOffset = -50;
    const element = document.getElementById(id);
    const y =
        element.getBoundingClientRect().top + window.pageYOffset + yOffset;
    window.scrollTo({ top: y, behavior: "smooth" });
    // document.querySelector("header .header-nav #menu-nav").style.display =
    //     "none";
    // document.querySelector("header .header-nav .fig-bar a").style.transform =
    //     "scale(1)";
}

function scrollFunction() {
    const sections = document.querySelectorAll("section");
    // Get current scroll position
    let scrollY = window.pageYOffset;
    let check_width = window.innerWidth;

    if (scrollY > 80) {
        document.querySelector("header").style.height = "60px";
        if (check_width >= 992) {
            document.querySelector("header .menu-list .menu button").style.height = "60px";
        } else {
            document.querySelector("header .menu-list .menu button").style.height = null;
             document.querySelector("header .header-nav #menu-nav").style.display = "none";
             document.querySelector("header .header-nav .fig-bar a").style.transform = "scale(1)";
        }
    } else {
        document.querySelector("header").style.height = "80px";
        if (check_width >= 992) {
            document.querySelector("header .menu-list .menu button").style.height =
                "80px";
        } else {
            document.querySelector("header .menu-list .menu button").style.height =null;
            document.querySelector("header .header-nav #menu-nav").style.display = "none";
            document.querySelector("header .header-nav .fig-bar a").style.transform = "scale(1)";
        }
    }
    sections.forEach((current) => {
        const sectionHeight = current.offsetHeight;
        const sectionTop = current.offsetTop - 60;
        const sectionId = current.getAttribute("id");

        if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
            document.querySelector(".header-nav #menu-nav ul li button.menu-"+sectionId).classList.add("active");
        } else {
            document.querySelector(".header-nav #menu-nav ul li button.menu-" + sectionId).classList.remove("active");
        }
    });

    let mybutton = document.querySelector(".btn-bring-top");
    if (
        document.body.scrollTop > 20 ||
        document.documentElement.scrollTop > 20
    ) {
        mybutton.style.display = "flex";
    } else {
        mybutton.style.display = "none";
    }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}
// mobile
function navMobile() {
    document.querySelector("header .header-nav #menu-nav").style.display =
        "block";
    document.querySelector("header .header-nav .fig-bar a").style.transform =
        "scale(0)";
}
let close_modal = document.querySelector(
    "header .header-nav #menu-nav .menu-list .close-modal"
);
close_modal.onclick = function (evt) {
    document.querySelector("header .header-nav #menu-nav").style.display =
        "none";
    document.querySelector("header .header-nav .fig-bar a").style.transform =
        "scale(1)";
};
// close outside
let close_outside = document.querySelectorAll(
    "header .header-nav #menu-nav .menu-list .menu a"
);
close_outside.forEach((element) => {
    element.onclick = function (evt) {
        if (window.innerWidth < 992) {
            document.querySelector(
                "header .header-nav #menu-nav"
            ).style.display = "none";
        }
    };
});

window.onresize = function () {
    if (window.innerWidth > 992) {
        document.querySelector("header .header-nav #menu-nav").style.display =
            null;
        scrollFunction();
    }
};
