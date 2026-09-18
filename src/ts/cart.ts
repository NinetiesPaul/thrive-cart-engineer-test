const updateCartTotal = (): void => {
    $("#cartTableBody").empty();

    let orderTotal = 0;

    for (const cartKey of Object.keys(cart)) {
        let lineTotal = 0.0;
        for (const [, value] of Object.entries(cart[cartKey])) {
            let itemPrice: number | string = value.price;
            if (value.specialOffer < 1) {
                itemPrice = Number(itemPrice) * value.specialOffer;
            }

            itemPrice = String(itemPrice);
            if (itemPrice.indexOf(".") !== -1) {
                itemPrice = itemPrice.substring(0, itemPrice.indexOf(".") + 3);
            }

            lineTotal += parseFloat(itemPrice);
        }
        orderTotal += lineTotal;

        let specialOfferText = "";
        if (Object.keys(itemsOnSpecialOffer).includes(cartKey)) {
            const itemDiscountRate = itemsOnSpecialOffer[cartKey].discountRate * 100;
            specialOfferText =
                itemDiscountRate +
                "% off on every " +
                itemsOnSpecialOffer[cartKey].onEveryNItems +
                " items like this!";
        }

        $("#cartTableBody").append(`
            <tr>
                <td>${cart[cartKey][0].name}<br/>
                <small><i>$${cart[cartKey][0].price} per item</i></small><br/>
                <small><i>${specialOfferText}</i></small><br/>
                <a href='#' class='decreaseQuantity btn btn-sm btn-primary' data-code='${cartKey}'>-</a> ${cart[cartKey].length}<a href='#' class='increaseQuantity btn btn-sm btn-primary' data-code='${cartKey}'>+</a></td><td>$${lineTotal.toFixed(2)}</td>
            </tr>
        `);
    }

    $("#subtotal").text(`$${orderTotal.toFixed(2)}`);

    let shipping = 0;
    if (orderTotal < 50) {
        shipping = 4.95;
    } else if (orderTotal >= 50 && orderTotal < 90) {
        shipping = 2.95;
    }

    $("#shipping").text(`$${shipping.toFixed(2)}`);
    $("#cartTotal").text(`$${(orderTotal + shipping).toFixed(2)}`);
};

const checkIfProductIsOnSpecialOffer = (code: string): number => {
    let specialOfferRate = 1;
    if (Object.keys(itemsOnSpecialOffer).includes(code)) {
        if ((cart[code].length + 1) % itemsOnSpecialOffer[code].onEveryNItems == 0) {
            specialOfferRate = itemsOnSpecialOffer[code].discountRate;
        }
    }
    return specialOfferRate;
};

const addProductToCart = (method: AddToCartMethod, code: string): void => {
    if (method == "increaseQuantityButton") {
        const clonedProduct: CartItem = {
            ...catalogItems[code],
            specialOffer: checkIfProductIsOnSpecialOffer(code),
        };
        cart[code].push(clonedProduct);
    } else {
        if (!Object.keys(cart).includes(code)) {
            cart[code] = [
                {
                    specialOffer: 1,
                    ...catalogItems[code],
                },
            ];
        } else {
            cart[code].push({
                specialOffer: checkIfProductIsOnSpecialOffer(code),
                ...catalogItems[code],
            });
        }
    }
};

const getCatalogItems = (): void => {
    $.ajax({
        url: "/catalog-ajax",
        type: "GET",
        success: function (response: string) {
            const parsed = JSON.parse(response) as ApiResponse<CatalogItems>;
            if (parsed.error) {
                console.log("Error: " + parsed.data);
            } else {
                catalogItems = parsed.data;
            }
        },
    });
};

const getSpecialOffers = (): void => {
    $.ajax({
        url: "/special-offers-ajax",
        type: "GET",
        success: function (response: string) {
            const parsed = JSON.parse(response) as ApiResponse<SpecialOffers>;
            if (parsed.error) {
                console.log("Error: " + parsed.data);
            } else {
                itemsOnSpecialOffer = parsed.data;
            }
        },
    });
};

$(document).ready(function () {
    getCatalogItems();

    getSpecialOffers();

    window.itemsOnSpecialOffer = {};

    window.cart = {};

    window.catalogItems = {};

    $(".product").click(function () {
        const productData = $(this).data("product-data") as CatalogItem;

        addProductToCart("addToCartButton", productData.code);

        updateCartTotal();
    });

    $("#cartTableBody").on("click", ".decreaseQuantity", function (e: JQuery.ClickEvent) {
        e.preventDefault();
        const productCode = String($(this).data("code"));

        cart[productCode].pop();
        if (cart[productCode].length == 0) {
            delete cart[productCode];
        }

        updateCartTotal();
    });

    $("#cartTableBody").on("click", ".increaseQuantity", function (e: JQuery.ClickEvent) {
        e.preventDefault();
        const productCode = String($(this).data("code"));

        addProductToCart("increaseQuantityButton", productCode);

        updateCartTotal();
    });
});
