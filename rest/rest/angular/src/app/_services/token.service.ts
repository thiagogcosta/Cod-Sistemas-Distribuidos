import { Injectable } from '@angular/core';
import { LocalStorageService } from 'gc-package';

@Injectable()
export class TokenService {

    TOKEN_KEY : string;

    constructor( private localStorageService: LocalStorageService ) {
        this.TOKEN_KEY = 'token';
    }

    get token() {
        return this.localStorageService.get(this.TOKEN_KEY);
    }

    set token(value) {
        value ? this.localStorageService.set(this.TOKEN_KEY, value) : this.localStorageService.remove(this.TOKEN_KEY);
    }

    public setTokenKey(key){
        this.TOKEN_KEY = key;
    }

}
