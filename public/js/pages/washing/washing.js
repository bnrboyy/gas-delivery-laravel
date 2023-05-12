const currency = document.getElementById("currency").value;
let capacity_price = document
    .querySelector(".washing-item-type-capacity-content-group.active")
    .getAttribute("data-price");

let water_temp_price = document
    .querySelector(".washing-item-type-watertemp-content-group.active")
    .getAttribute("data-price");

document.querySelector("button.add-to-cart p").innerText =
    parseInt(water_temp_price) + parseInt(capacity_price) + " " + currency;

const capacitys = document.querySelectorAll(
    ".washing-item-type-capacity-content-group"
);

capacitys.forEach((capacity) => {
    capacity.addEventListener("click", function () {
        if (capacity.classList.contains("active")) {
            return false;
        } else {
            capacitys.forEach((el) => {
                el.classList.remove("active");
            });
            capacity_price = this.getAttribute("data-price");
            document.querySelector("button.add-to-cart p").innerText =
                parseInt(water_temp_price) +
                parseInt(capacity_price) +
                " " +
                currency;
            this.classList.add("active");
        }
    });
});

const waterTemps = document.querySelectorAll(
    ".washing-item-type-watertemp-content-group"
);

waterTemps.forEach((waterTemp) => {
    waterTemp.addEventListener("click", function () {
        if (waterTemp.classList.contains("active")) {
            return false;
        } else {
            waterTemps.forEach((el) => {
                el.classList.remove("active");
            });
            water_temp_price = this.getAttribute("data-price");
            document.querySelector("button.add-to-cart p").innerText =
                parseInt(water_temp_price) +
                parseInt(capacity_price) +
                " " +
                currency;
            this.classList.add("active");
        }
    });
});

function saveWashing(_page) {
    const capacity = document.querySelector(
        ".washing-item-type-capacity-content-group.active"
    );
    const water_temp = document.querySelector(
        ".washing-item-type-watertemp-content-group.active"
    );
    const param = {
        capacity_id: capacity.getAttribute("data-id"),
        water_temp_id: water_temp.getAttribute("data-id"),
    };

    localStorage.setItem("capacity_price", capacity.getAttribute("data-price"));
    localStorage.setItem("water_temp_price", water_temp.getAttribute("data-price"));

    axios
        .post(`/api-member/orderWash/temp`, param, {
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
        })
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

function summaryPage() {
    const totalList = document.querySelector(".btn-summary").getAttribute("data-price")
    if (parseInt(totalList) <= 0) {
        return false;
    }
    window.location.href = "/washing/cart";
}
