window.addEventListener("DOMContentLoaded", () => {
    const urlParams = new URLSearchParams(window.location.search);
    const categoryId = urlParams.get("category");

    const input = document.getElementById("default-search");
    const searchForm = document.getElementById("search-form");

    searchForm.addEventListener("submit", (e) => {
        e.preventDefault();
        let title = input.value;
        if (categoryId == null) {
            let url = `http://localhost:8000/events?title=${title}`;
            window.location = url;
        }else{
            let url = `http://localhost:8000/events?category=${categoryId}&title=${title}`;
            window.location = url;
        }
    });
});
