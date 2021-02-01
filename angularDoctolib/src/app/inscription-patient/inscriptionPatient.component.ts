import { Component } from "@angular/core";
import { NgForm } from "@angular/forms";

@Component({
  selector: "app-inscription-patient",
  templateUrl: "./inscriptionPatient.component.html",
  styleUrls: ["./inscriptionPatient.component.css"]
})
export class InscriptionPatientComponent {
  nom:string;
  prenom:string;
  adresse:string;
  numSecuSociale:number;
  birthday:string;
  email:string;
  password:string;

  inscription(form: NgForm){
    console.log(form);
  }

}
