updateCartTotal = () => {
    $("#cartTableBody").empty();

    let orderTotal = 0;

    for (const cartKey of Object.keys(cart)) {
        let lineTotal = 0.00;
        for (const [key, value] of Object.entries(cart[cartKey])) {
            let itemPrice = value.price;
            if (value.specialOffer < 1) {
                itemPrice = itemPrice * value.specialOffer;
            }

            itemPrice = String(itemPrice);
            if (itemPrice.indexOf('.') !== -1) {
                itemPrice = itemPrice.substring(0, itemPrice.indexOf('.') + 3);
            }

            lineTotal += parseFloat(itemPrice);
        }
        orderTotal += lineTotal;

        let specialOfferText = "";
        if (Object.keys(itemsOnSpecialOffer).includes(cartKey)) {
            let itemDiscountRate = itemsOnSpecialOffer[cartKey].discountRate*100;
            specialOfferText = itemDiscountRate + "% off on every " + itemsOnSpecialOffer[cartKey].onEveryNItems + " items like this!";
        }

        $("#cartTableBody").append(`
            <tr>
                <td>${cart[cartKey][0].name}<br/>
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
}

checkIfProductIsOnSpecialOffer = (code) => {
    let specialOfferRate = 1
    if (Object.keys(itemsOnSpecialOffer).includes(code)) {
        if ((cart[code].length + 1) % itemsOnSpecialOffer[code].onEveryNItems == 0) {
            specialOfferRate = itemsOnSpecialOffer[code].discountRate;
        }
    }
    return specialOfferRate;
}

addProductToCart = (method, code) => {

    if (method == "increaseQuantityButton") {
        let clonedProduct = {...catalogItems[code]};
        clonedProduct.specialOffer = checkIfProductIsOnSpecialOffer(code);
        cart[code].push(clonedProduct);
    } else  {
        if (!Object.keys(cart).includes(code)) {
            cart[code] = [{
                specialOffer: 1,
                ...catalogItems[code]
            }];
        } else {
            cart[code].push({
                specialOffer: checkIfProductIsOnSpecialOffer(code),
                ...catalogItems[code]
            });
        }
    }
}

getCatalogItems = () => {
    $.ajax({
        url: "/catalog-ajax",
        type: "GET",
        success: function(response) {
            response = JSON.parse(response);
            if (response.error) {
                console.log("Error: " + response.data);
            } else {
                catalogItems = response.data;
            }
        }
    });
}

getSpecialOffers = () => {
    $.ajax({
        url: "/special-offers-ajax",
        type: "GET",
        success: function(response) {
            response = JSON.parse(response);
            if (response.error) {
                console.log("Error: " + response.data);
            } else {
                itemsOnSpecialOffer = response.data;
            }
        }
    });
}

$(document).ready(function(){

    getCatalogItems();

    getSpecialOffers();

    window.itemsOnSpecialOffer = {};

    window.cart = {};

    window.catalogItems = {};

    $(".product").click(function(){
        var productData = $(this).data("product-data");

        addProductToCart("addToCartButton", productData.code);

        updateCartTotal();
    });

    $("#cartTableBody").on("click", ".decreaseQuantity", function(e){
        e.preventDefault();
        var productCode = $(this).data("code");

        cart[productCode].pop();
        if (cart[productCode].length == 0) {
            delete cart[productCode];
        }

        updateCartTotal();
    });

    $("#cartTableBody").on("click", ".increaseQuantity", function(e){
        e.preventDefault();
        var productCode = $(this).data("code");

        addProductToCart("increaseQuantityButton", productCode);

        updateCartTotal();
    });
});
