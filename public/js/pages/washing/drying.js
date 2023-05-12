let totalPrice = 0;
let minute = 0;
let minute_confirmed = 0;
let totalPriceAdd = 0;

const currency = document.getElementById("currency").value;
const capacity_price = parseInt(localStorage.getItem("capacity_price"));
const water_temp_price = parseInt(localStorage.getItem("water_temp_price"));

document.querySelector(".drying-item-button-receipt-title-right p").innerText =
    capacity_price + water_temp_price + " " + currency;

const capacitys = document.querySelectorAll(
    ".drying-item-capacity-content-group"
);

capacitys.forEach((capacity) => {
    capacity.addEventListener("click", function () {
        if (capacity.classList.contains("active")) {
            return false;
        } else {
            capacitys.forEach((el) => el.classList.remove("active"));
            this.classList.add("active");
            const capacity_id = this.getAttribute("data-id");
            minute_confirmed = 0;
            minute = 0;
            setDryingTime(capacity_id);
            calPrice();
        }
    });
});

function saveWashing(_page) {
    const capacity = document.querySelector(
        ".drying-item-capacity-content-group.active"
    );
    const param = {
        product_id: capacity.getAttribute("data-id"),
        minutes_add: minute_confirmed,
    };
    axios
        .post(`/api-member/orderDry/temp`, param)
        .then((response) => {
            window.location.href = _page;
        })
        .catch(({ response }) => {
            if (response.status === 301) {
                console.log("ok");
                window.location.href = "/washing";
            } else {
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "Something went wrong.",
                    text: response.description,
                    showConfirmButton: true,
                    width: 400,
                });
                return false;
            }
        });
}

function minusTime() {
    let round_minutes = document
        .querySelector(".drying-time")
        .getAttribute("round-minutes");
    if (minute > 0) minute -= parseInt(round_minutes);
    showTime();
}

function plusTime() {
    let round_minutes = document
        .querySelector(".drying-time")
        .getAttribute("round-minutes");
    minute += parseInt(round_minutes);
    showTime();
}

function showTime() {
    document.getElementById("minute").innerHTML = minute;
    let round_minutes = document
        .querySelector(".drying-time")
        .getAttribute("round-minutes");
    const price_per_min = document
        .querySelector(".drying-time")
        .getAttribute("price-per-minutes");
    totalPriceAdd = parseInt(price_per_min) * (minute / round_minutes);
    document.getElementById("price_add_dry").innerHTML = totalPriceAdd;
}

function resetTime() {
    minute_confirmed = 0;
    showTime();
    confirmAddMin();
}

function wadlistPage() {
    window.location.href = "/washing/cart";
}

function calPrice() {
    let drying_price = document
        .querySelector(".drying-time")
        .getAttribute("price-capacity");
    totalPrice = totalPriceAdd + parseInt(drying_price);
    document.querySelector("button.add-to-cart p").innerText =
        totalPrice + " " + currency;
}

function setDryingTime(_id) {
    axios
        .get(`/api-member/product/${_id}`)
        .then(({ data }) => {
            const result = data.data;
            if (result) {
                resetTime();
                const e = document.querySelector(".drying-time");
                e.setAttribute("price-per-minutes", result.price_per_minutes);
                e.setAttribute("round-minutes", result.round_minutes);
                e.setAttribute("price-capacity", result.price);
                e.setAttribute("default-minutes", result.default_minutes);
                e.querySelector(".drying-time-title p").innerText =
                    result.default_minutes + " minutes";
                e.querySelector(".drying-time-description p").innerText =
                    result.price + " " + currency;
                document.querySelector("button.add-to-cart p").innerText =
                    result.price + " " + currency;
            }
        })
        .catch(({ response }) => {
            console.log(response);
        });
}

function confirmAddMin() {
    minute_confirmed += minute;
    minute = 0;
    showTime();

    /** get element of drying content */
    const e = document.querySelector(".drying-time");
    /** get price from attribute */
    const price_capa = e.getAttribute("price-capacity");
    /** get default minute from attribute */
    const default_min = e.getAttribute("default-minutes");

    /** get price per minutes from attribute */
    const price_per_min = e.getAttribute("price-per-minutes");
    /** get round minutes from attribute */
    const round_min = e.getAttribute("round-minutes");
    const price_per_min_total = price_per_min * (minute_confirmed / round_min);

    /** show new Minutes */
    e.querySelector(".drying-time-title p").innerText =
        parseInt(default_min) + minute_confirmed + " minutes";
    /** show new Price */
    e.querySelector(".drying-time-description p").innerText =
        parseInt(price_capa) + price_per_min_total + " " + currency;
    /** show new Price on "go to cart" button */
    document.querySelector("button.add-to-cart p").innerText =
        parseInt(price_capa) + price_per_min_total + " " + currency;
}

calPrice();
