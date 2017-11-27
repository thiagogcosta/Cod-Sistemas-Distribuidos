import {NgModule} from '@angular/core';
import {CommonModule} from '@angular/common';

import {FlexLayoutModule} from '@angular/flex-layout';
import {FormsModule, ReactiveFormsModule} from '@angular/forms';

import {SharedModule} from "../_shared/shared.module";

import {PanelRoutingModule} from './panel-routing.module';
import {PanelComponent} from "./panel.component";

import {DashboardComponent} from "./dashboard/dashboard.component";

import {ProductComponent} from './product/product.component';
import {ProductSaveComponent} from './product/save/product.component';

import {NavbarComponent} from "./navbar/navbar.component";

import {TreeModule} from "angular-tree-component";

@NgModule({
    imports: [
        CommonModule,
        PanelRoutingModule,
        SharedModule,
        FormsModule,
        TreeModule,
        ReactiveFormsModule,
        FlexLayoutModule,
    ],
    declarations: [
        PanelComponent,
        ProductComponent,
        ProductSaveComponent,
        DashboardComponent,
        NavbarComponent,
    ],
    providers: [
    ],
    exports: []
})
export class PanelModule {
}
