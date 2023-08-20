const ApiVersion = '/api/v1.0'
const ApiRoutes = {
    // Authentication
    Login: ApiVersion + '/auth/login',
    //Category
    AddCategory: ApiVersion + '/category/save',
    EditCategory: ApiVersion + '/category/update',
    SingleCategory: ApiVersion + '/category/single',
    DeleteCategory: ApiVersion + '/category/delete',
    ListCategory: ApiVersion + '/category/list',
    //Fee
    AddFee: ApiVersion + '/delivery/save',
    EditFee: ApiVersion + '/delivery/update',
    SingleFee: ApiVersion + '/delivery/single',
    DeleteFee: ApiVersion + '/delivery/delete',
    ListFee: ApiVersion + '/delivery/list',
    //Slide
    AddSlide: ApiVersion + '/slide/save',
    EditSlide: ApiVersion + '/slide/update',
    SingleSlide: ApiVersion + '/slide/single',
    DeleteSlide: ApiVersion + '/slide/delete',
    ListSlide: ApiVersion + '/slide/list',
    //Website
    AddWebsite: ApiVersion + '/website/save',
    EditWebsite: ApiVersion + '/website/update',
    SingleWebsite: ApiVersion + '/website/single',
    //Product
    AddProduct: ApiVersion + '/product/save',
    EditProduct: ApiVersion + '/product/update',
    SingleProduct: ApiVersion + '/product/single',
    DeleteProduct: ApiVersion + '/product/delete',
    ListProduct: ApiVersion + '/product/list',
    DeleteProductImage: ApiVersion + '/product/delete/image',
    DeleteProductVideo: ApiVersion + '/product/delete/video',
    //Order
    getOrder: ApiVersion + '/order/get',
    updateStatusOrder: ApiVersion + '/order/update/status',
    singleOrder: ApiVersion + '/order/single',
};

export default ApiRoutes;
