import api           from './request';

export const getVoucherItems = () => api
    .request('/voucher-limits/get-all')
    .get();

export const storeFoodOrderItems = (data) => api
    .request('/voucher-limits/store-many')
    .withBody(data)
    .post();

export const getMenuCategories = () => api
    .request('/menu-categories/get-all')
    .get();

export const getItemList = (mainRoute) => api
    .request(mainRoute + '/get-item-list')
    .get();

