import { Routes } from '@angular/router';
import { LoginComponent } from './pages/login/login.component';
import { ProductInfoComponent } from './components/product-info/product-info.component';
import { SectionProductsComponent } from './components/section-products/section-products.component';

export const routes: Routes = [
    { path: 'login', component: LoginComponent },
    { path: 'producto/:id', component: ProductInfoComponent },
    {path:'', component:SectionProductsComponent},
    { path: '**', redirectTo: '', pathMatch: 'full' },
];
