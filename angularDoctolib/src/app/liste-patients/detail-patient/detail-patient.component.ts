import { Component, OnInit } from "@angular/core";
import { ActivatedRoute, Router } from "@angular/router";
import { Patient } from "../../models/patient.model";
import { PatientService } from "../../services/patient.service";

@Component({
  selector: "app-detail-patient",
  templateUrl: "./detail-patient.component.html",
  styleUrls: ["./detail-patient.component.css"]
})
export class DetailPatientComponent implements OnInit{
  patient: Patient[];

  constructor(private patientService: PatientService, private router: Router, private activatedRoute: ActivatedRoute){

  }

  ngOnInit(){
    this.patientService.searchPatientById().subscribe((response) => {
      console.log(response);
      this.patient = response.body;
    }, (error) => {
      console.log(error);
    });
  }
}
