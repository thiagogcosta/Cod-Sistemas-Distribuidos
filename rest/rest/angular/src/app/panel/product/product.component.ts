import {Component, OnInit} from "@angular/core";
import {Router} from "@angular/router";

import {ProductService} from "./product.service";
import {DialogService, Paginator, RouteService} from "gc-package";

export let PRODUCTS;

@Component({
    selector: 'list-products',
    templateUrl: './product.component.html',
    styleUrls: ['./product.component.scss'],
    providers: [ProductService]
})

export class ProductComponent implements OnInit {

    page: Paginator;
    pageExists:boolean = false;
    rows;
    isLoading:boolean = false;

    constructor(private productService: ProductService,
                private routeService: RouteService,
    ) {
    }

    ngOnInit() {
        this.get();
    }

    products() {
        return PRODUCTS;
    }

    get() {
        this.setPage(null);
    }

    setPage(pageInfo) {
        var current_page = pageInfo ? pageInfo.offset + 1 : 0;
        this.isLoading = true;

        this.productService.find({
            params: {
                per_page: 10,
                page: current_page
            }
        }).then((result : Paginator) => {
            this.page = result;
            this.page.current_page = --this.page.current_page;

            result
                .data
                .getItemsObservable()
                .subscribe((res) => {
                    this.rows = res;
                    this.pageExists = true;
                    this.isLoading = false;
                });
        }, () => {
            this.isLoading = false;
        });

    }

    edit(event){
        this.routeService.navigate(['panel.products-edit', {id: event.row['id']}]);
    }

    setSort(sortInfo) {

    }

}
