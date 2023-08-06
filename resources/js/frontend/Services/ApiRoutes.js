const ApiVersion = '/api/v1.0'
const ApiRoutes = {
    // Authentication
    Login: ApiVersion + '/login',
    // Website
    Website: ApiVersion + '/website/get',
    // Product
    ProductLatest: ApiVersion + '/product/get/latest',
    ProductByCategory: ApiVersion + '/product/by/category',
    ProductAll: ApiVersion + '/product/get/all',
    ProductSingle: ApiVersion + '/product/get/single',
};

export default ApiRoutes;
