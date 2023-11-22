const sideMenu = document.querySelector("aside");
const menuBtn = document.querySelector("#menu-btn");
const closeBtn = document.querySelector("#close-btn");
const themeToggler = document.querySelector(".slider");

//SHOW SIDEBAR
menuBtn.addEventListener("click", () => {
    sideMenu.style.display = "block";
});
window.onresize = function(event) {
    sideMenu.style.display = "block";
};

//CLOSE SIDEBAR
closeBtn.addEventListener("click", () => {
    sideMenu.style.display = "none";
});

//CHANGE THEME
const checkbox = document.querySelector(".checkbox");

themeToggler.addEventListener("click", () => {
    document.body.classList.toggle("dark-theme-variables");
    let theme;
    if (document.body.classList.contains("dark-theme-variables")) {
        theme = "dark";
    } else {
        theme = "light";
    }

    //save to localstorage /*uses to prevent theme on reload*/
    localStorage.setItem("PageTheme", JSON.stringify(theme));
});

//getting the data for theme from local storage
const getTheme = JSON.parse(localStorage.getItem("PageTheme"));
//console.log(getTheme);
if (getTheme == "dark") {
    document.body.classList = "dark-theme-variables";
    checkbox.checked = true;
}