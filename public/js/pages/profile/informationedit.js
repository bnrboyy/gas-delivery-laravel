function editInfo() {
    const input = document.querySelector(".editinfo-item-form input");
    if (input.value !== "") {
      Swal.fire({
          position: "center",
          icon: "success",
          title: "Edit successful.",
          showConfirmButton: false,
          width: 400,
          timer: 1000,
      });
      setTimeout(() => {
        window.location.href = "/profile/information";
      }, 1000);
    } else {
      Swal.fire({
          position: "center",
          icon: "error",
          title: "Edit failed.",
          text: "Something went wrong.",
          showConfirmButton: false,
          width: 400,
          timer: 1000,
      });
    }
}

function infoPage() {
  window.location.href = "/profile/information";
}