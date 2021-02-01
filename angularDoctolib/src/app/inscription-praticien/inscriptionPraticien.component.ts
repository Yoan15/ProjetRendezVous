import { Component } from "@angular/core";
import { NgForm } from "@angular/forms";

@Component({
  selector: "app-inscription-praticien",
  templateUrl: "./inscriptionPraticien.component.html",
  styleUrls: ["./inscriptionPraticien.component.css"]
})
export class InscriptionPraticienComponent {
  nom:string;
  prenom:string;
  adresse:string;
  specialites:number;
  email:string;
  password:string;

  inscription(form: NgForm){
    console.log(form);
  }

}
