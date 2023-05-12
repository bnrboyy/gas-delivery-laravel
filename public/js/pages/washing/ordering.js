const config = {
    enableTime: true,
    dateFormat: "Y-m-d H:i",
    minDate: "today",
    disableMobile: true,
    plugins: [
        new confirmDatePlugin({
            confirmText: "Close",
            confirmIcon: "",
            showAlways: false,
        }),
    ],
};
flatpickr("input[type=datetime-local]", config);

const datetimeInput1 = document.getElementById("time_now");
const datetimeInput2 = document.getElementById("time_pickup");
const datetimeInput3 = document.getElementById("time_drop");

let time_now = new Date();
let time_pickup = "";
let time_drop = "";

var now = new Date();
var year = now.getFullYear();
var month = (now.getMonth() + 1).toString().padStart(2, "0");
var day = now.getDate().toString().padStart(2, "0");
var hour = now.getHours().toString().padStart(2, "0");
var minute = now.getMinutes().toString().padStart(2, "0");
var datetime = year + "-" + month + "-" + day + " " + hour + ":" + minute;

datetimeInput1.value = datetime;
datetimeInput2.value = "เลือกเวลา";
datetimeInput3.value = "เลือกเวลา";

localStorage.setItem(
    "branch_location",
    document.querySelector("p.branch_selected").getAttribute("data-location")
);

function dropDown() {
    let dd = document.querySelector(
        ".wad-item-branch-list-description-dropdown"
    );
    if (dd.classList.contains("active")) {
        dd.classList.remove("active");
    } else {
        dd.classList.add("active");
    }
    document.getElementById("myDropdown").classList.toggle("show");
}

function closeDropdown() {
    setTimeout(() => {
        let dd = document.querySelector(
            ".wad-item-branch-list-description-dropdown"
        );
        if (dd.classList.contains("active")) {
            dd.classList.remove("active");
        } else {
            dd.classList.add("active");
        }
        document.getElementById("myDropdown").classList.remove("show");
    }, 300);
}

function onSelectBranch(_id, _title, _location) {
    let el = document.querySelector("p.branch_selected");
    el.setAttribute("data-id", _id);
    el.innerText = _title;
    localStorage.setItem("branch_location", _location);
}

function timeNow() {
    document.getElementById("time_now").style.display = "block";
    document.getElementById("time_pickup").style.display = "none";
    document.getElementById("time_drop").style.display = "none";
}

function pickUp() {
    document.getElementById("time_now").style.display = "none";
    document.getElementById("time_pickup").style.display = "block";
    document.getElementById("time_drop").style.display = "none";
}

function dropOff() {
    document.getElementById("time_now").style.display = "none";
    document.getElementById("time_pickup").style.display = "none";
    document.getElementById("time_drop").style.display = "block";
}

const buttons = document.querySelectorAll(".wad-item-pickup-button button");
const figures = document.querySelectorAll(
    ".wad-item-pickup-button button figure"
);
buttons.forEach((button) => {
    button.addEventListener("click", function () {
        console.log(figures[0].closest("button").getAttribute("btn-name"));
        if (button.classList.contains("active")) {
            this.classList.remove("active");
            figures.forEach((el) => {
                const currentBtn = el
                    .closest("button")
                    .getAttribute("btn-name");
                if (
                    currentBtn === "time_now" ||
                    (currentBtn === "time_pickup" && !time_pickup) ||
                    (currentBtn === "time_drop" && !time_drop)
                ) {
                    el.style.display = "none";
                }
            });
        } else {
            buttons.forEach((el) => el.classList.remove("active"));
            this.classList.add("active");
            figures.forEach((el) => {
                const currentBtn = el
                    .closest("button")
                    .getAttribute("btn-name");
                if (
                    currentBtn === "time_now" ||
                    (currentBtn === "time_pickup" && !time_pickup) ||
                    (currentBtn === "time_drop" && !time_drop)
                ) {
                    el.style.display = "none";
                }
            });
            this.querySelector("figure").style.display = "flex";
        }
    });
});

const clothTypes = document.querySelectorAll(".clothing-type");
clothTypes.forEach((clothType) => {
    clothType.addEventListener("click", function (e) {
        if (clothType.classList.contains("active")) {
            return false;
        } else {
            clothTypes.forEach((el) => el.classList.remove("active"));
            this.classList.add("active");
        }
    });
});

const washTypes = document.querySelectorAll(
    ".wad-item-type-washing-content-group"
);

washTypes.forEach((washType) => {
    washType.addEventListener("click", function () {
        if (washType.classList.contains("active")) {
            return false;
        } else {
            washTypes.forEach((el) => el.classList.remove("active"));
            this.classList.add("active");
        }
    });
});

function getLocationData() {
    let input_addres_pickup = document.querySelector("#input-address-pickup p");
    let input_addres_drop = document.querySelector("#input-address-drop p");
    if (input_addres_pickup) {
        input_addres_pickup.innerText = localStorage.getItem("pickup_address");
    }
    if (input_addres_drop) {
        input_addres_drop.innerText = localStorage.getItem("drop_address");
    }
}

getLocationData();

function selectTime(e) {
    if (e.getAttribute("id") === "time_pickup") {
        time_pickup = e.value;
    }
    if (e.getAttribute("id") === "time_drop") {
        time_drop = e.value;
        document
            .querySelector(
                ".wad-item-pickup-button button[btn-name='time_drop']"
            )
            .classList.remove("error");
    }
}

function nextPage() {
    let errorArr = [];

    const element = {
        pickup_address: document.querySelector("#input-address-pickup p"),
        drop_address: document.querySelector("#input-address-drop p"),
        pickup_detail: document.querySelector('input[name="pickup_detail"]'),
        drop_detail: document.querySelector('input[name="drop_detail"]'),
        phone_number: document.querySelector('input[name="phone_number"]'),
        order_details: document.querySelector('input[name="order_details"]'),
        clothing_type_id: document.querySelector(".clothing-type.active"),
        branch_id: document.querySelector("p.branch_selected"),
        wash_or_dry_id: document.querySelector(
            ".wad-item-type-washing-content-group.active"
        ),
    };

    const orders = {
        pickup_address: element.pickup_address.innerHTML,
        drop_address: element.drop_address.innerHTML,
        pickup_location: localStorage.getItem("pickup"),
        drop_location: localStorage.getItem("drop"),
        pickup_location_address: localStorage.getItem("pickup_address"),
        drop_location_address: localStorage.getItem("drop_address"),
        pickup_address_detail: element.pickup_detail.value,
        drop_address_detail: element.drop_detail.value,
        phone_number: element.phone_number.value,
        order_details: element.order_details.value,
        clothing_type_id: element.clothing_type_id.getAttribute("data-id"),
        wash_or_dry_id: element.wash_or_dry_id.getAttribute("data-id"),
        type_order: "washanddry",
        pickup_time: time_pickup ? time_pickup : time_now,
        drop_time: time_drop,
        branch_id: parseInt(element.branch_id.getAttribute("data-id")),
    };

    if (!orders.pickup_location) {
        document.querySelector("figure.location-pickup").classList.add("error");
        errorArr.push("Please select your pickup location");
    } else {
        document
            .querySelector("figure.location-pickup")
            .classList.remove("error");
    }

    if (!orders.drop_location) {
        document.querySelector("figure.location-drop").classList.add("error");
        errorArr.push("Please select your drop location");
    } else {
        document
            .querySelector("figure.location-drop")
            .classList.remove("error");
    }

    if (orders.phone_number === "") {
        element.phone_number.classList.add("error");
        errorArr.push("Please enter your phone number");
    } else {
        element.phone_number.classList.remove("error");
    }

    if (!time_drop) {
        document
            .querySelector(
                ".wad-item-pickup-button button[btn-name='time_drop']"
            )
            .classList.add("error");
        errorArr.push("Please select your time to drop off");
    } else {
        document
            .querySelector(
                ".wad-item-pickup-button button[btn-name='time_drop']"
            )
            .classList.remove("error");
    }

    if (errorArr.length !== 0) {
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Invalid input",
            text: errorArr[0],
            showConfirmButton: true,
            width: 400,
        });
        return false;
    }

    saveTemp(orders);
}

async function saveTemp(param) {
    const response = await axios.post(`/api-member/order/temp`, param, {
        headers: {
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
    });
    if (response.status) {
        const activeUrl = document
            .querySelector(".wad-item-type-washing-content-group.active")
            .getAttribute("urls");
        window.location.href = activeUrl;
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
}

function inputEmpty(el) {
    if (el.value === "") {
        el.classList.add("error");
    } else {
        el.classList.remove("error");
    }
}

localStorage.setItem("capacity_price", 0);
localStorage.setItem("water_temp_price", 0);
