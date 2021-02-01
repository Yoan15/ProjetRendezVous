import { Component, OnInit } from "@angular/core";
import { Praticien } from "../../models/praticien.model";
import { PraticienService } from "../../services/praticien.service";

@Component({
  selector: "app-detail-praticien",
  templateUrl: "./detail-praticien.component.html",
  styleUrls: ["./detail-praticien.component.css"]
})
export class PraticienComponent implements OnInit{
  praticien: Praticien[];

  constructor(private praticienService: PraticienService){

  }

  ngOnInit(){
    this.praticienService.searchPraticienById().subscribe((response) => {
      console.log(response);
      this.praticien = response.body;
    }, (error) => {
      console.log(error);
    });
  }
}
