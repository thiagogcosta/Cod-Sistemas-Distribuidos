import {Component, OnInit} from '@angular/core';
import {RouteService} from "gc-package";

@Component({
    selector: 'app-panel',
    templateUrl: './panel.component.html',
    styleUrls: ['./panel.component.css']
})
export class PanelComponent implements OnInit {

    constructor (private routeService: RouteService) {
    }

    ngOnInit() {


    }

    getMenuItems() {
        let menu = [
            {route: 'panel.dashboard',  title: 'Dashboard', icon: 'dashboard', class: 'active'},
            {route: 'panel.products', title: 'Products', icon: 'store', class: ''},
        ];



        return menu;

    }

}
