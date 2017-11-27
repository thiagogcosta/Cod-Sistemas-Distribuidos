import {Injectable} from '@angular/core';
import {Routes, ActivatedRoute, Params, Router, UrlTree} from '@angular/router';
import {isArray} from 'rxjs/util/isArray';
import {isObject} from 'util';

let ROUTES: Object = {};


export function objectRoutesToArray(objRoutes, routes) {

    // let routes = [];

    for (let k in objRoutes) {
        let route = {...objRoutes[k]};
        if (route.children) {
            route.children = objectRoutesToArray(route.children, routes);
        }
        routes.push( Object.assign({}, route) );
    }

    // return routes;
}


@Injectable()
export class RouteService {

    private paramsGlobal = {};

    constructor(private router: Router, private activatedRoute: ActivatedRoute) {
        this.activatedRoute.params.subscribe((params: Params) => {
            this.paramsGlobal = params;
        });
    }

    public static loadRoutes(objRoutes): Routes {
        ROUTES = {...ROUTES, ...objRoutes};
        return this.objectRoutesToArray(objRoutes);
    }

    public static objectRoutesToArray(objRoutes): Routes {
        let routes = [];
        for (let k in objRoutes) {
            let route = {...objRoutes[k]};
            if (route.children) {
                route.children = this.objectRoutesToArray(route.children);
            }
            routes.push( Object.assign({}, route) );
        }

        return routes;
    }

    private prepareParams(params, url) {
        if (isObject(params)) {
            for (let param in params) {
                url = url.replace(':' + param, params[param]);

            }
        }
        return url;
    }

    public prepareRoute(routeName: string|Array<any>): UrlTree {

        let routes = [];
        let params = {};
        let options = {};

        if (isArray(routeName)) {
            routes = routeName[0].split('.');
            if (routeName[1]) {
                params = routeName[1];
            }
            if (routeName[2]) {
                options = routeName[2];
            }
        } else {
            routes = routeName.split('.');
        }


        let url = '';
        let map = null;
        for (let route of routes) {
            if (!map) {
                map = ROUTES[route];
            } else {
                map = map['children'][route];
            }

            if (map['path']) {
                url += '/' + map['path'];
            }
        }

        url = this.prepareParams(params, url);
        url = this.prepareParams(this.paramsGlobal, url);

        return this.router.createUrlTree([url], options);
    }

    public getUrl(routeName: string|Array<any>) {
        return this.prepareRoute(routeName).toString();
    }

    public navigate(routeName: string|Array<any>) {
        this.router.navigate([this.getUrl(routeName)] );
    }

    public navigateByUrl(url: string) {
        this.router.navigateByUrl(url);
    }
}
