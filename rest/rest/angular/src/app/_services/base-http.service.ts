import { Injectable }    from '@angular/core';
import {Http} from '@angular/http';
import { Router } from '@angular/router';
import { TokenService } from './token.service';
import { DialogService, LocalStorageService, HttpService as Base } from 'gc-package';

import 'rxjs/add/operator/toPromise';
import { environment } from '../../environments/environment';

@Injectable()
export class BaseHttpService extends Base {

    constructor(
        public http: Http,
        public tokenService: TokenService,
        public dialog: DialogService,
        public localStorage: LocalStorageService,
        public router: Router
    ) {

        super(http, dialog);
    }

    init() {
        this.apiUrl = environment.apiUrl;
    }

    getHeaders() {
        this.headers.delete('Authorization');
        if (this.tokenService.token) {
            this.headers.append('Authorization', 'Bearer ' + this.tokenService.token);
        }
        return this.headers;
    }

    onError401(error: any): void{
        let data: any = this.toSwalFormat(error);
        data.onClose = () => {
            this.tokenService.token = null;
            this.localStorage.remove('USER');
            this.router.navigate(['/login']);
        };
        this.dialog.error(data);
    }

}
