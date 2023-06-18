const drop_address = localStorage.getItem("drop_address");
const drop_details = document.querySelector(".detail-drop-address p");
const drop_details_more = document.getElementById("address");
const map = document.querySelector(".map");

const memberName = document.getElementById("name");
const phone = document.getElementById("phone");
const second_phone = document.getElementById("second-phone");

const radio_cash = document.getElementById("radio-cash");
const radio_tranfer = document.getElementById("radio-tranfer");
const upload_slip = document.querySelector(".upload-slip");
const bank_id = document.getElementById("bank-id");

// var date = new Date().toISOString().slice(0, 10);
// var timeNow = new Date().toLocaleTimeString().slice(0, 7);
// var dateTime = date + " " + timeNow;

var now2 = new Date();
var year = now2.getFullYear();
var month = (now2.getMonth() + 1).toString().padStart(2, "0");
var day = now2.getDate().toString().padStart(2, "0");
var hour = now2.getHours().toString().padStart(2, "0");
var minute = now2.getMinutes().toString().padStart(2, "0");
var datetime2 = year + "-" + month + "-" + day + "T" + hour + ":" + minute;


const total_price_product = document
    .querySelector(".total-price-product")
    .getAttribute("total-price-product");
const maximum = parseInt(
    document.querySelector(".web-info").getAttribute("maximum-radius")
);
const delivery_price = parseInt(
    document.querySelector(".web-info").getAttribute("delivery-price")
);
const price_per_kilo = parseInt(
    document.querySelector(".web-info").getAttribute("price-per-kilo")
);
let distance = 0;
let radius = 0;
let shipping_fee = 0;

localStorage.setItem("payment_type", "cash");

function paymentType() {
    if (radio_tranfer.checked) {
        upload_slip.classList.add("active");
        localStorage.setItem("payment_type", "transfer");
    } else {
        upload_slip.classList.remove("active");
        localStorage.setItem("payment_type", "cash");
    }
}

function copyBankId() {
    bank_id.select();
    bank_id.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(bank_id.value);
}

drop_details.innerHTML = drop_address
    ? drop_address.substring(0, 40) + ". . . "
    : "";

/* Upload Slip */

const inputFile = document.createElement("input");
inputFile.type = "file";
inputFile.setAttribute("accept", "image/png, image/gif, image/jpeg");

const slip_area = document.querySelector(".slip-area");

slip_area.addEventListener("click", () => {
    inputFile.click();
});

inputFile.addEventListener("change", () => {
    const reader = new FileReader();
    reader.onload = (e) => {
        slip_area.querySelector("figure img").src = e.target.result;
    };
    reader.readAsDataURL(inputFile.files[0]);
    slip_area.querySelector("figure").style.width = "100%";
    slip_area.querySelector("figure").style.height = "auto";
    // slip_area.querySelector("figure img").style.opacity = "1";
});

/* End upload slip */

function confirmOrder() {
    let errorArr = [];

    const orders = {
        drop_address: drop_address,
        drop_detail: drop_details_more.value,
        member_name: memberName.value,
        phone: phone.value,
        second_phone: second_phone.value,
        payment_type: localStorage.getItem("payment_type"),
        slip_image: inputFile.files,
    };

    if (!drop_address) {
        map.classList.remove("border-black");
        map.classList.add("border-red-500");
        errorArr.push("โปรดเลือกที่อยู่ในการจัดส่ง");
    } else {
        map.classList.remove("border-red-500");
        map.classList.add("border-black");
    }

    if (memberName.value === "") {
        memberName.classList.add("border", "border-red-500");
        errorArr.push("โปรดกรอกชื่อ");
    } else {
        memberName.classList.remove("border", "border-red-500");
    }

    if (phone.value === "") {
        phone.classList.add("border", "border-red-500");
        errorArr.push("โปรดกรอกเบอร์โทรศัพท์");
    } else {
        phone.classList.remove("border", "border-red-500");
    }

    if (orders.payment_type === "transfer") {
        if (orders.slip_image.length === 0) {
            errorArr.push("โปรดอัพโหลดสลิป");
        }
    }

    if (errorArr.length > 0) {
        Swal.fire({
            title: errorArr[0],
            icon: "info",
            focusConfirm: false,
        }).then(() => {
            return false;
        });
    } else {
        localStorage.setItem('phone_number', orders.phone);
        saveOrder(orders);
    }
}

async function saveOrder(_orders) {
    let formData = new FormData();
    formData.append("drop_location", localStorage.getItem("drop"));
    formData.append("drop_address", _orders.drop_address);
    formData.append("drop_address_detail", _orders.drop_detail);
    formData.append("customer_name", _orders.member_name);
    formData.append("phone_number", _orders.phone);
    formData.append("second_phone_number", _orders.second_phone);
    formData.append("payment_type", _orders.payment_type);
    formData.append("second_phone_number", _orders.second_phone);
    formData.append("distance", (distance / 1000).toFixed(2));
    formData.append("total_price", total_price_product);
    formData.append("delivery_price", shipping_fee);
    formData.append("transaction_date", datetime2);

    if (_orders.payment_type === "transfer") {
        formData.append("slip_image[]", _orders.slip_image[0]);
    }

    const response = await axios.post("/order/confirmorder", formData);
    const phone_number = localStorage.getItem("phone_number")

    if (response.data.status) {
        Swal.fire({
            position: "center",
            icon: "success",
            title: "สั่งสินค้าสำเร็จ",
            showConfirmButton: false,
            timer: 2500,
        }).then(() => {
            window.location.href = `/searchorder?phone=${phone_number}`;
        });
    } else {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Something went wrong!",
        });
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
            radius = getRadius(
                route.origin.lat,
                route.origin.lng,
                route.destination.lat,
                route.destination.lng
            );
            if (Math.round(distance) <= maximum * 1000) {
                shipping_fee = delivery_price;
            } else {
                shipping_fee =
                    delivery_price +
                    Math.ceil((distance - maximum * 1000) / 1000) *
                        price_per_kilo;
            }
            if (radius > maximum * 1000) {
                clearLocationDrop();
            }
            setPriceShow();
        }
    });
}

/* get Distance */
function getRadius(_lat1, _lng1, _lat2, _lng2) {
    let distance =
        2 *
        6371000 *
        Math.asin(
            Math.sqrt(
                Math.pow(
                    Math.sin(
                        (_lat2 * (3.14159 / 180) - _lat1 * (3.14159 / 180)) / 2
                    ),
                    2
                ) +
                    Math.cos(_lat2 * (3.14159 / 180)) *
                        Math.cos(_lat1 * (3.14159 / 180)) *
                        Math.sin(
                            Math.pow(
                                (_lng2 * (3.14159 / 180) -
                                    _lng1 * (3.14159 / 180)) /
                                    2,
                                2
                            )
                        )
            )
        );
    return distance;
}

function clearLocationDrop() {
    Swal.fire({
        position: "center",
        icon: "error",
        title: "นอกพื้นที่บริการ",
        text: "โปรดปักหมุดให้อยู่ในบริเวรรัศมีที่ให้บริการ",
        width: 400,
    }).then(() => {
        localStorage.setItem("drop", "");
        localStorage.setItem("drop_address", "");
        shipping_fee = 0;
        window.location.reload();
    });
    // getLocationData();
    setPriceShow();
}

function setPriceShow() {
    const shipped = document.querySelector(".delivery-price span");
    const distanceShow = document.querySelector(".delivery-price p");
    const total_price_show = document.querySelector(".total-price");
    const tt = total_price_show.getAttribute("total-price");
    let distanceText = (distance / 1000).toFixed(2);

    distanceShow.innerHTML = "ค่าจัดส่ง " + `(ประมาณ ${distanceText} Km. )`;
    shipped.innerText = shipping_fee + " " + "บาท";
    total_price_show.innerHTML = parseInt(tt) + shipping_fee + " " + "บาท";
}

setPriceShow();

window.initMap = initMap;
