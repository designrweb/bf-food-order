export default {
    urlBuilder() {
        return new UrlBuilder();
    }
};

export class UrlBuilder {
    constructor(url) {
        this.filters      = null;
        this.sort         = null;
        this.page         = null;
        this.exportType   = null;
        this.itemsPerPage = null;
    }

    setPage(page) {
        this.page = page;
        return this;
    }

    setItemsPerPage(quantity) {
        this.itemsPerPage = quantity;
        return this;
    }

    setSort(sort) {
        this.sort = sort;
        return this;
    }

    setExportType(exportType) {
        this.exportType = exportType;
        return this;
    }

    setFilters(filters) {
        this.filters = filters;
        return this;
    }

    _preparePageUrl() {
        if (!this.page) return '';

        return 'page=' + this.page;
    }

    _prepareExportTypeUrl() {
        if (!this.exportType) return '';

        return 'exportType=' + this.exportType;
    }

    _prepareItemsPerPageUrl() {
        if (!this.itemsPerPage) return '';

        return 'itemsPerPage=' + this.itemsPerPage;
    }

    _prepareFiltersUrl() {
        let filterQuery = '';
        let filterValue = '';

        if (!this.filters) return filterQuery;
        let iteration = 1;
        for (let key in this.filters) {
            if (this.filters[key].length == 0) continue;
            if (iteration > 1) filterQuery += '&';

            if (this.filters[key] instanceof Object) {
                filterValue = JSON.stringify(this.filters[key]);
            } else {
                filterValue = this.filters[key];
            }

            filterQuery += 'filters' + this._prepareKey(key) + '=' + filterValue;
            iteration += 1;
        }

        return filterQuery;
    }

    _prepareSortUrl() {
        let sortQuery = '';

        if (!this.sort) return sortQuery;

        let iteration = 1;

        for (let key in this.sort) {
            if (this.sort[key].length == 0) continue;

            if (iteration > 1) sortQuery += '&';

            sortQuery += 'sort' + this._prepareKey(key) + '=' + this.sort[key];
            iteration += 1;
        }

        return sortQuery;
    }

    /**
     * ex1: key => [key]
     * ex2: key1.key2 => [key1][key2]
     *
     * @param keyString
     * @returns {string}
     * @private
     */
    _prepareKey(keyString) {
        const keys = keyString.split('.');
        let result = '';

        for (const index in keys) {
            result += '[' + keys[index] + ']';
        }
        return result;
    }

    getUrl() {
        let url = [];

        let pageUrl = this._preparePageUrl();
        if (pageUrl.length > 0) url.push(pageUrl);

        let exportTypeUrl = this._prepareExportTypeUrl();
        if (exportTypeUrl.length > 0) url.push(exportTypeUrl);

        let filterUrl = this._prepareFiltersUrl();
        if (filterUrl.length > 0) url.push(filterUrl);

        let itemsPerPageUrl = this._prepareItemsPerPageUrl();
        if (itemsPerPageUrl.length > 0) url.push(itemsPerPageUrl);

        let sortUrl = this._prepareSortUrl();
        if (sortUrl.length > 0) url.push(sortUrl);

        return (url.length > 0 ? '?' : '') + url.join('&');
    }
}
