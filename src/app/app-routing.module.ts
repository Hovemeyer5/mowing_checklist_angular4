import { NgModule }             from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
 
import { MowingComponent }   from './mowing/mowing.component';
 
const routes: Routes = [
  { path: '', redirectTo: '/mowing', pathMatch: 'full' },
  { path: 'mowing',  component: MowingComponent}
];
 
@NgModule({
  imports: [ RouterModule.forRoot(routes) ],
  exports: [ RouterModule ]
})
export class AppRoutingModule {}