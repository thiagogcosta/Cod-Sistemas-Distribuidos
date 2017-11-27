import {NgModule} from '@angular/core';
import {RouterModule} from '@angular/router';
import {RouteService} from "gc-package";

let routes = [];
routes = RouteService.loadRoutes({
});

@NgModule({
    imports: [RouterModule.forRoot(routes)],
    exports: [RouterModule],
    providers: []
})

export class RoutingModule {
}
