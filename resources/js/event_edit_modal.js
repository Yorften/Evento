import "./bootstrap";

import "flowbite";

import { Modal } from "flowbite";

let element = document.getElementById("edit-modal");

const modal = new Modal(element);

window.openEditModal = function (id, title, overview, genres, actors) {
    let select_genres = document.getElementById("genres_edit").options;
    let select_actors = document.getElementById("actors_edit").options;

    document.getElementById("edit_form").action =
        "http://127.0.0.1:8000/dashboard/films/edit/" + id;
    document.getElementById("title_edit").value = title;
    document.getElementById("overview_edit").innerText = overview;

    Array.from(select_actors).forEach(function (option) {
        option.selected = false;
        if (actors.includes(parseInt(option.value))) {
            option.selected = true;
        }
    });

    Array.from(select_genres).forEach(function (option) {
        option.selected = false;
        if (genres.includes(parseInt(option.value))) {
            option.selected = true;
        }
    });
    select_genres_fun();
    select_actors_fun();

    modal.show();
};
