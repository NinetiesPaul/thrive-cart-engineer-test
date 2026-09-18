interface CatalogItem {
  id: number | string;
  code: string;
  name: string;
  price: number | string;
}

interface CartItem extends CatalogItem {
  specialOffer: number;
}

interface SpecialOfferRule {
  onEveryNItems: number;
  discountRate: number;
}

interface ApiResponse<T> {
  error: boolean;
  data: T;
}

type Cart = Record<string, CartItem[]>;
type CatalogItems = Record<string, CatalogItem>;
type SpecialOffers = Record<string, SpecialOfferRule>;
type AddToCartMethod = "increaseQuantityButton" | "addToCartButton";

declare var cart: Cart;
declare var catalogItems: CatalogItems;
declare var itemsOnSpecialOffer: SpecialOffers;

interface Window {
  cart: Cart;
  catalogItems: CatalogItems;
  itemsOnSpecialOffer: SpecialOffers;
}
