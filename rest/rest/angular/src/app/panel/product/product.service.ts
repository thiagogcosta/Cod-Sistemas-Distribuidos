import { Product } from 'app/_models/product/product.model';
import { BaseRestService } from 'app/_services/base-rest.service';

export class ProductService extends BaseRestService {
    protected model = Product;
}
