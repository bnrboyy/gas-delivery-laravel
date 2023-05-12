function drop(_order_number, _product_id, _cart_number) {
let params = {
    'orders_number': _order_number,
    'product_id': _product_id,
    'cart_number': _cart_number
}

console.log(params);
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
                onRemoveItem(params);
            });
        }
    });
}

function onRemoveItem(_params) {
    axios.post('/api-member/order/temp/food/delete', _params).then(() => {
        window.location.reload();
    }).catch((err) => {
        console.log(err);
        return false;
    });
}

function foodNdrinkPage() {
    window.location.href = "/foods/menu";
}

function confirmCart() {
    axios
        .post(`/api-member/order/foodtemp/confirm`)
        .then((response) => {
            location.href = "/foods/payment";
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
                    window.location.href = "/foods";
                });
            } else if (response.status === 401) {
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

function minusQuantity(_order_number, _product_id, _quantity, _cart_number) {
    if (_quantity === 1) return false;
    const _data = {
        orders_number: _order_number,
        product_id: _product_id,
        quantity: _quantity - 1,
        cart_number: _cart_number,
    };
    updateQuantityProduct(_data);
}

function plusQuantity(_order_number, _product_id, _quantity, _cart_number) {
    const _data = {
        orders_number: _order_number,
        product_id: _product_id,
        quantity: _quantity + 1,
        cart_number: _cart_number,
    };
    updateQuantityProduct(_data);
}

async function updateQuantityProduct(param) {
    axios
        .post(`/api-member/order/food/updatecart`, param)
        .then((response) => {
            location.reload();
        })
        .catch(({ response }) => {
            Swal.fire({
                position: "center",
                icon: "error",
                title: "Something went wrong.",
                text: response.description,
                showConfirmButton: true,
                width: 400,
            });
            return false;
        });
}
