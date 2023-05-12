function showPassword() {
    password = document.getElementById("password");
    if (password.value !== "" && password.type === "password") {
        password.type = "text";
    } else {
        password.type = "password";
    }
}

function showConfirm() {
    confirm = document.getElementById("confirm");
    if (confirm.value !== "" && confirm.type === "password") {
        confirm.type = "text";
    } else {
        confirm.type = "password";
    }
}

function signUpApi() {
    let data = {
        name: document.querySelector("#name").value,
        email: document.querySelector("#email").value,
        lineId: document.querySelector("#line").value,
        phone: document.querySelector("#phone").value,
        password: document.querySelector("#password").value,
        c_password: document.querySelector("#confirm").value,
    };

    axios
        .post("/api-member/member/register", data)
        .then((res) => {
            Swal.fire({
                position: "center",
                icon: "success",
                title: "Sign up successfully.",
                showConfirmButton: false,
                width: 400,
                timer: 1500,
            }).then(() => {
                localStorage.clear();
                window.location.href = "/auth/auth-login";
            });
        })
        .catch((err) => {
            console.log(err);
            Swal.fire({
                position: "center",
                icon: "error",
                title: err.response.data.errorMessage.email,
                showConfirmButton: false,
                width: 400,
                // timer: 1500,
            });
        });
}

function onSignUp() {
    let errorArr = [];
    const validEmail = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
    const passReg = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
    const policy = document.getElementById("policy");

    const element = {
        name: document.querySelector("#name"),
        email: document.querySelector("#email"),
        phone_number: document.querySelector("#phone"),
        password: document.querySelector("#password"),
        confirm_password: document.querySelector("#confirm"),
    };
    Object.keys(element).forEach((key, index) => {
        if (element[key].value === "") {
            if (key === "phone_number") {
                errorArr.push(`Please enter phone number`);
            } else if (key === "confirm_password") {
                errorArr.push(`Please enter confirm password`);
            } else {
                errorArr.push(`Please enter ${key}`);
            }
            element[key].classList.add("error");
        } else {
            element[key].classList.remove("error");
        }
    });
    if (element.email.value.match(validEmail)) {
        element.email.classList.remove("error");
    } else {
        element.email.classList.add("error");
        errorArr.push(" Your email is incorrect!");
    }

    if (!element.password.value.match(passReg)) {
        element.password.classList.add("error");
        errorArr.push(
            "The password must be at least 8 characters, at least one letter and one number"
        );
    } else {
        element.password.classList.remove("error");
    }

    if (element.confirm_password.value !== element.password.value) {
        element.confirm_password.classList.add("error");
        errorArr.push("The password and confirm password must match");
    } else {
        element.confirm_password.classList.remove("error");
    }

    if (errorArr.length !== 0) {
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Invalid params",
            text: errorArr[0],
            showConfirmButton: true,
            width: 400,
        });
        return false;
    }

    if (!policy.checked) {
        policy.classList.add("error");
        return false;
    } else {
        policy.classList.remove("error");
    }

    signUpApi();
}

function inputEmpty(el) {
    if (el.value === "") {
        el.classList.add("error");
    } else {
        el.classList.remove("error");
    }
}

function emailValid(el) {
    let validEmail = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;

    if (el.value.match(validEmail)) {
        el.classList.add("valid");
    } else {
        el.classList.remove("valid");
        el.classList.add("error");
    }
}
