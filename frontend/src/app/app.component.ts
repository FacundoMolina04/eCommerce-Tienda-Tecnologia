import { CommonModule } from '@angular/common';
import { Component, OnInit, inject } from '@angular/core';
import { Router, RouterOutlet } from '@angular/router';
import { SectionProductsComponent } from './components/section-products/section-products.component'; // Importa el componente aquí


@Component({
  selector: 'app-root',
  standalone: true,
  imports: [RouterOutlet,CommonModule,SectionProductsComponent],
  templateUrl: './app.component.html',
  styleUrl: './app.component.css'
})
export class AppComponent implements OnInit{

  ngOnInit(): void { // Método ngOnInit que implementa la interfaz OnInit
    // Este método se ejecutaría al inicializar el componente, pero está vacío en este caso
  }
  private _router = inject(Router);

  navegate(): void { 
    this._router.navigate(['/login']); 
  }
  menuOption: string = ''
  // declara una propiedad menuOption que se utilizará para almacenar la opción de menú seleccionada.
  constructor(private router: Router) {}
  onOption(menuOption: string){
    // es un método que actualiza la propiedad menuOption con la opción de menú seleccionada.
    this.menuOption = menuOption
    this.router.navigate([menuOption]);
  }
}
