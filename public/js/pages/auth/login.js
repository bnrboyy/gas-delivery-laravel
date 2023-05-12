function showPassword() {
    password = document.getElementById("password");
    if (password.value !== "" && password.type === "password") {
        password.type = "text";
    } else {
        password.type = "password";
    }
}

function login() {
    let name = document.getElementById("name");
    let password = document.getElementById("password");

    let data = {
        username: name.value,
        password: password.value,
    };

    axios
        .post("/api-member/member/login", data)
        .then(({data}) => {
            localStorage.setItem('is_login', 'true')
            localStorage.setItem('account', JSON.stringify(data.user_name))
            Swal.fire({
                position: "center",
                icon: "success",
                title: "Logged in successfully.",
                showConfirmButton: false,
                width: 400,
                timer: 1500,
            }).then(() => {
                window.location.href = "/";
            });
        })
        .catch((err) => {
            console.log("Error:", err);
            Swal.fire({
                position: "center",
                icon: "error",
                title: "Error",
                text: "Username or password are incorrect!",
                showConfirmButton: true,
                width: 400,
            });
        });

}
