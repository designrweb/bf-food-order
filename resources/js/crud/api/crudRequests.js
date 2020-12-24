import api           from "./request";
import gridUrlHelper from "../utils/gridUrlHelper";

export const getItems = function (mainRoute, page = 1, itemsPerPage, filters, sort) {
    let gridParams = gridUrlHelper.urlBuilder()
        .setPage(page)
        .setItemsPerPage(itemsPerPage)
        .setFilters(filters)
        .setSort(sort)
        .getUrl();

    return api.request(mainRoute + '/get-all' + gridParams).get();
};

export const getStructure = (mainRoute) => api
    .request(mainRoute + '/get-structure')
    .get();

export const getViewStructure = (mainRoute) => api
    .request(mainRoute + '/get-view-structure')
    .get();

export const getItem = (mainRoute, id) => api
    .request(mainRoute + '/get-one/' + id)
    .get();

export const store = (mainRoute, id, data) => typeof id === "undefined" ? api
    .request(mainRoute)
    .withBody(data, true)
    .withHeaders({
        "Content-type": "multipart/form-data"
    })
    .post() : api
    .request(mainRoute + '/' + id)
    .withBody(data, true)
    .withHeaders({
        "Content-type": "multipart/form-data"
    })
    .put();

export const getLocationGroupsByLocationId = (url) => api
    .request(url)
    .get();

export const getSubsidizationRulesBySubsidizationOrganizationId = (url) => api
    .request(url)
    .get();
