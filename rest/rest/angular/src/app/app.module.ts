import {BrowserModule} from '@angular/platform-browser';
import {NgModule} from '@angular/core';

import {HttpModule} from '@angular/http';
import {AppComponent} from './app.component';

import {SharedModule} from './_shared/shared.module';
import {PanelModule} from './panel/panel.module';

import {RoutingModule} from './app-routing.module';
import {BrowserAnimationsModule} from '@angular/platform-browser/animations';

import {TokenService} from './_services/token.service';
import {BaseHttpService} from './_services/base-http.service';
import {FlexLayoutModule} from '@angular/flex-layout';

import { LocationService } from 'gc-package';
import { DialogService, RouteService, LocalStorageService, HttpService } from 'gc-package';
import { ToastyModule } from 'ng2-toasty';


@NgModule({
    declarations: [
        AppComponent,
    ],
    imports: [
        BrowserModule,
        SharedModule,
        PanelModule,
        RoutingModule,
        HttpModule,
        FlexLayoutModule,
        BrowserAnimationsModule,
        ToastyModule.forRoot(),
    ],
    providers: [
        HttpService,
        LocalStorageService,
        TokenService,
        DialogService,
        RouteService,
        BaseHttpService,
        DialogService,
        LocationService
    ],
    bootstrap: [AppComponent]
})
export class AppModule {
}
