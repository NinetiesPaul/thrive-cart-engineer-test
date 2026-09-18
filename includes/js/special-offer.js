deleteSpecialOffer = (specialOfferId) => {
    $.ajax({
        url: "/special-offers-delete-ajax/" + specialOfferId,
        type: "DELETE",
        data: { id: specialOfferId },
        success: function(response) {
            response = JSON.parse(response);
            if (response.error) {
                console.log("Error: " + response.data);
            } else {
                window.location.reload();
            }
        }
    });
}

$(document).ready(function(){

    $(".delete-special-offer").click(function(e){
        e.preventDefault();
        var specialOfferId = $(this).data("id");

        deleteSpecialOffer(specialOfferId);
    });

});
