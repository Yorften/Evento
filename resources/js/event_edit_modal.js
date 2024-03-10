import "./bootstrap";

import "flowbite";

import { Modal } from "flowbite";

let element = document.getElementById("edit-modal");

const modal = new Modal(element);

window.openEditModal = function (id, title, category, description, date, location, capacity, auto) {
    let jsDate = new Date(date);
    jsDate = jsDate.toISOString().slice(0, -5);
    document.getElementById("edit_form").action = "http://127.0.0.1:8000/organizer/dashboard/events/" + id;

    document.getElementById("edit_title").value = title;
    document.getElementById("edit_categories").value = category;
    document.getElementById("edit_description").innerText = description;
    document.getElementById("edit_capacity").value = capacity;
    document.getElementById("edit_location").value = location;
    document.getElementById("edit_date").value = jsDate;
    

    document.getElementById("edit_mode").value = auto;


    select_categories_fun();

    modal.show();
};
