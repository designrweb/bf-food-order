import api from './request';

export const get = (url) => api
    .request(url)
    .get();