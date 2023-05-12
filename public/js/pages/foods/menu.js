const urlParams = new URLSearchParams(window.location.search);
const cate_id = urlParams.get("cate_id");

const searchInput = document.getElementById("search");
const dishs = document.querySelectorAll(".food-item-category-dish-box");

searchInput.addEventListener("input", function () {
    const searchTerm = this.value.toLowerCase();
    dishs.forEach((dish) => {
        if (dish.textContent.toLowerCase().includes(searchTerm)) {
            dish.style.display = "flex";
        } else {
            dish.style.display = "none";
        }
    });
});

const dishCats = document.querySelectorAll(".food-item-category-dish-box");
dishCats.forEach((dishCat) => {
    dishCat.addEventListener("click", function () {
        const food_id = dishCat.getAttribute("dish-id");
        const foodUrl = "/foods/details/" + food_id;
        window.location.href = foodUrl;
    });
});

function cartPage() {
    window.location.href = "/foods/cart";
}

const foodCate = document.querySelectorAll(".food-item-category-list-box");

foodCate.forEach((cate, index) => {
    cate.addEventListener("click", function () {
        const current_cate_id = cate.getAttribute("cate-id");
        let url = "/foods/menu?cate_id=" + current_cate_id;
        if (cate.classList.contains("active")) {
            url = "/foods/menu";
        }
        window.location.href = url;
    });
    activeCate(cate, index);
});

function activeCate(cate, index) {
    if (cate.getAttribute("cate-id") == cate_id) {
        foodCate.forEach((el) => {
            el.classList.remove("active");
            el.querySelector("figure").classList.remove("active");
            el.querySelector("p").classList.remove("active");
        });
        cate.classList.add("active");
        cate.querySelector("figure").classList.add("active");
        cate.querySelector("p").classList.add("active");

        document.querySelector('.food-item-category-list').scrollLeft = cate.offsetWidth * index
    }
}
