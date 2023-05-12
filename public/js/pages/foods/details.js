/** foods */
let amount = 0;
let price = 0;
const amount_el = document.getElementById("quantity");
const currency = document.getElementById("currency").value;

price = parseInt(
    document
        .querySelector(".dish-item-content-address-price")
        .getAttribute("product-price")
);
let total_el = document.querySelector(".dish-item-button-content-right b");

const typeWave = document.querySelectorAll(
    ".dish-item-microwave-box-temp-button button"
);

typeWave.forEach((type) => {
    type.addEventListener("click", function () {
        typeWave.forEach((el) => el.classList.remove("active"));
        this.classList.add("active");
        microwave_id = parseInt(this.getAttribute("data-id"));
    });
});

const typeSweet = document.querySelectorAll(
    ".bottle-item-sweetness-box-temp-button button"
);

typeSweet.forEach((type) => {
    type.addEventListener("click", function () {
        typeSweet.forEach((el) => el.classList.remove("active"));
        this.classList.add("active");
        sweetness_id = parseInt(this.getAttribute("data-id"));
    });
});

function minusQuantity() {
    if (amount > 0) {
        amount = amount - 1;
        amount_el.innerHTML = amount;
        total_el.innerHTML = price * amount + " " + currency;
    }
}

function plusQuantity() {
    amount = amount + 1;
    amount_el.innerHTML = amount;
    total_el.innerHTML = price * amount + " " + currency;
}

async function addToCart(_id) {
    const prev_id = document
        .querySelector(".dish-item-button-content")
        .getAttribute("prev-id");
    const prevUrl = "/foods/menu?cate_id=" + prev_id;
    if (amount <= 0) return false;

    const microwave = document.querySelector(
        ".dish-item-microwave-box-temp-button button.active"
    );

    const sweetness = document.querySelector(
        ".bottle-item-sweetness-box-temp-button button.active"
    );

    const param = {
        product_id: _id,
        quantity: amount,
        requirements: document.querySelector('input[name="requirements"]')
            .value,
        microwave_id: microwave
            ? parseInt(microwave.getAttribute("data-id"))
            : 0,
        sweetness_id: sweetness
            ? parseInt(sweetness.getAttribute("data-id"))
            : 0,
    };
    axios
        .post(`/api-member/order/foodcart`, param)
        .then((response) => {
            window.location.href = prevUrl;
        })
        .catch(({ response }) => {
            if (response.status === 301) {
                Swal.fire({
                    position: "center",
                    icon: "info",
                    title: "Timeout, Please make new order.",
                    // text: response.description,
                    showConfirmButton: true,
                    width: 400,
                }).then(() => {
                    window.location.href = "/foods";
                });
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
