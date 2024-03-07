function printError(Id, Msg) {
    document.getElementById(Id).innerHTML = Msg;
}

function validateForm() {
    var username = document.getElementById("name").value;
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
    var repeat = document.getElementById("password_confirmation").value;
    var role = document.getElementById("role").value;

    var userErr = validateName(username);
    var emailErr = validateEmail(email);
    var passwordErr = validatePassword(password);
    var repeatErr = validateRepeat(password, repeat);
    var roleErr = validateRole(role);

    if (userErr && emailErr && passwordErr && repeatErr && roleErr) {
        return true;
    } else return false;
}

function validateName(username) {
    if (username == "" || username == null) {
        printError("nameErr", "Please enter your username");
        return false;
    } else {
        var regex = /^[\w]+(?:\s\w+)*$/;
        if (!regex.test(username)) {
            printError(
                "nameErr",
                "Please enter a valid name (no special chars, double spaces)"
            );
            return false;
        } else {
            printError("nameErr", "");
            return true;
        }
    }
}

function validateEmail(email) {
    if (email == "" || email == null) {
        printError("emailErr", "Please enter your email.");
        return false;
    } else {
        var regex = /^[a-zA-Z0-9]+@[a-z]+\.[a-zA-Z]{2,3}$/;
        if (!regex.test(email)) {
            printError(
                "emailErr",
                "Please enter a valid email (example@gmail.com)"
            );
            return false;
        } else {
            printError("emailErr", "");
            return true;
        }
    }
}

function validatePassword(password) {
    if (password == "" || password == null) {
        printError("passwordErr", "Please enter your password");
        return false;
    } else {
        var regex = /^.{8,}$/;
        if (!regex.test(password)) {
            printError(
                "passwordErr",
                "Password must contain atleast 8 characters"
            );
            return false;
        } else {
            printError("passwordErr", "");
            return true;
        }
    }
}

function validateRepeat(password, repeat) {
    if (repeat == "" || repeat == null) {
        printError("repeatErr", "Please repeat your password");
        return false;
    } else {
        if (password != repeat) {
            printError("repeatErr", "Passwords do not match");
            return false;
        } else {
            printError("repeatErr", "");
            return true;
        }
    }
}

function validateRole(role) {
    if (role == "" || role == null) {
        printError("roleErr", "Please choose a role");
        return false;
    } else {
        printError("roleErr", "");
        return true;
    }
}

function keydownValidation() {
    var username = document.getElementById("name");
    var email = document.getElementById("email");
    var password = document.getElementById("password");
    var repeat = document.getElementById("password_confirmation");
    var role = document.getElementById("role");

    email.addEventListener("input", function () {
        validateEmail(email.value);
    });
    password.addEventListener("input", function () {
        validatePassword(password.value);
    });
    username.addEventListener("input", function () {
        validateName(username.value);
    });
    repeat.addEventListener("input", function () {
        validateRepeat(password.value, repeat.value);
    });
    role.addEventListener("input", function () {
        validateRole(role.value);
    });
}

function initValidation() {
    var username = document.getElementById("name");
    var email = document.getElementById("email");
    var password = document.getElementById("password");
    var repeat = document.getElementById("password_confirmation");
    var role = document.getElementById("role");

    email.addEventListener("blur", function () {
        validateEmail(email.value);
    });
    password.addEventListener("blur", function () {
        validatePassword(password.value);
    });
    repeat.addEventListener("blur", function () {
        validateRepeat(password.value, repeat.value);
    });
    username.addEventListener("blur", function () {
        validateName(username.value);
    });
    role.addEventListener("blur", function () {
        validateRole(role.value);
    });
}

keydownValidation();
// initValidation();

document.addEventListener("DOMContentLoaded", function () {
    var form = document.getElementById("register_form");
    form.addEventListener("submit", function (event) {
        if (!validateForm()) {
            event.preventDefault();
        }
    });
});
