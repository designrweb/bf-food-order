import api from './request';

export const storeImage = (data) => api
    .request('/admin/images/store')
    .withBody(data)
    .post();

export const removeImage = (data) => api
    .request('/admin/images/remove')
    .withBody(data)
    .post();
