import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class AdminService {
  private apiUrl = 'http://localhost/Proyecto_PHP_ANGULAR/api.php';

  constructor(private http: HttpClient) { }

  modificarProducto(producto_id: number, nombre: string, precio: number, descripcion: string, categoria: string): Observable<any> {
    return this.http.post(`${this.apiUrl}/modificarProducto`, { producto_id, nombre, precio, descripcion, categoria });
  }

  addProducto(nombre: string, precio: number, descripcion: string, categoria: string): Observable<any> {
    return this.http.post(`${this.apiUrl}/addProducto`, { nombre, precio, descripcion, categoria });
  }

  eliminarProducto(producto_id: number): Observable<any> {
    return this.http.post(`${this.apiUrl}/eliminarProducto`, { producto_id });
  }
}