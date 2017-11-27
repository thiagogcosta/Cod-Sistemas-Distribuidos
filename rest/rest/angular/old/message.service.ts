import {Injectable, OnInit} from '@angular/core';
import {ToastyService, ToastyConfig, ToastOptions, ToastData} from 'ng2-toasty';

@Injectable()
export class MessageService implements OnInit {

    // http://akserg.github.io/ng2-webpack-demo/#/toasty

    constructor(private toastyService: ToastyService, private toastyConfig: ToastyConfig) {
        this.toastyConfig.theme = 'default';
        this.toastyConfig.position = "top-center";
        this.toastyConfig.showClose = true;
        //this.toastyConfig.timeout = 2000;
    }

    ngOnInit() {
    }

    default(options: string | ToastOptions) {
        this.toastyService.default(options);
    }

    success(options: string | ToastOptions) {
        this.toastyService.success(options);
    }

    info(options: string | ToastOptions) {
        this.toastyService.info(options);
    }

    warning(options: string | ToastOptions) {
        this.toastyService.warning(options);
    }

    error(options: string | ToastOptions) {
        this.toastyService.error(options);
    }

    wait(options: string | ToastOptions) {
        this.toastyService.wait(options);
    }

}
