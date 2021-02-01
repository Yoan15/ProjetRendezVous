import { Component } from "@angular/core";
import { NgForm } from "@angular/forms";

@Component({
  selector: "app-connexion",
  templateUrl: "./connexion.component.html",
  styleUrls: ["./connexion.component.css"]
})
export class ConnexionComponent {
  email:string;
  password:string;

  connexion(form: NgForm){
    console.log(form);
  }

}
