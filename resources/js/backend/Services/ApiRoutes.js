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
};

export default ApiRoutes;
