window.addEventListener("DOMContentLoaded", () => {
    const incButton = document.getElementById("increment-button");
    const decButton = document.getElementById("decrement-button");
    let ticketsElement = document.getElementById("quantity-input");
    let ticketElement = document.getElementById("number");
    let priceElement = document.getElementById("price");
    let price = 0;

    incButton.addEventListener("click", () => {
        let tickets = ticketsElement.value;
        if (tickets == 20) {
            Swal.fire({
                title: "Error",
                icon: "error",
                confirmButtonText: "Ok",
                html: "You have reached the maximum number of places allowed.",
            });
        } else {
            tickets = ++tickets;
            price = 250 * tickets;
            ticketElement.innerHTML = tickets;
            priceElement.innerHTML = price;
        }
    });

    decButton.addEventListener("click", () => {
        let tickets = ticketsElement.value;

        if (!(tickets == 0)) {
            --tickets;
            price = 250 * tickets;
            ticketElement.innerHTML = tickets;
            priceElement.innerHTML = price;
        }
    });
});
