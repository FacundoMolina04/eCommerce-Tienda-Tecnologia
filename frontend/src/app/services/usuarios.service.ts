import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class UsuarioService {
  private apiUrl = 'http://localhost/Proyecto_PHP_ANGULAR/api.php';

  constructor(private http: HttpClient) { }

  añadirAlCarrito(producto_id: number, cantidad: number, usuario_id: number): Observable<any> {
    return this.http.post(`${this.apiUrl}/añadirAlCarrito`, { producto_id, cantidad, usuario_id });
  }

  login(correo: string, password: string): Observable<any> {
    return this.http.post(`${this.apiUrl}/login`, { correo, password });
  }

  registro(nombre: string, username: string, correo: string, password: string): Observable<any> {
    return this.http.post(`${this.apiUrl}/registro`, { nombre, username, correo, password });
  }

  finalizarCompra(usuario_id: number, direccion: string, departamento: string): Observable<any> {
    return this.http.post(`${this.apiUrl}/finalizarCompra`, { usuario_id, direccion, departamento });
  }

  eliminarDelCarrito(producto_id: number, cantidad: number, usuario_id: number): Observable<any> {
    return this.http.post(`${this.apiUrl}/eliminarDelCarrito`, { producto_id, cantidad, usuario_id });
  }
}