import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

import { AppRoutingModule }     from './app-routing.module';
import { MowingPiece } from './classes/mowingPiece';
import { MowingService } from './services/mowing.service';

import { AppComponent } from './app.component';
import { MowingComponent } from './mowing/mowing.component';

@NgModule({
  declarations: [
    AppComponent,
    MowingComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule
  ],
  providers: [MowingService],
  bootstrap: [AppComponent]
})
export class AppModule { }
