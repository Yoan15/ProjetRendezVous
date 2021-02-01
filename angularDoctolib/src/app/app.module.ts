import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

import { AppComponent } from './app.component';
import { FormsModule } from '@angular/forms';
import { ConnexionComponent } from './Connexion/connexion.component';
import { ListePraticiensComponent } from './liste-praticiens/liste-praticiens.component';
import { HttpClientModule } from '@angular/common/http';
import { PraticienService } from './services/praticien.service';
import { ListePatientsComponent } from './liste-patients/liste-patients.component';
import { InscriptionPatientComponent } from './inscription-patient/inscriptionPatient.component';
import { InscriptionPraticienComponent } from './inscription-praticien/inscriptionPraticien.component';
import { NotFoundComponent } from './not-found/not-found.component';
import { NavbarComponent } from './navbar/navbar.component';
import { RouterModule, Routes } from '@angular/router';
import { AccueilComponent } from './accueil/accueil.component';
import { CommonModule } from '@angular/common';
import { DetailPatientComponent } from './liste-patients/detail-patient/detail-patient.component';
import { RdvComponent } from './rdv/rdv.component';

const ROUTES: Routes = [
  {path: "", component: AccueilComponent},
  {path: "connexion", component: ConnexionComponent},
  {
    path: "patients",
    component: ListePatientsComponent,
    children: [
      {path: ":idPatient", component: DetailPatientComponent}
    ]
  },
  {
    path: "praticiens",
    component: ListePraticiensComponent
  },
  {path: "404", component: NotFoundComponent}
]

@NgModule({
  declarations: [
    AppComponent,
    InscriptionPatientComponent,
    InscriptionPraticienComponent,
    ConnexionComponent,
    ListePraticiensComponent,
    ListePatientsComponent,
    NotFoundComponent,
    NavbarComponent,
    AccueilComponent,
    NotFoundComponent,
    RdvComponent

  ],
  imports: [
    BrowserModule,
    FormsModule,
    HttpClientModule,
    RouterModule.forRoot(ROUTES),
    CommonModule
  ],
  providers: [ PraticienService ],
  bootstrap: [AppComponent]
})
export class AppModule { }
