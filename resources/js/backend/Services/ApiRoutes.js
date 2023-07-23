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
};

export default ApiRoutes;
