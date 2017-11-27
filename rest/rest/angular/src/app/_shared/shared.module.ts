import { CommonModule } from "@angular/common";
import { NgModule } from "@angular/core";
import { RouterModule } from '@angular/router';
import { FlexLayoutModule } from '@angular/flex-layout';
import { MaterialComponentsModule } from "../material-components.module";
import { RouteDirective } from 'gc-package';
import { LoadingOverlayComponent } from 'app/_shared/loading-overlay/loading-overlay.component';
import { SidebarComponent } from 'app/_shared/sidebar/sidebar.component';
import { NgxDatatableModule } from '@swimlane/ngx-datatable';


import {FormsModule, ReactiveFormsModule} from '@angular/forms';

@NgModule({
    imports: [
        CommonModule,
        MaterialComponentsModule,
        FormsModule,
        FlexLayoutModule,
        NgxDatatableModule,
        RouterModule
    ],
    declarations: [
        RouteDirective,
        LoadingOverlayComponent,
        SidebarComponent,
    ],
    exports: [
        RouteDirective,
        LoadingOverlayComponent,
        SidebarComponent,
        MaterialComponentsModule,
        FormsModule,
        FlexLayoutModule,
        NgxDatatableModule
    ]
})
export class SharedModule {
}
