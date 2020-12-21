import api from './request';

export const storeImage = (url, data) => api
    .request(url)
    .withBody(data)
    .post();

export const removeImage = (url, data) => api
    .request(url)
    .withBody(data)
    .post();

export const uploadFileRequest = (url, data) => api
    .request(url)
    .withBody(data, true)
    .withHeaders({
        "Content-type": "multipart/form-data"
    })
    .post();
