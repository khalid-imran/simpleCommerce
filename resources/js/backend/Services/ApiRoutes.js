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
    DeleteProductVariant: ApiVersion + '/product/delete/variant',
    UpdateProductVariant: ApiVersion + '/product/update/variant',
    //Order
    getOrder: ApiVersion + '/order/get',
    updateStatusOrder: ApiVersion + '/order/update/status',
    singleOrder: ApiVersion + '/order/single',
    //State
    AddState: ApiVersion + '/state/save',
    EditState: ApiVersion + '/state/update',
    SingleState: ApiVersion + '/state/single',
    DeleteState: ApiVersion + '/state/delete',
    ListState: ApiVersion + '/state/list',
    //City
    AddCity: ApiVersion + '/city/save',
    EditCity: ApiVersion + '/city/update',
    SingleCity: ApiVersion + '/city/single',
    DeleteCity: ApiVersion + '/city/delete',
    ListCity: ApiVersion + '/city/list',
    //Pages
    AddPages: ApiVersion + '/pages/save',
    EditPages: ApiVersion + '/pages/update',
    SinglePages: ApiVersion + '/pages/single',
    DeletePages: ApiVersion + '/pages/delete',
    ListPages: ApiVersion + '/pages/list',
};

export default ApiRoutes;
