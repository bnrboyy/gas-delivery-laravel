const payTypes = document.querySelectorAll(".ordersum-item-payment-type-group");
const bank = document.querySelector(".ordersum-item-payment-bank");
const slip = document.querySelector(".ordersum-item-payment-slip");
var loader = document.getElementById("loader");
const price_per_kilo = document
    .querySelector("#price_per_kilo")
    .getAttribute("data-price");
let distance = 0;
let shipping_fee = 0;

const subtotal = document.querySelector("p[name='subtotal']");
const shipped = document.querySelector("p[name='shipped']");
const total = document.querySelector("b[name='total']");
const totalb = document.querySelector("b[name='totalb']");
const maximum = document.querySelector("p#maximum").getAttribute("data");

localStorage.setItem(
    "branch_location",
    document.querySelector("p.branch_selected").getAttribute("data-location")
);

payTypes.forEach((payType) => {
    payType.addEventListener("click", function () {
        payTypes.forEach((el) => el.classList.remove("active"));
        this.classList.add("active");
        if (payType.getAttribute("type") !== "cash") {
            bank.style.display = "flex";
            slip.style.display = "flex";
        } else {
            bank.style.display = "none";
            slip.style.display = "none";
        }
    });
});

const upload = document.querySelector(
    ".ordersum-item-payment-slip-content-left"
);

const image = document.querySelector(
    ".ordersum-item-payment-slip-content-left img"
);

const inputFile = document.createElement("input");
inputFile.type = "file";

upload.addEventListener("click", () => {
    inputFile.click();
});

inputFile.addEventListener("change", () => {
    const reader = new FileReader();
    reader.onload = function (e) {
        upload.querySelector("img").src = e.target.result;
    };
    reader.readAsDataURL(inputFile.files[0]);
    image.style.opacity = "1";
});

function uploadFile() {
    inputFile.click();
    inputFile.addEventListener("change", () => {
        const reader = new FileReader();
        reader.onload = function (e) {
            upload.querySelector("img").src = e.target.result;
        };
        reader.readAsDataURL(inputFile.files[0]);
        image.style.opacity = "1";
    });
}

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

async function onSelectBranch(_branch_id) {
    const response = await axios.get(
        `/api-member/order/changebranch?id=${_branch_id}`
    );
    if (response.status) {
        window.location.reload();
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

function confirmOrder() {
    const element = {
        pickup_address: document.querySelector("#input-address-pickup p"),
        drop_address: document.querySelector("#input-address-drop p"),
        pickup_detail: document.querySelector('input[name="pickup_detail"]'),
        drop_detail: document.querySelector('input[name="drop_detail"]'),
        phone_number: document.querySelector('input[name="phone_number"]'),
        branch_id: document.querySelector("p.branch_selected"),
        payment_type: document.querySelector(
            ".ordersum-item-payment-type-group.active"
        ),
    };

    const orders = {
        pickup_location: localStorage.getItem("pickup"),
        drop_location: localStorage.getItem("drop"),
        pickup_location_address: localStorage.getItem("pickup_address"),
        drop_location_address: localStorage.getItem("drop_address"),
        pickup_address_detail: element.pickup_detail.value,
        drop_address_detail: element.drop_detail.value,
        phone_number: element.phone_number.value,
        branch_id: parseInt(element.branch_id.getAttribute("data-id")),
        /** payment */
        payment_type: element.payment_type?.getAttribute("type"),
        slip_image: inputFile.files,
    };

    if (orders.phone_number === "") {
        element.phone_number.classList.add("error");
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Please enter your phone number",
            showConfirmButton: true,
            width: 400,
        });
        return false;
    } else {
        element.phone_number.classList.remove("error");
    }

    if (!orders.payment_type) {
        Swal.fire({
            position: "center",
            icon: "info",
            title: "Please choose payment type.",
            showConfirmButton: true,
            width: 400,
        });
        return false;
    }

    if (!orders.drop_location) {
        document.querySelector("figure.location-drop").classList.add("error");
        Swal.fire({
            position: "center",
            icon: "info",
            title: "Please select your drop location.",
            showConfirmButton: true,
            width: 400,
        });
    } else {
        document
            .querySelector("figure.location-drop")
            .classList.remove("error");
    }

    if (orders.payment_type === "transfer") {
        if (orders.slip_image.length === 0) {
            Swal.fire({
                position: "center",
                icon: "info",
                title: "Please upload slip.",
                showConfirmButton: true,
                width: 400,
            });
            return false;
        }
    }
    onConfirmOrder(orders);
}

async function onConfirmOrder(_param) {
    let formData = new FormData();
    formData.append("pickup_location", _param.pickup_location);
    formData.append("drop_location", _param.drop_location);
    formData.append("pickup_location_address", _param.pickup_location_address);
    formData.append("drop_location_address", _param.drop_location_address);
    formData.append("pickup_address_detail", _param.pickup_address_detail);
    formData.append("drop_address_detail", _param.drop_address_detail);
    formData.append("phone_number", _param.phone_number);
    formData.append("branch_id", _param.branch_id);
    formData.append("payment_type", _param.payment_type);
    formData.append("distance", distance);
    if (_param.payment_type === "transfer") {
        formData.append("slip_image[]", _param.slip_image[0]);
    }
    const response = await axios.post(`/api-member/order/confirm`, formData, {
        headers: {
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
    });
    if (response.status) {
        Swal.fire({
            position: "center",
            icon: "success",
            title: "Complete.",
            text: response.description,
            showConfirmButton: true,
            width: 400,
        }).then(() => {
            window.location.href = "/";
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
}

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

function inputEmpty(el) {
    if (el.value === "") {
        el.classList.add("error");
    } else {
        el.classList.remove("error");
    }
}

function initMap() {
    let branch_location = localStorage.getItem("branch_location")?.split(",");
    let drop_location = "";
    if (localStorage.getItem("drop")) {
        drop_location = localStorage.getItem("drop")?.split(",");
    } else {
        return false;
    }
    let directionsService = new google.maps.DirectionsService();
    // Create route from existing points used for markers
    const route = {
        origin: {
            lat: parseFloat(branch_location[0]),
            lng: parseFloat(branch_location[1]),
        },
        destination: {
            lat: parseFloat(drop_location[0]),
            lng: parseFloat(drop_location[1]),
        },
        travelMode: "DRIVING",
    };
    directionsService.route(route, function (response, status) {
        // anonymous function to capture directions
        if (status !== "OK") {
            window.alert("Directions request failed due to " + status);
            return;
        } else {
            distance = response.routes[0].legs[0].distance.value;
            shipping_fee = Math.ceil(distance / 1000) * price_per_kilo;
            if (distance > maximum * 1000) {
                clearLocationDrop();
            }
            setPriceShow();
        }
    });
}

function setPriceShow() {
    const currency = document.getElementById("currency").value
    shipped.innerText = shipping_fee + " " + currency;
    total.innerText =
        parseInt(subtotal.getAttribute("data")) + shipping_fee + " " + currency;
    totalb.innerText =
        parseInt(subtotal.getAttribute("data")) + shipping_fee + " " + currency;
}

function clearLocationDrop() {
    Swal.fire({
        position: "center",
        icon: "error",
        title: "Out of distance.",
        text: "Please contact line support to use services.",
        width: 400,
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "gray",
        confirmButtonText: "Show contact",
        cancelButtonText: "Close",
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: "Scan QRcode.",
                text: "or add line @mananicafe",
                imageUrl: "/images/line/qrcode-line-manami.png",
                imageWidth: 200,
                imageHeight: 200,
                imageAlt: "Custom image",
                confirmButtonColor: "#3085d6",
                width: 400,
            });
        }
    });
    localStorage.setItem("drop", "");
    localStorage.setItem("drop_address", "");
    getLocationData();
    shipping_fee = 0;
    setPriceShow();
}

window.initMap = initMap;

getLocationData();
