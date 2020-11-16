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

    setFilters(filters) {
        this.filters = filters;
        return this;
    }

    _preparePageUrl() {
        if (!this.page) return '';

        return 'page=' + this.page;
    }

    _prepareItemsPerPageUrl() {
        if (!this.itemsPerPage) return '';

        return 'itemsPerPage=' + this.itemsPerPage;
    }

    _prepareFiltersUrl() {
        let filterQuery = '';

        if (!this.filters) return filterQuery;
        let iteration = 1;
        for (let key in this.filters) {
            if (this.filters[key].length == 0) continue;
            if (iteration > 1) filterQuery += '&';

            filterQuery += 'filters' + this._prepareKey(key) + '=' + this.filters[key];
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
    _prepareKey(keyString){
        const keys = keyString.split('.');
        let result = '';

        for(const index in keys) {
            result += '['+keys[index]+']';
        }
        return result;
    }

    getUrl() {
        let url = '';

        let pageUrl = this._preparePageUrl();
        if (pageUrl.length > 0) url += '?' + pageUrl;

        let filterUrl = this._prepareFiltersUrl();
        if (filterUrl.length > 0) url += '&' + filterUrl;

        let itemsPerPageUrl = this._prepareItemsPerPageUrl();
        if (itemsPerPageUrl.length > 0) url += '&' + itemsPerPageUrl;

        let sortUrl = this._prepareSortUrl();
        if (sortUrl.length > 0) url += '&' + sortUrl;

        return url;
    }
}
