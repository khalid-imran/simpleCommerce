const ApiVersion = '/api/v1.0'
const ApiRoutes = {
    // Authentication
    Login: ApiVersion + '/auth/login',
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
};

export default ApiRoutes;
