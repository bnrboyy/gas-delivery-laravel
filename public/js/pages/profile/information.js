function discard() {
    const btnChangePassword = document.querySelector(".info-item-btnpassword");
    const changePassword = document.querySelector(".info-item-password");
    const inputs = document.querySelectorAll(".info-item-password-group input");
    inputs.forEach((el) => (el.value = ""));
    btnChangePassword.style.display = "flex";
    changePassword.style.display = "none";
}

async function newPassword(_id) {
    const passReg = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
    const currentPw = document.querySelector("#current");
    const newPw = document.querySelector("#newPassword");
    const confirmPw = document.querySelector("#confirmNewPassword");

    if (currentPw.value === "") {
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Invalid input",
            text: "Please enter current password",
            showConfirmButton: true,
            width: 400,
        }).then(() => {
            currentPw.classList.add("error");
        });
        return false;
    }

    if (!newPw.value.match(passReg)) {
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Invalid input",
            text: "The new password must be at least 8 characters, at least one letter and one number",
            showConfirmButton: true,
            width: 400,
        }).then(() => {
            newPw.classList.add("error");
        });
        return false;
    }

    if (confirmPw.value !== newPw.value) {
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Invalid input",
            text: "The new password and confirm password must match",
            showConfirmButton: true,
            width: 400,
        }).then(() => {
            confirmPw.classList.add("error");
        });
        return false;
    }
    let input = {
        current_password: document.getElementById("current").value,
        new_password: document.getElementById("newPassword").value,
        c_password: document.getElementById("confirmNewPassword").value,
    };

    const response = await axios
        .post(`/api-member/profile/password/update/${_id}`, input)
        .then((res) => {
            Swal.fire({
                position: "center",
                icon: "success",
                title: "Complete.",
                text: res.data.description,
                showConfirmButton: true,
                width: 400,
            }).then(() => {
                location.reload();
            });
        })
        .catch((err) => {
            Swal.fire({
                position: "center",
                icon: "error",
                title: "Invalid input",
                text: "Current password is incorrect!",
                showConfirmButton: true,
                width: 400,
            }).then(() => {
                currentPw.classList.add("error");
            });
            return false;
        });
}

const upload = document.querySelector(".info-item-profile-frame-image");
const image = document.querySelector(".info-item-profile-frame-image img");
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

function showChangePassword() {
    const btnChangePassword = document.querySelector(".info-item-btnpassword");
    const changePassword = document.querySelector(".info-item-password");
    btnChangePassword.style.display = "none";
    changePassword.style.display = "flex";
}

function saveInfo() {
    Swal.fire({
        position: "center",
        icon: "success",
        title: "Changed successful.",
        showConfirmButton: false,
        width: 400,
        timer: 1000,
    });
    setTimeout(() => {
        window.location.reload();
    }, 1000);
}

function showInput(e) {
    el = e.closest(".input-group").querySelector("input");
    el.removeAttribute("disabled");
    el.focus();
}

function onBlurFunction(e) {
    e.setAttribute("disabled", "true");
}

// localStorage.removeItem("pickup_address");
if (localStorage.getItem("pickup_address") !== null) {
    document.querySelector("#address").innerHTML =
        localStorage.getItem("pickup_address");
}

async function onUpdateProfile(_id) {
    let formData = new FormData();
    formData.append("member_name", document.querySelector("#name").value);
    formData.append("email", document.querySelector("#email").value);
    formData.append("line_id", document.querySelector("#line").value);
    formData.append("phone_number", document.querySelector("#phone").value);
    formData.append("address", localStorage.getItem("pickup_address"));
    formData.append("address_location", localStorage.getItem("pickup"));
    if (inputFile.files.length > 0) {
        formData.append("profile_image[]", inputFile.files[0]);
    }

    const response = await axios
        .post(`/api-member/profile/update/${_id}`, formData)
        .then((res) => {
            Swal.fire({
                position: "center",
                icon: "success",
                title: "Complete.",
                text: res.data.description,
                showConfirmButton: true,
                width: 400,
            }).then(() => {
                location.reload();
            });
        })
        .catch((err) => {
            Swal.fire({
                position: "center",
                icon: "error",
                title: "Something went wrong.",
                text: err.response.data.description,
                showConfirmButton: true,
                width: 400,
            });
            return false;
        });
}

function nextPage(_id) {
    let errorArr = [];
    let validEmail = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
    const element = {
        name: document.querySelector("#name"),
        phone: document.querySelector("#phone"),
        email: document.querySelector("#email"),
    };

    const inputVal = {
        name: element.name.value,
        phone: element.phone.value,
        email: element.email.value,
    };

    if (inputVal.name === "") {
        element.name.classList.add("error");
        errorArr.push(" Please enter your name");
    } else {
        element.name.classList.remove("error");
    }

    if (inputVal.phone === "") {
        element.phone.classList.add("error");
        errorArr.push(" Please enter your phone number");
    } else {
        element.phone.classList.remove("error");
    }

    if (inputVal.email.match(validEmail)) {
        element.email.classList.remove("error");
    } else {
        element.email.classList.add("error");
        errorArr.push(" Your email is incorrect!");
    }

    if (errorArr.length !== 0) {
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Invalid input",
            text: errorArr,
            showConfirmButton: true,
            width: 400,
        });
        return false;
    }

    onUpdateProfile(_id);
}

function inputEmpty(el) {
    if (el.value === "") {
        el.classList.add("error");
    } else {
        el.classList.remove("error");
    }
}

function validateEmail(el) {
    let validEmail = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;

    if (el.value.match(validEmail)) {
        el.classList.add("valid");
    } else {
        el.classList.remove("valid");
        el.classList.add("error");
    }
}
