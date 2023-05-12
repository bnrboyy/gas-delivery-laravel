function resetPassword() {
    const validEmail = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
    let email = document.getElementById("email");
    const data = {
        email: email.value,
    };
    if (email.value === "" || !email.value.match(validEmail)) {
        Swal.fire({
            position: "center",
            icon: "error",
            text: "Your email is incorrect.",
            showConfirmButton: true,
            width: 400,
        }).then(() => {
            email.classList.add("error");
            return false;
        });
    } else {
        axios
            .post("/api-member/member/forget-password", data)
            .then((response) => {
                console.log(response);
                Swal.fire({
                    position: "center",
                    icon: "success",
                    text: "We have e-mailed your password reset link! Please check your email.",
                    showConfirmButton: true,
                    width: 400,
                }).then(() => {
                    window.location.reload();
                });
            })
            .catch((err) => {
                Swal.fire({
                    position: "center",
                    icon: "error",
                    text: "Your email is incorrect.",
                    showConfirmButton: true,
                    width: 400,
                }).then(() => {
                    window.location.reload();
                });
            });
    }
}

function validatePassword() {
    const passReg = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
    const queryString = window.location.search;
    const paramToken = new URLSearchParams(queryString);
    const token = paramToken.get("token");
    let errorArr = [];

    const el = {
        password: document.querySelector("#new-password"),
        c_password: document.querySelector("#c-password"),
    };

    if (el.password.value.match(passReg)) {
        el.password.classList.remove("error");
    } else {
        errorArr.push(
            "The password must be at least 8 characters, at least one letter and one number"
        );
        el.password.classList.add("error");
    }

    if (el.c_password.value === el.password.value) {
        el.c_password.classList.remove("error");
    } else {
        errorArr.push("The password and confirm password must match");
        el.c_password.classList.add("error");
    }

    if (errorArr.length !== 0) {
        Swal.fire({
            position: "center",
            icon: "error",
            text: errorArr[0],
            showConfirmButton: true,
            width: 400,
        });
        return false;
    }

    let data = {
        password: el.password.value,
        c_password: el.c_password.value,
        token: token,
    };

    onResetPassword(data);
}

function onResetPassword(_params) {
    axios
        .post("/api-member/member/reset-password", _params)
        .then((res) => {
            console.log(res);
            Swal.fire({
                position: "center",
                icon: "success",
                text: "The new password has been created.",
                showConfirmButton: false,
                width: 400,
                timer: 1500,
            }).then(() => (window.location.href = "/auth/auth-login"));
        })
        .catch(({ response }) => {
            Swal.fire({
                position: "center",
                icon: "error",
                text: response.data.description,
                showConfirmButton: true,
                width: 400,
            });
            window.location.href = "/auth/auth-forgot";
        });
}

function inputEmpty(el) {
    if (el.value === "") {
        el.classList.add("error");
    } else {
        el.classList.remove("error");
    }
}
