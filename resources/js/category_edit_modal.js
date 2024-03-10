import "./bootstrap";

import "flowbite";

import { Modal } from "flowbite";

let element = document.getElementById("edit-modal");

const modal = new Modal(element);

window.openEditModal = function (id, name) {
    document.getElementById("edit_form").action =
        "http://127.0.0.1:8000/dashboard/categories/" + id;

    document.getElementById("edit_name").value = name;

    modal.show();
};
