window.addEventListener("DOMContentLoaded", () => {
    let form = document.getElementById("event_form");
    let max = document
        .getElementById("quantity-input")
        .getAttribute("data-input-counter-max");
    const incButton = document.getElementById("increment-button");
    const decButton = document.getElementById("decrement-button");
    let ticketsElement = document.getElementById("quantity-input");
    let ticketElement = document.getElementById("number");
    let priceElement = document.getElementById("price");
    let price = 0;
    form.addEventListener("submit", (event) => {
        let tickets = ticketsElement.value;
        if (tickets == 0) {
            event.preventDefault();
        }
    });

    incButton.addEventListener("click", () => {
        let tickets = ticketsElement.value;
        if (tickets == max) {
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
