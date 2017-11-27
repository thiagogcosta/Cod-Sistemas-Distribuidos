import {Injectable} from '@angular/core';

import swal from 'sweetalert2';
import {isObject} from "util";

@Injectable()
export class DialogService {

    // Documentaion: https://limonte.github.io/sweetalert2/

    constructor() {

        swal.setDefaults({});

    }

    private show(title, message?: string, type?): Promise<any> {
        if (isObject(title)) {
            title.type = type;
            return swal(title);
        } else {
            return swal(title, message, type);
        }
    }

    success(title, message?: string): Promise<any> {
        return this.show(title, message, 'success');
    }

    error(title, message?: string): Promise<any> {
        return this.show(title, message, 'error');
    }

    warning(title, message?: string): Promise<any> {
        return this.show(title, message, 'warning');
    }

    info(title, message?: string): Promise<any> {
        return this.show(title, message, 'info');
    }

    question(title, message?: string): Promise<any> {
        return this.show(title, message, 'question');
    }

    confirm(title: string, message?: string, type='question'): Promise<any> {
        return this.show({
            title: title,
            text: message,
            type: type,
            showCancelButton: true,
        });
    }

    delete(title='Are you sure?', message="You won't be able to revert this!"): Promise<any> {
        return this.show({
            title: title,
            text: message,
            type: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!'
        });
    }

}
