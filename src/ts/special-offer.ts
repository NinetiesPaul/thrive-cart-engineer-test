const deleteSpecialOffer = (specialOfferId: string | number): void => {
    $.ajax({
        url: "/special-offers-delete-ajax/" + specialOfferId,
        type: "DELETE",
        data: { id: specialOfferId },
        success: function (response: string) {
            const parsed = JSON.parse(response) as ApiResponse<unknown>;
            if (parsed.error) {
                console.log("Error: " + parsed.data);
            } else {
                window.location.reload();
            }
        },
    });
};

$(document).ready(function () {
    $(".delete-special-offer").click(function (e: JQuery.ClickEvent) {
        e.preventDefault();
        const specialOfferId = $(this).data("id") as string | number;

        deleteSpecialOffer(specialOfferId);
    });
});
