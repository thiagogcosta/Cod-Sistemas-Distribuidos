import {Model} from "gc-package";
import {Observable, Subscriber} from "rxjs";

export class BaseCollection {

    private _items: Model[];

    private _changed = false;

    constructor(items){
        this.setItems(items);
    }

    /**
     * @returns {Model[]}
     */
    public getItems(): Array<any> {
        return this._items;
    }

    public setItems(items) {
        this._changed = true;
        this._items = items;
        return this;
    }

    public addItem(item) {
        this._changed = true;
        this._items.push(item);
    }

    public removeItem(key) {
        this._changed = true;
        delete this._items[key];
    }

    public getItemsObservable(interval:number=1000): Observable<any> {
        return new Observable<any>((observer: Subscriber<any>) => {
            setInterval(() => {
                if (this._changed) {
                    this._changed = false;
                    observer.next( this.getItems() );
                }
            }, interval);
        });
    }

}