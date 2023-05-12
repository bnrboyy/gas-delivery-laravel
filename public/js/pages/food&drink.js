const searchInput = document.getElementById("search");
const dishs = document.querySelectorAll(".food-item-category-dish-box");
const searchIcon = document.querySelector(".food-item-category-search figure");

searchIcon.addEventListener("click", ()=> {
  searchInput.focus();
})

searchInput.addEventListener("input", function() {
   const searchTerm = this.value.toLowerCase();
   dishs.forEach((dish) => {
     if (dish.textContent.toLowerCase().includes(searchTerm)) {
       dish.style.display = "flex";
     } else {
       dish.style.display = "none";
     }
   });
})

const dishCats = document.querySelectorAll(".food-item-category-dish-box");
dishCats.forEach((dishCat) => {
  dishCat.addEventListener("click", function() {
    const food_id = dishCat.getAttribute("dish-id")
    const foodUrl = "/foods/" + food_id
    window.location.href = foodUrl;
  })
})

function cartPage() {
  window.location.href = "/foods/cart";
}

const foodCats = document.querySelectorAll(".food-item-category-list-box");
foodCats.forEach((foodCat) => {
  foodCat.addEventListener("click", function () {
    const cate_id = foodCat.getAttribute("food-id")
    const url = "/foods/menu/" + cate_id
    window.location.href = url;
    if (foodCat.classList.contains("active")) {
      this.classList.remove("active");
      this.querySelector(".food-item-category-list-box figure").classList.remove("active");
      this.querySelector(".food-item-category-list-box p").classList.remove("active");
    } else {
      foodCats.forEach((el) => {
        el.classList.remove("active");
        el.querySelector(".food-item-category-list-box figure").classList.remove("active");
        el.querySelector(".food-item-category-list-box p").classList.remove("active");
      });
      this.classList.add("active");
      this.querySelector(".food-item-category-list-box figure").classList.add("active");
      this.querySelector(".food-item-category-list-box p").classList.add("active");

      localStorage.setItem("activeFoodItem", cate_id);
      localStorage.setItem('scrollPosition', document.querySelector('.food-item-category-list').scrollLeft);
    }
  });
});

var activeFoodItem = localStorage.getItem('activeFoodItem');
if (activeFoodItem) {
  const activeFoodCat = document.querySelector('.food-item-category-list-box[food-id="' + activeFoodItem + '"]');
  if (activeFoodCat) {
    activeFoodCat.classList.add('active');
    activeFoodCat.querySelector('.food-item-category-list-box figure').classList.add('active');
    activeFoodCat.querySelector('.food-item-category-list-box p').classList.add('active');
  }
}

var scrollPosition = localStorage.getItem('scrollPosition');
if (scrollPosition) {
  document.querySelector('.food-item-category-list').scrollLeft = scrollPosition;
}

// Cart list
let count = parseInt(localStorage.getItem("count")) || 0;
localStorage.setItem("count", count);
document.querySelector(".food-item-button-content-left p").innerHTML = localStorage.count;

// Cart Price
let price = parseInt(localStorage.getItem("price")) || 0;
localStorage.setItem("price", price);
document.querySelector(".food-item-button-content-right b").innerHTML = localStorage.price + " THB";

console.log(localStorage);
