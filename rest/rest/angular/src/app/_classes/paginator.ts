import {BaseCollection} from "../_collections/base";

export class Paginator {
    total: number = null;
    per_page: number = null;
    current_page: number = null;
    last_page: number = null;
    next_page_url: string = null;
    prev_page_url: string = null;
    path: string = null;
    from: number = null;
    to: number = null;
    data: BaseCollection = null;

    constructor(data:Object={}) {
        for(let key in data) {
            if (this.hasOwnProperty(key))
                this[key] = data[key];
        }
    }

}
