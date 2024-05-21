import { CommonModule, NgClass } from '@angular/common';
import { Component, OnInit, inject } from '@angular/core';
import { FormBuilder, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { ServiceLoginService } from '../../services/service-login.service';


@Component({
  selector: 'app-login',
  standalone: true,
  imports: [CommonModule,ReactiveFormsModule, NgClass],
  templateUrl: './login.component.html',
  styleUrl: './login.component.css'
})
export class LoginComponent implements OnInit {
  contactForm!: FormGroup;

  constructor(
    private formBuilder: FormBuilder,
    private serviceLogin: ServiceLoginService // Inyecta el servicio en el constructor
  ) {
    this.contactForm = this.formBuilder.group({
      ci: ['', [Validators.required]],
      nombre: ['', [Validators.required, Validators.minLength(2)]],
      username: ['', [Validators.required, Validators.minLength(2)]],
      apellido: ['', [Validators.required, Validators.minLength(2)]],
      fechanacimiento: ['', [Validators.required]],
      imagen: ['', [Validators.required]],
      password: ['', [Validators.required, Validators.minLength(6)]]
    });
  }

  enviar(event: Event) {
    event.preventDefault();
    if (this.contactForm.valid) {
      this.serviceLogin.enviarDatos(this.contactForm.value).subscribe(
        response => {
          console.log(response);
        },
        error => {
          console.error(error);
        }
      );
    } else {
      console.log('Form is invalid');
    }
  }

  ngOnInit(): void { // Método ngOnInit que implementa la interfaz OnInit
    // Este método se ejecutaría al inicializar el componente, pero está vacío en este caso
  }
  
  hasErrors(field: string, typeError: string) { // Método hasErrors que recibe dos parámetros: el nombre del campo y el tipo de error
    return this.contactForm.get(field)?.hasError(typeError) && this.contactForm.get(field)?.touched;
     // Retorna true si el campo tiene el error especificado y ha sido tocado por el usuario, de lo contrario retorna false
  }

}
