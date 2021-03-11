import api           from './request';

/**
 * @param params
 * @returns {*}
 */
export const getMenuItems = (params) => api
    .request('/user/menu-items/get-by-date')
    .withParams(params)
    .get();

/**
 * @param data
 * @returns {*|Promise }
 */
export const storeFoodOrder = (data) => api
    .request('/user/order')
    .withBody(data)
    .post();

/**
 * @param data
 * @returns {*|Promise}
 */
export const updateFoodOrder = (data) => api
    .request('/user/order')
    .withBody(data)
    .put();

/**
 * TODO: remove after approving auto-ordering flow
 * @param data
 * @returns {*|Promise<AxiosResponse<T>>}
 */
export const storeFoodOrderItems = (data) => api
    .request('/foodorder/update-many')
    .withBody(data)
    .post();

/**
 * @param data
 * @returns {*|Promise<AxiosResponse<T>>}
 */
export const removeFoodOrder = (data) => api
    .request('/user/order')
    .withBody(data)
    .delete();

/**
 * @returns {Promise}
 */
export const getMenuCategories = () => api
    .request('/user/menu-categories/get-all')
    .get();

/**
 * @returns {Promise}
 */
export const getConsumerInformation = () => api
    .request('/user/consumers/get-data')
    .get();

/**
 * @returns {*|Promise<AxiosResponse<T>>}
 */
export const toggleAutoorderStatus = () => api
    .request('/auto-orders/set-status')
    .withBody({})
    .post();
