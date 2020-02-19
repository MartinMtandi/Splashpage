$(document).ready(function() {
    $("#splash-form").validate({
        rules: {
            firstname: {
                required: true,
                minlength: 4
            }
        },
        submitHandler: function(form) {
            // for demo
            alert("valid form submitted"); // for demo
            return false; // for demo
        }
    });
});
