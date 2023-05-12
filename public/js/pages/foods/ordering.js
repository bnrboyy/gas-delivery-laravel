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

var now2 = new Date();
var year = now2.getFullYear();
var month = (now2.getMonth() + 1).toString().padStart(2, "0");
var day = now2.getDate().toString().padStart(2, "0");
var hour = now2.getHours().toString().padStart(2, "0");
var minute = now2.getMinutes().toString().padStart(2, "0");
var datetime = year + "-" + month + "-" + day + "T" + hour + ":" + minute;
document.getElementById("datetime1").value = datetime;
document.getElementById("datetime2").value = datetime;

localStorage.setItem('branch_location', document.querySelector("p.branch_selected").getAttribute('data-location'))


function timeNow() {
    document.getElementById("datetime1").style.display = "block";
    document.getElementById("datetime2").style.display = "none";
}

function shipTime() {
    document.getElementById("datetime1").style.display = "none";
    document.getElementById("datetime2").style.display = "block";
}

const buttons = document.querySelectorAll(".vac-item-pickup-button button");
const figures = document.querySelectorAll(
    ".vac-item-pickup-button button figure"
);

buttons.forEach((button) => {
    button.addEventListener("click", function () {
        if (button.classList.contains("active")) {
            this.classList.remove("active");
            figures.forEach((el) => (el.style.display = "none"));
        } else {
            buttons.forEach((el) => el.classList.remove("active"));
            this.classList.add("active");
            figures.forEach((el) => (el.style.display = "none"));
            this.querySelector("figure").style.display = "flex";
        }
    });
});

function getLocationData() {
    let input_addres_drop = document.querySelector("#input-address-drop p");
    if (input_addres_drop) {
        input_addres_drop.innerText = localStorage.getItem("drop_address");
    }
}

getLocationData();

const phoneInput = document.querySelector(".vac-item-phone-input input");
const heightPhoneInput = phoneInput.offsetHeight + 208;
phoneInput.addEventListener("click", () => {
    phoneInput.style.borderColor = "#ebf3ff";
});

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
    localStorage.setItem('branch_location', _location)
}

function NextPage() {
    let errorArr = [];

    const element = {
        drop_address: document.querySelector("#input-address-drop p"),
        drop_detail: document.querySelector('input[name="drop_detail"]'),
        phone_number: document.querySelector('input[name="phone_number"]'),
        branch_id: document.querySelector("p.branch_selected"),
        shipping_time: document.querySelector(
            ".vac-item-pickup-button .active"
        ),
    };

    const orders = {
        drop_location: localStorage.getItem("drop"),
        drop_location_address: localStorage.getItem("drop_address"),
        drop_address_detail: element.drop_detail.value,
        phone_number: element.phone_number.value,
        type_order: "foods",
        shipping_time:
            element.shipping_time?.getAttribute("time-type") === "now"
                ? new Date()
                : document.getElementById("datetime2").value,
        branch_id: parseInt(element.branch_id?.getAttribute("data-id")),
    };

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
    const response = await axios.post(`/api-member/order/foodtemp`, param, {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    });
    if (response.status) {
        window.location.href = "/foods/menu";
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
