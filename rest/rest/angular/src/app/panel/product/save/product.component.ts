import {Component, OnInit, ViewChild} from '@angular/core';
import {ProductService} from '../product.service';
import {Product} from 'app/_models/product/product.model';
import {DialogService, RouteService} from 'gc-package';
import {ActivatedRoute, Router} from '@angular/router';

@Component({
    selector: 'ms-product-save',
    templateUrl: './product.component.html',
    styleUrls: ['./product.component.scss'],
    providers:[ProductService]
})
export class ProductSaveComponent implements OnInit {

    product: Product;
    isLoading: boolean = false;
    productLoaded: boolean = false;
    method: string;
    title: string = '';

    constructor(
        private productService: ProductService,
        private activateRoute: ActivatedRoute,
        private routeService: RouteService,
        private dialogService : DialogService
    ) {
        var id = activateRoute.snapshot.params['id'];
        this.product = new Product();

        if ( typeof id != 'undefined' ) {
            this.method = 'update';
            this.productService.findById(id)
                .then((result: Product) => {
                    this.product = result;
                    this.title = this.product.name;
                    this.productLoaded = true;
                });
        }else {
            this.method = 'create';
            this.title = 'Novo Produto';
            this.productLoaded = true;
        }
    }

    ngOnInit() {
    }

    onSubmit(){
        this.isLoading = true;
        if(this.method == 'create'){
            this.productService.create(this.product)
                .then((result: Product) => {
                    this.routeService.navigate('panel.products');
                    this.dialogService.success('Cadastrar', 'Produto cadastrado com sucesso!');
                    this.isLoading = false;
                }, () => function(){
                    this.isLoading = false;
                });
        }else{
            console.log(this.product);
            this.productService.update(this.product)
                .then((result: Product) => {
                    this.routeService.navigate('panel.products');
                    this.dialogService.success('Atualizar', 'Produto atualizado com sucesso!');
                    this.isLoading = false;
                }, () => function(){
                    this.isLoading = false;
                });
        }
    }

    delete(){
        this.dialogService.remove('EXCLUIR', 'Deseja excluir este produto?')
        .then((result) => {
            if (result) {
                this.isLoading = true;
                this.productService.delete(this.product)
                    .then((response) => {
                        this.isLoading = false;
                        this.routeService.navigate('panel.products');
                        this.dialogService.success('Excluir', 'Produto excluído com sucesso!');
                    }, () => function(){
                        this.isLoading = false;
                    });
            }
        });
    }

}
