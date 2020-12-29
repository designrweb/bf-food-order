import api           from "./request";
import gridUrlHelper from "../utils/gridUrlHelper";

export const exportCall = function (mainRoute, filters, sort, type, exportType) {
    let gridParams = gridUrlHelper.urlBuilder()
        .setFilters(filters)
        .setSort(sort)
        .setExportType(exportType)
        .getUrl();

    return api.request(mainRoute + '/export/run' + gridParams).withResponseType(type).get();
};