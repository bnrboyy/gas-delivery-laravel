function removeFromCart(_orders_number, _page_id, _cart_number) {
    const param = {
        orders_number: _orders_number,
        page_id: _page_id,
        cart_number: _cart_number
    };
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        width: 400,
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: "Deleted!",
                text: "Your order has been deleted.",
                icon: "success",
                width: 400,
            }).then(() => {
                onRemoveCart(param);
            });
        }
    });
}

function onRemoveCart(_param) {
    axios
        .post(`/api-member/order/temp/delete`, _param)
        .then((response) => {
            location.reload();
        })
        .catch(({ response }) => {
            console.log(response);
        });
}

function wadPage() {
    window.location.href = "/washing/wash";
}

function ordersumPage() {
    axios
        .post(`/api-member/order/temp/confirm`)
        .then((response) => {
            location.href = "/washing/payment";
        })
        .catch(({ response }) => {
            if (response.status === 301) {
                Swal.fire({
                    position: "center",
                    icon: "info",
                    title: "Order not found.",
                    text: response.description,
                    showConfirmButton: true,
                    width: 400,
                }).then(() => {
                    window.location.href = "/washing";
                });
            } else if(response.status === 401) {
                Swal.fire({
                    position: "center",
                    icon: "info",
                    title: "Please Login.",
                    text: response.description,
                    showConfirmButton: true,
                    width: 400,
                }).then(() => {
                    window.location.href = "/auth/auth-login";
                });
            } else {
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "Something went wrong.",
                    // text: response.description,
                    showConfirmButton: true,
                    width: 400,
                });
                return false;
            }
        });
}
