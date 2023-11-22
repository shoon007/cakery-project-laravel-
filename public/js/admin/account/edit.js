const realFileBtn = document.querySelectorAll("#real-file");
const customBtn = document.querySelectorAll("#custom-button");
const customTxt = document.getElementById("custom-text");

//custom input file choose
customBtn.forEach((btn) =>
    btn.addEventListener("click", function() {
        realFileBtn.forEach((btn) => btn.click());
        document.getElementById("name").focus();
    })
);

realFileBtn.forEach((file) =>
    file.addEventListener("change", function() {
        if (file.value) {
            customTxt.innerHTML = file.value.match(
                /[\/\\]([\w\d\s\.\-\(\)]+)$/
            )[1];

            document.getElementById("name").focus();
        } else {
            customTxt.innerHTML = "No file chosen, yet.";
        }
    })
);

$("#textarea").keydown(function(e) {
    // Enter pressed
    if (e.keyCode == 13) {
        //method to prevent from default behaviour
        e.preventDefault();
    }
});