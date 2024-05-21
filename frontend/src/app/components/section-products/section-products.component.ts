import { Component, inject } from '@angular/core';
import { ProductosService } from '../../services/productos.service';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';

@Component({
  selector: 'app-section-products',
  standalone: true,
  imports: [CommonModule,RouterModule],
  templateUrl: './section-products.component.html',
  styleUrl: './section-products.component.css'
})
export class SectionProductsComponent {
  private prodService = inject(ProductosService); // Declara una variable privada _apiService e inyecta el servicio ApiService
  public productos: any[] = []; // Declara una variable privada productos de tipo array
  ngOnInit(): void { // Método ngOnInit que implementa la interfaz OnInit
    this.prodService.listarProductos().subscribe((data: any[]) => { // Llama al método getProducts del servicio ApiService y se suscribe a los datos devueltos
      console.log(data); // Imprime los datos devueltos en la consola
      this.productos = data; // Asigna los datos devueltos a la variable productList
    });
  }
}
