import { CommonModule } from '@angular/common';
import { Component, inject } from '@angular/core';
import { ProductosService } from '../../services/productos.service';
import { ActivatedRoute } from '@angular/router';
import { IProduct } from '../../models/IProduct';

@Component({
  selector: 'app-product-info',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './product-info.component.html',
  styleUrl: './product-info.component.css'
})
export class ProductInfoComponent {
  private _route = inject(ActivatedRoute); // Declara una variable privada _route e inyecta ActivatedRoute
  private _apiService = inject(ProductosService); // Declara una variable privada _apiService e inyecta ApiService
  public product?: IProduct;
  public loading = true;
  ngOnInit(): void { // Método ngOnInit que implementa la interfaz OnInit
    this._route.params.subscribe(params => { // Se suscribe a los parámetros de la ruta
      this._apiService.infoProducto(params['id']).subscribe((data) => { 
        // Llama al método getProduct del servicio ApiService con el ID de producto proporcionado en la ruta y se suscribe a los datos devueltos
        //console.log(data[0]);
        this.product = <IProduct>data; // Asigna los datos del producto devueltos a la variable product
        this.loading = false; // Establece loading en falso para indicar que la carga ha finalizado
      });
    }
    )
  }
}
