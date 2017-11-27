import { Inject, Injectable } from '@angular/core';
import { RestfulService } from "gc-package";
import { BaseHttpService } from "./base-http.service";
import 'rxjs/add/operator/map';

@Injectable()
export class BaseRestService extends RestfulService{
    constructor(protected httpService: BaseHttpService){
        super(httpService);
    }
}
