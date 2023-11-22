//jquery pop up
jQuery(document).ready(function($) {
    //open popup
    $(".change-name").on("click", function(event) {
        event.preventDefault();
        $(".popup").addClass("is-visible");
    });

    //close popup
    $(".popup").on("click", function(event) {
        if (
            $(event.target).is(".popup-close") ||
            $(event.target).is(".popup")
        ) {
            event.preventDefault();
            $(this).removeClass("is-visible");
        }
    });
    //open popup
    $(".members").on("click", function(event) {
        event.preventDefault();
        $(".popup2").addClass("is-visible");
    });

    //close popup
    $(".popup2").on("click", function(event) {
        if (
            $(event.target).is(".popup-close2") ||
            $(event.target).is(".popup2")
        ) {
            event.preventDefault();
            $(this).removeClass("is-visible");
        }
    });

    //close popup when clicking the esc keyboard button
    $(document).keyup(function(event) {
        if (event.which == "27") {
            $(".popup").removeClass("is-visible");
        }
    });

    //counting the current length in input to show
    let textAreaLength = $("#groupTitle").val().length;
    document.getElementById("charactersLeft").innerHTML = textAreaLength;

    //counting the length of group name in input
    $("#groupTitle").on("input", function() {
        let textAreaLength = $(this).val().replace(/\s/g, "").length;
        let maxLength = 10;
        document.getElementById("charactersLeft").innerHTML = textAreaLength;
        document.getElementById("length").innerHTML = maxLength;
        if ($(this).val() === "") {
            $("#saveBtn").prop("disabled", true);
        } else {
            $("#saveBtn").prop("disabled", false);
        }
    });

    //setting as a disabled button if input(title) is empty
    $("#groupTitle").on("keypress", function(e) {
        if (e.keyCode === 13 && $("#groupTitle").val() == "") {
            e.preventDefault();
        }
    });

    const realFileBtn = document.querySelectorAll("#realFile");
    const customBtn = document.querySelectorAll("#customBtn");

    customBtn.forEach((btn) =>
        btn.addEventListener("click", function() {
            realFileBtn.forEach((btn) => btn.click());
        })
    );

});
