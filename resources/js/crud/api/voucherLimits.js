import api           from './request';

export const storeItemList = (mainRoute, data) => api
    .request(mainRoute)
    .withBody(data)
    .post();

