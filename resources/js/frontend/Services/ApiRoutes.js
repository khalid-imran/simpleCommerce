const ApiVersion = '/api/v1.0'
const ApiRoutes = {
    // Authentication
    Registration: ApiVersion + '/auth/registration',
    Login: ApiVersion + '/auth/login',
    LoginUser: ApiVersion + '/auth/login/user',
    LogoutUser: ApiVersion + '/auth/logout/user',
    Profile: ApiVersion + '/auth/user/get',
    // Guest
    CreateGuest: ApiVersion + '/auth/guest/create',
    GetGuest: ApiVersion + '/auth/guest/get',
    // Website
    Website: ApiVersion + '/website/get',
    // Product
    ProductLatest: ApiVersion + '/product/get/latest',
    ProductByCategory: ApiVersion + '/product/by/category',
    ProductAll: ApiVersion + '/product/get/all',
    ProductSingle: ApiVersion + '/product/get/single',
    // Cart
    AddCart: ApiVersion + '/cart/add',
    GetCart: ApiVersion + '/cart/get',
    DeleteCart: ApiVersion + '/cart/delete',
    // Delivery Fee
    GetDeliveryFee: ApiVersion + '/deliveryFee/get',
    // Order
    addOrder: ApiVersion + '/order/user/create',
    getOrder: ApiVersion + '/order/user/get',
    getOrderGuest: ApiVersion + '/order/user/get/guest',
};

export default ApiRoutes;
