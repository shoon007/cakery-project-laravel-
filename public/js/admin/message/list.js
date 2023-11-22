/*The info or settings about chat */
const setting = document.querySelector(".chat-setting");
const settingIcon = document.querySelector(".setting");
settingIcon.addEventListener("click", () => {
    if (setting.style.display == "none") {
        setting.style.display = "block";
    } else {
        setting.style.display = "none";
    }
});

/* Delete the sent message */
function toggleDelete(id) {
    var button = document.querySelectorAll("#delete-" + id);
    button.forEach((btn) => {
        if (btn.style.display == "none") {
            btn.style.display = "block";
        } else {
            btn.style.display = "none";
        }
    });
}

//show delete icon for different id
function toggleImgDelete(id) {
    var button = document.querySelectorAll("#deleteImg-" + id);

    button.forEach((btn) => {
        if (btn.style.display == "none") {
            btn.style.display = "block";
        } else {
            btn.style.display = "none";
        }
    });
}

/* The custom input file */
Array.prototype.forEach.call(
    document.querySelectorAll(".file-upload__button"),
    function(button) {
        const hiddenInput = button.parentElement.querySelector(
            ".file-upload__input"
        );
        const label = button.parentElement.querySelector(".file-upload__label");
        const defaultLabelText = "No file(s) selected";

        // Set default text for label
        label.textContent = defaultLabelText;
        label.title = defaultLabelText;

        button.addEventListener("click", function() {
            hiddenInput.click();
        });

        hiddenInput.addEventListener("change", function() {
            const filenameList = Array.prototype.map.call(
                hiddenInput.files,
                function(file) {
                    return file.name;
                }
            );
            label.textContent = filenameList.join(", ") || defaultLabelText;
            label.title = label.textContent;
        });
    }
);

/* Show send button only when there's a text or an image */
const sendBtn = document.querySelector("#sendBtn");
const inputBox = document.querySelector("#inputBox");

inputBox.addEventListener("input", () => {
    // console.log(inputBox.value.replace(/\s+/g, '').length)
    //checking if there's text or not in input form
    if (inputBox.value.replace(/\s+/g, "").length > 0) {
        sendBtn.style.display = "inline-block";
    } else {
        if (fileInput.value == "") {
            sendBtn.style.display = "none";
        }
    }
});

/*not submitting form when input is empty */
inputBox.addEventListener("keypress", function(e) {
    if (e.keyCode === 13 && inputBox.value == "" && fileInput.value == "") {
        e.preventDefault();
    }
});

/* The preview img before sending to different users */
const preview = document.querySelector(".preview");
const fileInput = document.querySelector("#myFile");
const previewDelete = document.querySelector("#preview-delete");
fileInput.addEventListener("change", function() {
    preview.style.display = "block";
    inputBox.focus();
    sendBtn.style.display = "inline-block";
});
previewDelete.addEventListener("click", () => {
    preview.style.display = "none";
    inputBox.focus();
    fileInput.value = "";
    sendBtn.style.display = "none";
    if (inputBox.value.replace(/\s+/g, "").length > 0) {
        sendBtn.style.display = "inline-block";
    }
});

//scrolling to the last messages of the chat box as soon as the loading is done
const element = document.getElementById("element");
element.scrollTo({ top: element.scrollHeight, behavior: "instant" });