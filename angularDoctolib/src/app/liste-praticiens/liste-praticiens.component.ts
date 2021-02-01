import { Component, OnInit } from "@angular/core";
import { Praticien } from "../models/praticien.model";
import { PraticienService } from "../services/praticien.service";

@Component({
  selector: "app-liste-praticiens",
  templateUrl: "./liste-praticiens.component.html",
  styleUrls: ["./liste-praticiens.component.css"]
})
export class ListePraticiensComponent implements OnInit{
  listePraticiens: Praticien[];

  constructor(private praticienService: PraticienService){

  }

  ngOnInit(){
    this.praticienService.searchAllPraticiens().subscribe((response) => {
      console.log(response);
      this.listePraticiens = response.body;
    }, (error) => {
      console.log(error);
    });
  }
}
