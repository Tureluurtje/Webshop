

function toggleButton(x) {
    x.classList.toggle("change");
}

function myFunction(id) {
    setTimeout(function() {
        document.getElementById(id).classList.toggle("visible");
    }, 500);
};
function toggle(x, id) {
    toggleButton(x);
    myFunction(id);
}
