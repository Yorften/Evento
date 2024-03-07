const incButton = document.getElementById("increment-button");
const decButton = document.getElementById("decrement-button");
let price = 0;
incButton.addEventListener("click", () => {
    let tickets = document.getElementById("quantity-input").value;
    let ticketElement = document.getElementById("number");
    let priceElement = document.getElementById("price");
    if (tickets == 20) {
        Swal.fire({
            title: "Error",
            icon: "error",
            confirmButtonText: "Ok",
            html: "You have reached the maximum number of places allowed.",
        });
    } else {
        price += 250;
        console.log(price);
        ticketElement.innerHTML = ++tickets;
        priceElement.innerHTML = price;
    }
});

decButton.addEventListener("click", () => {
    let tickets = document.getElementById("quantity-input").value;
    let ticketElement = document.getElementById("number");
    let priceElement = document.getElementById("price");
    if (!(tickets == 0)) {
        price -= 250;
        ticketElement.innerHTML = --tickets;
        priceElement.innerHTML = price;
    }
});
