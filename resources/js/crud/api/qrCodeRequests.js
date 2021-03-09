import api from './request';

export const generateCode = (url, data) => api
    .request(url)
    .withBody(data)
    .post();

export const downloadCode = (url, type) => api
    .request(url)
    .withResponseType(type)
    .get();

export const downloadManual = (url, type) => api
    .request(url)
    .withResponseType(type)
    .get();