import {NgModule} from '@angular/core';
import {RouterModule} from '@angular/router';
import {PanelComponent} from "./panel.component";
import {RouteService} from 'gc-package';

import {DashboardComponent} from "./dashboard/dashboard.component";
import {ProductComponent} from "./product/product.component";
import {ProductSaveComponent} from "./product/save/product.component";


let routes = [];
routes = RouteService.loadRoutes({
    'panel': {
        path: '',
        component: PanelComponent,
        children: {
            'dashboard': {
                path: '',
                component: DashboardComponent,
                pathMatch: 'full'
            },
            'products' : {
                path: 'products',
                component: ProductComponent,
                pathMatch: 'full',
            },
            'products-new': {
                path: 'products-new',
                component: ProductSaveComponent,
                pathMatch: 'full',
            },
            'products-edit': {
                path: 'products-edit/:id',
                component: ProductSaveComponent,
                pathMatch: 'full',
            },
        }
    }
});

@NgModule({
    imports: [RouterModule.forChild(routes)],
    exports: [RouterModule],
    providers: [
        RouteService
    ]
})
export class PanelRoutingModule {
}
