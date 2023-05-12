function orderDetailWashNdryPage() {
    window.location.href = "/profile/orderhistory/orderdetailwash&dry";
}

function orderDetailVendingNcafePage() {
    window.location.href = "/profile/orderhistory/orderdetailvending&cafe";
}

function onOrderDetail(ordersNumber) {
    window.location.href = `/profile/orderhistory/detail?order_numb=${ordersNumber}`;
}
