import {Directive, ElementRef, Input, HostListener, OnInit} from '@angular/core';
import {RouteService} from "../_services/route.service";

@Directive({
    selector: '[route]',
    providers: [RouteService]
})
export class RouteDirective implements OnInit {

    constructor(private elem: ElementRef, private routeService: RouteService) {}

    @Input('route')
    route: string;

    private url: string;

    ngOnInit(): void {
        this.url = this.routeService.getUrl(this.route);
        if (this.elem.nativeElement.tagName == 'A') {
            this.elem.nativeElement.setAttribute('href', this.url);
        }
    }


    @HostListener('click', ['$event'])
    onClick(event: Event) {
        event.preventDefault();
        this.routeService.navigateByUrl(this.url);
    }

}
