function signOut() {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        width: 400,
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, sign out!",
    }).then((result) => {
        console.log(result.isConfirmed);
        if (result.isConfirmed) {
            axios
                .get("/api-member/member/logout")
                .then((response) => {
                    console.log(response);
                    Swal.fire({
                        title: "Success!",
                        text: "Signing out.",
                        icon: "success",
                        width: 400,
                        showConfirmButton: false,
                        timer: 1500,
                    }).then(() => {
                        window.location.href = "/auth/auth-login";
                    });
                })
                .catch((err) => {
                    console.log(err);
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "Something went wrong.",
                        text: err.response.data.description,
                        showConfirmButton: true,
                        width: 400,
                    });
                });
        }
        return false;
    });
}

function infoPage() {
    window.location.href = "/profile/information";
}

function orderhistoryPage() {
    window.location.href = "/profile/orderhistory";
}

function homePage() {
    window.location.href = "/";
}
