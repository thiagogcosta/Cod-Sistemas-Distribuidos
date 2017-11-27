import {Component, OnInit, Input} from '@angular/core';
import { ROUTES } from './sidebar-routes.config';
import { RouteService } from 'gc-package';

declare var $:any;
@Component({
    moduleId: module.id,
    selector: 'sidebar-cmp',
    templateUrl: 'sidebar.component.html',
})

export class SidebarComponent implements OnInit {

    @Input()
    public menuItems: any[];

    menuItems2: any[];

    constructor (private routeService: RouteService) {


    }

    ngOnInit() {
        $.getScript('../../assets/js/sidebar-moving-tab.js');

        this.menuItems2 = this.menuItems.slice();


    }

    getPath(item) {
        return this.routeService.getUrl(item.route)+'';
    }

}
