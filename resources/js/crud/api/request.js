import axios                              from "axios";
import {isUndefinedOrNull, isEmptyString} from "../utils/helpers";

const queryBuilder = require("query-string");

export default {
    request(url) {
        return new Request(url);
    }
};

export class Request {
    constructor(url) {
        this.url      = url;
        this.options  = {};
        this.includes = [];
        this.body     = null;
        this.params   = null;
    }

    withBody(body, shouldSanitize = false) {
        this.body = shouldSanitize ? body : Request._sanitizeData(body);
        return this;
    }

    withIncludes(includes) {
        this.includes = includes;
        return this;
    }

    withHeaders(headers) {
        this.options.headers = headers;
        return this;
    }

    withParams(params) {
        this.params = Request._sanitizeData(params);
        return this;
    }

    getUrl() {
        let queryParams = this._buildQueryParams();
        return this.url + (queryParams ? "?" + queryParams : "");
    }

    patch() {
        return axios.patch(this.getUrl(), this.body, this.options);
    }

    get() {
        return axios.get(this.getUrl(), this.options);
    }

    post() {
        return axios.post(this.getUrl(), this.body, this.options);
    }

    put() {
        return axios.put(this.getUrl(), this.body, this.options);
    }

    delete() {
        return axios.delete(this.getUrl(), this.body, this.options);
    }

    _buildQueryParams() {
        let build = "";
        if (this.includes.length > 0) {
            build += this._buildIncludes() + "&";
        }
        if (this.params) {
            build += this._buildParams();
        }

        return build;
    }

    _buildIncludes() {
        return queryBuilder.stringify({include: this.includes.join(",")});
    }

    _buildParams() {
        return queryBuilder.stringify(this.params, { arrayFormat: "bracket" });
    }

    static _sanitizeData(data) {
        let output = {};
        for (let prop in data) {
            if (typeof data[prop] == 'object') {
                let innerObj = {};
                for (let prop1 in data[prop]) {
                    if (!isUndefinedOrNull(data[prop][prop1]) && !isEmptyString(data[prop][prop1])) {
                        innerObj[prop1] = data[prop][prop1];
                    }
                }
                // check if inner object is not empty
                if (!(Object.keys(innerObj).length === 0 && innerObj.constructor === Object)) {
                    output[prop] = innerObj;
                }
            } else {
                if (!isUndefinedOrNull(data[prop]) && !isEmptyString(data[prop])) {
                    output[prop] = data[prop];
                }
            }
        }
        return output;
    }

    static _serialize(obj) {
        let res = Object.keys(obj).filter((key) => obj[key] != undefined && obj[key] != '').reduce((str, key, i) => {
            let delimiter, val;
            delimiter = (i === 0) ? '?' : '&';

            if (Array.isArray(obj[key])) {
                key          = encodeURIComponent(key);
                let arrayVar = obj[key].reduce((str, item) => {
                    val = encodeURIComponent(JSON.stringify(item));
                    return [str, key, '=', val, '&'].join('');
                }, '');
                return [str, delimiter, arrayVar.trimRight('&')].join('');
            } else if (Object.keys(obj[key]).length > 0 && obj[key].constructor === Object) {
                let res = Request._serialize(obj[key]);

                return res;
            } else {
                key = encodeURIComponent(key);
                val = encodeURIComponent(JSON.stringify(obj[key]));
                return [str, delimiter, key, '=', val].join('');
            }
        }, '');

        return res;
    }
}
