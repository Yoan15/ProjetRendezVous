import { Component, OnInit } from "@angular/core";
import { Patient } from "../models/patient.model";
import { PatientService } from "../services/patient.service";

@Component({
  selector: "app-liste-patients",
  templateUrl: "./liste-patients.component.html",
  styleUrls: ["./liste-patients.component.css"]
})
export class ListePatientsComponent implements OnInit{
  listePatients: Patient[];

  constructor(private patientService: PatientService){

  }

  ngOnInit(){
    this.patientService.searchAllPatients().subscribe((response) => {
      console.log(response);
      this.listePatients = response.body;
    }, (error) => {
      console.log(error);
    });
  }
}
